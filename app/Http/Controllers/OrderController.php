<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate_deatails = $request->validate([
            'shipping_full_name'    => 'required',
            'shipping_state'        => 'required',
            'shipping_city'         => 'required',
            'shipping_zip'          => 'required',
            'shipping_full_address' => 'required',
            'shipping_mobile'       => 'required',
            'payment_method'        => 'required'
        ]);

            $order = new Order();

            $order->order_number=uniqid('OrderNumber-');

            $order->shipping_fullname = $request->input('shipping_full_name');
            $order->shipping_state    = $request->input('shipping_state');
            $order->shipping_city     = $request->input('shipping_city');
            $order->shipping_zipcode  = $request->input('shipping_zip');
            $order->shipping_address  = $request->input('shipping_full_address');
            $order->shipping_phone    = $request->input('shipping_mobile');

            // check in the request have 'billing_fullname' ===================

            if(!$request->has('billing_fullname')){
                $order->billing_fullname = $request->input('shipping_full_name');
                $order->billing_state    = $request->input('shipping_state');
                $order->billing_city     = $request->input('shipping_city');
                $order->billing_zipcode  = $request->input('shipping_zip');
                $order->billing_address  = $request->input('shipping_full_address');
                $order->billing_phone    = $request->input('shipping_mobile');
            }else{
                $order->billing_fullname = $request->input('billing_full_name');
                $order->billing_state    = $request->input('billing_state');
                $order->billing_city     = $request->input('billing_city');
                $order->billing_zipcode  = $request->input('billing_zip');
                $order->billing_address  = $request->input('billing_full_address');
                $order->billing_phone    = $request->input('billing_mobile');
            }

            $order->grand_total = \Cart::session(auth()->id())->getTotal(); //get cat total ammount
            $order->item_count  = \Cart::session(auth()->id())->getcontent()->count(); //get cart added item count 
            $order->user_id  = auth()->id();
            $order->save();

            //save all order items in to items_table ==============================================
            $CartItems = \Cart::session(auth()->id())->getcontent(); //get cat total ammount

            // dd($CartItems);
            foreach($CartItems as $item){

                $order->items()->attach($item->id,['price'=>$item->price,'quantity'=>$item->quantity]);
            }

            //payment methods (PayPal) ===================
            if(request('payment_method')=='paypal'){
                //redirect to pp 
                return view(route('paypal/checkout'));

                // dd('workingg');
            }

            //Empty cart --------
            // \Cart::session(auth()->id())->clear();
            //Send email to user --------

            //Load Thank Toy msg --------
            return "Order completed. Thank You !";
            // dd('Order Created',$order);

            
    }

   
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
