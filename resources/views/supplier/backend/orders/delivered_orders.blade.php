@extends('supplier.supplier_dashboard')
@section('supplier')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Delivered Order</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Delivered Order</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">

						</div>
					</div>
				</div>
				<!--end breadcrumb-->

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
			<tr>
				<th>Sl</th>
				<th>Date </th>
				<th>Invoice </th>
				<th>Amount </th>
				<th>Payment </th>
				<th>State </th>
				<th>Action</th> 
			</tr>
		</thead>
		<tbody>
		@foreach($orders as $order)
    @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $loop->parent->index + 1 }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ $order->invoice_no }}</td>
            <td>Ksh {{ $item->qty * $item->price }}</td>
            <td>{{ $order->payment_method }}</td>
            <td><span class="badge rounded-pill bg-success">{{ $order->status }}</span></td>
            <td>
                <a href="{{ route('supplier.order.details', [$order->id, $item->id]) }}" class="btn btn-info" title="Details">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endforeach


		</tbody>
		<tfoot>
			<tr>
				<th>Sl</th>
				<th>Date </th>
				<th>Invoice </th>
				<th>Amount </th>
				<th>Payment </th>
				<th>State </th>
				<th>Action</th> 
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>



			</div>




@endsection