@extends('layouts.app')
@section('content')
<div class="container">
    <h2    id    = "test"> Your Cart</h2>
    <table class = "table" id = "cart_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quontity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
   @foreach ($cart_items as $item)
                <tr id = "first_tr">
                    <td hidden>{{$item->id}}</td>
                    <td scope = "row">{{ $item->name }}</td>
                    <td class = "price">
                        {{-- {{ $item->price }} --}}
                        {{ Cart::session(auth()->id())->get($item->id)->getPriceSum()}}
                    </td>
                    <td>
                        <form action="{{route('cart.update',$item->id)}}">
                        <input type="number" id="quantityz" class ="quantityz" name="quantity" value="{{$item->quantity}}">
                        <input type="submit" value="save">
                        {{-- <input type   = "" id          = "item_id" class   = "item_id" value      = "{{$item->id}}"> --}}
                        </form>
                     </td>
                    
                    <td><a href = "{{route('cart.destroy',$item->id)}}">Delete</a></td>
                </tr>
   @endforeach
            </tbody>
        </table>

            <h3>
                Total Price :$ {{ Cart::session(auth()->id())->getTotal()}}
            </h3>
        <h2><a class="btn btn-primary" href="{{route('cart.checkout')}}" role="button">Proceed to checkout</a></h2>
             <div hidden>
                <h2>Jquery Table</h2>
               <table class = "table ajax_cart_table" id = "ajax_cart_table">
                   <thead>
                       <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quontity</th>
                            <th>Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       
                   </tbody>
               </table>
                </div>
</div>

  @endsection

  @section('script')
        <script src = "https://code.jquery.com/jquery-3.3.1.js" defer></script>
        <script src = "//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>

        <script type = "application/javascript">
                  $(function () {
                     load_cart_table_ajax();
                    });
        
                
                 function load_cart_table_ajax() {
                                        var tableData = '';
                                        $.ajax({
                                            url : "{{route('cart.load_cart_items_ajax')}}",
                                            type: 'get',
                                            data: {
                                            },
                                            dataType: 'json',
                                            success : function(data) {
                                                if (!($.isEmptyObject(data.error))) {
                                                    // data not found ------
                                                    printErrorMsg(data.error);
                                                    tableData += '<tr><th colspan="4" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
             
                                         } else {
                                                    // console.log(data)
                                                    //data found --------
                                                    // $.each(data, function (index, qData) {
                                                    $.each(data, function (index, qData) {
                                                    index++;
                                                    tableData += '<tr>';
                                                    tableData += '<td>' + index + '</td>';
                                                    tableData += '<td>' + qData.name + '</td>';
                                                    tableData += '<td>' + qData.price + '</td>';
                                                    tableData += '<td><input type="number" id="quantity" name="quantity" class="" data-rowId  = "' + qData.price + '"  value="' + qData.quantity + '"></td>';
                                                    tableData += '<td><button id="btn" class="btn btn-danger delStrData btn-sm fa  fa-sm"  data-quantity  = "' + qData.quantity + '"  value="' + qData.quantity + '">&nbsp;Select</button> </td>';

                                                    tableData += '</tr>';
                                                }); 
                                                    $('.ajax_cart_table tbody').html(tableData);
                                                }
                                            }
                                           
                                        });
       }

       //Cart items add/minus function (Ajax data send)===================================
       $(document).on('click', '#btn', function(e) {
        alert($(this).data('quantity'));
       });

       $(document).on('click', '#quantity', function(e) {
                    e.preventDefault();
                    var qty    = $(this).val();
                    var row_id = ($(this).closest('tr').find('td:first').text());

                    // var row_id    =($(this).closest('tr').find('td:first').text());
                    // alert(item_id)
                        $.ajax({
                            url : "{{route('cart.update_ajax2')}}",
                            type: 'get',
                            data: {
                                row_id: row_id,
                                qty   : qty
                            },
                            dataType: 'json',
                            success : function(data) {
                                if ($.isEmptyObject(data.error)) {
                                    // alert(data.success);
                                    // load_cart_table_ajax();
                                } else {
                                    printErrorMsg(data.error);
                                }
                            }
                        });
                    });


           //Cart items add/minus function (Normal data send)===================================
                $(document).on('click', '#quantityz', function(e) {
                    e.preventDefault();
                    var qty    = $(this).val();
                    var row_id = ($(this).closest('tr').find('td:first').text());
                    // alert(item_id)
                        $.ajax({
                            url : "{{route('cart.update_ajax2')}}",
                            type: 'get',
                            data: {
                                row_id: row_id,
                                qty   : qty
                            },
                            dataType: 'json',
                            success : function(data) {
                                if ($.isEmptyObject(data.error)) {
                                    // alert(data.success);
                                    // load_cart_table_ajax();
                                } else {
                                    printErrorMsg(data.error);
                                }
                            }
                        });
                    });


     </script>
 @endsection