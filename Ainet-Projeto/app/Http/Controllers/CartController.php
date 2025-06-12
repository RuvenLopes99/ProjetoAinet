<?php
namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SettingsShippingCost;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Product added to cart!');
    }

    public function addQuantity($id)
    {
        $quantity = 1;

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            return back()->with('error', 'Product not found in cart.');
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

    public function removeQuantity($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id]) && $cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        return back()->with('success', 'One quantity removed from cart!');
    }

    public function confirm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to confirm the order.');
        }

        $cart = collect($cart)->map(function ($quantity, $id) {
            return [
                'id' => $id,
                'quantity' => $quantity,

            ];
        })->values()->all();

        return view('cart.confirm', compact('cart'));
    }

    public function processConfirm(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->type === 'employee') {
            return back()->with('error', 'Employees are not allowed to make purchases.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // $cart is [product_id => quantity]
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total_items = 0;
        $total = 0;
        foreach ($cart as $id => $quantity) {
            $product = $products[$id] ?? null;
            if ($product) {
                $total_items += $quantity;
                $total += $product->price * $quantity;
            }
        }

        $shippingCostSetting = SettingsShippingCost::where('min_value_threshold', '<=', $total)
            ->where('max_value_threshold', '>=', $total)
            ->first();

        $shipping_cost = $shippingCostSetting ? $shippingCostSetting->shipping_cost : 0;

        $CardId = $user;
        if ($CardId) {
            $Card = Card::find($CardId);
            if (!$Card) {
                return back()->with('error', 'Card not found.');
            }
            $orderTotal = $total + $shipping_cost;
            if ($Card->balancce < $orderTotal) {
                return back()->with('error', 'Not enough balance on the Card.');
            }
            $Card->balancce -= $orderTotal;
            $Card->save();
        }

        $order = Order::create([
            'member_id' => $user,
            'status' => 'pending',
            'date' => now(),
            'total_items' => $total_items,
            'shipping_cost' => $shipping_cost,
            'total' => $total + $shipping_cost,
            'nif' => $request->input('nif', 'nif'),
            'delivery_address' => $request->input('address', 'address'),
            'pdf_receipt' => null,
            'cancel_reason' => null,
        ]);

        // Attach products to the order (assuming pivot table order_product)
        foreach ($cart as $id => $quantity) {
            $product = $products[$id] ?? null;
            if ($product) {
                $order->products()->attach($id, ['quantity' => $quantity, 'price' => $product->price]);
            }
        }

        session()->forget('cart');

        return redirect()->route('orders.myOrders')->with('success', 'Order created successfully!');
    }


    public function destroy()
    {
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Cart cleared!');
    }
}


