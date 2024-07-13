@extends('supplier.supplier_dashboard')
@section('supplier')

@php
	$id = Auth::user()->id;
	$supplierId = App\Models\User::find($id);
	$status = $supplierId->status; 
@endphp

<div class="page-content">

@if($status === 'active')
	<h4>Supplier Account is <span class="text-success">Active</span> </h4>
	@else
	<h4>Supplier Account is <span class="text-danger">InActive</span> </h4>
	<p class="text-danger"><b> Please wait admin will check and approve your account</b></p>
	@endif

					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

					 <a href="{{ route('supplier.all.product') }}">
						<div class="col">
							<div class="card radius-10 bg-gradient-deepblue">
							 <div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0 text-white">Product Manage</h5>
									<div class="ms-auto">
                                        <i class='bx bx-box fs-3 text-white'></i>
									</div>
								</div>
								<div class="progress my-3 bg-light-transparent" style="height:3px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<!-- <p class="mb-0">Pending Orders</p>
									<p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						  </div>
						</div>
						</a>

						<a href="{{ route('supplier.pending.order') }}">
						<div class="col">
							<div class="card radius-10 bg-gradient-orange">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0 text-white">Pending orders</h5>
									<div class="ms-auto">
                                        <i class='bx bx-cart fs-3 text-white'></i>
									</div>
								</div>
								<div class="progress my-3 bg-light-transparent" style="height:3px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<!-- <p class="mb-0">Total Revenue</p>
									<p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						  </div>
						</div>
						</a>

						<a href="{{ route('supplier.confirmed.order') }}">
						<div class="col">
							<div class="card radius-10 bg-gradient-ohhappiness">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0 text-white">Confirmed Orders</h5>
									<div class="ms-auto">
                                        <i class='bx bx-cart fs-3 text-white'></i>
									</div>
								</div>
								<div class="progress my-3 bg-light-transparent" style="height:3px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<!-- <p class="mb-0">Visitors</p>
									<p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						</div>
						</div>
						</a>

						<a href="{{ route('supplier.processing.order') }}">
						<div class="col">
							<div class="card radius-10 bg-gradient-ibiza">
							 <div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0 text-white">Processing Orders</h5>
									<div class="ms-auto">
                                        <i class='bx bx-cart fs-3 text-white'></i>
									</div>
								</div>
								<div class="progress my-3 bg-light-transparent" style="height:3px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<!-- <p class="mb-0">Messages</p>
									<p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						 </div>
						</div>
						</a>
						
					</div><!--end row-->


					@php
    // Get the authenticated user's supplier ID
    $supplierId = auth()->user()->id;

    // Fetch the orders where the supplier ID matches the authenticated user's supplier ID in the orderItems
    $orders = App\Models\Order::whereHas('orderItems', function($query) use ($supplierId) {
        $query->where('supplier_id', $supplierId)
              ->whereHas('product', function($query) use ($supplierId) {
                  $query->where('supplier_id', $supplierId);
              });
    })->with(['orderItems' => function($query) use ($supplierId) {
        $query->where('supplier_id', $supplierId)
              ->whereHas('product', function($query) use ($supplierId) {
                  $query->where('supplier_id', $supplierId);
              });
    }])->where('status', 'delivered')->orderBy('id', 'DESC')->limit(10)->get();
@endphp

<div class="card radius-10">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <h5 class="mb-0">Delivered Orders Summary</h5>
            </div>
            <div class="font-22 ms-auto">
                <i class="bx bx-dots-horizontal-rounded"></i>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        @foreach($order->orderItems->where('supplier_id', $supplierId) as $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->invoice_no }}</td>
								<td>Ksh {{ $item->qty * $item->price }}</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>{{ $order->status }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection