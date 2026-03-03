$(document).ready(function () {
    // datatable js start
    new DataTable('#gemstones-table', {
        layout: {},
        "ordering": false,
        oLanguage: {
            sLengthMenu: "_MENU_",
        }
    });
    // datatable js end

    // modal delete operation start
    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let Id = button.data('id'); // Extract info from data-* attributes
        let Name = button.data('name');
        let form = $('#deleteForm');

        // Update form action URL
        form.attr('action', APP_URL + '/' + Name + '/' + Id);
    });
    // modal delete operation end

    // Function to show toast notification
    function showToast(message, type = 'success') {
        const toastHTML = `
            <div class="bs-toast toast fade ${type === 'success' ? 'bg-success' : 'bg-danger'}" role="alert" aria-live="assertive" aria-atomic="true" id="ajaxToast">
                <div class="toast-header">
                    <i class="icon-base bx bx-bell me-2"></i>
                    <div class="me-auto fw-medium">${type === 'success' ? 'Success' : 'Alert'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <strong>${message}</strong>
                </div>
            </div>
        `;

        // Create container if it doesn't exist
        let container = document.querySelector('.toast-container-custom');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container-custom';
            container.style.position = 'fixed';
            container.style.top = '20px';
            container.style.right = '20px';
            container.style.zIndex = '999';
            document.body.appendChild(container);
        }

        // Insert toast
        container.insertAdjacentHTML('beforeend', toastHTML);

        // Initialize and show toast
        const toastElement = document.getElementById('ajaxToast');
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        toast.show();

        // Remove element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });
    }

    // active and in active status changes start (banner)
    $(document).on('change', '.change_gemstone_status', function () {
        let dataId = $(this).data('id');
        let isChecked = $(this).is(':checked');
        let status = isChecked ? 'Active' : 'Inactive';
        $.ajax({
            url: APP_URL + '/change_gemstone_status',
            type: 'GET',
            data: { id: dataId, status: status },
            success: function (response) {
                if (response.success) {
                    showToast('Status updated successfully!' , 'success');
                } else {
                    showToast('Error updating status.', 'danger');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
                showToast('Error updating status.', 'danger');
            }
        });
    });
    // active and in active status changes end (banner)

    // load branches by company for gemstone form
    const $companySelect = $('#company_id');
    const $branchSelect = $('#branch_id');
    if ($companySelect.length && $branchSelect.length) {
        const populateBranches = (companyId, selectedId) => {
            $branchSelect.prop('disabled', true);
            $branchSelect.html('<option value="">Loading...</option>');
            $.ajax({
                url: APP_URL + '/get_branch_by_company',
                type: 'GET',
                data: { company_id: companyId },
                success: function (response) {
                    if (!response.success) {
                        showToast('Error fetching branches.', 'danger');
                        $branchSelect.html('<option value="">Select Branch</option>');
                        $branchSelect.prop('disabled', false);
                        return;
                    }

                    let options = '<option value="">Select Branch</option>';
                    $.each(response.branches || [], function (index, branch) {
                        const isSelected = String(branch.branch_id) === String(selectedId) ? ' selected' : '';
                        options += `<option value="${branch.branch_id}"${isSelected}>${branch.branch_name}</option>`;
                    });

                    $branchSelect.html(options);
                    $branchSelect.prop('disabled', false);
                },
                error: function () {
                    showToast('Error fetching branches.', 'danger');
                    $branchSelect.html('<option value="">Select Branch</option>');
                    $branchSelect.prop('disabled', false);
                }
            });
        };

        $companySelect.on('change', function () {
            const companyId = $(this).val();
            if (!companyId) {
                $branchSelect.html('<option value="">Select Branch</option>');
                return;
            }
            populateBranches(companyId, $branchSelect.data('selected'));
        });

        const initialCompanyId = $companySelect.val();
        if (initialCompanyId) {
            populateBranches(initialCompanyId, $branchSelect.data('selected'));
        }
    }
});
