<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartControllerNew extends Controller
{
    //Update item in cart -----------------
    public function update_ajax(Request $request)
        {
            $rowId    = $request->get('row_id');
            $quantity = $request->get('qty');

            // dd($quantity);
            // update the item on cart
            $userId = auth()->id();
          if(\Cart::session($userId)->update($rowId,[
            'quantity' => array(
                'relative' => false,
                'value'    => $quantity
            ),
        ])){
             //condition true
            return response()->json(['success' => "Updated"]);

          }else{
            return response()->json(['error' => "Error"]);
              //condition false

          }
            // return back(); 
            

        }
}
