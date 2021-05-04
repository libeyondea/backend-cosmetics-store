<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\CartProduct;
use App\Transformers\CartProductTransformers;

class CartController extends Controller
{
    private $cartProductTransformers;

    public function __construct(CartProductTransformers $cartProductTransformers)
    {
        $this->cartProductTransformers = $cartProductTransformers;
    }

    public function listCart(Request $request, $limit = 10, $offset = 0)
    {
        $limit = $request->input('limit', $limit);
        $offset = $request->input('offset', $offset);

        $product = Product::whereHas('cart', function($q) use ($request) {
            $q->where('user_id', auth()->user()->id);
        });

        $listProduct = fractal($product->skip($offset)->take($limit)->get(), $this->cartProductTransformers);

        $productsCount = $product->get()->count();

        return response()->json([
            'success' => true,
            'data' => $listProduct,
            'meta' => [
                'products_count' => $productsCount
            ]
        ], 200);
    }

    public function addToCart(Request $request)
    {
        try {
            $checkCart = Cart::where('user_id', auth()->user()->id);
            if ($checkCart->get()->count() < 1) {
                $cart = new Cart;
                $cart->user_id = auth()->user()->id;
                $cart->save();
            } else {
                $cart = $checkCart->first();
            }
            $checkProductCart = CartProduct::where('product_id', $request->product_id)->where('cart_id', $cart->id);
            if ($checkProductCart->get()->count() > 0) {
                $qty = $checkProductCart->first()->quantity + $request->quantity;
                if ($qty == 0) {
                    $checkProductCart->delete();
                } else {
                    $checkProductCart->update(['quantity' => $qty]);
                }
            } else {
                $productCart = new CartProduct;
                $productCart->cart_id = $cart->id;
                $productCart->product_id = $request->product_id;
                $productCart->quantity = $request->quantity;
                $productCart->save();
            }
            return response()->json(['success' => true, 'data' => 'add to cart success'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()], 500);
        }
    }

    public function delCartItem(Request $request)
    {
        try {
            $checkCart = Cart::where('user_id', auth()->user()->id);
            if ($checkCart->get()->count() > 0) {
                $cart = $checkCart->first();
                $checkProductCart = CartProduct::where('product_id', $request->product_id)->where('cart_id', $cart->id);
                if ($checkProductCart->get()->count() > 0) {
                    $checkProductCart->delete();
                    return response()->json(['success' => true, 'data' => 'Delete cart item success'], 200);
                }
            }
            return response()->json(['success' => true, 'error' => 'error'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->status = 0;
            $order->shipping = $request->shipping;
            $order->promo = $request->promo;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->phone_number = $request->phone_number;
            $order->address = $request->address;
            $order->district = $request->district;
            $order->ward = $request->ward;
            $order->city = $request->city;
            if ($order->save()){
                foreach ($request->order_product as $key => $order_product) {
                    $orderProduct = new OrderProduct;
                    $orderProduct->product_id = $order_product['product_id'];
                    $orderProduct->order_id = $order->id;
                    $orderProduct->price = $order_product['price'];
                    $orderProduct->quantity = $order_product['quantity'];
                    if ($orderProduct->save()){
                        CartProduct::where('product_id', $order_product['product_id'])->where('cart_id', $cart->id)->delete();
                    }
                }
                return response()->json(['success' => true, 'data' => 'Checkout product success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 500);
        }
    }

}
