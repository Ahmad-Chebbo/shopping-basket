<?php

namespace App\Http\Controllers\Api;

use App\Models\Basket;
use App\Models\Product;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FrontRequest\AddToCartRequest;

class CartController extends BaseController
{
    // Fetch products
    public function getProducts()
    {
        $products = Product::select(['id', 'name', 'image', 'price', 'discount_price'])->get();
        return $this->responseJsonSuccess('Products fetched successfully', ['products' => $products]);
    }

    public function getCart(Request $request)
    {
        if (Auth::check()) {
            // If user is authenticated, get cart by user_id
            $cart = Basket::where('user_id', auth()->id())->with('products')->first();
        } else {
            $sessionId = $request->header('X-Session-Id') ?? session()->getId();
            // If user is not authenticated, get cart by session id
            $cart = Basket::where('session_id', $sessionId)->with('products')->first();
        }
        return $this->responseJsonSuccess('Cart fetched successfully', ['cart' => $cart]);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');

        // Check if the product exists or not
        $product = Product::find($productId);

        // Return error message if the product not found
        if (!$product) return $this->responseJsonSuccessNotFound('Product not found');

        // Check if the user is logged in
        if (Auth::check()) {
            // If user is logged in, add to cart associated with user ID
            $userId = Auth::id();
            $basket = Basket::where('user_id', $userId)->firstOrCreate(['user_id' => $userId]);

            // Check if the product is already in the cart
            $basketItem = BasketItem::where('basket_id', $basket->id)->where('product_id', $productId)->first();
            if ($basketItem) {
                if ($basketItem->removed) {
                    // If product is in cart but removed, set removed to false and reset the quantity to 1
                    $basketItem->removed = false;
                    $basketItem->quantity = 1;
                } else {
                    // If product already exists in cart, update the quantity
                    $basketItem->quantity += $quantity;
                }
                $basketItem->price = $product->discount_price ?? $product->price;
                $basketItem->total = $basketItem->quantity * $basketItem->price;
                $basketItem->save();
            } else {
                // If product does not exist in cart, create a new basket item
                $basketItem = new BasketItem([
                    'basket_id' => $basket->id,
                    'product_id' => $productId,
                    'price' => $product->discount_price ?? $product->price,
                    'total' => $product->discount_price ?? $product->price,
                    'quantity' => $quantity,
                    'removed' => false,
                ]);
                $basketItem->save();
            }
        } else {
            $sessionId = $request->header('X-SESSION-ID') ?? $request->session()->getId();

            // If user is not logged in, add to cart associated with session ID
            $basket = Basket::firstOrCreate([
                'session_id' => $sessionId
            ]);

            // Check if the product is already in the cart
            $basketItem = BasketItem::where('basket_id', $basket->id)->where('product_id', $productId)->first();
            if ($basketItem) {
                if ($basketItem->removed) {
                    // If product is in cart but removed, set removed to false and reset the quantity to 1
                    $basketItem->removed = false;
                    $basketItem->quantity = 1;
                } else {
                    // If product already exists in cart, update the quantity
                    $basketItem->quantity += $quantity;
                }
                $basketItem->price = $product->discount_price ?? $product->price;
                $basketItem->total = $basketItem->quantity * $basketItem->price;
                $basketItem->save();
            } else {
                // If product does not exist in cart, create a new basket item
                $basketItem = new BasketItem([
                    'basket_id' => $basket->id,
                    'product_id' => $productId,
                    'price' => $product->discount_price ?? $product->price,
                    'total' => $product->discount_price ?? $product->price,
                    'quantity' => $quantity,
                    'removed' => false,
                ]);
                $basketItem->save();
            }
        }

        // Return a response indicating successful addition to cart
        return $this->responseJsonSuccess('Product added to cart successfully');
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // User is logged in, update the BasketItem record
            $basket = Basket::where('user_id', $user->id)->first();

            if ($basket) {
                $basketItem = $basket->products()->where('product_id', $request->get('product_id'))->first();

                if ($basketItem) {
                    $basketItem->pivot->removed = true;
                    $basketItem->pivot->save();
                }
            } else {
                return $this->responseJsonSuccessNotFound('Basket not found');
            }
        } else {
            // User is not logged in, update the session cart
            $sessionId = $request->header('X-SESSION-ID') ?? $request->session()->getId();
            $basket = Basket::where('session_id', $sessionId)->first();
            // return response()->json(['message' => $sessionId]);

            if ($basket) {
                $basketItem = $basket->products()->where('product_id', $request->get('product_id'))->first();

                if ($basketItem) {
                    $basketItem->pivot->removed = true;
                    $basketItem->pivot->save();
                }
            }
            else
            {
                return $this->responseJsonSuccessNotFound('Basket not found');
            }
        }

        // Add any additional logic or response as needed
        return $this->responseJsonSuccess('Product removed successfully');
    }


    public function proceedToCheckout()
    {
        $user = Auth::user();
        if (!$user) {
            // User is not authenticated
            return $this->returnJsonResponse(false, 'You must be authenticated to proceed to checkout', null, 401);
        }

        $basket = Basket::where('user_id', $user->id)->first();

        if ($basket) {
            $basketItems = $basket->basketItems;
            $hasRemovedItems = false;

            // Check if there are any removed basket items
            foreach ($basketItems as $basketItem) {
                if ($basketItem->removed) {
                    $hasRemovedItems = true;
                    break;
                }
            }

            if ($hasRemovedItems) {
                // Delete only the not removed items
                foreach ($basketItems as $basketItem) {
                    if (!$basketItem->removed) {
                        $basketItem->delete();
                    }
                }
            } else {
                // Delete the whole basket
                $basket->delete();
            }
        }

        // Add any additional logic here for processing the checkout
        return $this->responseJsonSuccess('Checkout processed successfully');
    }

}
