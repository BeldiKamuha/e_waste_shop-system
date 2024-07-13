@extends('supplier.supplier_dashboard')

@section('supplier')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Supplier Order Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Supplier Order Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr/>

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
        <div class="col">
            <div class="card">
                <div class="card-header"><h4>Shipping Details</h4></div>
                <hr>
                <div class="card-body">
                    <table class="table" style="background:#F4F6FA;font-weight: 600;">
                        <tr>
                            <th>Shipping Name:</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Phone:</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Email:</th>
                            <td>{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Address:</th>
                            <td>{{ $order->adress }}</td>
                        </tr>
                        <tr>
                            <th>Order Date:</th>
                            <td>{{ $order->order_date }}</td>
                        </tr>
                        <tr>
                            <th>Notes:</th>
                            <td>{{ $order->notes }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Order Details <span class="text-danger">Invoice: {{ $order->invoice_no }}</span></h4>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table" style="background:#F4F6FA;font-weight: 600;">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Payment Type:</th>
                            <td>{{ $order->payment_method }}</td>
                        </tr>
                
                        <tr>
                            <th>Invoice:</th>
                            <td class="text-danger">{{ $order->invoice_no }}</td>
                        </tr>
                        <tr>
                            <th>Order Amount:</th>
                            <td>Ksh {{ $order->amount }}</td>
                        </tr>
                        <tr>
                            <th>Order Status:</th>
                            <th><span class="badge bg-danger" style="font-size: 15px;">{{ $order->status }}</span></th>
                        </tr>
                        <tr>
                            <th></th>
                            <!-- <td>

                                @if($order->status == 'pending')
                                    <a href="{{ route('pending-confirm', $order->id) }}" class="btn btn-block btn-success confirm-order" data-url="{{ route('pending-confirm', $order->id) }}">Confirm Order</a>

                                @elseif($order->status == 'confirm')
                                   <a href="{{ route('confirm-processing', $order->id) }}" class="btn btn-block btn-success process-order" data-url="{{ route('confirm-processing', $order->id) }}" >Processing Order</a>

                                @elseif($order->status == 'processing')
                                <a href="{{ route('processing-delivered', $order->id) }}" class="btn btn-block btn-success delivered-order" data-url="{{ route('processing-delivered', $order->id) }}" >Delivered Order</a>
                                @endif

                            </td> -->
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1">
        <div class="col">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" style="font-weight: 600;">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Supplier Name</th>
                                <th>Product Code</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderItems as $item)
                            <tr>
                                <td><img src="{{ asset($item->product->product_thambnail) }}" style="width:50px; height:50px;"></td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->supplier_id ? $item->product->supplier->name : 'Owner' }}</td>
                                <td>{{ $item->product->product_code }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Ksh {{ $item->price }}<br>Total = Ksh {{ $item->price * $item->qty }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
