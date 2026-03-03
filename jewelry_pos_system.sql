-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 05, 2026 at 10:54 AM
-- Server version: 9.5.0
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jewelry_pos_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CalculateProductCostFromComponents` (IN `p_product_id` INT)   BEGIN
    DECLARE total_material_cost DECIMAL(12,2) DEFAULT 0;
    DECLARE total_labor_cost DECIMAL(12,2) DEFAULT 0;
    DECLARE total_setting_cost DECIMAL(12,2) DEFAULT 0;
    DECLARE total_component_cost DECIMAL(12,2) DEFAULT 0;
    DECLARE v_overhead_percentage DECIMAL(5,2) DEFAULT 30.00; -- 30% overhead

    -- Calculate costs from components
    SELECT
        SUM(COALESCE(component_cost, 0)),
        SUM(COALESCE(labor_cost, 0)),
        SUM(COALESCE(setting_cost, 0))
    INTO total_material_cost, total_labor_cost, total_setting_cost
    FROM product_components
    WHERE product_id = p_product_id;

    -- Get labor costs
    SELECT SUM(labor_cost) INTO total_labor_cost
    FROM product_labor
    WHERE product_id = p_product_id;

    -- Calculate total component cost
    SET total_component_cost = total_material_cost + total_labor_cost + total_setting_cost;

    -- Calculate final cost with overhead
    SET total_component_cost = total_component_cost * (1 + v_overhead_percentage / 100);

    -- Return cost breakdown
    SELECT
        p_product_id as product_id,
        total_material_cost,
        total_labor_cost,
        total_setting_cost,
        v_overhead_percentage as overhead_percentage,
        total_component_cost as calculated_cost_price;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckStockAlerts` (IN `p_product_id` INT, IN `p_location_id` INT)   BEGIN
    DECLARE v_quantity_available INT;
    DECLARE v_reorder_point INT;
    DECLARE v_safety_stock INT;
    DECLARE v_max_stock INT;
    DECLARE v_days_since_movement INT;
    DECLARE v_product_name VARCHAR(200);
    DECLARE v_location_name VARCHAR(100);

    -- Get current stock levels
    SELECT
        isl.quantity_available,
        isl.reorder_point,
        isl.safety_stock_level,
        isl.maximum_stock_level,
        DATEDIFF(CURDATE(), isl.last_movement_date),
        p.product_name,
        l.location_name
    INTO
        v_quantity_available,
        v_reorder_point,
        v_safety_stock,
        v_max_stock,
        v_days_since_movement,
        v_product_name,
        v_location_name
    FROM inventory_stock isl
    JOIN products p ON isl.product_id = p.product_id
    JOIN locations l ON isl.location_id = l.location_id
    WHERE isl.product_id = p_product_id AND isl.location_id = p_location_id;

    -- Check low stock
    IF v_quantity_available <= v_safety_stock THEN
        INSERT INTO inventory_alerts (alert_type, product_id, location_id, alert_level, alert_message, threshold_value, current_value)
        VALUES (
            'low_stock',
            p_product_id,
            p_location_id,
            'critical',
            CONCAT(v_product_name, ' at ', v_location_name, ' is below safety stock! Available: ', v_quantity_available),
            v_safety_stock,
            v_quantity_available
        );
    ELSEIF v_quantity_available <= v_reorder_point THEN
        INSERT INTO inventory_alerts (alert_type, product_id, location_id, alert_level, alert_message, threshold_value, current_value)
        VALUES (
            'reorder_point',
            p_product_id,
            p_location_id,
            'warning',
            CONCAT(v_product_name, ' at ', v_location_name, ' has reached reorder point. Available: ', v_quantity_available),
            v_reorder_point,
            v_quantity_available
        );
    END IF;

    -- Check overstock
    IF v_max_stock IS NOT NULL AND v_quantity_available >= v_max_stock THEN
        INSERT INTO inventory_alerts (alert_type, product_id, location_id, alert_level, alert_message, threshold_value, current_value)
        VALUES (
            'over_stock',
            p_product_id,
            p_location_id,
            'warning',
            CONCAT(v_product_name, ' at ', v_location_name, ' is over maximum stock level! Available: ', v_quantity_available),
            v_max_stock,
            v_quantity_available
        );
    END IF;

    -- Check slow moving
    IF v_days_since_movement > 90 AND v_quantity_available > 0 THEN
        INSERT INTO inventory_alerts (alert_type, product_id, location_id, alert_level, alert_message, threshold_value, current_value)
        VALUES (
            'slow_moving',
            p_product_id,
            p_location_id,
            'info',
            CONCAT(v_product_name, ' at ', v_location_name, ' has not moved in ', v_days_since_movement, ' days'),
            90,
            v_days_since_movement
        );
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CloneEstimateForRevision` (IN `p_estimate_id` INT, IN `p_revision_reason` TEXT, IN `p_revised_by` INT)   BEGIN
    DECLARE v_new_estimate_id INT;
    DECLARE v_new_estimate_number VARCHAR(50);
    DECLARE v_old_estimate_number VARCHAR(50);
    DECLARE v_revision_number INT;

    -- Get current estimate details and revision number
    SELECT estimate_number INTO v_old_estimate_number
    FROM estimates WHERE estimate_id = p_estimate_id;

    SELECT COALESCE(MAX(revision_number), 0) + 1 INTO v_revision_number
    FROM estimate_revisions
    WHERE estimate_id = p_estimate_id;

    -- Generate new estimate number
    SET v_new_estimate_number = CONCAT(v_old_estimate_number, '-R', v_revision_number);

    -- Clone estimate
    INSERT INTO estimates (
        estimate_number,
        estimate_type,
        customer_id,
        customer_name,
        customer_email,
        customer_phone,
        created_by,
        assigned_to,
        title,
        description,
        purpose,
        status,
        priority,
        subtotal,
        tax_amount,
        discount_amount,
        total_amount,
        deposit_required,
        deposit_percentage,
        validity_days,
        valid_until,
        related_intent_id,
        notes
    )
    SELECT
        v_new_estimate_number,
        estimate_type,
        customer_id,
        customer_name,
        customer_email,
        customer_phone,
        created_by,
        assigned_to,
        CONCAT(title, ' (Revision ', v_revision_number, ')'),
        description,
        purpose,
        'draft',
        priority,
        subtotal,
        tax_amount,
        discount_amount,
        total_amount,
        deposit_required,
        deposit_percentage,
        validity_days,
        DATE_ADD(CURDATE(), INTERVAL validity_days DAY),
        related_intent_id,
        CONCAT('Revision of estimate #', v_old_estimate_number, '. Reason: ', p_revision_reason)
    FROM estimates
    WHERE estimate_id = p_estimate_id;

    SET v_new_estimate_id = LAST_INSERT_ID();

    -- Clone items
    INSERT INTO estimate_items (
        estimate_id,
        item_type,
        item_name,
        description,
        specifications,
        product_id,
        gemstone_id,
        material_id,
        labor_id,
        quantity,
        unit_of_measure,
        unit_cost,
        unit_price,
        markup_percentage,
        markup_amount,
        discount_percentage,
        discount_amount,
        is_optional,
        is_recommended,
        estimated_duration_hours,
        estimated_completion_days,
        notes
    )
    SELECT
        v_new_estimate_id,
        item_type,
        item_name,
        description,
        specifications,
        product_id,
        gemstone_id,
        material_id,
        labor_id,
        quantity,
        unit_of_measure,
        unit_cost,
        unit_price,
        markup_percentage,
        markup_amount,
        discount_percentage,
        discount_amount,
        is_optional,
        is_recommended,
        estimated_duration_hours,
        estimated_completion_days,
        notes
    FROM estimate_items
    WHERE estimate_id = p_estimate_id;

    -- Record revision
    INSERT INTO estimate_revisions (
        estimate_id,
        revision_number,
        reason_for_revision,
        changes_summary,
        previous_total_amount,
        previous_valid_until,
        revised_by
    )
    SELECT
        p_estimate_id,
        v_revision_number,
        p_revision_reason,
        CONCAT('Cloned to new estimate #', v_new_estimate_number),
        total_amount,
        valid_until,
        p_revised_by
    FROM estimates
    WHERE estimate_id = p_estimate_id;

    -- Update old estimate revision to not current
    UPDATE estimate_revisions
    SET is_current_version = FALSE
    WHERE estimate_id = p_estimate_id;

    -- Add new revision as current
    INSERT INTO estimate_revisions (
        estimate_id,
        revision_number,
        reason_for_revision,
        changes_summary,
        revised_by
    ) VALUES (
        v_new_estimate_id,
        1,
        'Initial version',
        'Cloned from estimate #' || v_old_estimate_number,
        p_revised_by
    );

    SELECT v_new_estimate_id as new_estimate_id, v_new_estimate_number as new_estimate_number;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConvertIntentToSale` (IN `p_intent_id` INT, IN `p_user_id` INT, IN `p_payment_method` VARCHAR(50))   BEGIN
    DECLARE v_customer_id INT;
    DECLARE v_total_amount DECIMAL(12,2);
    DECLARE v_sale_id INT;
    DECLARE v_intent_number VARCHAR(50);
    DECLARE v_commission_amount DECIMAL(10,2);

    -- Get intent details
    SELECT customer_id, quotation_amount, intent_number
    INTO v_customer_id, v_total_amount, v_intent_number
    FROM product_intents
    WHERE intent_id = p_intent_id;

    -- Calculate commission (example: 10% of sale)
    SET v_commission_amount = v_total_amount * 0.10;

    -- Create sale using existing procedure (would need to be adapted)
    -- This is a simplified example
    INSERT INTO sales (
        invoice_number,
        customer_id,
        user_id,
        subtotal,
        total_amount,
        amount_paid,
        payment_method,
        notes
    ) VALUES (
        CONCAT('SALE-', v_intent_number),
        v_customer_id,
        p_user_id,
        v_total_amount,
        v_total_amount,
        v_total_amount,
        p_payment_method,
        CONCAT('Converted from intent: ', v_intent_number)
    );

    SET v_sale_id = LAST_INSERT_ID();

    -- Update intent
    UPDATE product_intents
    SET
        status = 'order_created',
        converted_to_sale_id = v_sale_id,
        closed_at = CURRENT_TIMESTAMP,
        probability_of_sale = 100.00
    WHERE intent_id = p_intent_id;

    -- Record conversion
    INSERT INTO intent_conversions (
        intent_id,
        conversion_type,
        converted_entity_id,
        converted_entity_type,
        conversion_value,
        commission_amount,
        converted_by
    ) VALUES (
        p_intent_id,
        'sale',
        v_sale_id,
        'sale',
        v_total_amount,
        v_commission_amount,
        p_user_id
    );

    -- Log history
    INSERT INTO intent_history (intent_id, user_id, action_type, description)
    VALUES (p_intent_id, p_user_id, 'converted',
            CONCAT('Intent converted to sale #', v_sale_id, ' for $', FORMAT(v_total_amount, 2)));

    SELECT v_sale_id as sale_id, v_total_amount as sale_amount, v_commission_amount as commission;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateEstimateComparison` (IN `p_estimate_ids` JSON, IN `p_title` VARCHAR(200), IN `p_description` TEXT, IN `p_created_by` INT)   BEGIN
    DECLARE v_comparison_id INT;
    DECLARE i INT DEFAULT 0;
    DECLARE v_estimate_count INT;
    DECLARE v_estimate_id INT;
    DECLARE v_recommended_id INT;
    DECLARE v_recommendation_reason TEXT;
    DECLARE v_criteria JSON;

    SET v_estimate_count = JSON_LENGTH(p_estimate_ids);
    SET v_criteria = JSON_ARRAY('price', 'timeline', 'materials', 'complexity', 'warranty');

    -- Find recommended estimate (cheapest by default)
    SELECT estimate_id INTO v_recommended_id
    FROM estimates
    WHERE estimate_id IN (
        SELECT CAST(JSON_EXTRACT(p_estimate_ids, CONCAT('$[', i, ']')) AS UNSIGNED)
    )
    ORDER BY total_amount ASC
    LIMIT 1;

    SET v_recommendation_reason = CONCAT('Lowest cost option at $',
        (SELECT FORMAT(total_amount, 2) FROM estimates WHERE estimate_id = v_recommended_id));

    -- Create comparison
    INSERT INTO estimate_comparisons (
        title,
        description,
        estimate_id_1,
        estimate_id_2,
        estimate_id_3,
        estimate_id_4,
        comparison_criteria,
        recommended_estimate_id,
        recommendation_reason,
        created_by
    ) VALUES (
        p_title,
        p_description,
        CASE WHEN v_estimate_count >= 1 THEN JSON_EXTRACT(p_estimate_ids, '$[0]') END,
        CASE WHEN v_estimate_count >= 2 THEN JSON_EXTRACT(p_estimate_ids, '$[1]') END,
        CASE WHEN v_estimate_count >= 3 THEN JSON_EXTRACT(p_estimate_ids, '$[2]') END,
        CASE WHEN v_estimate_count >= 4 THEN JSON_EXTRACT(p_estimate_ids, '$[3]') END,
        v_criteria,
        v_recommended_id,
        v_recommendation_reason,
        p_created_by
    );

    SET v_comparison_id = LAST_INSERT_ID();

    SELECT v_comparison_id as comparison_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateEstimateFromTemplate` (IN `p_customer_id` INT, IN `p_template_id` INT, IN `p_created_by` INT, IN `p_custom_data` JSON)   BEGIN
    DECLARE v_estimate_id INT;
    DECLARE v_estimate_number VARCHAR(50);
    DECLARE v_title VARCHAR(200);
    DECLARE v_description TEXT;
    DECLARE v_valid_until DATE;
    DECLARE v_deposit_percentage DECIMAL(5,2);
    DECLARE v_items_template JSON;
    DECLARE i INT DEFAULT 0;
    DECLARE v_items_count INT;
    DECLARE v_item JSON;

    -- Get template details
    SELECT
        title_template,
        description_template,
        default_validity_days,
        default_deposit_percentage,
        items_template
    INTO
        v_title,
        v_description,
        @validity_days,
        v_deposit_percentage,
        v_items_template
    FROM estimate_templates
    WHERE template_id = p_template_id;

    -- Generate estimate number
    SET v_estimate_number = CONCAT('EST-', DATE_FORMAT(NOW(), '%Y%m%d-'), LPAD(FLOOR(RAND() * 10000), 4, '0'));

    -- Calculate validity date
    SET v_valid_until = DATE_ADD(CURDATE(), INTERVAL @validity_days DAY);

    -- Create estimate
    INSERT INTO estimates (
        estimate_number,
        customer_id,
        created_by,
        estimate_type,
        title,
        description,
        validity_days,
        valid_until,
        deposit_percentage,
        status
    ) VALUES (
        v_estimate_number,
        p_customer_id,
        p_created_by,
        (SELECT template_type FROM estimate_templates WHERE template_id = p_template_id),
        COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_custom_data, '$.title')), v_title),
        COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_custom_data, '$.description')), v_description),
        @validity_days,
        v_valid_until,
        v_deposit_percentage,
        'draft'
    );

    SET v_estimate_id = LAST_INSERT_ID();

    -- Add template items if available
    IF v_items_template IS NOT NULL THEN
        SET v_items_count = JSON_LENGTH(v_items_template);
        WHILE i < v_items_count DO
            SET v_item = JSON_EXTRACT(v_items_template, CONCAT('$[', i, ']'));

            INSERT INTO estimate_items (
                estimate_id,
                item_type,
                item_name,
                description,
                quantity,
                unit_price,
                unit_cost
            ) VALUES (
                v_estimate_id,
                JSON_UNQUOTE(JSON_EXTRACT(v_item, '$.item_type')),
                JSON_UNQUOTE(JSON_EXTRACT(v_item, '$.item_name')),
                JSON_UNQUOTE(JSON_EXTRACT(v_item, '$.description')),
                JSON_EXTRACT(v_item, '$.quantity'),
                JSON_EXTRACT(v_item, '$.unit_price'),
                JSON_EXTRACT(v_item, '$.unit_cost')
            );

            SET i = i + 1;
        END WHILE;
    END IF;

    -- Calculate initial totals
    CALL CalculateEstimateTotals(v_estimate_id);

    -- Add standard terms
    INSERT INTO estimate_terms (estimate_id, term_category, term_text, is_standard)
    SELECT v_estimate_id, term_category, term_text, is_standard
    FROM estimate_terms
    WHERE estimate_id IS NULL AND is_standard = TRUE;

    SELECT v_estimate_id as estimate_id, v_estimate_number as estimate_number, v_title as title;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateProductFromTemplate` (IN `p_template_name` VARCHAR(100), IN `p_base_sku` VARCHAR(50), IN `p_product_name` VARCHAR(200), IN `p_category_id` INT, IN `p_material_id` INT, IN `p_markup_percentage` DECIMAL(5,2))   BEGIN
    DECLARE new_product_id INT;
    DECLARE total_cost DECIMAL(12,2) DEFAULT 0;
    DECLARE selling_price DECIMAL(12,2);

    -- Create new product
    INSERT INTO products (
        sku,
        product_name,
        category_id,
        material_id,
        component_based,
        is_active
    ) VALUES (
        p_base_sku,
        p_product_name,
        p_category_id,
        p_material_id,
        TRUE,
        TRUE
    );

    SET new_product_id = LAST_INSERT_ID();

    -- Copy components from template (you would need a template table)
    -- This is a simplified example
    INSERT INTO product_components (
        product_id,
        component_type_id,
        component_name,
        material_id,
        material_weight,
        component_cost
    )
    SELECT
        new_product_id,
        component_type_id,
        component_name,
        material_id,
        material_weight,
        component_cost
    FROM product_component_templates
    WHERE template_name = p_template_name;

    -- Calculate total cost
    SELECT SUM(total_component_cost) INTO total_cost
    FROM product_components
    WHERE product_id = new_product_id;

    -- Calculate selling price
    SET selling_price = total_cost * (1 + p_markup_percentage / 100);

    -- Update product with calculated prices
    UPDATE products
    SET cost_price = total_cost,
        selling_price = selling_price,
        markup_percentage = p_markup_percentage
    WHERE product_id = new_product_id;

    SELECT new_product_id as product_id, total_cost, selling_price;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateSale` (IN `p_customer_id` INT, IN `p_user_id` INT, IN `p_payment_method` VARCHAR(20), IN `p_items` JSON)   BEGIN
    DECLARE v_invoice_number VARCHAR(50);
    DECLARE v_subtotal DECIMAL(12,2) DEFAULT 0;
    DECLARE v_total DECIMAL(12,2) DEFAULT 0;
    DECLARE v_sale_id INT;
    DECLARE i INT DEFAULT 0;
    DECLARE v_items_count INT;

    -- Generate invoice number
    SET v_invoice_number = CONCAT('INV-', DATE_FORMAT(NOW(), '%Y%m%d-'), LPAD(FLOOR(RAND() * 10000), 4, '0'));

    -- Calculate totals from JSON items
    SET v_items_count = JSON_LENGTH(p_items);

    WHILE i < v_items_count DO
        SET v_subtotal = v_subtotal + (
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity')) *
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].unit_price'))
        );
        SET i = i + 1;
    END WHILE;

    SET v_total = v_subtotal; -- Add tax calculation here if needed

    -- Insert sale record
    INSERT INTO sales (
        invoice_number,
        customer_id,
        user_id,
        subtotal,
        total_amount,
        amount_paid,
        payment_method,
        sale_status,
        payment_status
    ) VALUES (
        v_invoice_number,
        p_customer_id,
        p_user_id,
        v_subtotal,
        v_total,
        v_total, -- Assuming full payment
        p_payment_method,
        'completed',
        'paid'
    );

    SET v_sale_id = LAST_INSERT_ID();

    -- Insert sale items and update stock
    SET i = 0;
    WHILE i < v_items_count DO
        INSERT INTO sale_items (
            sale_id,
            product_id,
            quantity,
            unit_price,
            line_total
        ) VALUES (
            v_sale_id,
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].product_id')),
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity')),
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].unit_price')),
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity')) *
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].unit_price'))
        );

        -- Update product stock
        CALL UpdateProductStock(
            JSON_EXTRACT(p_items, CONCAT('$[', i, '].product_id')),
            -JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity')),
            'sale',
            p_user_id,
            v_sale_id,
            'Sale transaction'
        );

        SET i = i + 1;
    END WHILE;

    SELECT v_sale_id as sale_id, v_invoice_number as invoice_number;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ExpireOldEstimates` ()   BEGIN
    DECLARE expired_count INT DEFAULT 0;

    -- Update estimates that have passed their validity date
    UPDATE estimates
    SET
        status = 'expired',
        updated_at = CURRENT_TIMESTAMP
    WHERE status IN ('sent_to_customer', 'customer_reviewed')
      AND valid_until < CURDATE();

    SET expired_count = ROW_COUNT();

    SELECT CONCAT(expired_count, ' estimates have been expired.') as message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateIntentQuotation` (IN `p_intent_id` INT, IN `p_valid_days` INT, IN `p_user_id` INT)   BEGIN
    DECLARE v_total_amount DECIMAL(12,2) DEFAULT 0;
    DECLARE v_quotation_number VARCHAR(50);
    DECLARE v_items_count INT DEFAULT 0;

    -- Calculate total from intent items
    SELECT SUM(line_total) INTO v_total_amount
    FROM intent_quotations
    WHERE intent_id = p_intent_id AND is_included = TRUE;

    -- Generate quotation number
    SET v_quotation_number = CONCAT('QTN-', DATE_FORMAT(NOW(), '%Y%m%d-'), LPAD(FLOOR(RAND() * 10000), 4, '0'));

    -- Update intent with quotation details
    UPDATE product_intents
    SET
        quotation_amount = v_total_amount,
        quotation_valid_until = DATE_ADD(CURDATE(), INTERVAL p_valid_days DAY),
        quotation_sent_at = CURRENT_TIMESTAMP,
        status = 'quotation_sent',
        probability_of_sale = 65.00
    WHERE intent_id = p_intent_id;

    -- Log history
    INSERT INTO intent_history (intent_id, user_id, action_type, description)
    VALUES (p_intent_id, p_user_id, 'quotation_sent',
            CONCAT('Quotation sent for amount: $', FORMAT(v_total_amount, 2), ', valid until: ',
                   DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL p_valid_days DAY), '%Y-%m-%d')));

    -- Create reminder for quotation expiry
    INSERT INTO intent_reminders (intent_id, user_id, reminder_type, reminder_date, message, notify_email)
    VALUES (
        p_intent_id,
        p_user_id,
        'quotation_expiry',
        DATE_ADD(CURDATE(), INTERVAL p_valid_days DAY),
        CONCAT('Quotation for intent ', (SELECT intent_number FROM product_intents WHERE intent_id = p_intent_id), ' expires today.'),
        TRUE
    );

    SELECT v_quotation_number as quotation_number, v_total_amount as total_amount;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateReplenishmentOrders` (IN `p_location_id` INT, IN `p_user_id` INT)   BEGIN
    DECLARE v_done BOOLEAN DEFAULT FALSE;
    DECLARE v_product_id INT;
    DECLARE v_sku VARCHAR(50);
    DECLARE v_product_name VARCHAR(200);
    DECLARE v_supplier_id INT;
    DECLARE v_reorder_qty INT;
    DECLARE v_unit_cost DECIMAL(12,2);
    DECLARE v_po_id INT;

    DECLARE cur_reorder CURSOR FOR
        SELECT
            rs.product_id,
            p.sku,
            p.product_name,
            p.supplier_id,
            rs.suggested_reorder_qty,
            p.cost_price
        FROM reorder_suggestions rs
        WHERE rs.location_name = (SELECT location_name FROM locations WHERE location_id = p_location_id)
          AND rs.reorder_priority IN ('URGENT', 'PRIORITY');

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    -- Create purchase order
    INSERT INTO purchase_orders (po_number, supplier_id, user_id, order_date, status)
    VALUES (
        CONCAT('REPL-', DATE_FORMAT(NOW(), '%Y%m%d-'), LPAD(FLOOR(RAND() * 1000), 3, '0')),
        NULL, -- Will be set per supplier
        p_user_id,
        CURDATE(),
        'draft'
    );

    SET v_po_id = LAST_INSERT_ID();

    OPEN cur_reorder;
    read_loop: LOOP
        FETCH cur_reorder INTO v_product_id, v_sku, v_product_name, v_supplier_id, v_reorder_qty, v_unit_cost;

        IF v_done THEN
            LEAVE read_loop;
        END IF;

        -- Add item to purchase order
        INSERT INTO po_items (po_id, product_id, quantity_ordered, unit_cost)
        VALUES (v_po_id, v_product_id, v_reorder_qty, v_unit_cost);

        -- Update next reorder date
        UPDATE inventory_stock
        SET next_reorder_date = DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        WHERE product_id = v_product_id AND location_id = p_location_id;

    END LOOP;
    CLOSE cur_reorder;

    -- Update PO with supplier if all items from same supplier
    UPDATE purchase_orders po
    SET po.supplier_id = (
        SELECT DISTINCT supplier_id
        FROM po_items poi
        JOIN products p ON poi.product_id = p.product_id
        WHERE poi.po_id = v_po_id
        GROUP BY p.supplier_id
        ORDER BY COUNT(*) DESC
        LIMIT 1
    )
    WHERE po.po_id = v_po_id;

    SELECT CONCAT('Replenishment order ', v_po_id, ' created with ',
           (SELECT COUNT(*) FROM po_items WHERE po_id = v_po_id), ' items') as result;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetIntentStatistics` (IN `p_start_date` DATE, IN `p_end_date` DATE, IN `p_user_id` INT)   BEGIN
    SELECT
        -- Overall stats
        COUNT(*) as total_intents,
        SUM(CASE WHEN status = 'order_created' THEN 1 ELSE 0 END) as converted_intents,
        SUM(CASE WHEN status IN ('quotation_rejected', 'cancelled', 'lost') THEN 1 ELSE 0 END) as lost_intents,

        -- Value stats
        SUM(estimated_value) as total_pipeline_value,
        SUM(estimated_value * (probability_of_sale / 100)) as weighted_pipeline_value,
        SUM(CASE WHEN status = 'order_created' THEN estimated_value ELSE 0 END) as converted_value,

        -- Time stats
        AVG(DATEDIFF(updated_at, created_at)) as avg_days_in_pipeline,
        AVG(CASE WHEN status = 'order_created' THEN DATEDIFF(closed_at, created_at) END) as avg_days_to_conversion,

        -- Source analysis
        (SELECT source FROM product_intents
         WHERE (created_at BETWEEN p_start_date AND p_end_date)
         AND (p_user_id IS NULL OR assigned_user_id = p_user_id)
         GROUP BY source ORDER BY COUNT(*) DESC LIMIT 1) as top_source,

        -- Type analysis
        (SELECT intent_type FROM product_intents
         WHERE (created_at BETWEEN p_start_date AND p_end_date)
         AND (p_user_id IS NULL OR assigned_user_id = p_user_id)
         GROUP BY intent_type ORDER BY COUNT(*) DESC LIMIT 1) as top_intent_type

    FROM product_intents
    WHERE created_at BETWEEN p_start_date AND p_end_date
    AND (p_user_id IS NULL OR assigned_user_id = p_user_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcessStockAdjustment` (IN `p_adjustment_id` INT, IN `p_user_id` INT)   BEGIN
    DECLARE v_location_id INT;
    DECLARE v_done BOOLEAN DEFAULT FALSE;
    DECLARE v_product_id INT;
    DECLARE v_quantity_before INT;
    DECLARE v_quantity_adjustment INT;
    DECLARE v_current_cost DECIMAL(12,2);
    DECLARE v_unit_cost DECIMAL(12,2);
    DECLARE v_serial_numbers JSON;

    DECLARE cur_items CURSOR FOR
        SELECT product_id, current_quantity, quantity_adjustment, current_cost, serial_numbers
        FROM stock_adjustment_items
        WHERE adjustment_id = p_adjustment_id AND processed = FALSE;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    -- Get location
    SELECT location_id INTO v_location_id
    FROM stock_adjustments
    WHERE adjustment_id = p_adjustment_id;

    OPEN cur_items;

    read_loop: LOOP
        FETCH cur_items INTO v_product_id, v_quantity_before, v_quantity_adjustment, v_current_cost, v_serial_numbers;

        IF v_done THEN
            LEAVE read_loop;
        END IF;

        -- Use current average cost if not specified
        SET v_unit_cost = COALESCE(v_current_cost, (
            SELECT average_cost
            FROM inventory_stock
            WHERE product_id = v_product_id AND location_id = v_location_id
        ));

        -- Process adjustment
        CALL UpdateStockLevels(
            v_product_id,
            v_location_id,
            v_quantity_adjustment,
            v_unit_cost,
            'stock_adjustment',
            p_user_id,
            p_adjustment_id,
            'stock_adjustments',
            NULL,
            'Stock adjustment'
        );

        -- Update adjustment item as processed
        UPDATE stock_adjustment_items
        SET
            processed = TRUE,
            processed_date = NOW()
        WHERE adjustment_id = p_adjustment_id AND product_id = v_product_id;

    END LOOP;

    CLOSE cur_items;

    -- Update adjustment status
    UPDATE stock_adjustments
    SET
        status = 'processed',
        processed_at = NOW(),
        total_items = (SELECT COUNT(*) FROM stock_adjustment_items WHERE adjustment_id = p_adjustment_id),
        total_quantity_adjustment = (SELECT SUM(quantity_adjustment) FROM stock_adjustment_items WHERE adjustment_id = p_adjustment_id),
        total_value_adjustment = (SELECT SUM(quantity_adjustment * COALESCE(current_cost, 0)) FROM stock_adjustment_items WHERE adjustment_id = p_adjustment_id)
    WHERE adjustment_id = p_adjustment_id;

    SELECT CONCAT('Adjustment ', p_adjustment_id, ' processed successfully') as message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcessStockTransfer` (IN `p_transfer_id` INT, IN `p_action` VARCHAR(50), IN `p_user_id` INT, IN `p_items` JSON)   BEGIN
    DECLARE v_from_location INT;
    DECLARE v_to_location INT;
    DECLARE v_item_count INT;
    DECLARE i INT DEFAULT 0;
    DECLARE v_transfer_item_id INT;
    DECLARE v_product_id INT;
    DECLARE v_quantity INT;
    DECLARE v_serial_numbers JSON;
    DECLARE v_unit_cost DECIMAL(12,2);

    -- Get transfer details
    SELECT from_location_id, to_location_id
    INTO v_from_location, v_to_location
    FROM stock_transfers
    WHERE transfer_id = p_transfer_id;

    -- Process based on action
    CASE p_action
        WHEN 'pick' THEN
            -- Update picking quantities
            SET v_item_count = JSON_LENGTH(p_items);
            WHILE i < v_item_count DO
                SET v_transfer_item_id = JSON_EXTRACT(p_items, CONCAT('$[', i, '].transfer_item_id'));
                SET v_quantity = JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity'));
                SET v_serial_numbers = JSON_EXTRACT(p_items, CONCAT('$[', i, '].serial_numbers'));

                UPDATE stock_transfer_items
                SET
                    quantity_picked = v_quantity,
                    picked_serials = v_serial_numbers,
                    item_status = 'picked'
                WHERE transfer_item_id = v_transfer_item_id;

                -- Reduce stock in from location
                SELECT product_id, unit_cost INTO v_product_id, v_unit_cost
                FROM stock_transfer_items
                WHERE transfer_item_id = v_transfer_item_id;

                CALL UpdateStockLevels(
                    v_product_id,
                    v_from_location,
                    -v_quantity,
                    v_unit_cost,
                    'stock_transfer',
                    p_user_id,
                    p_transfer_id,
                    'stock_transfers',
                    NULL,
                    'Picked for transfer'
                );

                SET i = i + 1;
            END WHILE;

            -- Update transfer status
            UPDATE stock_transfers
            SET
                status = 'picking',
                sent_by = p_user_id,
                sent_date = NOW()
            WHERE transfer_id = p_transfer_id;

        WHEN 'ship' THEN
            -- Update shipping quantities
            SET v_item_count = JSON_LENGTH(p_items);
            WHILE i < v_item_count DO
                SET v_transfer_item_id = JSON_EXTRACT(p_items, CONCAT('$[', i, '].transfer_item_id'));
                SET v_quantity = JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity'));
                SET v_serial_numbers = JSON_EXTRACT(p_items, CONCAT('$[', i, '].serial_numbers'));

                UPDATE stock_transfer_items
                SET
                    quantity_shipped = v_quantity,
                    item_status = 'shipped'
                WHERE transfer_item_id = v_transfer_item_id;

                SET i = i + 1;
            END WHILE;

            -- Update transfer status
            UPDATE stock_transfers
            SET
                status = 'in_transit'
            WHERE transfer_id = p_transfer_id;

        WHEN 'receive' THEN
            -- Update receiving quantities
            SET v_item_count = JSON_LENGTH(p_items);
            WHILE i < v_item_count DO
                SET v_transfer_item_id = JSON_EXTRACT(p_items, CONCAT('$[', i, '].transfer_item_id'));
                SET v_quantity = JSON_EXTRACT(p_items, CONCAT('$[', i, '].quantity'));
                SET v_serial_numbers = JSON_EXTRACT(p_items, CONCAT('$[', i, '].serial_numbers'));

                SELECT product_id, unit_cost INTO v_product_id, v_unit_cost
                FROM stock_transfer_items
                WHERE transfer_item_id = v_transfer_item_id;

                -- Add stock to destination location
                CALL UpdateStockLevels(
                    v_product_id,
                    v_to_location,
                    v_quantity,
                    v_unit_cost,
                    'stock_transfer',
                    p_user_id,
                    p_transfer_id,
                    'stock_transfers',
                    NULL,
                    'Received from transfer'
                );

                UPDATE stock_transfer_items
                SET
                    quantity_received = v_quantity,
                    received_serials = v_serial_numbers,
                    item_status = 'received'
                WHERE transfer_item_id = v_transfer_item_id;

                SET i = i + 1;
            END WHILE;

            -- Update transfer status
            UPDATE stock_transfers
            SET
                status = 'received',
                received_by = p_user_id,
                received_date = NOW()
            WHERE transfer_id = p_transfer_id;

        ELSE
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Invalid action. Use "pick", "ship", or "receive"';
    END CASE;

    -- Calculate transfer totals
    UPDATE stock_transfers st
    JOIN (
        SELECT
            transfer_id,
            COUNT(*) as items,
            SUM(quantity_requested) as total_qty,
            SUM(quantity_requested * unit_cost) as total_val,
            SUM(quantity_received) as received_qty
        FROM stock_transfer_items
        GROUP BY transfer_id
    ) ti ON st.transfer_id = ti.transfer_id
    SET
        st.total_items = ti.items,
        st.total_quantity = ti.total_qty,
        st.total_value = ti.total_val,
        st.received_quantity = ti.received_qty
    WHERE st.transfer_id = p_transfer_id;

    SELECT CONCAT('Transfer ', p_action, ' processed successfully') as message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SendEstimateToCustomer` (IN `p_estimate_id` INT, IN `p_sent_by` INT, IN `p_send_method` ENUM('email','sms','whatsapp','in_person'), IN `p_message` TEXT)   BEGIN
    DECLARE v_customer_email VARCHAR(100);
    DECLARE v_customer_name VARCHAR(200);
    DECLARE v_estimate_number VARCHAR(50);
    DECLARE v_total_amount DECIMAL(12,2);
    DECLARE v_valid_until DATE;

    -- Get estimate and customer details
    SELECT
        e.estimate_number,
        e.total_amount,
        e.valid_until,
        c.email,
        CONCAT(c.first_name, ' ', c.last_name)
    INTO
        v_estimate_number,
        v_total_amount,
        v_valid_until,
        v_customer_email,
        v_customer_name
    FROM estimates e
    JOIN customers c ON e.customer_id = c.customer_id
    WHERE e.estimate_id = p_estimate_id;

    -- Update estimate status
    UPDATE estimates
    SET
        status = 'sent_to_customer',
        sent_date = NOW(),
        updated_at = CURRENT_TIMESTAMP
    WHERE estimate_id = p_estimate_id;

    -- Record communication
    INSERT INTO estimate_communications (
        estimate_id,
        communication_type,
        direction,
        subject,
        message,
        sent_by
    ) VALUES (
        p_estimate_id,
        p_send_method,
        'outbound',
        CONCAT('Estimate ', v_estimate_number, ' - ', v_customer_name),
        COALESCE(p_message, CONCAT('Dear ', v_customer_name, ', Please find attached your estimate #', v_estimate_number, ' totaling $', FORMAT(v_total_amount, 2), '. This estimate is valid until ', DATE_FORMAT(v_valid_until, '%M %d, %Y'), '.')),
        p_sent_by
    );

    -- Create revision record
    INSERT INTO estimate_revisions (estimate_id, revised_by, reason_for_revision)
    VALUES (p_estimate_id, p_sent_by, 'Sent to customer');

    SELECT CONCAT('Estimate ', v_estimate_number, ' sent to ', v_customer_name, ' via ', p_send_method) as message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateIntentStatus` (IN `p_intent_id` INT, IN `p_new_status` VARCHAR(50), IN `p_user_id` INT, IN `p_notes` TEXT)   BEGIN
    DECLARE v_old_status VARCHAR(50);
    DECLARE v_probability DECIMAL(5,2);

    -- Get current status
    SELECT status INTO v_old_status FROM product_intents WHERE intent_id = p_intent_id;

    -- Calculate new probability based on status
    CASE p_new_status
        WHEN 'new' THEN SET v_probability = 10.00;
        WHEN 'contacted' THEN SET v_probability = 25.00;
        WHEN 'design_in_progress' THEN SET v_probability = 50.00;
        WHEN 'quotation_sent' THEN SET v_probability = 65.00;
        WHEN 'quotation_reviewed' THEN SET v_probability = 75.00;
        WHEN 'quotation_accepted' THEN SET v_probability = 85.00;
        WHEN 'order_created' THEN SET v_probability = 95.00;
        WHEN 'completed' THEN SET v_probability = 100.00;
        WHEN 'cancelled' THEN SET v_probability = 0.00;
        WHEN 'lost' THEN SET v_probability = 0.00;
        ELSE SET v_probability = (SELECT probability_of_sale FROM product_intents WHERE intent_id = p_intent_id);
    END CASE;

    -- Update intent
    UPDATE product_intents
    SET
        status = p_new_status,
        probability_of_sale = v_probability,
        updated_at = CURRENT_TIMESTAMP
    WHERE intent_id = p_intent_id;

    -- Log history
    INSERT INTO intent_history (intent_id, user_id, action_type, old_value, new_value, description)
    VALUES (p_intent_id, p_user_id, 'status_changed', v_old_status, p_new_status, p_notes);

    -- If converting to order, set conversion date
    IF p_new_status = 'order_created' THEN
        UPDATE product_intents
        SET closed_at = CURRENT_TIMESTAMP
        WHERE intent_id = p_intent_id;
    END IF;

    SELECT p_intent_id as intent_id, p_new_status as new_status, v_probability as new_probability;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProductStock` (IN `p_product_id` INT, IN `p_quantity_change` INT, IN `p_transaction_type` VARCHAR(50), IN `p_user_id` INT, IN `p_reference_id` INT, IN `p_notes` TEXT)   BEGIN
    DECLARE current_qty INT;

    START TRANSACTION;

    -- Get current quantity
    SELECT quantity_in_stock INTO current_qty FROM products WHERE product_id = p_product_id FOR UPDATE;

    -- Update product stock
    UPDATE products
    SET quantity_in_stock = quantity_in_stock + p_quantity_change,
        updated_at = CURRENT_TIMESTAMP
    WHERE product_id = p_product_id;

    -- Log inventory transaction
    INSERT INTO inventory_transactions (
        product_id,
        transaction_type,
        quantity_change,
        new_quantity,
        reference_id,
        user_id,
        notes
    ) VALUES (
        p_product_id,
        p_transaction_type,
        p_quantity_change,
        current_qty + p_quantity_change,
        p_reference_id,
        p_user_id,
        p_notes
    );

    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateStockLevels` (IN `p_product_id` INT, IN `p_location_id` INT, IN `p_quantity_change` INT, IN `p_unit_cost` DECIMAL(12,2), IN `p_transaction_type` VARCHAR(50), IN `p_user_id` INT, IN `p_reference_id` INT, IN `p_reference_table` VARCHAR(50), IN `p_serial_id` INT, IN `p_notes` TEXT)   BEGIN
    DECLARE v_current_quantity INT;
    DECLARE v_new_quantity INT;
    DECLARE v_average_cost DECIMAL(12,2);
    DECLARE v_transaction_id INT;

    START TRANSACTION;

    -- Get current stock level
    SELECT COALESCE(quantity_on_hand, 0) INTO v_current_quantity
    FROM inventory_stock
    WHERE product_id = p_product_id AND location_id = p_location_id
    FOR UPDATE;

    -- Calculate new quantity
    SET v_new_quantity = v_current_quantity + p_quantity_change;

    -- Calculate new average cost (only for positive stock additions)
    IF p_quantity_change > 0 AND p_unit_cost > 0 THEN
        SELECT
            CASE
                WHEN v_current_quantity + p_quantity_change > 0
                THEN ((v_current_quantity * average_cost) + (p_quantity_change * p_unit_cost)) / (v_current_quantity + p_quantity_change)
                ELSE p_unit_cost
            END INTO v_average_cost
        FROM inventory_stock
        WHERE product_id = p_product_id AND location_id = p_location_id;
    ELSE
        SELECT average_cost INTO v_average_cost
        FROM inventory_stock
        WHERE product_id = p_product_id AND location_id = p_location_id;
    END IF;

    -- Update or insert stock level
    INSERT INTO inventory_stock (product_id, location_id, quantity_on_hand, average_cost, last_movement_date)
    VALUES (p_product_id, p_location_id, v_new_quantity, COALESCE(v_average_cost, p_unit_cost), CURDATE())
    ON DUPLICATE KEY UPDATE
        quantity_on_hand = v_new_quantity,
        average_cost = COALESCE(v_average_cost, average_cost),
        last_movement_date = CURDATE(),
        updated_at = CURRENT_TIMESTAMP;

    -- Record transaction
    INSERT INTO inventory_transactions (
        transaction_type,
        reference_number,
        reference_id,
        reference_table,
        product_id,
        location_id,
        serial_id,
        quantity_before,
        quantity_change,
        unit_cost,
        user_id,
        reason_description,
        notes
    ) VALUES (
        p_transaction_type,
        NULL,
        p_reference_id,
        p_reference_table,
        p_product_id,
        p_location_id,
        p_serial_id,
        v_current_quantity,
        p_quantity_change,
        p_unit_cost,
        p_user_id,
        p_transaction_type,
        p_notes
    );

    SET v_transaction_id = LAST_INSERT_ID();

    -- Check for low stock alerts
    CALL CheckStockAlerts(p_product_id, p_location_id);

    COMMIT;

    SELECT v_transaction_id as transaction_id, v_new_quantity as new_quantity, v_average_cost as new_average_cost;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateEstimateAge` (`estimate_id` INT) RETURNS INT DETERMINISTIC READS SQL DATA BEGIN
    DECLARE age_days INT;

    SELECT DATEDIFF(CURDATE(), created_at) INTO age_days
    FROM estimates
    WHERE estimate_id = estimate_id;

    RETURN age_days;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateIntentAge` (`intent_id` INT) RETURNS INT DETERMINISTIC READS SQL DATA BEGIN
    DECLARE age_days INT;

    SELECT DATEDIFF(CURDATE(), created_at) INTO age_days
    FROM product_intents
    WHERE intent_id = intent_id;

    RETURN age_days;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetEstimateStage` (`estimate_id` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 DETERMINISTIC READS SQL DATA BEGIN
    DECLARE stage VARCHAR(50);
    DECLARE estimate_status VARCHAR(50);

    SELECT status INTO estimate_status
    FROM estimates
    WHERE estimate_id = estimate_id;

    CASE estimate_status
        WHEN 'draft' THEN SET stage = 'Creation';
        WHEN 'pending_approval' THEN SET stage = 'Internal Review';
        WHEN 'approved' THEN SET stage = 'Ready to Send';
        WHEN 'sent_to_customer' THEN SET stage = 'With Customer';
        WHEN 'customer_reviewed' THEN SET stage = 'Under Review';
        WHEN 'accepted' THEN SET stage = 'Accepted';
        WHEN 'rejected' THEN SET stage = 'Rejected';
        WHEN 'expired' THEN SET stage = 'Expired';
        WHEN 'converted_to_sale' THEN SET stage = 'Converted';
        ELSE SET stage = 'Unknown';
    END CASE;

    RETURN stage;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetIntentStage` (`intent_id` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 DETERMINISTIC READS SQL DATA BEGIN
    DECLARE stage VARCHAR(50);
    DECLARE intent_status VARCHAR(50);

    SELECT status INTO intent_status
    FROM product_intents
    WHERE intent_id = intent_id;

    CASE intent_status
        WHEN 'new' THEN SET stage = 'Discovery';
        WHEN 'contacted' THEN SET stage = 'Initial Contact';
        WHEN 'design_in_progress' THEN SET stage = 'Design Phase';
        WHEN 'quotation_sent' THEN SET stage = 'Quotation Sent';
        WHEN 'quotation_reviewed' THEN SET stage = 'Under Review';
        WHEN 'quotation_accepted' THEN SET stage = 'Accepted';
        WHEN 'order_created' THEN SET stage = 'Converted';
        WHEN 'completed' THEN SET stage = 'Completed';
        WHEN 'cancelled' THEN SET stage = 'Cancelled';
        WHEN 'lost' THEN SET stage = 'Lost';
        ELSE SET stage = 'Unknown';
    END CASE;

    RETURN stage;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetProductComposition` (`product_id` INT) RETURNS JSON DETERMINISTIC READS SQL DATA BEGIN
    DECLARE result JSON;

    SELECT JSON_OBJECT(
        'product_id', p.product_id,
        'sku', p.sku,
        'product_name', p.product_name,
        'total_weight', p.weight_grams,
        'metal_weight', p.total_metal_weight,
        'gemstone_weight', p.total_gemstone_weight,
        'components', (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'component_id', pc.component_id,
                    'component_name', pc.component_name,
                    'type', ct.type_name,
                    'material', m.material_name,
                    'material_weight', pc.material_weight,
                    'gemstone', g.gemstone_name,
                    'gemstone_carat', pc.gemstone_carat_weight,
                    'component_cost', pc.total_component_cost
                )
            )
            FROM product_components pc
            LEFT JOIN component_types ct ON pc.component_type_id = ct.type_id
            LEFT JOIN materials m ON pc.material_id = m.material_id
            LEFT JOIN gemstones g ON pc.gemstone_id = g.gemstone_id
            WHERE pc.product_id = p.product_id
        ),
        'labor', (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'labor_name', lt.labor_name,
                    'hours', pl.actual_hours,
                    'cost', pl.labor_cost
                )
            )
            FROM product_labor pl
            JOIN labor_types lt ON pl.labor_id = lt.labor_id
            WHERE pl.product_id = p.product_id
        )
    ) INTO result
    FROM products p
    WHERE p.product_id = product_id;

    RETURN result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `IsEstimateValid` (`estimate_id` INT) RETURNS TINYINT(1) DETERMINISTIC READS SQL DATA BEGIN
    DECLARE is_valid BOOLEAN;
    DECLARE valid_until_date DATE;
    DECLARE estimate_status VARCHAR(50);

    SELECT status, valid_until INTO estimate_status, valid_until_date
    FROM estimates
    WHERE estimate_id = estimate_id;

    SET is_valid = (estimate_status IN ('sent_to_customer', 'customer_reviewed', 'accepted')
                    AND valid_until_date >= CURDATE());

    RETURN is_valid;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_estimates_summary`
-- (See below for the actual view)
--
CREATE TABLE `active_estimates_summary` (
`estimate_id` int
,`estimate_number` varchar(50)
,`estimate_type` enum('custom_design','repair_quote','resizing','stone_replacement','cleaning_service','appraisal','insurance_valuation','trade_in')
,`title` varchar(200)
,`customer_name` varchar(101)
,`customer_email` varchar(100)
,`customer_phone` varchar(20)
,`created_by` varchar(101)
,`status` enum('draft','pending_approval','approved','sent_to_customer','customer_reviewed','accepted','rejected','expired','converted_to_sale')
,`total_amount` decimal(12,2)
,`deposit_required` decimal(12,2)
,`created_at` timestamp
,`valid_until` date
,`days_remaining` int
,`action_required` varchar(20)
,`item_count` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_intents_summary`
-- (See below for the actual view)
--
CREATE TABLE `active_intents_summary` (
`intent_id` int
,`intent_number` varchar(50)
,`intent_type` enum('inquiry','quotation','custom_design','wishlist_item','repair_request','appointment_followup')
,`title` varchar(200)
,`customer_name` varchar(101)
,`customer_email` varchar(100)
,`customer_phone` varchar(20)
,`assigned_to` varchar(101)
,`status` enum('new','contacted','design_in_progress','quotation_sent','quotation_reviewed','quotation_accepted','quotation_rejected','order_created','production_started','completed','cancelled','lost')
,`priority` enum('low','medium','high','urgent')
,`estimated_value` decimal(12,2)
,`probability_of_sale` decimal(5,2)
,`created_at` timestamp
,`next_followup_date` date
,`days_until_followup` int
);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `purpose` enum('consultation','fitting','repair','custom_design','purchase') NOT NULL,
  `status` enum('scheduled','confirmed','completed','cancelled','no_show') DEFAULT 'scheduled',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `audit_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `record_id` int DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `company_id` int NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `description` text,
  `parent_category_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `component_stock`
--

CREATE TABLE `component_stock` (
  `component_stock_id` int NOT NULL,
  `component_type_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `gemstone_id` int DEFAULT NULL,
  `stock_code` varchar(50) NOT NULL,
  `description` text,
  `quantity_in_stock` int DEFAULT '0',
  `minimum_stock_level` int DEFAULT '10',
  `reorder_quantity` int DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `bin_number` varchar(50) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `component_types`
--

CREATE TABLE `component_types` (
  `type_id` int NOT NULL,
  `company_id` int NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `current_stock_levels`
-- (See below for the actual view)
--
CREATE TABLE `current_stock_levels` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`category_name` varchar(50)
,`location_code` varchar(50)
,`location_name` varchar(100)
,`quantity_on_hand` int
,`quantity_allocated` int
,`quantity_available` int
,`reorder_point` int
,`safety_stock_level` int
,`stock_status` varchar(9)
,`average_cost` decimal(12,2)
,`total_value` decimal(12,2)
,`is_serialized` tinyint
,`serialized_count` int
);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `customer_code` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `customer_type` enum('regular','vip','wholesale','corporate') DEFAULT 'regular',
  `loyalty_points` int DEFAULT '0',
  `total_purchases` decimal(12,2) DEFAULT '0.00',
  `credit_limit` decimal(10,2) DEFAULT '0.00',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_purchase_history`
-- (See below for the actual view)
--
CREATE TABLE `customer_purchase_history` (
`customer_id` int
,`customer_name` varchar(101)
,`total_purchases` bigint
,`total_spent` decimal(34,2)
,`last_purchase_date` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `customer_tags`
--

CREATE TABLE `customer_tags` (
  `customer_tag_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `tag_id` int NOT NULL,
  `added_by` int DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `daily_sales_summary`
-- (See below for the actual view)
--
CREATE TABLE `daily_sales_summary` (
`sale_day` date
,`total_transactions` bigint
,`total_sales` decimal(34,2)
,`total_tax` decimal(34,2)
,`total_discount` decimal(34,2)
,`average_transaction` decimal(16,6)
);

-- --------------------------------------------------------

--
-- Table structure for table `diamond_details`
--

CREATE TABLE `diamond_details` (
  `diamond_id` int NOT NULL,
  `gemstone_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `carat_weight` decimal(8,3) NOT NULL,
  `color_grade` varchar(2) DEFAULT NULL,
  `clarity_grade` varchar(3) DEFAULT NULL,
  `cut_grade` varchar(10) DEFAULT NULL,
  `length` decimal(6,2) DEFAULT NULL,
  `width` decimal(6,2) DEFAULT NULL,
  `depth` decimal(6,2) DEFAULT NULL,
  `table_size` decimal(6,2) DEFAULT NULL,
  `depth_percentage` decimal(5,2) DEFAULT NULL,
  `table_percentage` decimal(5,2) DEFAULT NULL,
  `polish` varchar(10) DEFAULT NULL,
  `symmetry` varchar(10) DEFAULT NULL,
  `fluorescence` varchar(20) DEFAULT NULL,
  `fluorescence_intensity` varchar(20) DEFAULT NULL,
  `girdle_thickness` varchar(20) DEFAULT NULL,
  `girdle_percentage` decimal(5,2) DEFAULT NULL,
  `culet_size` varchar(20) DEFAULT NULL,
  `certificate_lab` varchar(50) DEFAULT NULL,
  `certificate_number` varchar(100) DEFAULT NULL,
  `certificate_date` date DEFAULT NULL,
  `plot_diagram` text,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `estimate_id` int NOT NULL,
  `estimate_number` varchar(50) NOT NULL,
  `estimate_type` enum('custom_design','repair_quote','resizing','stone_replacement','cleaning_service','appraisal','insurance_valuation','trade_in') DEFAULT 'custom_design',
  `customer_id` int NOT NULL,
  `customer_name` varchar(200) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `created_by` int NOT NULL,
  `assigned_to` int DEFAULT NULL,
  `approver_id` int DEFAULT NULL,
  `related_intent_id` int DEFAULT NULL,
  `related_repair_id` int DEFAULT NULL,
  `related_sale_id` int DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `purpose` text,
  `status` enum('draft','pending_approval','approved','sent_to_customer','customer_reviewed','accepted','rejected','expired','converted_to_sale') DEFAULT 'draft',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `subtotal` decimal(12,2) DEFAULT '0.00',
  `tax_amount` decimal(12,2) DEFAULT '0.00',
  `discount_amount` decimal(12,2) DEFAULT '0.00',
  `total_amount` decimal(12,2) DEFAULT '0.00',
  `deposit_required` decimal(12,2) DEFAULT '0.00',
  `deposit_percentage` decimal(5,2) DEFAULT '30.00',
  `validity_days` int DEFAULT '30',
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sent_date` datetime DEFAULT NULL,
  `accepted_date` datetime DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `approval_notes` text,
  `rejection_reason` text,
  `customer_notes` text,
  `customer_feedback` text,
  `feedback_rating` int DEFAULT NULL,
  `customer_signature` text,
  `signed_date` datetime DEFAULT NULL,
  `attachments` json DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_approvals`
--

CREATE TABLE `estimate_approvals` (
  `approval_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `approval_type` enum('internal','customer','management') DEFAULT 'internal',
  `approver_id` int DEFAULT NULL,
  `approver_role` varchar(100) DEFAULT NULL,
  `action` enum('submitted','approved','rejected','reviewed','requested_changes') NOT NULL,
  `comments` text,
  `previous_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_communications`
--

CREATE TABLE `estimate_communications` (
  `communication_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `communication_type` enum('email','call','meeting','sms','whatsapp','in_person') DEFAULT 'email',
  `direction` enum('inbound','outbound') DEFAULT 'outbound',
  `subject` varchar(200) DEFAULT NULL,
  `message` text,
  `email_to` text,
  `email_cc` text,
  `email_bcc` text,
  `email_sent` tinyint DEFAULT '0',
  `email_message_id` varchar(200) DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `participants` text,
  `attachments` json DEFAULT NULL,
  `requires_followup` tinyint DEFAULT '0',
  `followup_date` date DEFAULT NULL,
  `followup_notes` text,
  `sent_by` int DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_comparisons`
--

CREATE TABLE `estimate_comparisons` (
  `comparison_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `estimate_id_1` int DEFAULT NULL,
  `estimate_id_2` int DEFAULT NULL,
  `estimate_id_3` int DEFAULT NULL,
  `estimate_id_4` int DEFAULT NULL,
  `comparison_criteria` json DEFAULT NULL,
  `recommended_estimate_id` int DEFAULT NULL,
  `recommendation_reason` text,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `estimate_conversion_rates`
-- (See below for the actual view)
--
CREATE TABLE `estimate_conversion_rates` (
`month` varchar(7)
,`estimate_type` enum('custom_design','repair_quote','resizing','stone_replacement','cleaning_service','appraisal','insurance_valuation','trade_in')
,`total_estimates` bigint
,`converted` decimal(23,0)
,`rejected` decimal(23,0)
,`expired` decimal(23,0)
,`conversion_rate` decimal(29,2)
,`avg_estimate_value` decimal(16,6)
,`total_converted_value` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `estimate_discounts`
--

CREATE TABLE `estimate_discounts` (
  `discount_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `discount_type` enum('percentage','fixed','promotional','loyalty','trade_in') DEFAULT 'percentage',
  `discount_name` varchar(100) DEFAULT NULL,
  `discount_value` decimal(12,2) NOT NULL,
  `discount_reason` text,
  `applies_to` enum('subtotal','total','specific_items') DEFAULT 'subtotal',
  `applies_to_items` json DEFAULT NULL,
  `max_discount_amount` decimal(12,2) DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_images`
--

CREATE TABLE `estimate_images` (
  `image_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `image_type` enum('sketch','reference','inspiration','technical','concept') DEFAULT 'reference',
  `image_url` text NOT NULL,
  `thumbnail_url` text,
  `description` text,
  `is_primary` tinyint DEFAULT '0',
  `display_order` int DEFAULT '0',
  `uploaded_by` int DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_items`
--

CREATE TABLE `estimate_items` (
  `item_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `item_type` enum('material','gemstone','labor','service','product','other') NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `description` text,
  `specifications` text,
  `product_id` int DEFAULT NULL,
  `gemstone_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `labor_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '1.00',
  `unit_of_measure` varchar(50) DEFAULT NULL,
  `unit_cost` decimal(12,2) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `markup_percentage` decimal(5,2) DEFAULT '0.00',
  `markup_amount` decimal(12,2) DEFAULT '0.00',
  `discount_percentage` decimal(5,2) DEFAULT '0.00',
  `discount_amount` decimal(12,2) DEFAULT '0.00',
  `line_total` decimal(12,2) GENERATED ALWAYS AS (((`quantity` * (`unit_price` - `discount_amount`)) * (1 - (`discount_percentage` / 100)))) STORED,
  `profit_margin` decimal(12,2) GENERATED ALWAYS AS (((`unit_price` - `unit_cost`) * `quantity`)) STORED,
  `is_optional` tinyint DEFAULT '0',
  `is_recommended` tinyint DEFAULT '1',
  `estimated_duration_hours` decimal(5,2) DEFAULT NULL,
  `estimated_completion_days` int DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_options`
--

CREATE TABLE `estimate_options` (
  `option_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `parent_item_id` int DEFAULT NULL,
  `option_name` varchar(200) NOT NULL,
  `option_description` text,
  `option_type` enum('alternative','upgrade','downgrade','custom') DEFAULT 'alternative',
  `product_id` int DEFAULT NULL,
  `gemstone_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `price_difference` decimal(12,2) NOT NULL,
  `impact_on_total` decimal(12,2) GENERATED ALWAYS AS (`price_difference`) STORED,
  `time_difference_days` int DEFAULT '0',
  `complexity_difference` enum('simpler','same','more_complex') DEFAULT 'same',
  `benefits` text,
  `drawbacks` text,
  `is_recommended` tinyint DEFAULT '0',
  `recommendation_reason` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `estimate_pipeline_value`
-- (See below for the actual view)
--
CREATE TABLE `estimate_pipeline_value` (
`status` enum('draft','pending_approval','approved','sent_to_customer','customer_reviewed','accepted','rejected','expired','converted_to_sale')
,`estimate_count` bigint
,`total_potential_value` decimal(34,2)
,`avg_estimate_value` decimal(16,6)
,`oldest_estimate` timestamp
,`newest_estimate` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `estimate_profitability`
-- (See below for the actual view)
--
CREATE TABLE `estimate_profitability` (
`estimate_id` int
,`estimate_number` varchar(50)
,`total_amount` decimal(12,2)
,`total_cost` decimal(44,4)
,`total_profit` decimal(45,4)
,`profit_margin_percentage` decimal(49,2)
,`estimate_type` enum('custom_design','repair_quote','resizing','stone_replacement','cleaning_service','appraisal','insurance_valuation','trade_in')
,`customer_name` varchar(101)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `estimate_revisions`
--

CREATE TABLE `estimate_revisions` (
  `revision_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `revision_number` int NOT NULL DEFAULT '1',
  `reason_for_revision` text,
  `changes_summary` text,
  `previous_total_amount` decimal(12,2) DEFAULT NULL,
  `previous_valid_until` date DEFAULT NULL,
  `revised_by` int NOT NULL,
  `revision_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_current_version` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_specifications`
--

CREATE TABLE `estimate_specifications` (
  `spec_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `spec_key` varchar(100) NOT NULL,
  `spec_value` text NOT NULL,
  `spec_unit` varchar(50) DEFAULT NULL,
  `is_required` tinyint DEFAULT '1',
  `is_customer_specified` tinyint DEFAULT '1',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_statistics`
--

CREATE TABLE `estimate_statistics` (
  `stat_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `times_viewed_by_customer` int DEFAULT '0',
  `times_viewed_by_staff` int DEFAULT '0',
  `last_viewed_by_customer` datetime DEFAULT NULL,
  `last_viewed_by_staff` datetime DEFAULT NULL,
  `response_time_minutes` int DEFAULT NULL,
  `total_communications` int DEFAULT '0',
  `days_to_conversion` int DEFAULT NULL,
  `estimate_pdf_downloads` int DEFAULT '0',
  `estimate_shared_count` int DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_taxes`
--

CREATE TABLE `estimate_taxes` (
  `tax_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `tax_name` varchar(100) NOT NULL,
  `tax_type` enum('percentage','fixed','compound') DEFAULT 'percentage',
  `tax_rate` decimal(5,2) NOT NULL,
  `tax_amount` decimal(12,2) DEFAULT NULL,
  `taxable_amount` decimal(12,2) DEFAULT NULL,
  `is_inclusive` tinyint DEFAULT '0',
  `applies_to_item_type` enum('all','material','labor','service') DEFAULT 'all',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_templates`
--

CREATE TABLE `estimate_templates` (
  `template_id` int NOT NULL,
  `template_name` varchar(200) NOT NULL,
  `template_type` enum('custom_design','repair','service','appraisal') DEFAULT 'custom_design',
  `title_template` varchar(200) DEFAULT NULL,
  `description_template` text,
  `terms_conditions` text,
  `payment_terms` text,
  `default_validity_days` int DEFAULT '30',
  `default_deposit_percentage` decimal(5,2) DEFAULT '30.00',
  `items_template` json DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `is_system_template` tinyint DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_terms`
--

CREATE TABLE `estimate_terms` (
  `term_id` int NOT NULL,
  `estimate_id` int NOT NULL,
  `term_category` varchar(100) DEFAULT NULL,
  `term_text` text NOT NULL,
  `is_standard` tinyint DEFAULT '1',
  `requires_acknowledgement` tinyint DEFAULT '0',
  `display_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fifo_layers`
--

CREATE TABLE `fifo_layers` (
  `layer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `receipt_date` date NOT NULL,
  `receipt_reference` varchar(100) DEFAULT NULL,
  `receipt_id` int DEFAULT NULL,
  `unit_cost` decimal(12,2) NOT NULL,
  `quantity_remaining` int NOT NULL,
  `total_value` decimal(12,2) GENERATED ALWAYS AS ((`quantity_remaining` * `unit_cost`)) STORED,
  `is_active` tinyint DEFAULT '1',
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gemstones`
--

CREATE TABLE `gemstones` (
  `gemstone_id` int NOT NULL,
  `company_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `gemstone_name` varchar(50) NOT NULL,
  `type` enum('diamond','ruby','sapphire','emerald','pearl','other') NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `clarity` varchar(30) DEFAULT NULL,
  `cut_grade` varchar(30) DEFAULT NULL,
  `default_carat_weight` decimal(6,3) DEFAULT NULL,
  `gemstone_code` varchar(50) DEFAULT NULL,
  `shape` varchar(50) DEFAULT NULL,
  `cut` varchar(50) DEFAULT NULL,
  `measurement_length` decimal(6,2) DEFAULT NULL,
  `measurement_width` decimal(6,2) DEFAULT NULL,
  `measurement_depth` decimal(6,2) DEFAULT NULL,
  `treatment` varchar(100) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `fluorescence` varchar(50) DEFAULT NULL,
  `symmetry` varchar(50) DEFAULT NULL,
  `polish` varchar(50) DEFAULT NULL,
  `girdle` varchar(50) DEFAULT NULL,
  `culet` varchar(50) DEFAULT NULL,
  `table_percentage` decimal(5,2) DEFAULT NULL,
  `depth_percentage` decimal(5,2) DEFAULT NULL,
  `certification_lab` varchar(100) DEFAULT NULL,
  `certification_number` varchar(100) DEFAULT NULL,
  `certification_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `gemstone_inventory_by_product`
-- (See below for the actual view)
--
CREATE TABLE `gemstone_inventory_by_product` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`gemstone_name` varchar(50)
,`gemstone_type` enum('diamond','ruby','sapphire','emerald','pearl','other')
,`total_stones` decimal(32,0)
,`total_carat_weight` decimal(30,3)
,`avg_stone_weight` decimal(10,7)
);

-- --------------------------------------------------------

--
-- Table structure for table `good_receive_notes`
--

CREATE TABLE `good_receive_notes` (
  `grn_id` int NOT NULL,
  `grn_number` varchar(50) NOT NULL,
  `po_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `received_by` int NOT NULL,
  `received_date` date NOT NULL,
  `received_time` time DEFAULT NULL,
  `delivery_note_number` varchar(100) DEFAULT NULL,
  `carrier_name` varchar(100) DEFAULT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `status` enum('draft','received','in_qc','accepted','rejected','partially_accepted') DEFAULT 'draft',
  `grn_type` enum('direct','returnable','sample','loan') DEFAULT 'direct',
  `packaging_condition` enum('good','damaged','tampered') DEFAULT 'good',
  `seal_intact` tinyint DEFAULT '1',
  `total_items_received` int DEFAULT NULL,
  `total_items_accepted` int DEFAULT NULL,
  `total_items_rejected` int DEFAULT NULL,
  `total_value_received` decimal(12,2) DEFAULT NULL,
  `total_value_accepted` decimal(12,2) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_amount` decimal(12,2) DEFAULT NULL,
  `receiving_location_id` int DEFAULT NULL,
  `storage_location_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` datetime DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grn_items`
--

CREATE TABLE `grn_items` (
  `grn_item_id` int NOT NULL,
  `grn_id` int NOT NULL,
  `po_item_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity_ordered` int NOT NULL,
  `quantity_received` int NOT NULL,
  `quantity_accepted` int DEFAULT '0',
  `quantity_rejected` int DEFAULT '0',
  `rejection_reason` text,
  `rejection_category` enum('damaged','wrong_item','quality_issue','quantity_mismatch','expired','other') DEFAULT 'other',
  `unit_price` decimal(10,2) DEFAULT NULL,
  `unit_of_measure` varchar(50) DEFAULT NULL,
  `serial_numbers` json DEFAULT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `received_location_id` int DEFAULT NULL,
  `item_status` enum('pending','received','in_qc','accepted','rejected') DEFAULT 'pending',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grn_serialized_items`
--

CREATE TABLE `grn_serialized_items` (
  `grn_serial_id` int NOT NULL,
  `grn_item_id` int NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  `received_condition` enum('excellent','good','fair','poor','damaged') DEFAULT 'good',
  `qc_status` enum('pending','passed','failed','requires_repair','quarantined') DEFAULT 'pending',
  `qc_notes` text,
  `actual_weight` decimal(8,3) DEFAULT NULL,
  `measured_dimensions` json DEFAULT NULL,
  `certificate_number` varchar(100) DEFAULT NULL,
  `certificate_match` tinyint DEFAULT '1',
  `assigned_location_id` int DEFAULT NULL,
  `assigned_bin` varchar(50) DEFAULT NULL,
  `current_status` enum('received','in_qc','accepted','rejected','quarantined','returned_to_supplier') DEFAULT 'received',
  `notes` text,
  `received_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_analytics`
--

CREATE TABLE `intent_analytics` (
  `analytic_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `view_count` int DEFAULT '0',
  `email_open_count` int DEFAULT '0',
  `quote_view_count` int DEFAULT '0',
  `quote_download_count` int DEFAULT '0',
  `first_response_minutes` int DEFAULT NULL,
  `total_communication_time_minutes` int DEFAULT NULL,
  `touchpoints` int DEFAULT '0',
  `last_engaged_at` datetime DEFAULT NULL,
  `days_to_conversion` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_attachments`
--

CREATE TABLE `intent_attachments` (
  `attachment_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `file_type` enum('image','sketch','document','quote','certificate','other') DEFAULT 'image',
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `description` text,
  `is_primary` tinyint DEFAULT '0',
  `uploaded_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_categories`
--

CREATE TABLE `intent_categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text,
  `color_code` varchar(7) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_category_mapping`
--

CREATE TABLE `intent_category_mapping` (
  `mapping_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_communications`
--

CREATE TABLE `intent_communications` (
  `communication_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `communication_type` enum('call','email','meeting','sms','whatsapp','note') NOT NULL,
  `direction` enum('inbound','outbound') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text,
  `duration_minutes` int DEFAULT NULL,
  `participants` text,
  `email_to` text,
  `email_cc` text,
  `email_bcc` text,
  `status` enum('sent','delivered','read','failed','scheduled') DEFAULT 'sent',
  `requires_followup` tinyint DEFAULT '0',
  `followup_date` date DEFAULT NULL,
  `followup_notes` text,
  `attachments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_conversions`
--

CREATE TABLE `intent_conversions` (
  `conversion_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `conversion_type` enum('sale','product','service','repair') NOT NULL,
  `converted_entity_id` int NOT NULL,
  `converted_entity_type` varchar(50) NOT NULL,
  `conversion_value` decimal(12,2) DEFAULT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL,
  `conversion_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `converted_by` int DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `intent_conversion_rates`
-- (See below for the actual view)
--
CREATE TABLE `intent_conversion_rates` (
`month` varchar(7)
,`intent_type` enum('inquiry','quotation','custom_design','wishlist_item','repair_request','appointment_followup')
,`total_intents` bigint
,`converted` decimal(23,0)
,`lost` decimal(23,0)
,`conversion_rate` decimal(29,2)
,`avg_estimated_value` decimal(16,6)
,`total_converted_value` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `intent_history`
--

CREATE TABLE `intent_history` (
  `history_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action_type` enum('created','status_changed','assigned','quotation_created','quotation_sent','quotation_modified','followup_added','communication_added','attachment_added','converted','cancelled') NOT NULL,
  `old_value` text,
  `new_value` text,
  `description` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_items`
--

CREATE TABLE `intent_items` (
  `intent_item_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_variant` varchar(100) DEFAULT NULL,
  `item_description` text,
  `item_type` enum('ring','necklace','earrings','bracelet','watch','other') DEFAULT 'ring',
  `material_preference_id` int DEFAULT NULL,
  `material_notes` text,
  `gemstone_type_preference` varchar(100) DEFAULT NULL,
  `gemstone_carat_preference` decimal(8,3) DEFAULT NULL,
  `gemstone_shape_preference` varchar(50) DEFAULT NULL,
  `gemstone_color_preference` varchar(50) DEFAULT NULL,
  `gemstone_clarity_preference` varchar(50) DEFAULT NULL,
  `gemstone_count` int DEFAULT '1',
  `size_preference` varchar(50) DEFAULT NULL,
  `length_preference` varchar(50) DEFAULT NULL,
  `width_preference` varchar(50) DEFAULT NULL,
  `estimated_cost` decimal(10,2) DEFAULT NULL,
  `target_price` decimal(10,2) DEFAULT NULL,
  `quantity` int DEFAULT '1',
  `reference_images` text,
  `sketch_image_url` text,
  `is_primary_item` tinyint DEFAULT '0',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `intent_pipeline_value`
-- (See below for the actual view)
--
CREATE TABLE `intent_pipeline_value` (
`status` enum('new','contacted','design_in_progress','quotation_sent','quotation_reviewed','quotation_accepted','quotation_rejected','order_created','production_started','completed','cancelled','lost')
,`intent_count` bigint
,`total_potential_value` decimal(34,2)
,`weighted_value` decimal(43,8)
,`avg_probability` decimal(9,6)
);

-- --------------------------------------------------------

--
-- Table structure for table `intent_reminders`
--

CREATE TABLE `intent_reminders` (
  `reminder_id` int NOT NULL,
  `intent_id` int NOT NULL,
  `user_id` int NOT NULL,
  `reminder_type` enum('followup','quotation_expiry','deadline','meeting','other') DEFAULT 'followup',
  `reminder_date` datetime NOT NULL,
  `message` text NOT NULL,
  `notify_email` tinyint DEFAULT '1',
  `notify_sms` tinyint DEFAULT '0',
  `notify_in_app` tinyint DEFAULT '1',
  `status` enum('pending','sent','acknowledged','cancelled') DEFAULT 'pending',
  `sent_at` datetime DEFAULT NULL,
  `acknowledged_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intent_templates`
--

CREATE TABLE `intent_templates` (
  `template_id` int NOT NULL,
  `template_name` varchar(200) NOT NULL,
  `template_type` enum('inquiry','quotation','design_brief','followup') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `body_template` text,
  `default_intent_type` varchar(50) DEFAULT NULL,
  `default_category_id` int DEFAULT NULL,
  `default_priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `available_variables` json DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `inventory_accuracy_report`
-- (See below for the actual view)
--
CREATE TABLE `inventory_accuracy_report` (
`count_number` varchar(50)
,`count_date` date
,`location_name` varchar(100)
,`total_items_expected` int
,`total_items_counted` int
,`total_variance_count` int
,`total_variance_value` decimal(12,2)
,`accuracy_percentage` decimal(5,2)
,`supervisor` varchar(101)
,`status` enum('planned','in_progress','completed','cancelled','verified')
,`accuracy_rating` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_aging`
--

CREATE TABLE `inventory_aging` (
  `aging_id` int NOT NULL,
  `product_id` int NOT NULL,
  `location_id` int DEFAULT NULL,
  `age_0_30` int DEFAULT '0',
  `age_31_60` int DEFAULT '0',
  `age_61_90` int DEFAULT '0',
  `age_91_180` int DEFAULT '0',
  `age_181_365` int DEFAULT '0',
  `age_over_365` int DEFAULT '0',
  `total_quantity` int DEFAULT '0',
  `value_0_30` decimal(12,2) DEFAULT '0.00',
  `value_31_60` decimal(12,2) DEFAULT '0.00',
  `value_61_90` decimal(12,2) DEFAULT '0.00',
  `value_91_180` decimal(12,2) DEFAULT '0.00',
  `value_181_365` decimal(12,2) DEFAULT '0.00',
  `value_over_365` decimal(12,2) DEFAULT '0.00',
  `total_value` decimal(12,2) DEFAULT '0.00',
  `last_sale_date` date DEFAULT NULL,
  `days_since_last_sale` int DEFAULT NULL,
  `is_slow_moving` tinyint DEFAULT '0',
  `is_non_moving` tinyint DEFAULT '0',
  `as_of_date` date NOT NULL,
  `calculated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_alerts`
--

CREATE TABLE `inventory_alerts` (
  `alert_id` int NOT NULL,
  `alert_type` enum('low_stock','over_stock','slow_moving','non_moving','expiring_soon','stockout','reorder_point','variance','theft_suspicion','damage_pattern') NOT NULL,
  `product_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `alert_level` enum('info','warning','critical') DEFAULT 'warning',
  `alert_message` text NOT NULL,
  `threshold_value` decimal(12,2) DEFAULT NULL,
  `current_value` decimal(12,2) DEFAULT NULL,
  `status` enum('active','acknowledged','resolved','dismissed') DEFAULT 'active',
  `acknowledged_by` int DEFAULT NULL,
  `acknowledged_at` datetime DEFAULT NULL,
  `resolved_by` int DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `triggered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_date` date DEFAULT NULL,
  `action_taken` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_forecast`
--

CREATE TABLE `inventory_forecast` (
  `forecast_id` int NOT NULL,
  `product_id` int NOT NULL,
  `location_id` int DEFAULT NULL,
  `forecast_date` date NOT NULL,
  `forecast_type` enum('demand','supply','net') DEFAULT 'demand',
  `forecast_quantity` int NOT NULL,
  `confidence_level` decimal(5,2) DEFAULT '0.80',
  `actual_quantity` int DEFAULT NULL,
  `variance` int GENERATED ALWAYS AS ((`actual_quantity` - `forecast_quantity`)) STORED,
  `variance_percentage` decimal(5,2) DEFAULT NULL,
  `forecast_model` varchar(100) DEFAULT NULL,
  `model_parameters` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_kpis`
--

CREATE TABLE `inventory_kpis` (
  `kpi_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `period_type` enum('daily','weekly','monthly','quarterly','yearly') DEFAULT 'monthly',
  `beginning_inventory_value` decimal(12,2) DEFAULT '0.00',
  `ending_inventory_value` decimal(12,2) DEFAULT '0.00',
  `average_inventory_value` decimal(12,2) DEFAULT '0.00',
  `cost_of_goods_sold` decimal(12,2) DEFAULT '0.00',
  `inventory_turnover` decimal(10,2) GENERATED ALWAYS AS ((case when (`average_inventory_value` > 0) then (`cost_of_goods_sold` / `average_inventory_value`) else 0 end)) STORED,
  `days_in_inventory` decimal(10,2) GENERATED ALWAYS AS ((case when (`inventory_turnover` > 0) then (365 / `inventory_turnover`) else 0 end)) STORED,
  `stockout_occurrences` int DEFAULT '0',
  `stockout_duration_days` int DEFAULT '0',
  `stockout_quantity` int DEFAULT '0',
  `count_accuracy_percentage` decimal(5,2) DEFAULT '100.00',
  `variance_rate` decimal(5,2) DEFAULT '0.00',
  `carrying_cost_percentage` decimal(5,2) DEFAULT '25.00',
  `total_carrying_cost` decimal(12,2) GENERATED ALWAYS AS (((`average_inventory_value` * `carrying_cost_percentage`) / 100)) STORED,
  `fill_rate` decimal(5,2) DEFAULT '100.00',
  `order_fulfillment_rate` decimal(5,2) DEFAULT '100.00',
  `calculated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock`
--

CREATE TABLE `inventory_stock` (
  `stock_id` int NOT NULL,
  `product_id` int NOT NULL,
  `location_id` int NOT NULL,
  `quantity_on_hand` int DEFAULT '0',
  `quantity_allocated` int DEFAULT '0',
  `quantity_available` int GENERATED ALWAYS AS ((`quantity_on_hand` - `quantity_allocated`)) STORED,
  `reorder_point` int DEFAULT '0',
  `reorder_quantity` int DEFAULT NULL,
  `last_reorder_date` date DEFAULT NULL,
  `next_reorder_date` date DEFAULT NULL,
  `average_cost` decimal(12,2) DEFAULT '0.00',
  `total_value` decimal(12,2) GENERATED ALWAYS AS ((`quantity_on_hand` * `average_cost`)) STORED,
  `stock_turnover_rate` decimal(8,2) DEFAULT NULL,
  `days_in_stock` int DEFAULT '0',
  `last_movement_date` date DEFAULT NULL,
  `safety_stock_level` int DEFAULT '0',
  `minimum_stock_level` int DEFAULT '0',
  `maximum_stock_level` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `transaction_id` int NOT NULL,
  `transaction_type` enum('purchase_receipt','sales_delivery','stock_adjustment','stock_transfer','stock_count','production','assembly','disassembly','return_supplier','return_customer','write_off','damage','theft','sample','loan_out','loan_in') NOT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `reference_id` int DEFAULT NULL,
  `reference_table` varchar(50) DEFAULT NULL,
  `product_id` int NOT NULL,
  `location_id` int DEFAULT NULL,
  `to_location_id` int DEFAULT NULL,
  `serial_id` int DEFAULT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `quantity_before` int DEFAULT NULL,
  `quantity_change` int NOT NULL,
  `quantity_after` int GENERATED ALWAYS AS ((`quantity_before` + `quantity_change`)) STORED,
  `unit_cost` decimal(12,2) DEFAULT NULL,
  `total_cost` decimal(12,2) GENERATED ALWAYS AS ((`quantity_change` * `unit_cost`)) STORED,
  `valuation_method` enum('FIFO','LIFO','AVG','SPECIFIC') DEFAULT 'AVG',
  `user_id` int NOT NULL,
  `status` enum('draft','pending','completed','cancelled','reversed') DEFAULT 'completed',
  `is_reversed` tinyint DEFAULT '0',
  `reversal_reference` int DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `effective_date` date DEFAULT NULL,
  `reason_code` varchar(50) DEFAULT NULL,
  `reason_description` text,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `inventory_transactions_summary`
-- (See below for the actual view)
--
CREATE TABLE `inventory_transactions_summary` (
`transaction_day` date
,`transaction_type` enum('purchase_receipt','sales_delivery','stock_adjustment','stock_transfer','stock_count','production','assembly','disassembly','return_supplier','return_customer','write_off','damage','theft','sample','loan_out','loan_in')
,`transaction_count` bigint
,`total_quantity_change` decimal(32,0)
,`total_cost_change` decimal(34,2)
,`unique_products` bigint
,`unique_users` bigint
);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_valuation`
--

CREATE TABLE `inventory_valuation` (
  `valuation_id` int NOT NULL,
  `product_id` int NOT NULL,
  `fifo_value` decimal(12,2) DEFAULT '0.00',
  `lifo_value` decimal(12,2) DEFAULT '0.00',
  `average_cost_value` decimal(12,2) DEFAULT '0.00',
  `standard_cost_value` decimal(12,2) DEFAULT '0.00',
  `valuation_method` enum('FIFO','LIFO','AVG','STANDARD') DEFAULT 'AVG',
  `current_value` decimal(12,2) GENERATED ALWAYS AS ((case `valuation_method` when _utf8mb4'FIFO' then `fifo_value` when _utf8mb4'LIFO' then `lifo_value` when _utf8mb4'AVG' then `average_cost_value` when _utf8mb4'STANDARD' then `standard_cost_value` else 0.00 end)) STORED,
  `total_quantity` int DEFAULT '0',
  `average_unit_cost` decimal(12,2) DEFAULT '0.00',
  `valuation_date` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labor_types`
--

CREATE TABLE `labor_types` (
  `labor_id` int NOT NULL,
  `company_id` int NOT NULL,
  `labor_code` varchar(50) NOT NULL,
  `labor_name` varchar(100) NOT NULL,
  `description` text,
  `base_cost` decimal(10,2) DEFAULT NULL,
  `cost_per_hour` decimal(10,2) DEFAULT NULL,
  `estimated_hours` decimal(5,2) DEFAULT NULL,
  `skill_level` enum('basic','intermediate','advanced','master') DEFAULT 'basic',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int NOT NULL,
  `company_id` int NOT NULL,
  `branch_id` int NOT NULL,
  `location_code` varchar(50) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_type` enum('store','warehouse','display_case','safe','vault','counter','workshop','qc_area','quarantine') DEFAULT 'store',
  `parent_location_id` int DEFAULT NULL,
  `address` text,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `temperature_controlled` tinyint DEFAULT '0',
  `humidity_controlled` tinyint DEFAULT '0',
  `security_level` enum('low','medium','high','maximum') DEFAULT 'medium',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `low_stock_alert`
-- (See below for the actual view)
--
CREATE TABLE `low_stock_alert` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`quantity_in_stock` int
,`minimum_stock_level` int
,`supplier` varchar(100)
,`supplier_phone` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `description` text,
  `carat_purity` varchar(20) DEFAULT NULL,
  `density` decimal(8,4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `measurement_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `UOM` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE `po_items` (
  `po_item_id` int NOT NULL,
  `po_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity_ordered` int NOT NULL,
  `quantity_received` int DEFAULT '0',
  `unit_cost` decimal(12,2) NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `company_id` int NOT NULL,
  `sku` varchar(50) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `description` text,
  `category_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `weight_grams` decimal(8,3) DEFAULT NULL,
  `carat_purity` varchar(20) DEFAULT NULL,
  `gemstone_id` int DEFAULT NULL,
  `gemstone_count` int DEFAULT '0',
  `gemstone_weight` decimal(6,3) DEFAULT NULL,
  `metal_weight` decimal(8,3) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `style` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','unisex') DEFAULT 'unisex',
  `cost_price` decimal(12,2) NOT NULL,
  `markup_percentage` decimal(5,2) DEFAULT NULL,
  `selling_price` decimal(12,2) NOT NULL,
  `wholesale_price` decimal(12,2) DEFAULT NULL,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `quantity_in_stock` int DEFAULT '0',
  `minimum_stock_level` int DEFAULT '5',
  `reorder_quantity` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `is_featured` tinyint DEFAULT '0',
  `component_based` tinyint DEFAULT '0',
  `is_set` tinyint DEFAULT '0',
  `set_count` int DEFAULT '1',
  `total_metal_weight` decimal(8,3) DEFAULT NULL,
  `total_gemstone_weight` decimal(8,3) DEFAULT NULL,
  `certificate_number` varchar(100) DEFAULT NULL,
  `certificate_issuer` varchar(100) DEFAULT NULL,
  `certificate_date` date DEFAULT NULL,
  `collection` varchar(100) DEFAULT NULL,
  `designer` varchar(100) DEFAULT NULL,
  `country_of_origin` varchar(50) DEFAULT NULL,
  `is_serialized` tinyint DEFAULT '0',
  `track_individual_items` tinyint DEFAULT '0',
  `serial_number_format` varchar(100) DEFAULT NULL,
  `requires_certificate` tinyint DEFAULT '0',
  `is_lot_based` tinyint DEFAULT '0',
  `serialized_count` int DEFAULT '0',
  `last_serial_number` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_components`
--

CREATE TABLE `product_components` (
  `component_id` int NOT NULL,
  `product_id` int NOT NULL,
  `component_type_id` int DEFAULT NULL,
  `component_name` varchar(100) NOT NULL,
  `material_id` int DEFAULT NULL,
  `material_weight` decimal(8,3) DEFAULT NULL,
  `material_purity` varchar(20) DEFAULT NULL,
  `gemstone_id` int DEFAULT NULL,
  `gemstone_quantity` int DEFAULT '1',
  `gemstone_weight` decimal(8,3) DEFAULT NULL,
  `gemstone_carat_weight` decimal(8,3) DEFAULT NULL,
  `gemstone_shape` varchar(50) DEFAULT NULL,
  `gemstone_color` varchar(50) DEFAULT NULL,
  `gemstone_clarity` varchar(50) DEFAULT NULL,
  `gemstone_cut_grade` varchar(50) DEFAULT NULL,
  `gemstone_certificate` varchar(100) DEFAULT NULL,
  `dimension_length` decimal(8,2) DEFAULT NULL,
  `dimension_width` decimal(8,2) DEFAULT NULL,
  `dimension_height` decimal(8,2) DEFAULT NULL,
  `diameter` decimal(8,2) DEFAULT NULL,
  `component_cost` decimal(10,2) DEFAULT NULL,
  `labor_cost` decimal(10,2) DEFAULT NULL,
  `setting_cost` decimal(10,2) DEFAULT NULL,
  `total_component_cost` decimal(10,2) GENERATED ALWAYS AS (((`component_cost` + `labor_cost`) + `setting_cost`)) STORED,
  `position_order` int DEFAULT '0',
  `position_description` varchar(200) DEFAULT NULL,
  `is_main_component` tinyint DEFAULT '0',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_component_summary`
-- (See below for the actual view)
--
CREATE TABLE `product_component_summary` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`total_components` bigint
,`total_material_weight` decimal(30,3)
,`total_gemstone_weight` decimal(30,3)
,`total_gemstone_carat` decimal(30,3)
,`total_component_cost` decimal(32,2)
,`total_labor_cost` decimal(32,2)
,`cost_price` decimal(12,2)
,`selling_price` decimal(12,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `product_cost_breakdown`
--

CREATE TABLE `product_cost_breakdown` (
  `breakdown_id` int NOT NULL,
  `product_id` int NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `item_description` varchar(200) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `percentage_of_total` decimal(5,2) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_hallmarks`
--

CREATE TABLE `product_hallmarks` (
  `hallmark_id` int NOT NULL,
  `product_id` int NOT NULL,
  `hallmark_type` enum('purity','maker','country','assay','date','other') NOT NULL,
  `hallmark_text` varchar(100) DEFAULT NULL,
  `hallmark_location` varchar(100) DEFAULT NULL,
  `image_url` text,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` text NOT NULL,
  `is_primary` tinyint DEFAULT '0',
  `display_order` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_intents`
--

CREATE TABLE `product_intents` (
  `intent_id` int NOT NULL,
  `intent_number` varchar(50) NOT NULL,
  `intent_type` enum('inquiry','quotation','custom_design','wishlist_item','repair_request','appointment_followup') NOT NULL,
  `customer_id` int NOT NULL,
  `assigned_user_id` int DEFAULT NULL,
  `source` enum('walk_in','phone','email','website','social_media','referral','exhibition') DEFAULT 'walk_in',
  `title` varchar(200) NOT NULL,
  `description` text,
  `design_preferences` text,
  `budget_min` decimal(12,2) DEFAULT NULL,
  `budget_max` decimal(12,2) DEFAULT NULL,
  `desired_completion_date` date DEFAULT NULL,
  `reference_product_id` int DEFAULT NULL,
  `reference_intent_id` int DEFAULT NULL,
  `status` enum('new','contacted','design_in_progress','quotation_sent','quotation_reviewed','quotation_accepted','quotation_rejected','order_created','production_started','completed','cancelled','lost') DEFAULT 'new',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `quotation_amount` decimal(12,2) DEFAULT NULL,
  `quotation_valid_until` date DEFAULT NULL,
  `quotation_notes` text,
  `converted_to_sale_id` int DEFAULT NULL,
  `converted_to_product_id` int DEFAULT NULL,
  `conversion_date` datetime DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL,
  `followup_notes` text,
  `followup_count` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contacted_at` datetime DEFAULT NULL,
  `quotation_sent_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `probability_of_sale` decimal(5,2) DEFAULT '0.00',
  `tags` json DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_labor`
--

CREATE TABLE `product_labor` (
  `product_labor_id` int NOT NULL,
  `product_id` int NOT NULL,
  `labor_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `actual_hours` decimal(5,2) DEFAULT NULL,
  `labor_cost` decimal(10,2) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_measurements`
--

CREATE TABLE `product_measurements` (
  `measurement_id` int NOT NULL,
  `product_id` int NOT NULL,
  `measurement_type` varchar(50) DEFAULT NULL,
  `unit` varchar(20) DEFAULT 'mm',
  `value_decimal` decimal(8,2) DEFAULT NULL,
  `value_string` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sets`
--

CREATE TABLE `product_sets` (
  `set_id` int NOT NULL,
  `set_sku` varchar(50) NOT NULL,
  `set_name` varchar(200) NOT NULL,
  `description` text,
  `total_set_price` decimal(12,2) DEFAULT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `final_set_price` decimal(12,2) DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `image_url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_set_items`
--

CREATE TABLE `product_set_items` (
  `set_item_id` int NOT NULL,
  `set_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `position_order` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `product_tag_id` int NOT NULL,
  `product_id` int NOT NULL,
  `tag_id` int NOT NULL,
  `added_by` int DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_treatments`
--

CREATE TABLE `product_treatments` (
  `treatment_id` int NOT NULL,
  `product_id` int NOT NULL,
  `treatment_type` varchar(100) DEFAULT NULL,
  `treatment_method` varchar(100) DEFAULT NULL,
  `intensity` varchar(50) DEFAULT NULL,
  `disclosure_required` tinyint DEFAULT '1',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promotion_id` int NOT NULL,
  `promo_code` varchar(50) DEFAULT NULL,
  `promo_name` varchar(100) NOT NULL,
  `description` text,
  `discount_type` enum('percentage','fixed','buy_one_get_one') NOT NULL,
  `discount_value` decimal(10,2) DEFAULT NULL,
  `minimum_purchase` decimal(10,2) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `times_used` int DEFAULT '0',
  `is_active` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `po_id` int NOT NULL,
  `po_number` varchar(50) NOT NULL,
  `supplier_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` date NOT NULL,
  `expected_delivery` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `tax_amount` decimal(12,2) DEFAULT '0.00',
  `shipping_cost` decimal(10,2) DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('draft','ordered','received','partial','cancelled') DEFAULT 'draft',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisitions`
--

CREATE TABLE `purchase_requisitions` (
  `requisition_id` int NOT NULL,
  `requisition_number` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `requisition_type` enum('new_stock','reorder','custom_order','replacement','special_order') DEFAULT 'new_stock',
  `requested_by` int NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `status` enum('draft','submitted','under_review','approved','rejected','cancelled','converted_to_po') DEFAULT 'draft',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `approver_id` int DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `approval_notes` text,
  `rejection_reason` text,
  `estimated_budget` decimal(12,2) DEFAULT NULL,
  `total_estimated_cost` decimal(12,2) DEFAULT NULL,
  `budget_code` varchar(100) DEFAULT NULL,
  `required_by_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `submitted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attachment_paths` json DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisition_items`
--

CREATE TABLE `purchase_requisition_items` (
  `requisition_item_id` int NOT NULL,
  `requisition_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` text,
  `specifications` json DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `quantity_requested` int NOT NULL,
  `unit_of_measure` varchar(50) DEFAULT 'pieces',
  `estimated_unit_cost` decimal(10,2) DEFAULT NULL,
  `estimated_total_cost` decimal(10,2) DEFAULT NULL,
  `preferred_supplier_id` int DEFAULT NULL,
  `supplier_notes` text,
  `urgency_level` enum('normal','urgent','critical') DEFAULT 'normal',
  `justification` text,
  `current_stock_level` int DEFAULT NULL,
  `minimum_stock_level` int DEFAULT NULL,
  `item_status` enum('pending','approved','rejected','ordered','received') DEFAULT 'pending',
  `po_id` int DEFAULT NULL,
  `po_item_id` int DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `reorder_suggestions`
-- (See below for the actual view)
--
CREATE TABLE `reorder_suggestions` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`category_name` varchar(50)
,`location_name` varchar(100)
,`quantity_available` int
,`reorder_point` int
,`safety_stock_level` int
,`reorder_quantity` int
,`last_reorder_date` date
,`next_reorder_date` date
,`suggested_minimum` bigint
,`suggested_reorder_qty` bigint
,`supplier_id` int
,`supplier_name` varchar(100)
,`reorder_priority` varchar(8)
,`cost_price` decimal(12,2)
,`estimated_cost` decimal(22,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `repair_id` int NOT NULL,
  `repair_number` varchar(50) NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `received_date` date NOT NULL,
  `promised_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `issue_description` text NOT NULL,
  `repair_description` text,
  `service_type` enum('cleaning','resizing','stone_replacement','polishing','repair','other') NOT NULL,
  `estimate_amount` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `deposit_amount` decimal(10,2) DEFAULT '0.00',
  `status` enum('received','in_progress','waiting_parts','completed','delivered','cancelled') DEFAULT 'received',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replenishment_rules`
--

CREATE TABLE `replenishment_rules` (
  `rule_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `rule_type` enum('min_max','reorder_point','time_phased','forecast_based') DEFAULT 'min_max',
  `minimum_stock` int NOT NULL,
  `maximum_stock` int DEFAULT NULL,
  `reorder_point` int DEFAULT NULL,
  `reorder_quantity` int DEFAULT NULL,
  `lead_time_days` int DEFAULT '7',
  `safety_stock_days` int DEFAULT '3',
  `forecast_method` enum('simple_average','moving_average','exponential_smoothing','seasonal') DEFAULT 'simple_average',
  `forecast_period_days` int DEFAULT '30',
  `review_frequency` enum('daily','weekly','biweekly','monthly','quarterly') DEFAULT 'weekly',
  `next_review_date` date DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `auto_generate_po` tinyint DEFAULT '0',
  `po_template_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requisition_approval_history`
--

CREATE TABLE `requisition_approval_history` (
  `approval_id` int NOT NULL,
  `requisition_id` int NOT NULL,
  `approver_id` int NOT NULL,
  `action` enum('submitted','approved','rejected','returned','delegated') NOT NULL,
  `approval_level` int DEFAULT '1',
  `comments` text,
  `previous_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int NOT NULL,
  `return_number` varchar(50) NOT NULL,
  `sale_id` int NOT NULL,
  `customer_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `return_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `reason` text,
  `refund_amount` decimal(12,2) NOT NULL,
  `refund_method` enum('cash','credit_card','store_credit','exchange') NOT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `customer_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `sale_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `subtotal` decimal(12,2) NOT NULL,
  `tax_amount` decimal(12,2) DEFAULT '0.00',
  `discount_amount` decimal(12,2) DEFAULT '0.00',
  `discount_percentage` decimal(5,2) DEFAULT '0.00',
  `shipping_cost` decimal(10,2) DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `change_amount` decimal(10,2) DEFAULT '0.00',
  `balance_due` decimal(12,2) DEFAULT '0.00',
  `payment_method` enum('cash','credit_card','debit_card','bank_transfer','check','mobile_payment') NOT NULL,
  `payment_status` enum('pending','partial','paid','refunded') DEFAULT 'paid',
  `card_last_four` varchar(4) DEFAULT NULL,
  `card_type` varchar(30) DEFAULT NULL,
  `sale_status` enum('completed','pending','cancelled','refunded') DEFAULT 'completed',
  `shipping_address` text,
  `shipping_method` varchar(50) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int NOT NULL,
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT '0.00',
  `discount_percentage` decimal(5,2) DEFAULT '0.00',
  `tax_amount` decimal(10,2) DEFAULT '0.00',
  `line_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serialized_products`
--

CREATE TABLE `serialized_products` (
  `serial_id` int NOT NULL,
  `product_id` int NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `unique_identifier` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `qr_code` varchar(100) DEFAULT NULL,
  `rfid_tag` varchar(100) DEFAULT NULL,
  `actual_weight_grams` decimal(8,3) DEFAULT NULL,
  `actual_carat_purity` varchar(20) DEFAULT NULL,
  `actual_dimensions` json DEFAULT NULL,
  `gemstone_certificate_number` varchar(100) DEFAULT NULL,
  `gemstone_laboratory` varchar(100) DEFAULT NULL,
  `gemstone_certificate_date` date DEFAULT NULL,
  `manufacturer_serial` varchar(100) DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `manufacturing_batch` varchar(100) DEFAULT NULL,
  `manufacturing_location` varchar(100) DEFAULT NULL,
  `quality_grade` varchar(50) DEFAULT NULL,
  `quality_score` decimal(5,2) DEFAULT NULL,
  `quality_notes` text,
  `inspected_by` int DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `individual_cost` decimal(12,2) DEFAULT NULL,
  `individual_price` decimal(12,2) DEFAULT NULL,
  `appraisal_value` decimal(12,2) DEFAULT NULL,
  `status` enum('in_stock','sold','on_hold','on_display','in_transit','damaged','lost','stolen','returned','quarantined') DEFAULT 'in_stock',
  `location_id` int DEFAULT NULL,
  `shelf_location` varchar(100) DEFAULT NULL,
  `bin_number` varchar(50) DEFAULT NULL,
  `current_owner_customer_id` int DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `sale_id` int DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `custom_attributes` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serialized_product_tags`
--

CREATE TABLE `serialized_product_tags` (
  `serial_tag_id` int NOT NULL,
  `serial_id` int NOT NULL,
  `tag_id` int NOT NULL,
  `added_by` int DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int NOT NULL,
  `company_id` int NULL,
  `branch_id` int NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
  `category` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `slow_moving_inventory`
-- (See below for the actual view)
--
CREATE TABLE `slow_moving_inventory` (
`product_id` int
,`sku` varchar(50)
,`product_name` varchar(200)
,`category_name` varchar(50)
,`total_quantity` decimal(32,0)
,`total_value` decimal(34,2)
,`last_movement_date` date
,`days_since_last_movement` int
,`movement_status` varchar(11)
,`selling_price` decimal(12,2)
,`cost_price` decimal(12,2)
,`profit_margin` decimal(13,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `staff_estimate_performance`
-- (See below for the actual view)
--
CREATE TABLE `staff_estimate_performance` (
`user_id` int
,`staff_name` varchar(101)
,`role` enum('admin','manager','salesperson','inventory_manager')
,`total_estimates_created` bigint
,`estimates_converted` decimal(23,0)
,`estimates_rejected` decimal(23,0)
,`conversion_rate` decimal(29,2)
,`total_sales_value` decimal(34,2)
,`avg_sale_value` decimal(16,6)
,`avg_days_to_acceptance` decimal(12,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `adjustment_id` int NOT NULL,
  `adjustment_number` varchar(50) NOT NULL,
  `adjustment_type` enum('quantity','value','both') DEFAULT 'quantity',
  `adjustment_category` enum('count_variance','damage','theft','expired','quality_issue','vendor_error','system_error','revaluation','write_off','sample','demonstration') DEFAULT 'count_variance',
  `location_id` int NOT NULL,
  `requested_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `total_items` int DEFAULT '0',
  `total_value_adjustment` decimal(12,2) DEFAULT '0.00',
  `total_quantity_adjustment` int DEFAULT '0',
  `status` enum('draft','submitted','approved','processed','cancelled') DEFAULT 'draft',
  `adjustment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed_at` datetime DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_items`
--

CREATE TABLE `stock_adjustment_items` (
  `adjustment_item_id` int NOT NULL,
  `adjustment_id` int NOT NULL,
  `product_id` int NOT NULL,
  `current_quantity` int NOT NULL,
  `new_quantity` int NOT NULL,
  `quantity_adjustment` int GENERATED ALWAYS AS ((`new_quantity` - `current_quantity`)) STORED,
  `current_cost` decimal(12,2) DEFAULT NULL,
  `new_cost` decimal(12,2) DEFAULT NULL,
  `cost_adjustment` decimal(12,2) DEFAULT NULL,
  `serial_numbers` json DEFAULT NULL,
  `batch_numbers` json DEFAULT NULL,
  `adjustment_reason` varchar(200) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `requires_approval` tinyint DEFAULT '1',
  `approval_notes` text,
  `processed` tinyint DEFAULT '0',
  `processed_date` datetime DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `count_id` int NOT NULL,
  `count_number` varchar(50) NOT NULL,
  `count_type` enum('full_inventory','cycle_count','spot_check','random_check') DEFAULT 'cycle_count',
  `count_method` enum('manual','barcode','rfid') DEFAULT 'manual',
  `location_id` int DEFAULT NULL,
  `specific_bins` json DEFAULT NULL,
  `count_date` date NOT NULL,
  `scheduled_start_time` datetime DEFAULT NULL,
  `scheduled_end_time` datetime DEFAULT NULL,
  `actual_start_time` datetime DEFAULT NULL,
  `actual_end_time` datetime DEFAULT NULL,
  `supervisor_id` int DEFAULT NULL,
  `team_leader_id` int DEFAULT NULL,
  `team_members` json DEFAULT NULL,
  `status` enum('planned','in_progress','completed','cancelled','verified') DEFAULT 'planned',
  `total_items_expected` int DEFAULT '0',
  `total_items_counted` int DEFAULT '0',
  `total_variance_count` int DEFAULT '0',
  `total_variance_value` decimal(12,2) DEFAULT '0.00',
  `accuracy_percentage` decimal(5,2) DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `is_locked` tinyint DEFAULT '0',
  `locked_by` int DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_count_items`
--

CREATE TABLE `stock_count_items` (
  `count_item_id` int NOT NULL,
  `count_id` int NOT NULL,
  `product_id` int NOT NULL,
  `location_id` int DEFAULT NULL,
  `bin_number` varchar(50) DEFAULT NULL,
  `expected_quantity` int NOT NULL,
  `counted_quantity` int DEFAULT '0',
  `variance_quantity` int GENERATED ALWAYS AS ((`counted_quantity` - `expected_quantity`)) STORED,
  `expected_serials` json DEFAULT NULL,
  `counted_serials` json DEFAULT NULL,
  `unit_cost` decimal(12,2) DEFAULT NULL,
  `expected_value` decimal(12,2) GENERATED ALWAYS AS ((`expected_quantity` * `unit_cost`)) STORED,
  `counted_value` decimal(12,2) GENERATED ALWAYS AS ((`counted_quantity` * `unit_cost`)) STORED,
  `variance_value` decimal(12,2) GENERATED ALWAYS AS ((`counted_value` - `expected_value`)) STORED,
  `counted_by` int DEFAULT NULL,
  `count_time` datetime DEFAULT NULL,
  `count_method` enum('manual','barcode','rfid') DEFAULT 'manual',
  `verified_by` int DEFAULT NULL,
  `verification_time` datetime DEFAULT NULL,
  `verification_notes` text,
  `status` enum('pending','counted','verified','disputed') DEFAULT 'pending',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `transfer_id` int NOT NULL,
  `transfer_number` varchar(50) NOT NULL,
  `transfer_type` enum('store_to_store','warehouse_to_store','store_to_warehouse','supplier_return','customer_return') DEFAULT 'store_to_store',
  `from_location_id` int NOT NULL,
  `to_location_id` int NOT NULL,
  `requested_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `sent_by` int DEFAULT NULL,
  `received_by` int DEFAULT NULL,
  `status` enum('draft','pending_approval','approved','picking','in_transit','partially_received','received','verified','completed','cancelled') DEFAULT 'draft',
  `requested_date` date NOT NULL,
  `approved_date` datetime DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `received_date` datetime DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `transport_method` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `carrier_name` varchar(100) DEFAULT NULL,
  `total_items` int DEFAULT '0',
  `total_quantity` int DEFAULT '0',
  `received_items` int DEFAULT '0',
  `received_quantity` int DEFAULT '0',
  `total_value` decimal(12,2) DEFAULT '0.00',
  `verified_by` int DEFAULT NULL,
  `verification_date` datetime DEFAULT NULL,
  `verification_notes` text,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_items`
--

CREATE TABLE `stock_transfer_items` (
  `transfer_item_id` int NOT NULL,
  `transfer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity_requested` int NOT NULL,
  `quantity_picked` int DEFAULT '0',
  `quantity_shipped` int DEFAULT '0',
  `quantity_received` int DEFAULT '0',
  `quantity_rejected` int DEFAULT '0',
  `unit_cost` decimal(12,2) DEFAULT NULL,
  `total_cost` decimal(12,2) GENERATED ALWAYS AS ((`quantity_requested` * `unit_cost`)) STORED,
  `serial_numbers` json DEFAULT NULL,
  `picked_serials` json DEFAULT NULL,
  `received_serials` json DEFAULT NULL,
  `rejected_serials` json DEFAULT NULL,
  `item_status` enum('pending','picked','shipped','received','partially_received','rejected') DEFAULT 'pending',
  `rejection_reason` text,
  `from_bin` varchar(50) DEFAULT NULL,
  `to_bin` varchar(50) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_valuation_by_category`
-- (See below for the actual view)
--
CREATE TABLE `stock_valuation_by_category` (
`category_id` int
,`category_name` varchar(50)
,`product_count` bigint
,`total_quantity` decimal(32,0)
,`total_value` decimal(34,2)
,`avg_profit_margin` decimal(17,6)
,`avg_turnover_rate` decimal(12,6)
);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int NOT NULL,
  `supplier_code` varchar(20) NOT NULL,
  `company_id` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `bank_details` text,
  `rating` decimal(3,2) DEFAULT '0.00',
  `is_active` tinyint DEFAULT '1',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `tag_type` enum('product','customer','supplier','category','material','collection','season','campaign','custom') DEFAULT 'product',
  `tag_group` varchar(100) DEFAULT NULL,
  `color_hex` varchar(7) DEFAULT '#6B7280',
  `icon` varchar(50) DEFAULT NULL,
  `description` text,
  `is_system_tag` tinyint DEFAULT '0',
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` enum('admin','manager','salesperson','inventory_manager') DEFAULT 'salesperson',
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `hire_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT '0.00',
  `is_active` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_intent_performance`
-- (See below for the actual view)
--
CREATE TABLE `user_intent_performance` (
`user_id` int
,`user_name` varchar(101)
,`role` enum('admin','manager','salesperson','inventory_manager')
,`total_intents_assigned` bigint
,`intents_converted` bigint
,`intents_lost` bigint
,`conversion_rate` decimal(26,2)
,`total_sales_value` decimal(34,2)
,`avg_sale_value` decimal(16,6)
);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure for view `active_estimates_summary`
--
DROP TABLE IF EXISTS `active_estimates_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `active_estimates_summary`  AS SELECT `e`.`estimate_id` AS `estimate_id`, `e`.`estimate_number` AS `estimate_number`, `e`.`estimate_type` AS `estimate_type`, `e`.`title` AS `title`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `customer_name`, `c`.`email` AS `customer_email`, `c`.`phone` AS `customer_phone`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `created_by`, `e`.`status` AS `status`, `e`.`total_amount` AS `total_amount`, `e`.`deposit_required` AS `deposit_required`, `e`.`created_at` AS `created_at`, `e`.`valid_until` AS `valid_until`, (to_days(`e`.`valid_until`) - to_days(curdate())) AS `days_remaining`, (case when (`e`.`status` = 'accepted') then 'READY FOR PRODUCTION' when ((`e`.`status` = 'sent_to_customer') and ((to_days(`e`.`valid_until`) - to_days(curdate())) <= 7)) then 'EXPIRING SOON' when (`e`.`status` = 'sent_to_customer') then 'AWAITING RESPONSE' when (`e`.`status` = 'approved') then 'READY TO SEND' else 'IN PROGRESS' end) AS `action_required`, count(`ei`.`item_id`) AS `item_count` FROM (((`estimates` `e` join `customers` `c` on((`e`.`customer_id` = `c`.`customer_id`))) join `users` `u` on((`e`.`created_by` = `u`.`user_id`))) left join `estimate_items` `ei` on((`e`.`estimate_id` = `ei`.`estimate_id`))) WHERE (`e`.`status` not in ('expired','rejected','converted_to_sale')) GROUP BY `e`.`estimate_id` ORDER BY (case `e`.`priority` when 'urgent' then 1 when 'high' then 2 when 'medium' then 3 when 'low' then 4 end) ASC, `e`.`valid_until` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `active_intents_summary`
--
DROP TABLE IF EXISTS `active_intents_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `active_intents_summary`  AS SELECT `i`.`intent_id` AS `intent_id`, `i`.`intent_number` AS `intent_number`, `i`.`intent_type` AS `intent_type`, `i`.`title` AS `title`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `customer_name`, `c`.`email` AS `customer_email`, `c`.`phone` AS `customer_phone`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `assigned_to`, `i`.`status` AS `status`, `i`.`priority` AS `priority`, `i`.`estimated_value` AS `estimated_value`, `i`.`probability_of_sale` AS `probability_of_sale`, `i`.`created_at` AS `created_at`, `i`.`next_followup_date` AS `next_followup_date`, (to_days(`i`.`next_followup_date`) - to_days(curdate())) AS `days_until_followup` FROM ((`product_intents` `i` join `customers` `c` on((`i`.`customer_id` = `c`.`customer_id`))) left join `users` `u` on((`i`.`assigned_user_id` = `u`.`user_id`))) WHERE (`i`.`status` not in ('completed','cancelled','lost')) ORDER BY `i`.`priority` DESC, `i`.`next_followup_date` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `current_stock_levels`
--
DROP TABLE IF EXISTS `current_stock_levels`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `current_stock_levels`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, `c`.`category_name` AS `category_name`, `l`.`location_code` AS `location_code`, `l`.`location_name` AS `location_name`, `isl`.`quantity_on_hand` AS `quantity_on_hand`, `isl`.`quantity_allocated` AS `quantity_allocated`, `isl`.`quantity_available` AS `quantity_available`, `isl`.`reorder_point` AS `reorder_point`, `isl`.`safety_stock_level` AS `safety_stock_level`, (case when (`isl`.`quantity_available` <= `isl`.`safety_stock_level`) then 'CRITICAL' when (`isl`.`quantity_available` <= `isl`.`reorder_point`) then 'LOW' when ((`isl`.`maximum_stock_level` is not null) and (`isl`.`quantity_available` >= `isl`.`maximum_stock_level`)) then 'OVERSTOCK' else 'OK' end) AS `stock_status`, `isl`.`average_cost` AS `average_cost`, `isl`.`total_value` AS `total_value`, `p`.`is_serialized` AS `is_serialized`, `p`.`serialized_count` AS `serialized_count` FROM (((`inventory_stock` `isl` join `products` `p` on((`isl`.`product_id` = `p`.`product_id`))) join `locations` `l` on((`isl`.`location_id` = `l`.`location_id`))) left join `categories` `c` on((`p`.`category_id` = `c`.`category_id`))) WHERE (`p`.`is_active` = true) ;

-- --------------------------------------------------------

--
-- Structure for view `customer_purchase_history`
--
DROP TABLE IF EXISTS `customer_purchase_history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_purchase_history`  AS SELECT `c`.`customer_id` AS `customer_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `customer_name`, count(`s`.`sale_id`) AS `total_purchases`, sum(`s`.`total_amount`) AS `total_spent`, max(`s`.`sale_date`) AS `last_purchase_date` FROM (`customers` `c` left join `sales` `s` on(((`c`.`customer_id` = `s`.`customer_id`) and (`s`.`sale_status` = 'completed')))) GROUP BY `c`.`customer_id` ;

-- --------------------------------------------------------

--
-- Structure for view `daily_sales_summary`
--
DROP TABLE IF EXISTS `daily_sales_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daily_sales_summary`  AS SELECT cast(`sales`.`sale_date` as date) AS `sale_day`, count(0) AS `total_transactions`, sum(`sales`.`total_amount`) AS `total_sales`, sum(`sales`.`tax_amount`) AS `total_tax`, sum(`sales`.`discount_amount`) AS `total_discount`, avg(`sales`.`total_amount`) AS `average_transaction` FROM `sales` WHERE (`sales`.`sale_status` = 'completed') GROUP BY cast(`sales`.`sale_date` as date) ;

-- --------------------------------------------------------

--
-- Structure for view `estimate_conversion_rates`
--
DROP TABLE IF EXISTS `estimate_conversion_rates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estimate_conversion_rates`  AS SELECT date_format(`e`.`created_at`,'%Y-%m') AS `month`, `e`.`estimate_type` AS `estimate_type`, count(0) AS `total_estimates`, sum((case when (`e`.`status` = 'converted_to_sale') then 1 else 0 end)) AS `converted`, sum((case when (`e`.`status` = 'rejected') then 1 else 0 end)) AS `rejected`, sum((case when (`e`.`status` = 'expired') then 1 else 0 end)) AS `expired`, round(((sum((case when (`e`.`status` = 'converted_to_sale') then 1 else 0 end)) / count(0)) * 100),2) AS `conversion_rate`, avg(`e`.`total_amount`) AS `avg_estimate_value`, sum((case when (`e`.`status` = 'converted_to_sale') then `e`.`total_amount` else 0 end)) AS `total_converted_value` FROM `estimates` AS `e` GROUP BY date_format(`e`.`created_at`,'%Y-%m'), `e`.`estimate_type` ORDER BY `month` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `estimate_pipeline_value`
--
DROP TABLE IF EXISTS `estimate_pipeline_value`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estimate_pipeline_value`  AS SELECT `e`.`status` AS `status`, count(0) AS `estimate_count`, sum(`e`.`total_amount`) AS `total_potential_value`, avg(`e`.`total_amount`) AS `avg_estimate_value`, min(`e`.`created_at`) AS `oldest_estimate`, max(`e`.`created_at`) AS `newest_estimate` FROM `estimates` AS `e` WHERE (`e`.`status` in ('sent_to_customer','customer_reviewed','accepted')) GROUP BY `e`.`status` ORDER BY (case `e`.`status` when 'accepted' then 1 when 'customer_reviewed' then 2 when 'sent_to_customer' then 3 else 4 end) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `estimate_profitability`
--
DROP TABLE IF EXISTS `estimate_profitability`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estimate_profitability`  AS SELECT `e`.`estimate_id` AS `estimate_id`, `e`.`estimate_number` AS `estimate_number`, `e`.`total_amount` AS `total_amount`, sum((`ei`.`unit_cost` * `ei`.`quantity`)) AS `total_cost`, (`e`.`total_amount` - sum((`ei`.`unit_cost` * `ei`.`quantity`))) AS `total_profit`, round((((`e`.`total_amount` - sum((`ei`.`unit_cost` * `ei`.`quantity`))) / `e`.`total_amount`) * 100),2) AS `profit_margin_percentage`, `e`.`estimate_type` AS `estimate_type`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `customer_name`, `e`.`created_at` AS `created_at` FROM ((`estimates` `e` join `estimate_items` `ei` on((`e`.`estimate_id` = `ei`.`estimate_id`))) join `customers` `c` on((`e`.`customer_id` = `c`.`customer_id`))) WHERE (`e`.`status` = 'converted_to_sale') GROUP BY `e`.`estimate_id` ORDER BY `profit_margin_percentage` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `gemstone_inventory_by_product`
--
DROP TABLE IF EXISTS `gemstone_inventory_by_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gemstone_inventory_by_product`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, `g`.`gemstone_name` AS `gemstone_name`, `g`.`type` AS `gemstone_type`, sum(`pc`.`gemstone_quantity`) AS `total_stones`, sum(`pc`.`gemstone_carat_weight`) AS `total_carat_weight`, avg(`p`.`gemstone_weight`) AS `avg_stone_weight` FROM ((`products` `p` join `product_components` `pc` on((`p`.`product_id` = `pc`.`product_id`))) join `gemstones` `g` on((`pc`.`gemstone_id` = `g`.`gemstone_id`))) WHERE (`pc`.`gemstone_id` is not null) GROUP BY `p`.`product_id`, `g`.`gemstone_id` ;

-- --------------------------------------------------------

--
-- Structure for view `intent_conversion_rates`
--
DROP TABLE IF EXISTS `intent_conversion_rates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `intent_conversion_rates`  AS SELECT date_format(`i`.`created_at`,'%Y-%m') AS `month`, `i`.`intent_type` AS `intent_type`, count(0) AS `total_intents`, sum((case when (`i`.`status` = 'order_created') then 1 else 0 end)) AS `converted`, sum((case when (`i`.`status` in ('quotation_rejected','cancelled','lost')) then 1 else 0 end)) AS `lost`, round(((sum((case when (`i`.`status` = 'order_created') then 1 else 0 end)) / count(0)) * 100),2) AS `conversion_rate`, avg(`i`.`estimated_value`) AS `avg_estimated_value`, sum((case when (`i`.`status` = 'order_created') then `i`.`estimated_value` else 0 end)) AS `total_converted_value` FROM `product_intents` AS `i` GROUP BY date_format(`i`.`created_at`,'%Y-%m'), `i`.`intent_type` ORDER BY `month` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `intent_pipeline_value`
--
DROP TABLE IF EXISTS `intent_pipeline_value`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `intent_pipeline_value`  AS SELECT `i`.`status` AS `status`, count(0) AS `intent_count`, sum(`i`.`estimated_value`) AS `total_potential_value`, sum((`i`.`estimated_value` * (`i`.`probability_of_sale` / 100))) AS `weighted_value`, avg(`i`.`probability_of_sale`) AS `avg_probability` FROM `product_intents` AS `i` WHERE (`i`.`status` not in ('completed','cancelled','lost')) GROUP BY `i`.`status` ORDER BY (case `i`.`status` when 'new' then 1 when 'contacted' then 2 when 'design_in_progress' then 3 when 'quotation_sent' then 4 when 'quotation_reviewed' then 5 when 'quotation_accepted' then 6 when 'order_created' then 7 else 8 end) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `inventory_accuracy_report`
--
DROP TABLE IF EXISTS `inventory_accuracy_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory_accuracy_report`  AS SELECT `sc`.`count_number` AS `count_number`, `sc`.`count_date` AS `count_date`, `l`.`location_name` AS `location_name`, `sc`.`total_items_expected` AS `total_items_expected`, `sc`.`total_items_counted` AS `total_items_counted`, `sc`.`total_variance_count` AS `total_variance_count`, `sc`.`total_variance_value` AS `total_variance_value`, `sc`.`accuracy_percentage` AS `accuracy_percentage`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `supervisor`, `sc`.`status` AS `status`, (case when (`sc`.`accuracy_percentage` >= 98) then 'EXCELLENT' when (`sc`.`accuracy_percentage` >= 95) then 'GOOD' when (`sc`.`accuracy_percentage` >= 90) then 'FAIR' else 'POOR' end) AS `accuracy_rating` FROM ((`stock_counts` `sc` left join `locations` `l` on((`sc`.`location_id` = `l`.`location_id`))) left join `users` `u` on((`sc`.`supervisor_id` = `u`.`user_id`))) WHERE (`sc`.`status` in ('completed','verified')) ;

-- --------------------------------------------------------

--
-- Structure for view `inventory_transactions_summary`
--
DROP TABLE IF EXISTS `inventory_transactions_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory_transactions_summary`  AS SELECT cast(`inventory_transactions`.`transaction_date` as date) AS `transaction_day`, `inventory_transactions`.`transaction_type` AS `transaction_type`, count(0) AS `transaction_count`, sum(`inventory_transactions`.`quantity_change`) AS `total_quantity_change`, sum(`inventory_transactions`.`total_cost`) AS `total_cost_change`, count(distinct `inventory_transactions`.`product_id`) AS `unique_products`, count(distinct `inventory_transactions`.`user_id`) AS `unique_users` FROM `inventory_transactions` WHERE (`inventory_transactions`.`status` = 'completed') GROUP BY cast(`inventory_transactions`.`transaction_date` as date), `inventory_transactions`.`transaction_type` ORDER BY `transaction_day` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `low_stock_alert`
--
DROP TABLE IF EXISTS `low_stock_alert`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `low_stock_alert`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, `p`.`quantity_in_stock` AS `quantity_in_stock`, `p`.`minimum_stock_level` AS `minimum_stock_level`, `s`.`company_name` AS `supplier`, `s`.`phone` AS `supplier_phone` FROM (`products` `p` left join `suppliers` `s` on((`p`.`supplier_id` = `s`.`supplier_id`))) WHERE ((`p`.`quantity_in_stock` <= `p`.`minimum_stock_level`) AND (`p`.`is_active` = true)) ;

-- --------------------------------------------------------

--
-- Structure for view `product_component_summary`
--
DROP TABLE IF EXISTS `product_component_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_component_summary`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, count(`pc`.`component_id`) AS `total_components`, sum(`pc`.`material_weight`) AS `total_material_weight`, sum(`pc`.`gemstone_weight`) AS `total_gemstone_weight`, sum(`pc`.`gemstone_carat_weight`) AS `total_gemstone_carat`, sum(`pc`.`total_component_cost`) AS `total_component_cost`, sum(`pl`.`labor_cost`) AS `total_labor_cost`, `p`.`cost_price` AS `cost_price`, `p`.`selling_price` AS `selling_price` FROM ((`products` `p` left join `product_components` `pc` on((`p`.`product_id` = `pc`.`product_id`))) left join `product_labor` `pl` on((`p`.`product_id` = `pl`.`product_id`))) GROUP BY `p`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `reorder_suggestions`
--
DROP TABLE IF EXISTS `reorder_suggestions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reorder_suggestions`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, `c`.`category_name` AS `category_name`, `l`.`location_name` AS `location_name`, `isl`.`quantity_available` AS `quantity_available`, `isl`.`reorder_point` AS `reorder_point`, `isl`.`safety_stock_level` AS `safety_stock_level`, `isl`.`reorder_quantity` AS `reorder_quantity`, `isl`.`last_reorder_date` AS `last_reorder_date`, `isl`.`next_reorder_date` AS `next_reorder_date`, coalesce(`rr`.`minimum_stock`,`isl`.`minimum_stock_level`) AS `suggested_minimum`, coalesce(`rr`.`reorder_quantity`,`isl`.`reorder_quantity`) AS `suggested_reorder_qty`, `p`.`supplier_id` AS `supplier_id`, `s`.`company_name` AS `supplier_name`, (case when (`isl`.`quantity_available` <= `isl`.`safety_stock_level`) then 'URGENT' when (`isl`.`quantity_available` <= `isl`.`reorder_point`) then 'PRIORITY' else 'NORMAL' end) AS `reorder_priority`, `p`.`cost_price` AS `cost_price`, (coalesce(`rr`.`reorder_quantity`,`isl`.`reorder_quantity`) * `p`.`cost_price`) AS `estimated_cost` FROM (((((`inventory_stock` `isl` join `products` `p` on((`isl`.`product_id` = `p`.`product_id`))) join `locations` `l` on((`isl`.`location_id` = `l`.`location_id`))) left join `categories` `c` on((`p`.`category_id` = `c`.`category_id`))) left join `suppliers` `s` on((`p`.`supplier_id` = `s`.`supplier_id`))) left join `replenishment_rules` `rr` on(((`p`.`product_id` = `rr`.`product_id`) and (`isl`.`location_id` = `rr`.`location_id`)))) WHERE ((`p`.`is_active` = true) AND (`isl`.`quantity_available` <= `isl`.`reorder_point`) AND ((`isl`.`next_reorder_date` is null) OR (`isl`.`next_reorder_date` <= curdate()))) ;

-- --------------------------------------------------------

--
-- Structure for view `slow_moving_inventory`
--
DROP TABLE IF EXISTS `slow_moving_inventory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `slow_moving_inventory`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`sku` AS `sku`, `p`.`product_name` AS `product_name`, `c`.`category_name` AS `category_name`, sum(`isl`.`quantity_on_hand`) AS `total_quantity`, sum(`isl`.`total_value`) AS `total_value`, max(`isl`.`last_movement_date`) AS `last_movement_date`, (to_days(curdate()) - to_days(max(`isl`.`last_movement_date`))) AS `days_since_last_movement`, (case when ((to_days(curdate()) - to_days(max(`isl`.`last_movement_date`))) > 180) then 'NON-MOVING' when ((to_days(curdate()) - to_days(max(`isl`.`last_movement_date`))) > 90) then 'SLOW-MOVING' else 'ACTIVE' end) AS `movement_status`, `p`.`selling_price` AS `selling_price`, `p`.`cost_price` AS `cost_price`, (`p`.`selling_price` - `p`.`cost_price`) AS `profit_margin` FROM ((`inventory_stock` `isl` join `products` `p` on((`isl`.`product_id` = `p`.`product_id`))) left join `categories` `c` on((`p`.`category_id` = `c`.`category_id`))) WHERE (`p`.`is_active` = true) GROUP BY `p`.`product_id` HAVING (`total_quantity` > 0) ;

-- --------------------------------------------------------

--
-- Structure for view `staff_estimate_performance`
--
DROP TABLE IF EXISTS `staff_estimate_performance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `staff_estimate_performance`  AS SELECT `u`.`user_id` AS `user_id`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `staff_name`, `u`.`role` AS `role`, count(`e`.`estimate_id`) AS `total_estimates_created`, sum((case when (`e`.`status` = 'converted_to_sale') then 1 else 0 end)) AS `estimates_converted`, sum((case when (`e`.`status` = 'rejected') then 1 else 0 end)) AS `estimates_rejected`, round(((sum((case when (`e`.`status` = 'converted_to_sale') then 1 else 0 end)) / count(`e`.`estimate_id`)) * 100),2) AS `conversion_rate`, sum((case when (`e`.`status` = 'converted_to_sale') then `e`.`total_amount` else 0 end)) AS `total_sales_value`, avg((case when (`e`.`status` = 'converted_to_sale') then `e`.`total_amount` end)) AS `avg_sale_value`, avg((to_days(`e`.`accepted_date`) - to_days(`e`.`created_at`))) AS `avg_days_to_acceptance` FROM (`users` `u` left join `estimates` `e` on((`u`.`user_id` = `e`.`created_by`))) WHERE ((`u`.`is_active` = true) AND (`u`.`role` in ('salesperson','manager','admin'))) GROUP BY `u`.`user_id` ORDER BY `conversion_rate` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `stock_valuation_by_category`
--
DROP TABLE IF EXISTS `stock_valuation_by_category`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_valuation_by_category`  AS SELECT `c`.`category_id` AS `category_id`, `c`.`category_name` AS `category_name`, count(distinct `p`.`product_id`) AS `product_count`, sum(`isl`.`quantity_on_hand`) AS `total_quantity`, sum(`isl`.`total_value`) AS `total_value`, avg((`p`.`selling_price` - `p`.`cost_price`)) AS `avg_profit_margin`, avg(`isl`.`stock_turnover_rate`) AS `avg_turnover_rate` FROM ((`inventory_stock` `isl` join `products` `p` on((`isl`.`product_id` = `p`.`product_id`))) join `categories` `c` on((`p`.`category_id` = `c`.`category_id`))) WHERE (`p`.`is_active` = true) GROUP BY `c`.`category_id` ORDER BY `total_value` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `user_intent_performance`
--
DROP TABLE IF EXISTS `user_intent_performance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_intent_performance`  AS SELECT `u`.`user_id` AS `user_id`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `user_name`, `u`.`role` AS `role`, count(distinct `i`.`intent_id`) AS `total_intents_assigned`, count(distinct (case when (`i`.`status` = 'order_created') then `i`.`intent_id` end)) AS `intents_converted`, count(distinct (case when (`i`.`status` in ('quotation_rejected','cancelled','lost')) then `i`.`intent_id` end)) AS `intents_lost`, round(((count(distinct (case when (`i`.`status` = 'order_created') then `i`.`intent_id` end)) / count(distinct `i`.`intent_id`)) * 100),2) AS `conversion_rate`, sum((case when (`i`.`status` = 'order_created') then `i`.`estimated_value` else 0 end)) AS `total_sales_value`, avg((case when (`i`.`status` = 'order_created') then `i`.`estimated_value` end)) AS `avg_sale_value` FROM (`users` `u` left join `product_intents` `i` on((`u`.`user_id` = `i`.`assigned_user_id`))) WHERE (`u`.`is_active` = true) GROUP BY `u`.`user_id` ORDER BY `conversion_rate` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `idx_date` (`appointment_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_date` (`created_at`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `component_stock`
--
ALTER TABLE `component_stock`
  ADD PRIMARY KEY (`component_stock_id`),
  ADD UNIQUE KEY `stock_code` (`stock_code`),
  ADD KEY `idx_stock_code` (`stock_code`),
  ADD KEY `idx_component_type` (`component_type_id`),
  ADD KEY `component_type_id` (`component_type_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `component_types`
--
ALTER TABLE `component_types`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_code` (`customer_code`),
  ADD KEY `idx_customer_type` (`customer_type`),
  ADD KEY `idx_name` (`last_name`,`first_name`);

--
-- Indexes for table `customer_tags`
--
ALTER TABLE `customer_tags`
  ADD PRIMARY KEY (`customer_tag_id`),
  ADD UNIQUE KEY `unique_customer_tag` (`customer_id`,`tag_id`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_tag` (`tag_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `diamond_details`
--
ALTER TABLE `diamond_details`
  ADD PRIMARY KEY (`diamond_id`),
  ADD UNIQUE KEY `unique_diamond_cert` (`certificate_lab`,`certificate_number`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`estimate_id`),
  ADD UNIQUE KEY `estimate_number` (`estimate_number`),
  ADD KEY `idx_estimate_number` (`estimate_number`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_valid_until` (`valid_until`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `approver_id` (`approver_id`),
  ADD KEY `related_intent_id` (`related_intent_id`),
  ADD KEY `related_repair_id` (`related_repair_id`),
  ADD KEY `related_sale_id` (`related_sale_id`);

--
-- Indexes for table `estimate_approvals`
--
ALTER TABLE `estimate_approvals`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_approver` (`approver_id`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `estimate_communications`
--
ALTER TABLE `estimate_communications`
  ADD PRIMARY KEY (`communication_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_communication_type` (`communication_type`),
  ADD KEY `idx_sent_at` (`sent_at`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `sent_by` (`sent_by`);

--
-- Indexes for table `estimate_comparisons`
--
ALTER TABLE `estimate_comparisons`
  ADD PRIMARY KEY (`comparison_id`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `estimate_id_1` (`estimate_id_1`),
  ADD KEY `estimate_id_2` (`estimate_id_2`),
  ADD KEY `estimate_id_3` (`estimate_id_3`),
  ADD KEY `estimate_id_4` (`estimate_id_4`),
  ADD KEY `recommended_estimate_id` (`recommended_estimate_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `estimate_discounts`
--
ALTER TABLE `estimate_discounts`
  ADD PRIMARY KEY (`discount_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `estimate_images`
--
ALTER TABLE `estimate_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_image_type` (`image_type`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_item_type` (`item_type`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `labor_id` (`labor_id`);

--
-- Indexes for table `estimate_options`
--
ALTER TABLE `estimate_options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_parent_item` (`parent_item_id`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `parent_item_id` (`parent_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `estimate_revisions`
--
ALTER TABLE `estimate_revisions`
  ADD PRIMARY KEY (`revision_id`),
  ADD UNIQUE KEY `unique_estimate_revision` (`estimate_id`,`revision_number`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_current_version` (`is_current_version`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `revised_by` (`revised_by`);

--
-- Indexes for table `estimate_specifications`
--
ALTER TABLE `estimate_specifications`
  ADD PRIMARY KEY (`spec_id`),
  ADD UNIQUE KEY `unique_estimate_spec` (`estimate_id`,`spec_key`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `estimate_id` (`estimate_id`);

--
-- Indexes for table `estimate_statistics`
--
ALTER TABLE `estimate_statistics`
  ADD PRIMARY KEY (`stat_id`),
  ADD UNIQUE KEY `unique_estimate_stat` (`estimate_id`),
  ADD KEY `estimate_id` (`estimate_id`);

--
-- Indexes for table `estimate_taxes`
--
ALTER TABLE `estimate_taxes`
  ADD PRIMARY KEY (`tax_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `estimate_id` (`estimate_id`);

--
-- Indexes for table `estimate_templates`
--
ALTER TABLE `estimate_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD UNIQUE KEY `template_name` (`template_name`),
  ADD KEY `idx_template_type` (`template_type`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `estimate_terms`
--
ALTER TABLE `estimate_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `idx_estimate` (`estimate_id`),
  ADD KEY `idx_category` (`term_category`),
  ADD KEY `estimate_id` (`estimate_id`);

--
-- Indexes for table `fifo_layers`
--
ALTER TABLE `fifo_layers`
  ADD PRIMARY KEY (`layer_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_receipt_date` (`receipt_date`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gemstones`
--
ALTER TABLE `gemstones`
  ADD PRIMARY KEY (`gemstone_id`),
  ADD UNIQUE KEY `gemstone_code` (`gemstone_code`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `good_receive_notes`
--
ALTER TABLE `good_receive_notes`
  ADD PRIMARY KEY (`grn_id`),
  ADD UNIQUE KEY `grn_number` (`grn_number`),
  ADD KEY `idx_grn_number` (`grn_number`),
  ADD KEY `idx_po` (`po_id`),
  ADD KEY `idx_supplier` (`supplier_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_received_date` (`received_date`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `received_by` (`received_by`),
  ADD KEY `receiving_location_id` (`receiving_location_id`),
  ADD KEY `storage_location_id` (`storage_location_id`);

--
-- Indexes for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD PRIMARY KEY (`grn_item_id`),
  ADD KEY `idx_grn` (`grn_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_status` (`item_status`),
  ADD KEY `grn_id` (`grn_id`),
  ADD KEY `po_item_id` (`po_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `received_location_id` (`received_location_id`);

--
-- Indexes for table `grn_serialized_items`
--
ALTER TABLE `grn_serialized_items`
  ADD PRIMARY KEY (`grn_serial_id`),
  ADD KEY `idx_grn_item` (`grn_item_id`),
  ADD KEY `idx_serial_number` (`serial_number`),
  ADD KEY `grn_item_id` (`grn_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `assigned_location_id` (`assigned_location_id`);

--
-- Indexes for table `intent_analytics`
--
ALTER TABLE `intent_analytics`
  ADD PRIMARY KEY (`analytic_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `intent_id` (`intent_id`);

--
-- Indexes for table `intent_attachments`
--
ALTER TABLE `intent_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `idx_type` (`file_type`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `intent_categories`
--
ALTER TABLE `intent_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `intent_category_mapping`
--
ALTER TABLE `intent_category_mapping`
  ADD PRIMARY KEY (`mapping_id`),
  ADD UNIQUE KEY `unique_intent_category` (`intent_id`,`category_id`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `intent_communications`
--
ALTER TABLE `intent_communications`
  ADD PRIMARY KEY (`communication_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_type` (`communication_type`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `intent_conversions`
--
ALTER TABLE `intent_conversions`
  ADD PRIMARY KEY (`conversion_id`),
  ADD UNIQUE KEY `unique_intent_conversion` (`intent_id`,`converted_entity_type`,`converted_entity_id`),
  ADD KEY `idx_conversion_date` (`conversion_date`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `converted_by` (`converted_by`);

--
-- Indexes for table `intent_history`
--
ALTER TABLE `intent_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `idx_action` (`action_type`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `intent_items`
--
ALTER TABLE `intent_items`
  ADD PRIMARY KEY (`intent_item_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `material_preference_id` (`material_preference_id`);

--
-- Indexes for table `intent_reminders`
--
ALTER TABLE `intent_reminders`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `idx_intent` (`intent_id`),
  ADD KEY `idx_reminder_date` (`reminder_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `intent_id` (`intent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `intent_templates`
--
ALTER TABLE `intent_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD UNIQUE KEY `template_name` (`template_name`),
  ADD KEY `idx_type` (`template_type`),
  ADD KEY `default_category_id` (`default_category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `inventory_aging`
--
ALTER TABLE `inventory_aging`
  ADD PRIMARY KEY (`aging_id`),
  ADD UNIQUE KEY `unique_product_aging` (`product_id`,`location_id`,`as_of_date`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_as_of_date` (`as_of_date`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `inventory_alerts`
--
ALTER TABLE `inventory_alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `idx_alert_type` (`alert_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_triggered` (`triggered_at`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `acknowledged_by` (`acknowledged_by`),
  ADD KEY `resolved_by` (`resolved_by`);

--
-- Indexes for table `inventory_forecast`
--
ALTER TABLE `inventory_forecast`
  ADD PRIMARY KEY (`forecast_id`),
  ADD UNIQUE KEY `unique_product_forecast` (`product_id`,`location_id`,`forecast_date`,`forecast_type`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_forecast_date` (`forecast_date`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `inventory_kpis`
--
ALTER TABLE `inventory_kpis`
  ADD PRIMARY KEY (`kpi_id`),
  ADD UNIQUE KEY `unique_kpi` (`product_id`,`category_id`,`location_id`,`period_start`,`period_end`),
  ADD KEY `idx_period` (`period_start`,`period_end`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `inventory_stock`
--
ALTER TABLE `inventory_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD UNIQUE KEY `unique_product_location` (`product_id`,`location_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `idx_quantity_available` (`quantity_available`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `idx_transaction_type` (`transaction_type`),
  ADD KEY `idx_product_date` (`product_id`,`transaction_date`),
  ADD KEY `idx_reference` (`reference_table`,`reference_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `idx_date` (`transaction_date`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `to_location_id` (`to_location_id`),
  ADD KEY `serial_id` (`serial_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `inventory_valuation`
--
ALTER TABLE `inventory_valuation`
  ADD PRIMARY KEY (`valuation_id`),
  ADD UNIQUE KEY `unique_product_valuation` (`product_id`,`valuation_date`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_date` (`valuation_date`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `labor_types`
--
ALTER TABLE `labor_types`
  ADD PRIMARY KEY (`labor_id`),
  ADD UNIQUE KEY `labor_code` (`labor_code`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD UNIQUE KEY `location_code` (`location_code`),
  ADD KEY `parent_location_id` (`parent_location_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD UNIQUE KEY `material_name` (`material_name`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`measurement_id`);

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`po_item_id`),
  ADD KEY `idx_po` (`po_id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_sku` (`sku`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_price` (`selling_price`),
  ADD KEY `idx_stock` (`quantity_in_stock`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `product_components`
--
ALTER TABLE `product_components`
  ADD PRIMARY KEY (`component_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_type` (`component_type_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `component_type_id` (`component_type_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `gemstone_id` (`gemstone_id`);

--
-- Indexes for table `product_cost_breakdown`
--
ALTER TABLE `product_cost_breakdown`
  ADD PRIMARY KEY (`breakdown_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_hallmarks`
--
ALTER TABLE `product_hallmarks`
  ADD PRIMARY KEY (`hallmark_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_type` (`hallmark_type`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_intents`
--
ALTER TABLE `product_intents`
  ADD PRIMARY KEY (`intent_id`),
  ADD UNIQUE KEY `intent_number` (`intent_number`),
  ADD KEY `idx_intent_number` (`intent_number`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_type` (`intent_type`),
  ADD KEY `idx_assigned_user` (`assigned_user_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `assigned_user_id` (`assigned_user_id`),
  ADD KEY `reference_product_id` (`reference_product_id`),
  ADD KEY `converted_to_sale_id` (`converted_to_sale_id`),
  ADD KEY `converted_to_product_id` (`converted_to_product_id`);

--
-- Indexes for table `product_labor`
--
ALTER TABLE `product_labor`
  ADD PRIMARY KEY (`product_labor_id`),
  ADD UNIQUE KEY `unique_product_labor` (`product_id`,`labor_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `labor_id` (`labor_id`);

--
-- Indexes for table `product_measurements`
--
ALTER TABLE `product_measurements`
  ADD PRIMARY KEY (`measurement_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_type` (`measurement_type`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_sets`
--
ALTER TABLE `product_sets`
  ADD PRIMARY KEY (`set_id`),
  ADD UNIQUE KEY `set_sku` (`set_sku`);

--
-- Indexes for table `product_set_items`
--
ALTER TABLE `product_set_items`
  ADD PRIMARY KEY (`set_item_id`),
  ADD UNIQUE KEY `unique_set_product` (`set_id`,`product_id`),
  ADD KEY `set_id` (`set_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_tag_id`),
  ADD UNIQUE KEY `unique_product_tag` (`product_id`,`tag_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_tag` (`tag_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `product_treatments`
--
ALTER TABLE `product_treatments`
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotion_id`),
  ADD UNIQUE KEY `promo_code` (`promo_code`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`po_id`),
  ADD UNIQUE KEY `po_number` (`po_number`),
  ADD KEY `idx_po_number` (`po_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  ADD PRIMARY KEY (`requisition_id`),
  ADD UNIQUE KEY `requisition_number` (`requisition_number`),
  ADD KEY `idx_requisition_number` (`requisition_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_requested_by` (`requested_by`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `requested_by` (`requested_by`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  ADD PRIMARY KEY (`requisition_item_id`),
  ADD KEY `idx_requisition` (`requisition_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_status` (`item_status`),
  ADD KEY `requisition_id` (`requisition_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `preferred_supplier_id` (`preferred_supplier_id`),
  ADD KEY `po_id` (`po_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`repair_id`),
  ADD UNIQUE KEY `repair_number` (`repair_number`),
  ADD KEY `idx_repair_number` (`repair_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `replenishment_rules`
--
ALTER TABLE `replenishment_rules`
  ADD PRIMARY KEY (`rule_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `requisition_approval_history`
--
ALTER TABLE `requisition_approval_history`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `idx_requisition` (`requisition_id`),
  ADD KEY `idx_approver` (`approver_id`),
  ADD KEY `requisition_id` (`requisition_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD UNIQUE KEY `return_number` (`return_number`),
  ADD KEY `idx_return_number` (`return_number`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `idx_invoice` (`invoice_number`),
  ADD KEY `idx_sale_date` (`sale_date`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_status` (`sale_status`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `idx_sale` (`sale_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `serialized_products`
--
ALTER TABLE `serialized_products`
  ADD PRIMARY KEY (`serial_id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `idx_serial_number` (`serial_number`),
  ADD KEY `idx_product_serial` (`product_id`,`serial_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_barcode` (`barcode`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `inspected_by` (`inspected_by`),
  ADD KEY `current_owner_customer_id` (`current_owner_customer_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `serialized_product_tags`
--
ALTER TABLE `serialized_product_tags`
  ADD PRIMARY KEY (`serial_tag_id`),
  ADD UNIQUE KEY `unique_serial_tag` (`serial_id`,`tag_id`),
  ADD KEY `idx_serial` (`serial_id`),
  ADD KEY `idx_tag` (`tag_id`),
  ADD KEY `serial_id` (`serial_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`adjustment_id`),
  ADD UNIQUE KEY `adjustment_number` (`adjustment_number`),
  ADD KEY `idx_adjustment_number` (`adjustment_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `idx_date` (`adjustment_date`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `requested_by` (`requested_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  ADD PRIMARY KEY (`adjustment_item_id`),
  ADD KEY `idx_adjustment` (`adjustment_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `adjustment_id` (`adjustment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD PRIMARY KEY (`count_id`),
  ADD UNIQUE KEY `count_number` (`count_number`),
  ADD KEY `idx_count_number` (`count_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `idx_date` (`count_date`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `team_leader_id` (`team_leader_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `locked_by` (`locked_by`);

--
-- Indexes for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD PRIMARY KEY (`count_item_id`),
  ADD UNIQUE KEY `unique_count_product` (`count_id`,`product_id`,`location_id`,`bin_number`),
  ADD KEY `idx_count` (`count_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `count_id` (`count_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `counted_by` (`counted_by`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`transfer_id`),
  ADD UNIQUE KEY `transfer_number` (`transfer_number`),
  ADD KEY `idx_transfer_number` (`transfer_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_from_location` (`from_location_id`),
  ADD KEY `idx_to_location` (`to_location_id`),
  ADD KEY `from_location_id` (`from_location_id`),
  ADD KEY `to_location_id` (`to_location_id`),
  ADD KEY `requested_by` (`requested_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `sent_by` (`sent_by`),
  ADD KEY `received_by` (`received_by`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD PRIMARY KEY (`transfer_item_id`),
  ADD KEY `idx_transfer` (`transfer_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_status` (`item_status`),
  ADD KEY `transfer_id` (`transfer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `supplier_code` (`supplier_code`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`),
  ADD KEY `idx_tag_type` (`tag_type`),
  ADD KEY `idx_tag_group` (`tag_group`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `unique_wishlist_item` (`customer_id`,`product_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `component_stock`
--
ALTER TABLE `component_stock`
  MODIFY `component_stock_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `component_types`
--
ALTER TABLE `component_types`
  MODIFY `type_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_tags`
--
ALTER TABLE `customer_tags`
  MODIFY `customer_tag_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diamond_details`
--
ALTER TABLE `diamond_details`
  MODIFY `diamond_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `estimate_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_approvals`
--
ALTER TABLE `estimate_approvals`
  MODIFY `approval_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_communications`
--
ALTER TABLE `estimate_communications`
  MODIFY `communication_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_comparisons`
--
ALTER TABLE `estimate_comparisons`
  MODIFY `comparison_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_discounts`
--
ALTER TABLE `estimate_discounts`
  MODIFY `discount_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_images`
--
ALTER TABLE `estimate_images`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_items`
--
ALTER TABLE `estimate_items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_options`
--
ALTER TABLE `estimate_options`
  MODIFY `option_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_revisions`
--
ALTER TABLE `estimate_revisions`
  MODIFY `revision_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_specifications`
--
ALTER TABLE `estimate_specifications`
  MODIFY `spec_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_statistics`
--
ALTER TABLE `estimate_statistics`
  MODIFY `stat_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_taxes`
--
ALTER TABLE `estimate_taxes`
  MODIFY `tax_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_templates`
--
ALTER TABLE `estimate_templates`
  MODIFY `template_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_terms`
--
ALTER TABLE `estimate_terms`
  MODIFY `term_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fifo_layers`
--
ALTER TABLE `fifo_layers`
  MODIFY `layer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gemstones`
--
ALTER TABLE `gemstones`
  MODIFY `gemstone_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_receive_notes`
--
ALTER TABLE `good_receive_notes`
  MODIFY `grn_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grn_items`
--
ALTER TABLE `grn_items`
  MODIFY `grn_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grn_serialized_items`
--
ALTER TABLE `grn_serialized_items`
  MODIFY `grn_serial_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_analytics`
--
ALTER TABLE `intent_analytics`
  MODIFY `analytic_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_attachments`
--
ALTER TABLE `intent_attachments`
  MODIFY `attachment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_categories`
--
ALTER TABLE `intent_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_category_mapping`
--
ALTER TABLE `intent_category_mapping`
  MODIFY `mapping_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_communications`
--
ALTER TABLE `intent_communications`
  MODIFY `communication_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_conversions`
--
ALTER TABLE `intent_conversions`
  MODIFY `conversion_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_history`
--
ALTER TABLE `intent_history`
  MODIFY `history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_items`
--
ALTER TABLE `intent_items`
  MODIFY `intent_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_reminders`
--
ALTER TABLE `intent_reminders`
  MODIFY `reminder_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intent_templates`
--
ALTER TABLE `intent_templates`
  MODIFY `template_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_aging`
--
ALTER TABLE `inventory_aging`
  MODIFY `aging_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_alerts`
--
ALTER TABLE `inventory_alerts`
  MODIFY `alert_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_forecast`
--
ALTER TABLE `inventory_forecast`
  MODIFY `forecast_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_kpis`
--
ALTER TABLE `inventory_kpis`
  MODIFY `kpi_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_stock`
--
ALTER TABLE `inventory_stock`
  MODIFY `stock_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_valuation`
--
ALTER TABLE `inventory_valuation`
  MODIFY `valuation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labor_types`
--
ALTER TABLE `labor_types`
  MODIFY `labor_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `measurement_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `po_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_components`
--
ALTER TABLE `product_components`
  MODIFY `component_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_cost_breakdown`
--
ALTER TABLE `product_cost_breakdown`
  MODIFY `breakdown_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_hallmarks`
--
ALTER TABLE `product_hallmarks`
  MODIFY `hallmark_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_intents`
--
ALTER TABLE `product_intents`
  MODIFY `intent_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_labor`
--
ALTER TABLE `product_labor`
  MODIFY `product_labor_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_measurements`
--
ALTER TABLE `product_measurements`
  MODIFY `measurement_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sets`
--
ALTER TABLE `product_sets`
  MODIFY `set_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_set_items`
--
ALTER TABLE `product_set_items`
  MODIFY `set_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `product_tag_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_treatments`
--
ALTER TABLE `product_treatments`
  MODIFY `treatment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promotion_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `po_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  MODIFY `requisition_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  MODIFY `requisition_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `repair_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replenishment_rules`
--
ALTER TABLE `replenishment_rules`
  MODIFY `rule_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisition_approval_history`
--
ALTER TABLE `requisition_approval_history`
  MODIFY `approval_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serialized_products`
--
ALTER TABLE `serialized_products`
  MODIFY `serial_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serialized_product_tags`
--
ALTER TABLE `serialized_product_tags`
  MODIFY `serial_tag_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `adjustment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  MODIFY `adjustment_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `count_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  MODIFY `count_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `transfer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  MODIFY `transfer_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `component_stock`
--
ALTER TABLE `component_stock`
  ADD CONSTRAINT `component_stock_ibfk_1` FOREIGN KEY (`component_type_id`) REFERENCES `component_types` (`type_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `component_stock_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `component_stock_ibfk_3` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `component_stock_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_tags`
--
ALTER TABLE `customer_tags`
  ADD CONSTRAINT `customer_tags_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_tags_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `diamond_details`
--
ALTER TABLE `diamond_details`
  ADD CONSTRAINT `diamond_details_ibfk_1` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diamond_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimates`
--
ALTER TABLE `estimates`
  ADD CONSTRAINT `estimates_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimates_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `estimates_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimates_ibfk_4` FOREIGN KEY (`approver_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimates_ibfk_5` FOREIGN KEY (`related_intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimates_ibfk_6` FOREIGN KEY (`related_repair_id`) REFERENCES `repairs` (`repair_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimates_ibfk_7` FOREIGN KEY (`related_sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_approvals`
--
ALTER TABLE `estimate_approvals`
  ADD CONSTRAINT `estimate_approvals_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_approvals_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_communications`
--
ALTER TABLE `estimate_communications`
  ADD CONSTRAINT `estimate_communications_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_communications_ibfk_2` FOREIGN KEY (`sent_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_comparisons`
--
ALTER TABLE `estimate_comparisons`
  ADD CONSTRAINT `estimate_comparisons_ibfk_1` FOREIGN KEY (`estimate_id_1`) REFERENCES `estimates` (`estimate_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_comparisons_ibfk_2` FOREIGN KEY (`estimate_id_2`) REFERENCES `estimates` (`estimate_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_comparisons_ibfk_3` FOREIGN KEY (`estimate_id_3`) REFERENCES `estimates` (`estimate_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_comparisons_ibfk_4` FOREIGN KEY (`estimate_id_4`) REFERENCES `estimates` (`estimate_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_comparisons_ibfk_5` FOREIGN KEY (`recommended_estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_comparisons_ibfk_6` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `estimate_discounts`
--
ALTER TABLE `estimate_discounts`
  ADD CONSTRAINT `estimate_discounts_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_discounts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_images`
--
ALTER TABLE `estimate_images`
  ADD CONSTRAINT `estimate_images_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_images_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD CONSTRAINT `estimate_items_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_items_ibfk_3` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_items_ibfk_4` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_items_ibfk_5` FOREIGN KEY (`labor_id`) REFERENCES `labor_types` (`labor_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_options`
--
ALTER TABLE `estimate_options`
  ADD CONSTRAINT `estimate_options_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_options_ibfk_2` FOREIGN KEY (`parent_item_id`) REFERENCES `estimate_items` (`item_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_options_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_options_ibfk_4` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `estimate_options_ibfk_5` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_revisions`
--
ALTER TABLE `estimate_revisions`
  ADD CONSTRAINT `estimate_revisions_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estimate_revisions_ibfk_2` FOREIGN KEY (`revised_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `estimate_specifications`
--
ALTER TABLE `estimate_specifications`
  ADD CONSTRAINT `estimate_specifications_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE;

--
-- Constraints for table `estimate_statistics`
--
ALTER TABLE `estimate_statistics`
  ADD CONSTRAINT `estimate_statistics_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE;

--
-- Constraints for table `estimate_taxes`
--
ALTER TABLE `estimate_taxes`
  ADD CONSTRAINT `estimate_taxes_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE;

--
-- Constraints for table `estimate_templates`
--
ALTER TABLE `estimate_templates`
  ADD CONSTRAINT `estimate_templates_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `estimate_terms`
--
ALTER TABLE `estimate_terms`
  ADD CONSTRAINT `estimate_terms_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE;

--
-- Constraints for table `fifo_layers`
--
ALTER TABLE `fifo_layers`
  ADD CONSTRAINT `fifo_layers_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `good_receive_notes`
--
ALTER TABLE `good_receive_notes`
  ADD CONSTRAINT `good_receive_notes_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`po_id`),
  ADD CONSTRAINT `good_receive_notes_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `good_receive_notes_ibfk_3` FOREIGN KEY (`received_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `good_receive_notes_ibfk_4` FOREIGN KEY (`receiving_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `good_receive_notes_ibfk_5` FOREIGN KEY (`storage_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD CONSTRAINT `grn_items_ibfk_1` FOREIGN KEY (`grn_id`) REFERENCES `good_receive_notes` (`grn_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grn_items_ibfk_2` FOREIGN KEY (`po_item_id`) REFERENCES `po_items` (`po_item_id`),
  ADD CONSTRAINT `grn_items_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `grn_items_ibfk_4` FOREIGN KEY (`received_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `grn_serialized_items`
--
ALTER TABLE `grn_serialized_items`
  ADD CONSTRAINT `grn_serialized_items_ibfk_1` FOREIGN KEY (`grn_item_id`) REFERENCES `grn_items` (`grn_item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grn_serialized_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grn_serialized_items_ibfk_3` FOREIGN KEY (`assigned_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_analytics`
--
ALTER TABLE `intent_analytics`
  ADD CONSTRAINT `intent_analytics_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE;

--
-- Constraints for table `intent_attachments`
--
ALTER TABLE `intent_attachments`
  ADD CONSTRAINT `intent_attachments_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_attachments_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_category_mapping`
--
ALTER TABLE `intent_category_mapping`
  ADD CONSTRAINT `intent_category_mapping_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_category_mapping_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `intent_categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `intent_communications`
--
ALTER TABLE `intent_communications`
  ADD CONSTRAINT `intent_communications_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_communications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_conversions`
--
ALTER TABLE `intent_conversions`
  ADD CONSTRAINT `intent_conversions_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_conversions_ibfk_2` FOREIGN KEY (`converted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_history`
--
ALTER TABLE `intent_history`
  ADD CONSTRAINT `intent_history_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_items`
--
ALTER TABLE `intent_items`
  ADD CONSTRAINT `intent_items_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `intent_items_ibfk_3` FOREIGN KEY (`material_preference_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_reminders`
--
ALTER TABLE `intent_reminders`
  ADD CONSTRAINT `intent_reminders_ibfk_1` FOREIGN KEY (`intent_id`) REFERENCES `product_intents` (`intent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intent_reminders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `intent_reminders_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `intent_templates`
--
ALTER TABLE `intent_templates`
  ADD CONSTRAINT `intent_templates_ibfk_1` FOREIGN KEY (`default_category_id`) REFERENCES `intent_categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `intent_templates_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_aging`
--
ALTER TABLE `inventory_aging`
  ADD CONSTRAINT `inventory_aging_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_aging_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_alerts`
--
ALTER TABLE `inventory_alerts`
  ADD CONSTRAINT `inventory_alerts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_alerts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_alerts_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_alerts_ibfk_4` FOREIGN KEY (`acknowledged_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_alerts_ibfk_5` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_forecast`
--
ALTER TABLE `inventory_forecast`
  ADD CONSTRAINT `inventory_forecast_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_forecast_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_kpis`
--
ALTER TABLE `inventory_kpis`
  ADD CONSTRAINT `inventory_kpis_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_kpis_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_kpis_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_stock`
--
ALTER TABLE `inventory_stock`
  ADD CONSTRAINT `inventory_stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_stock_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transactions_ibfk_3` FOREIGN KEY (`to_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transactions_ibfk_4` FOREIGN KEY (`serial_id`) REFERENCES `serialized_products` (`serial_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transactions_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `inventory_valuation`
--
ALTER TABLE `inventory_valuation`
  ADD CONSTRAINT `inventory_valuation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_valuation_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`parent_location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `po_items`
--
ALTER TABLE `po_items`
  ADD CONSTRAINT `po_items_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`po_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_components`
--
ALTER TABLE `product_components`
  ADD CONSTRAINT `product_components_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_components_ibfk_2` FOREIGN KEY (`component_type_id`) REFERENCES `component_types` (`type_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_components_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_components_ibfk_4` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstones` (`gemstone_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_cost_breakdown`
--
ALTER TABLE `product_cost_breakdown`
  ADD CONSTRAINT `product_cost_breakdown_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_hallmarks`
--
ALTER TABLE `product_hallmarks`
  ADD CONSTRAINT `product_hallmarks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_intents`
--
ALTER TABLE `product_intents`
  ADD CONSTRAINT `product_intents_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_intents_ibfk_2` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_intents_ibfk_3` FOREIGN KEY (`reference_product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_intents_ibfk_4` FOREIGN KEY (`converted_to_sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_intents_ibfk_5` FOREIGN KEY (`converted_to_product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_labor`
--
ALTER TABLE `product_labor`
  ADD CONSTRAINT `product_labor_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_labor_ibfk_2` FOREIGN KEY (`labor_id`) REFERENCES `labor_types` (`labor_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_measurements`
--
ALTER TABLE `product_measurements`
  ADD CONSTRAINT `product_measurements_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_set_items`
--
ALTER TABLE `product_set_items`
  ADD CONSTRAINT `product_set_items_ibfk_1` FOREIGN KEY (`set_id`) REFERENCES `product_sets` (`set_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_set_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_treatments`
--
ALTER TABLE `product_treatments`
  ADD CONSTRAINT `product_treatments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `purchase_orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  ADD CONSTRAINT `purchase_requisitions_ibfk_1` FOREIGN KEY (`requested_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `purchase_requisitions_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  ADD CONSTRAINT `purchase_requisition_items_ibfk_1` FOREIGN KEY (`requisition_id`) REFERENCES `purchase_requisitions` (`requisition_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_requisition_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requisition_items_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requisition_items_ibfk_4` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requisition_items_ibfk_5` FOREIGN KEY (`preferred_supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_requisition_items_ibfk_6` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`po_id`) ON DELETE SET NULL;

--
-- Constraints for table `repairs`
--
ALTER TABLE `repairs`
  ADD CONSTRAINT `repairs_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `repairs_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `repairs_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `replenishment_rules`
--
ALTER TABLE `replenishment_rules`
  ADD CONSTRAINT `replenishment_rules_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replenishment_rules_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `replenishment_rules_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `replenishment_rules_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `requisition_approval_history`
--
ALTER TABLE `requisition_approval_history`
  ADD CONSTRAINT `requisition_approval_history_ibfk_1` FOREIGN KEY (`requisition_id`) REFERENCES `purchase_requisitions` (`requisition_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requisition_approval_history_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `returns_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `serialized_products`
--
ALTER TABLE `serialized_products`
  ADD CONSTRAINT `serialized_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `serialized_products_ibfk_2` FOREIGN KEY (`inspected_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `serialized_products_ibfk_3` FOREIGN KEY (`current_owner_customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `serialized_products_ibfk_4` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `serialized_products_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `serialized_products_ibfk_6` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `serialized_product_tags`
--
ALTER TABLE `serialized_product_tags`
  ADD CONSTRAINT `serialized_product_tags_ibfk_1` FOREIGN KEY (`serial_id`) REFERENCES `serialized_products` (`serial_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `serialized_product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `serialized_product_tags_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD CONSTRAINT `stock_adjustments_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `stock_adjustments_ibfk_2` FOREIGN KEY (`requested_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `stock_adjustments_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  ADD CONSTRAINT `stock_adjustment_items_ibfk_1` FOREIGN KEY (`adjustment_id`) REFERENCES `stock_adjustments` (`adjustment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_adjustment_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD CONSTRAINT `stock_counts_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_ibfk_3` FOREIGN KEY (`team_leader_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_counts_ibfk_5` FOREIGN KEY (`locked_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_count_items`
--
ALTER TABLE `stock_count_items`
  ADD CONSTRAINT `stock_count_items_ibfk_1` FOREIGN KEY (`count_id`) REFERENCES `stock_counts` (`count_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_count_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_count_items_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_count_items_ibfk_4` FOREIGN KEY (`counted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_count_items_ibfk_5` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD CONSTRAINT `stock_transfers_ibfk_1` FOREIGN KEY (`from_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `stock_transfers_ibfk_2` FOREIGN KEY (`to_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `stock_transfers_ibfk_3` FOREIGN KEY (`requested_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `stock_transfers_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_transfers_ibfk_5` FOREIGN KEY (`sent_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_transfers_ibfk_6` FOREIGN KEY (`received_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_transfers_ibfk_7` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD CONSTRAINT `stock_transfer_items_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `stock_transfers` (`transfer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfer_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
