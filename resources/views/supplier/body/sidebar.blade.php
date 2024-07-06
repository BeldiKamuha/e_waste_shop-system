
@php
	$id = Auth::user()->id;
	$supplierId = App\Models\User::find($id);
	$status = $supplierId->status; 
@endphp

<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('adminbackend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Supplier</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">

					<li>
					<a href="{{ route('supplier.dashboard') }}">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>

				@if($status === 'active')

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Product Manage</div>
					</a>
					<ul>
						
					<li> <a href="{{ route('supplier.all.product') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a>
					<li> <a href="{{ route('supplier.add.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
						</li>

						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Order Manage</div>
					</a>
					<ul>
					<li> <a href="{{ route('supplier.order') }}"><i class="bx bx-right-arrow-alt"></i>Pending Order</a>
						
						</li>
						<li> <a href="{{ route('supplier.confirmed.order') }}"><i class="bx bx-right-arrow-alt"></i>Confirmed Order</a>
						</li>
						<li> <a href="{{ route('supplier.processing.order') }}"><i class="bx bx-right-arrow-alt"></i>Processing Order</a>
						</li>
						<li> <a href="{{ route('supplier.delivered.order') }}"><i class="bx bx-right-arrow-alt"></i>Delivered Order</a>
						</li>
					</ul>
				</li>


				@else


				@endif


				<li>
					<a href=" " target="_blank">
						<div class="parent-icon"><i class="bx bx-support"></i>
						</div>
						<div class="menu-title">Support</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>