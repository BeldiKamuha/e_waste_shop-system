@extends('frontend.master_dashboard')

@section('main')


@section('title')
   Home E-Waste Shop 
@endsection

     @include('frontend.home.home_slider')


<!-- Products Tabs -->
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>Products</h3>
        </div>

        <!-- End nav-tabs -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach($sproduct as $product)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                
                        <img class="default-img" src="{{ asset( $product->product_thambnail ) }}" alt="" />

                    </a>
                                </div>
                                <!-- <div class="product-action-1">
                                    <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                    <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                </div> -->

                                @php
                                $amount = $product->selling_price - $product->discount_price;
                                $discount = ($amount/$product->selling_price) * 100;
                                @endphp

                                <div class="product-badges product-badges-position product-badges-mrg">
                                    @if($product->discount_price == NULL)
                                    <span class="new">New</span>
                                    @else
                                    <span class="hot">{{ round($discount) }} %</span>
                                    @endif
                                </div>
                            </div>

                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="shop-grid-right.html">{{ $product->category }}</a>
                                </div>
                                <h2><a href="{{ url('product/details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a></h2>
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
                                    <span class="font-small text-muted">By <a href="vendor-details-1.html">{{ $product->supplier->name }}</a></span>
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
                                            <input type="hidden" name="supplier_id" value="{{ $product->supplier_id }}"> <!-- Supplier ID -->
                                            <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End tab-content -->
    </div>
</section>
<!-- End Products Tabs -->

<!-- Vendor List -->

<!-- End Vendor List -->

@endsection