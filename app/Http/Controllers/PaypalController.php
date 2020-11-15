<?php

namespace App\Http\Controllers;

// use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    //paypal checkout ====================================
    public function getExpressCheckout()
    {
        $total = \Cart::session(auth()->id())->getTotal();
        $cart  = \Cart::session(auth()->id());

        
        // dd($cart->getContent()->toArray());

        //Array map function //////////////////////////////////////////
        $cartItems = array_map(function($item){
                return[
                    'name'  => $item['name'],
                    'price' => $item['price'],
                    'qty'   => $item['quantity']
                ];
        },$cart->getContent()->toArray()); 

        // dd($cartItems);

        // $cartItems = [
        //     [
        //         'name'  => 'Product 1',
        //         'price' => 100.50,
        //         'qty'   => 1,
        //     ],
        //     [
        //         'name'  => 'Product 2',
        //         'price' => 250.50,
        //         'qty'   => 2,
        //     ],
        // ];
        // $cartItems = 
            // dd($cartItems);

        $checkoutData = [
            'items'=> $cartItems,
            'return_url'=> route('paypal.success'),
            'cancel_url'=> route('paypal.cancel'),
            'invoice_id'=> uniqid(),
            'invoice_description'=> "order descrption",
            'total'=> $total
           
        ];
        
        dd($checkoutData);

        $provider = new ExpressCheckout();
        // $response = $provider->setExpressCheckout($checkoutData);
        // dd($response);

    }

    public function cancelpage()
    {
        dd("Payment Failed");
    }
}
