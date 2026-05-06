<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class CustomerController extends Controller
{
    /**
     * Display Menu with Search and Category Filtering
     */
    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $menus = $query->get();
        $cart = session()->get('cart', []);

        return view('welcome', compact('menus', 'cart'));
    }

    /**
     * Add item to Cart (Session)
     */
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image 
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', $menu->name . ' added to order!');
    }

    /**
     * Update Quantity (Plus/Minus Buttons)
     */
    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            if ($request->action == 'plus') {
                $cart[$id]['quantity']++;
            } else if ($request->action == 'minus' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    /**
     * Remove specific item from Cart
     */
    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from order.');
    }

    /**
     * Clear the entire Cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared.');
    }

    /**
     * Place the final Order
     */
    public function placeOrder(Request $request)
    {
        // 1. VALIDATION: Removed phone and address requirements
        $request->validate([
            'customer_name' => 'required|string|max:255',
        ]);

        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Your tray is empty!');
        }

        // Calculate total amount
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // 2. CREATE ORDER: Removed phone and address from database save
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'total_amount'  => $total,
            'status'        => 'Pending'
        ]);

        // 3. Create the Individual Order Items
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // Clear session cart
        session()->forget('cart');

        // Return with the Success Toast (Matches your screenshot)
        return redirect()->back()->with('success', 'Order Placed! Order ID: #' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
    }
}
