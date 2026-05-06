<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * 1. Dashboard View with Filtering Logic
     */
    public function dashboard(Request $request) 
    {
        // Statistics for the top cards (Always calculated from the full dataset)
        $totalSales = Order::where('status', 'Completed')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $completedOrders = Order::where('status', 'Completed')->count();
        $menuCount = Menu::count();

        // Start the query for the "Incoming Stream"
        $query = Order::with('items');

        // Handle the Status Filter buttons
        if ($request->has('status')) {
            if ($request->status == 'Pending') {
                $query->where('status', 'Pending');
            } elseif ($request->status == 'Done') {
                $query->where('status', 'Completed');
            }
        }

        // Get the orders (latest first)
        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact(
            'totalSales', 
            'totalOrders', 
            'pendingOrders', 
            'completedOrders', 
            'menuCount', 
            'orders'
        ));
    }

    /**
     * 2. Mark Order as Completed
     */
    public function completeOrder($id) 
    {
        $order = Order::findOrFail($id);
        $order->status = 'Completed';
        $order->save();

        return redirect()->back()->with('success', 'Order #' . $order->id . ' has been fulfilled!');
    }

    /**
     * 3. Menu Management View
     */
    public function menu() 
    {
        $menus = Menu::all();
        return view('admin.menu', compact('menus'));
    }

    /**
     * 4. Add New Menu Item (Create)
     */
    public function storeMenu(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string', 
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'price', 'category', 'description']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        Menu::create($data);
        
        return redirect()->route('admin.menu')->with('success', 'New item added to the menu!');
    }

    /**
     * 5. Update Menu Item (Update)
     */
    public function updateMenu(Request $request, $id) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $menu = Menu::findOrFail($id);
        
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->category = $request->category;
        $menu->description = $request->description;

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $path = $request->file('image')->store('menus', 'public');
            $menu->image = $path;
        }

        $menu->save();

        return redirect()->route('admin.menu')->with('success', 'Menu item updated successfully!');
    }

    /**
     * 6. Delete Menu Item (Inventory)
     */
    public function deleteMenu($id) 
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Item removed from menu.');
    }

    /**
     * 7. Delete Order (Record Erase)
     */
    public function deleteOrder($id) 
    {
        $order = Order::findOrFail($id);
        // This removes the order. Because of your design, 
        // using $item->item_name ensures history was saved correctly before deletion.
        $order->delete();

        return redirect()->back()->with('success', 'Order record erased successfully.');
    }
}