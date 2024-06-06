@extends('admin.admin_dashboard')
@section('admin')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content"> 
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Inactive Supplier Details</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Inactive Supplier Details</li>
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

		<form method="post" action="{{ route('active.supplier.approve') }}" enctype="multipart/form-data" >
			@csrf
		
            <input type="hidden" name="id" value="{{ $inactiveSupplierDetails->id }}">

			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">User Name</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" class="form-control" value="{{ $inactiveSupplierDetails->username }}" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0"> Shop Name</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="name" class="form-control" value="{{ $inactiveSupplierDetails->name }}" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Email</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="email" name="email" class="form-control" value="{{ $inactiveSupplierDetails->email }}" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Phone </h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="phone" class="form-control" value="{{ $inactiveSupplierDetails->phone }}" />
				</div>
			</div>


			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Address</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="address" class="form-control" value="{{ $inactiveSupplierDetails->address }}" />
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Join</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<input type="text" name="supplier_join" class="form-control" value="{{ $inactiveSupplierDetails->supplier_join }}" />
				</div>
			</div>

			


			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Info</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					<textarea name="supplier_short_info" class="form-control" id="inputAddress2" placeholder="Supplier Info " rows="3">
					{{ $inactiveSupplierDetails->supplier_short_info }}
				</textarea>
				</div>
			</div>



			<div class="row mb-3">
				<div class="col-sm-3">
					<h6 class="mb-0">Supplier Photo</h6>
				</div>
				<div class="col-sm-9 text-secondary">
					 <img id="showImage" src="{{ (!empty($inactiveSupplierDetails->photo)) ? url('upload/supplier_images/'.$inactiveSupplierDetails->photo):url('upload/no_image.jpg') }}" alt="Supplier" style="width:100px; height: 100px;"  >
				</div>
			</div>
 
  


			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 text-secondary">
					<input type="submit" class="btn btn-danger px-4" value="Active Supplier" />
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