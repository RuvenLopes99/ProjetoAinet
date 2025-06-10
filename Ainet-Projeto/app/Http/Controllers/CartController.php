<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $quantity = max(0, (int) $request->input('quantity', 0));
        if ($quantity < 1) {
            return back()->with('error', 'Quantity must be at least 1.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $quantity = max(0, (int) $request->input('quantity', 0));
        $cart = session()->get('cart', []);
        if ($quantity > 0) {
            $cart[$id] = $quantity;
        } else {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Product removed from cart!');
    }

    public function confirm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Here you would typically handle the confirmation logic, such as creating an order.
        // For now, we'll just clear the cart.
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Order confirmed!');
    }

    public function destroy()
    {
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Cart cleared!');
    }
}


