@extends('frontend.master_dashboard')
@section('main')

@section('title')
   Mpesa Payment 
@endsection

<h1>Mpesa Payment</h1>
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a> 
            <span></span> Mpesa Payment
        </div>
    </div>
</div>
<div class="container mb-80 mt-50">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <h3 class="heading-2 mb-10">Mpesa Payment</h3>
            <div class="d-flex justify-content-between">
                <!-- Optional content -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="border p-40 cart-totals ml-30 mb-50">
                <div class="d-flex align-items-end justify-content-between mb-30">
                    <h4>Your Order</h4>
                </div>
                <div class="divider-2 mb-30"></div>
                <div class="table-responsive order_table checkout"> 
                    <table class="table no-border">
                        <tbody>
                            <tr>
                                <td class="cart_total_label">
                                    <h6 class="text-muted">Total</h6>
                                </td>
                                <td class="cart_total_amount">
                                    <h4 class="text-brand text-end"></h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border p-40 cart-totals ml-30 mb-50">
                <div class="d-flex align-items-end justify-content-between mb-30">
                    <h4>Make Payment</h4>
                    <p></p>
                </div>
                <div class="divider-2 mb-30"></div>
                <div class="table-responsive order_table checkout">
                    <form action="{{ route('mpesa.order') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <label for="phone_number">
                                <input type="number" name="phone_number" placeholder="Enter phone number">
                            </label>

                            <input type="hidden" name="name" value="{{ $data['shipping_name'] }}">
                            <input type="hidden" class="form_total_amount" name="amount" value="">
                            <input type="hidden" name="email" value="{{ $data['shipping_email'] }}">
                            <input type="hidden" name="phone" value="{{ $data['shipping_phone'] }}">
                            <input type="hidden" name="address" value="{{ $data['shipping_address'] }}">
                            <input type="hidden" name="notes" value="{{ $data['notes'] }}">
                        </div>
                        <br>
                        <button class="btn btn-primary">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection