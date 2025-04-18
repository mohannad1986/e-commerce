@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="#">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    @endcomponent

    <div class="cart-section container">
        <div>
            <div class="alert alert-success">
                Your item was added successfully!gggggggggggggggg
            </div>

            <div class="cart-table">
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="#"><img src="{{ asset('img/sample-product.jpg') }}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="#">Sample Product</a></div>
                            <div class="cart-table-description">This is a sample product description.</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <button type="button" class="cart-options">Remove</button>
                            <button type="button" class="cart-options">Save for Later</button>
                        </div>
                        <div>
                            <select class="quantity">
                                <option selected>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div>$99.99</div>
                    </div>
                </div>
            </div>

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free!
                </div>
                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax (10%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        $99.99 <br>
                        $10.00 <br>
                        <span class="cart-totals-total">$109.99</span>
                    </div>
                </div>
            </div>

            <div class="cart-buttons">
                <a href="#" class="button">Continue Shopping</a>
                <a href="#" class="button-primary">Proceed to Checkout</a>
            </div>
        </div>
    </div>

    @include('partials.might-like')

@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')
            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    window.location.href = '#';
                })
            })
        })();
    </script>
@endsection
