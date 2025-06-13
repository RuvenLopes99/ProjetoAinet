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
    /**
     * Mostra o conteúdo do carrinho.
     */
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    /**
     * Adiciona um produto ao carrinho.
     * MODIFICADO: Utiliza route-model binding com o modelo Product.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Adiciona uma unidade de um produto que já está no carrinho.
     * MODIFICADO: Utiliza route-model binding.
     */
    public function addQuantity(Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]++;
        } else {
            return back()->with('error', 'Product not found in cart.');
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Product quantity increased!');
    }

    /**
     * Atualiza a quantidade de um produto no carrinho.
     * MODIFICADO: Utiliza route-model binding.
     */
    public function update(Request $request, Product $product)
    {
        $quantity = max(0, (int) $request->input('quantity', 0));
        $cart = session()->get('cart', []);

        if ($quantity > 0) {
            $cart[$product->id] = $quantity;
        } else {
            // Remove o produto se a quantidade for 0
            unset($cart[$product->id]);
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove um produto completamente do carrinho.
     * MODIFICADO: Utiliza route-model binding.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Product removed from cart!');
    }

    /**
     * Remove uma unidade de um produto do carrinho.
     * MODIFICADO: Utiliza route-model binding.
     */
    public function removeQuantity(Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id]) && $cart[$product->id] > 1) {
            $cart[$product->id]--;
        } else {
            // Se a quantidade for 1 ou menos, remove o produto completamente
            unset($cart[$product->id]);
        }
        session(['cart' => $cart]);
        return back()->with('success', 'One quantity removed from cart!');
    }

    /**
     * Mostra a página de confirmação do pedido.
     */
    public function confirm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to confirm the order.');
        }

        $cartData = collect($cart)->map(function ($quantity, $id) {
            $product = Product::find($id);
            if ($product) {
                return [
                    'id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                ];
            }
            return null;
        })->filter()->values()->all();

        return view('cart.confirm', ['cart' => $cartData]);
    }

    /**
     * Processa a confirmação do pedido, cria a encomenda e desconta o saldo.
     * MODIFICADO: Corrigidos vários potenciais erros.
     */
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

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total_items = 0;
        $total_price = 0;
        foreach ($cart as $id => $quantity) {
            $product = $products->get($id);
            if ($product) {
                // VERIFICAÇÃO DE STOCK (Exemplo, pode necessitar de adaptação)
                if ($product->stock < $quantity) {
                     return back()->with('error', "Not enough stock for the product: {$product->name}. Available: {$product->stock}.");
                }
                $total_items += $quantity;
                $total_price += $product->price * $quantity;
            }
        }

        $shippingCostSetting = SettingsShippingCost::where('min_value_threshold', '<=', $total_price)
            ->where('max_value_threshold', '>=', $total_price)
            ->first();

        $shipping_cost = $shippingCostSetting ? $shippingCostSetting->shipping_cost : 0;
        $orderTotal = $total_price + $shipping_cost;

        // CORREÇÃO: A lógica para encontrar o cartão foi melhorada.
        // Assumindo que o utilizador tem uma relação 'card' definida no modelo User.
        $card = $user->card; // Ex: public function card() { return $this->hasOne(Card::class); }
        if (!$card) {
            return back()->with('error', 'User card not found. Please contact support.');
        }

        if ($card->balance < $orderTotal) { // Corrigido 'balancce' para 'balance'
            return back()->with('error', 'Not enough balance on your card.');
        }

        // CORREÇÃO: O ID do utilizador é passado, não o objeto completo.
        $order = Order::create([
            'member_id' => $user->id,
            'status' => 'pending',
            'date' => now(),
            'total_items' => $total_items,
            'shipping_cost' => $shipping_cost,
            'total' => $orderTotal,
            'nif' => $request->input('nif'),
            'delivery_address' => $request->input('address'),
            'pdf_receipt' => null,
            'cancel_reason' => null,
        ]);

        foreach ($cart as $id => $quantity) {
            $product = $products->get($id);
            if ($product) {
                $order->products()->attach($id, ['quantity' => $quantity, 'price' => $product->price]);
                // Descontar do stock
                $product->decrement('stock', $quantity);
            }
        }

        // Descontar o saldo do cartão após a encomenda ser criada com sucesso
        $card->decrement('balance', $orderTotal);

        session()->forget('cart');

        // CORREÇÃO: A rota 'orders.myOrders' não existia, alterado para 'orders.showcase'.
        return redirect()->route('orders.showcase')->with('success', 'Order created successfully!');
    }

    /**
     * Limpa todo o carrinho de compras.
     */
    public function destroy()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Cart cleared!');
    }
}
