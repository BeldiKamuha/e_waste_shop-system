<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <title>E-Waste Shop </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
</head>

<body>
    @include('frontend.body.quickview')
    @include('frontend.body.header')
    
    <main class="main">
        @yield('main')
    </main>

    @include('frontend.body.footer')

    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>

<script type="text/javascript">
$(document).ready(function() {

    // Setup CSRF token for all Ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Function to update mini cart
    function updateMiniCart() {
        $.ajax({
            type: 'GET',
            url: '/product/mini/cart', // Replace with your actual route for fetching mini cart data
            dataType: 'json',
            success: function(response) {
                var miniCartHtml = '';
                var total = 0;

                $.each(response.carts, function(key, value) {
                    miniCartHtml += `
                        <ul>
                            <li>
                                <div class="shopping-cart-img">
                                    <a href="shop-product-right.html"><img alt="${value.name}" src="${value.options.image}" style="width:50px;height:50px;" /></a>
                                </div>
                                <div class="shopping-cart-title" style="margin-left: 10px;">
                                    <h4><a href="shop-product-right.html">${value.name}</a></h4>
                                    <h4><span>${value.qty} × </span>${value.price}</h4>
                                </div>
                                <div class="shopping-cart-delete">
                                    <a href="javascript:void(0);" id="${value.rowId}" class="miniCartRemove"><i class="fi-rs-cross-small"></i></a>
                                </div>
                            </li>
                        </ul>
                        <hr><br>`;
                    total += parseFloat(value.price) * parseInt(value.qty);
                });

                // Update mini cart HTML
                $('#miniCart').html(miniCartHtml);

                // Update total price
                $('.shopping-cart-total span').text('$' + total.toFixed(2));
                
                // Update mini cart count
                $('.pro-count').text(response.cartQty);

                // Attach event listeners to the remove buttons
                $('.miniCartRemove').on('click', function() {
                    var rowId = $(this).attr('id');
                    miniCartRemove(rowId);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching mini cart content:', error);
            }
        });
    }

    // Function to remove item from mini cart
    function miniCartRemove(rowId) {
        $.ajax({
            type: 'GET',
            url: '/minicart/product/remove/' + rowId,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Update mini cart after successful removal
                    updateMiniCart();

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error removing product from cart',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error removing product from cart:', error);

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error removing product from cart',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    // Add to cart form submission
    $(document).on('submit', '.add-to-cart-form', function(event) {
        event.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Product added to cart successfully',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // Update mini cart after successful addition
                    updateMiniCart();
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error adding product to cart',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding product to cart:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error adding product to cart',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    // Initial call to update mini cart on page load
    updateMiniCart();
});
</script>

<!-- // Start Load My Cart // -->
<script type="text/javascript">
$(document).ready(function() {
    // Function to update the cart
    function updateCart() {
        $.ajax({
            type: 'GET',
            url: '/get-cart-product',
            dataType: 'json',
            success: function(response) {
                console.log(response); // Log response to debug
                var rows = '';
                var total = 0;

                if (response.carts.length === 0) {
                    rows = '<tr><td colspan="9" class="text-center">Your cart is empty</td></tr>';
                } else {
                    $.each(response.carts, function(key, value) {
                        rows += `
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30"></td>
                                <td class="image product-thumbnail pt-40"><img src="/${value.options.image}" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name}</a></h6>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">Ksh ${value.price}</h4>
                                </td>
                                <td class="price" data-title="Color">
                                    ${value.options.color == null ? `<span>....</span>` : `<h6 class="text-body">${value.options.color}</h6>`}
                                </td>
                                <td class="price" data-title="Size">
                                    ${value.options.size == null ? `<span>....</span>` : `<h6 class="text-body">${value.options.size}</h6>`}
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down" data-rowid="${value.rowId}"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val" value="${value.qty}" min="1">
                                            <a href="#" class="qty-up" data-rowid="${value.rowId}"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Subtotal">
                                    <h4 class="text-brand">Ksh ${value.subtotal}</h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a href="#" class="text-body cartRemove" id="${value.rowId}"><i class="fi-rs-trash"></i></a></td>
                            </tr> `;
                        total += parseFloat(value.subtotal);
                    });
                }

                // Update cart HTML
                $('#cartPage').html(rows);

                // Update total price
                $('.shopping-cart-total span').text('$' + total.toFixed(2));

                // Update cart count
                $('.pro-count').text(response.cartQty);

                // Update subtotal and grand total in the cart summary
                $('.cart_total_label .text-brand').text('KSH ' + total.toFixed(2));
                $('.cart_total_amount .text-brand').text('KSH ' + total.toFixed(2));
                $('.form_total_amount').val(total.toFixed(0));

                // Attach event listeners to the remove buttons
                $('.cartRemove').on('click', function() {
                    var rowId = $(this).attr('id');
                    cartRemove(rowId);
                });

                // Attach event listeners to the quantity decrement buttons
                $('.qty-down').on('click', function() {
                    var rowId = $(this).data('rowid');
                    var qtyInput = $(this).siblings('.qty-val');
                    var newQty = parseInt(qtyInput.val()) - 1;
                    if (newQty >= 1) {
                        qtyInput.val(newQty);
                        updateCartQuantity(rowId, newQty);
                    }
                });

                // Attach event listeners to the quantity increment buttons
                $('.qty-up').on('click', function() {
                    var rowId = $(this).data('rowid');
                    var qtyInput = $(this).siblings('.qty-val');
                    var newQty = parseInt(qtyInput.val()) + 1;
                    qtyInput.val(newQty);
                    updateCartQuantity(rowId, newQty);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart content:', error);
            }
        });
    }

    // Function to update cart quantity
    function updateCartQuantity(rowId, qty) {
        $.ajax({
            type: 'POST',
            url: '/cart-update-quantity', // Replace with your actual route for updating cart quantity
            data: {
                rowId: rowId,
                qty: qty,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Update cart after successful quantity update
                    updateCart();

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error updating cart quantity',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating cart quantity:', error);

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error updating cart quantity',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    // Function to remove item from cart
    function cartRemove(rowId) {
        $.ajax({
            type: 'GET',
            url: '/cart-remove/' + rowId,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Update cart after successful removal
                    updateCart();

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error removing product from cart',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error removing product from cart:', error);

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error removing product from cart',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    // Initial call to update cart on page load
    updateCart();
});
</script>

<!-- // End Start Load My Cart // -->

</body>

</html>