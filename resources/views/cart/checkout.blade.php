@extends('layouts.app')
<script
    src="https://www.paypal.com/sdk/js?client-id=AfQlmW9XzXNUL1u9C24_CYCslhB8cvSiRX9ko8B8ZWsn6NcR8Mx02EUNmAAm6S930-6z497qEG31iZz3"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
  </script>
@section('content')
    <div class="container">
        <div class="">
            <h2>Checkout</h2>
            <h3>Shipping Information</h3>
        </div>
        <div>
        <form action="{{route('orders.store')}}" method="post">
                @csrf
                {{-- @include('_errors') --}}

                <div class="form-group">
                    <label for="shipping_full_name">Full Name</label> 
                    <input id="shipping_full_name" name="shipping_full_name" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shipping_state">State</label> 
                    <input id="shipping_state" name="shipping_state" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shipping_city">City</label> 
                    <input id="shipping_city" name="shipping_city" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shipping_zip">ZIP</label> 
                    <input id="shipping_zip" name="shipping_zip" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shipping_full_address">Full Address</label> 
                    <input id="shipping_full_address" name="shipping_full_address" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="shipping_mobile">Mobile</label> 
                    <input id="shipping_mobile" name="shipping_mobile" type="text" required="required" class="form-control">
                  </div>
                 
                  <h2>Payment Option</h2>
                  <div class="form-check">
                    <label for="shipping_mobile" class="form-check-label">
                      <input type="radio" class="form-check-input" name="payment_method" value="cash_on_delivery" id="cash_on_delivery" checked>
                      Cash on Delivery 
                    </label> 
                  </div>
                  <div class="form-check">
                    <label for="shipping_mobile" class="form-check-label">
                      <input type="radio" class="form-check-input" name="payment_method" value="paypal" id="paypal" >
                      PayPal
                    </label> 
                  </div>

                  <div class="form-group mt-3">
                    <button name="submit" type="submit" class="btn btn-primary">Place Order</button>
                  </div>
              </form>
              <div id="paypal-button-container"></div>
        </div>
    </div>
   
@endsection

@section('script')
<script type = "application/javascript">

$(function () {

  // paypal.Buttons().render('#paypal-button-container');
  paypal.Buttons({
  enableStandardCardFields: true,


  
  createOrder: function(data, actions) {
    
    return actions.order.create({
      intent: 'CAPTURE',
      payer: {
        name: {
          given_name: "PayPal",
          surname: "Customer"
        },
        address: {
          address_line_1: '123 ABC Street',
          address_line_2: 'Apt 2',
          admin_area_2: 'San Jose',
          admin_area_1: 'CA',
          postal_code: '95121',
          country_code: 'US'
        },
        email_address: "customer@domain.com",
        phone: {
          phone_type: "MOBILE",
          phone_number: {
            national_number: "14082508100"
          }
        }
      },
      purchase_units: [
        {
          amount: {
            value: '15.00',
            currency_code: 'USD'
          },
          shipping: {
            address: {
              address_line_1: '2211 N First Street',
              address_line_2: 'Building 17',
              admin_area_2: 'San Jose',
              admin_area_1: 'CA',
              postal_code: '95131',
              country_code: 'US'
            }
          },
        }
      ]
    });
  }
  
}).render("body");


   }); //on load function end

  

</script>
@endsection