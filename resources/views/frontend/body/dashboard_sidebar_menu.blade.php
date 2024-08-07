
@php
$route = Route::current()->getName();
@endphp


<div class="col-md-3">
<div class="dashboard-menu">
<ul class="nav flex-column" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ ($route ==  'dashboard')? 'active':  '' }}"  href="{{ route('dashboard') }}" ><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ ($route ==  'customer.order.page')? 'active':  '' }}" href="{{ route('customer.order.page') }}" ><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ ($route ==  'customer.account.page')? 'active':  '' }}" href="{{ route('customer.account.page') }}" ><i class="fi-rs-user mr-10"></i>Account details</a>
    </li>

      <li class="nav-item">
      <a class="nav-link {{ ($route ==  'customer.change.password')? 'active':  '' }}" href="{{ route('customer.change.password') }}" ><i class="fi-rs-user mr-10"></i>Change Password</a>
    </li>


    <li class="nav-item" style="background:#ddd;">
        <a class="nav-link" href="{{ route('customer.logout') }}"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
    </li>
</ul>
</div>
</div>