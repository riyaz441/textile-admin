<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryStock;
use App\Models\LocationMaster;
use App\Models\Product;

class InventoryStockController extends Controller
{
    /**
     * Display a listing of inventory stock records.
     */
    public function index()
    {
        $data['inventoryStocks'] = InventoryStock::with(['product', 'location'])
            ->orderBy('stock_id', 'DESC')
            ->get();

        return view('inventory_stocks.index', $data);
    }

    /**
     * Show the form for creating or editing inventory stock.
     */
    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data['inventoryStock'] = InventoryStock::findOrFail($id);
        }

        $data['products'] = Product::orderBy('product_name')->get();
        $data['locations'] = LocationMaster::orderBy('location_name')->get();

        return view('inventory_stocks.form', $data);
    }

    /**
     * Store or update inventory stock.
     */
    public function save(Request $request, $id = null)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'location_id' => 'required|exists:locations,location_id',
            'status' => 'required|in:Active,Inactive',
            'quantity_on_hand' => 'required|integer|min:0',
            'quantity_allocated' => 'required|integer|min:0',
            'quantity_available' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:0',
            'last_reorder_date' => 'nullable|date',
            'next_reorder_date' => 'nullable|date',
            'average_cost' => 'required|numeric|min:0',
            'total_value' => 'required|numeric|min:0',
            'stock_turnover_rate' => 'nullable|numeric|min:0',
            'days_in_stock' => 'required|integer|min:0',
            'last_movement_date' => 'nullable|date',
            'safety_stock_level' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_level' => 'nullable|integer|min:0',
        ]);

        $inventoryStock = $id
            ? InventoryStock::findOrFail($id)
            : new InventoryStock();

        $inventoryStock->fill($validated);
        $inventoryStock->save();

        return redirect()->route('inventory-stocks.index')
            ->with('success', 'Inventory stock saved successfully');
    }

    /**
     * Delete inventory stock.
     */
    public function destroy($id)
    {
        InventoryStock::findOrFail($id)->delete();

        return redirect()->route('inventory-stocks.index')
            ->with('success', 'Inventory stock deleted successfully');
    }

    /**
     * Display the specified inventory stock record.
     */
    public function show($id)
    {
        $data['inventoryStock'] = InventoryStock::with(['product', 'location'])
            ->findOrFail($id);

        return view('inventory_stocks.show', $data);
    }

    /**
     * Change the status of an inventory stock.
     */
    public function changeStatus(Request $request)
    {
        $inventoryStock = InventoryStock::findOrFail($request->id);
        $inventoryStock->status = $request->status;
        $inventoryStock->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}
