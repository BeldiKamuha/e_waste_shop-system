@extends('frontend.master_dashboard')
@section('main')

  <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Store <span></span> Supplier Details Page
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="archive-header-2 text-center pt-80 pb-50">
                <h1 class="display-2 mb-50"> {{ $supplier->name }} </h1>
                
            </div>
            <div class="row flex-row-reverse">
                <div class="col-lg-4-5">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                        <p>We found <strong class="text-brand">{{ count($sproduct) }}</strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
                                        <li><a href="#">All</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Featured</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#">Release Date</a></li>
                                        <li><a href="#">Avg. Rating</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">

                    @foreach($sproduct as $product)
    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
            <div class="product-img-action-wrap">
                <div class="product-img product-img-zoom">
                    <a href="{{ url('product/details/'.$product->id.'/'.$product->product_slug) }}">
                        <img class="default-img" src="{{ asset( $product->product_thambnail ) }}" alt="" />

                    </a>
                </div>
                <div class="product-action-1">
                    <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                    <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                </div>

    @php
    $amount = $product->selling_price - $product->discount_price;
    $discount = ($amount/$product->selling_price) * 100;
    @endphp


                <div class="product-badges product-badges-position product-badges-mrg">

                    @if($product->discount_price == NULL)
                    <span class="new">New</span>
                    @else
                    <span class="hot"> {{ round($discount) }} %</span>
                    @endif


                </div>
            </div>
            <div class="product-content-wrap">
                <div class="product-category">
                    <a href="shop-grid-right.html">{{ $product->category }}</a>
                </div>
                <h2><a href="{{ url('product/details/'.$product->id.'/'.$product->product_slug) }}"> {{ $product->product_name }} </a></h2>
                <div class="product-rate-cover">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                </div>
                <div>

                @if($product->supplier_id == NULL)
<span class="font-small text-muted">By <a href="vendor-details-1.html">Owner</a></span>
                    @else
  <span class="font-small text-muted">By <a href="vendor-details-1.html">{{ $product['supplier']['name'] }}</a></span>
                    @endif


                </div>
                <div class="product-card-bottom">

                    @if($product->discount_price == NULL)
                     <div class="product-price">
                        <span>Ksh {{ $product->selling_price }}</span>

                    </div>

                    @else
                    <div class="product-price">
                        <span>Ksh {{ $product->discount_price }}</span>
                        <span class="old-price">Ksh {{ $product->selling_price }}</span>
                    </div>
                    @endif



                    <div class="add-cart">
    <form action="{{ url('/cart/data/store/'.$product->id) }}" method="POST" class="add-to-cart-form">
        @csrf
        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="color" value="{{ $product->color }}">
        <input type="hidden" name="size" value="{{ $product->size }}">
        <input type="hidden" name="quantity" value="1"> <!-- Default quantity -->
        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add</button>
    </form>
</div>

                </div>
            </div>
        </div>
    </div> 
    <!--end product card-->
    @endforeach

                        
                    </div>
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                 
                    <!--End Deals-->
                </div>
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                    <div class="sidebar-widget widget-store-info mb-30 bg-3 border-0">
                        <div class="vendor-logo mb-30">
                        <img class="default-img" src="{{ (!empty($supplier->photo)) ? url('upload/supplier_images/'.$supplier->photo):url('upload/no_image.jpg') }}" style="width:120px;height: 120px;" alt="" />
                        </div>
                        <div class="vendor-info">
                            <div class="product-category">
                                <span class="text-muted">Since {{ $supplier->supplier_join }}</span>
                            </div>
                            <h4 class="mb-5"><a href="vendor-details-1.html" class="text-heading">{{ $supplier->name }}</a></h4>
                            <div class="product-rate-cover mb-15">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="vendor-des mb-30">
                                <p class="font-sm text-heading">{{ $supplier->supplier_short_info }}</p>
                            </div>
                            <div class="follow-social mb-20">
                                <h6 class="mb-15">Follow Us</h6>
                                <ul class="social-network">
                                    <li class="hover-up">
                                        <a href="#">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-tw.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-fb.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-insta.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-pin.svg') }}" alt="" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="vendor-info">
                                <ul class="font-sm mb-20">
                                    <li><img class="mr-5" src="assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>{{ $supplier->address }}</span></li>
                                    <li><img class="mr-5" src="assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us: </strong><span>{{ $supplier->phone }}</span></li>
                                </ul>
                                <a href="vendor-details-1.html" class="btn btn-xs">Contact Seller <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                 

                    <!-- Fillter By Price -->
               
                     
                </div>
            </div>
        </div>



@endsection