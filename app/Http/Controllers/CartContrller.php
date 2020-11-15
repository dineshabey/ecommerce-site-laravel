<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
// use Darryldecode\Cart\Cart;

class CartContrller extends Controller
{
   public function add($productId)
   {
      $productx = Product::find($productId);  // assuming you have a Product model with id, name, description & price
      // add the product to cart
    \Cart::session(auth()->id())->add(array(
    'id'              => $productx->id,
    'name'            => $productx->product_name,
    'price'           => $productx->price,
    'quantity'        => 1,
    'attributes'      => array(),
    'associatedModel' => $productx
));
    return redirect()->route('cart.index');
   }
   //Add item to cart (Cart Table load) ========================
    public function index()
        {
            $cart_items = \Cart::session(auth()->id())->getContent();
            return view('cart.index',compact('cart_items'));
        }
    //New Ajax cart items table load function =================
    public function load_cart_items_ajax()
        {
            $cart_items = \Cart::session(auth()->id())->getContent();
            // return response()->json(['data' => $cart_items]);
            return json_encode($cart_items);
        }

    //Remove item in cart  =====================================
    public function destroy($item_id)
        {
            \Cart:: session(auth()->id())->remove($item_id);
             return back(); 

        }
        //Update item in cart -----------------
    public function update($rowId)
        {
            //$rowId == $item_id
            // update the item on cart
            \Cart::session(auth()->id())->update($rowId,[
                'quantity' => array(
                    'relative' => false,
                    'value'    => request('quantity')
                ),
                
            ]);

             return back(); 

        }
         //Update item in cart -----------------
    public function update_ajax(Request $request)
            {
                $rowId    = $request->get('row_id');
                $quantity = $request->get('qty');

                // dd($request);
                // update the item on cart
                $userId = auth()->id();
            if(\Cart::session($userId)->update($rowId,[
                'quantity' => array(
                    'relative' => false,
                    'value'    => $quantity
                ),
            ])){
                //condition true
                   // return back(); 
                return response()->json(['success' => "Updated"]);

            }else{
                return response()->json(['error' => "Error"]);
                //condition false

            }
                // return back(); 
                

            }

    public function update_ajax2(Request $request)
            {
                $rowId    = $request->get('row_id');
                $quantity = $request->get('qty');


                // dd($request);
                // update the item on cart
                $userId = auth()->id();
            if(\Cart::session($userId)->update($rowId,[
                'quantity' => array(
                    'relative' => false,
                    'value'    => $quantity
                ),
            ]));
            return response()->json(['success' => "Updated"]);
        }


        //Checkout function -------------
     public function checkout()
     {
         return view('cart.checkout');
     }

}
