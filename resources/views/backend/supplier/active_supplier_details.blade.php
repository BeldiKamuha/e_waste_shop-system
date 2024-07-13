@extends('admin.admin_dashboard')
@section('admin')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content"> 
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Active Supplier Details</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Active Supplier Details</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
				 
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
			 
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">

		<form method="post" action="{{ route('inactive.supplier.approve') }}" enctype="multipart/form-data" >
			@csrf
		
		<input type="hidden" name="id" value="{{ $activeSupplierDetails->id }}">
		
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">User Name</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" class="form-control" name="username" value="{{ $activeSupplierDetails->username }}"   />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0"> Shop Name</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="name" class="form-control" value="{{ $activeSupplierDetails->name }}" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Email</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="email" name="email" class="form-control" value="{{ $activeSupplierDetails->email }}" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Phone </h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="phone" class="form-control" value="{{ $activeSupplierDetails->phone }}" />
				</div>
			</div>


			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Address</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="address" class="form-control" value="{{ $activeSupplierDetails->address }}" />
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Join</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="supplier_join" class="form-control" value="{{ $activeSupplierDetails->supplier_join }}" />
				</div>
			</div>

			 


			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Info</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<textarea name="supplier_short_info" class="form-control" id="inputAddress2" placeholder="Supplier Info " rows="3">
					{{ $activeSupplierDetails->supplier_short_info }}
				</textarea>
				</div>
			</div>



			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Photo</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					 <img id="showImage" src="{{ (!empty($activeSupplierDetails->photo)) ? url('upload/supplier_images/'.$activeSupplierDetails->photo):url('upload/no_image.jpg') }}" alt="Supplier" style="width:100px; height: 100px;"  >
				</div>
			</div>
 
  


			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 text-secondary">
				<button type="submit" class="btn btn-danger px-4 confirm-action" data-action="inactivate">Inactive Supplier</button>
				</div>
			</div>
		</div>

		</form>



	</div>
	 



							</div>
						</div>
					</div>
				</div>
			</div>



 


@endsection