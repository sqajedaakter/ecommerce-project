@extends('frontend.master')
@section('contant')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Customer Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ url('/') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Customer Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Main content -->
<section class="content">

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form action="{{ url('/shiping/store') }}" method="POST">
            @csrf

            @php
            $totalqty = 0;
            $totalprice = 0;
            @endphp
            @foreach ($products as $product)

            <input class="form-control" type="hidden" name="product_id[]" value="{{ $product->product_id }}">
            <input class="form-control" type="hidden" name="qty[]" value="{{  $qty = $product->qty }}">
            <input class="form-control" type="hidden" name="price[]" value="{{ $price =$product->price }}">

            @php
            $totalqty += $qty;
            $totalprice = $price * $totalqty;
            @endphp
            @endforeach



            <input class="form-control" type="hidden" name="total_qty" value="{{ $totalqty}}">
            <input class="form-control" type="hidden" name="total_price" value="{{ $totalprice}}">

            <div class=" row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="phone" placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" name="address_one" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" name="address_two" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country">
                                    <option selected>Bangladesh</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" name="zip" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            <div class="d-flex justify-content-between">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $productview)
                                        <tr>
                                            <th scope="row">{{ $productview->products->name }}</th>
                                            <td>{{ $productview->qty }}</td>
                                            <td>{{ $productview->price }}</td>
                                        </tr>


                                        @endforeach
                                    </tbody>
                                </table>
                            </div>





                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium">${{$totalprice}}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">$60</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">${{$totalprice += 60}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type" value="paypal"
                                        id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type"
                                        value="directcheck" id="directcheck">
                                    <label class="custom-control-label" for="directcheck">Direct
                                        Check</label>
                                </div>
                            </div>
                            <div class="">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_type"
                                        value="banktransfer" id="banktransfer">
                                    <label class="custom-control-label" for="banktransfer">Bank
                                        Transfer</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit"
                                class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                                Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->
</section>
<!-- /.content -->
@endsection