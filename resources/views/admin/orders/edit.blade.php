@extends('layouts.master')

@section('title')
{{__('s.edit_order')}}
@endsection

@section('css')
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if (session('errors1'))
<div class="alert alert-danger">
    {{ session('errors1') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="page-header">
    <h3 class="page-title">{{__('s.orders')}}</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}">{{__('s.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/orders') }}">{{__('s.orders')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a>{{__('s.edit_order')}}</a></li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- Form starts -->
            <form action="{{ route('orders.update', $order->id) }}" id="formDropzone" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                @csrf
                @method('PUT') 

                <div class="form-group">
                    <label for="exampleInputName1">{{ __('s.order_date') }} <span>*</span></label>
                    <input type="date" value="{{ $order->order_date }}" name="order_date" class="form-control" id="order_date" placeholder="{{ __('s.order_date_placeholder') }}">
                </div>

                <div class="form-group">
                    <label for="company_id">{{ __('s.select_company') }}</label>
                    <select name="company" class="form-control" id="company_id">
                        <option disabled value="">{{ __('s.select_company') }}</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div id="branch_select_wrapper" class="form-group">
                    <label for="branch_id">{{ __('s.select_branch') }}</label>
                    <select name="branch_id" class="form-control" id="branch_id">
                        <option disabled selected value="">{{__('s.select_branch') }}</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $order->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="status">
                    <label for="status">{{ __('s.order_status') }}</label>
                    <select name="status" id="orderStatus" class="form-control" >
                        <option value="success" {{ $order->status === 'success' ? 'selected' : '' }}>success</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>cancelled</option>
                    </select>
                </div>
                <div><p id='noStatus'></p></div>

                <div id="product_container">
                    <div class="form-group" id="hidden-select-product">
                        <label for="product_id">{{ __('s.select_product') }}</label>
                        <select name="product_id[]" class="form-control" id="product_id" multiple>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row selector-container">
                    <div id="product_price">
                        @foreach($productPrices as $productId => $productPrice)
                        <div class="form-group">
                            <label for="productPrice_{{$productId}}">{{__('s.product_price_for')}} {{$products->find($productId)->name}}</label>
                            <input type="number" name="product_price[]" value="{{ $productPrice }}" class="form-control product_price_input" id="product_price_{{$productId}}" data-product-id="{{$productId}}" min="1">
                        </div>
                        @endforeach
                    </div>
                    <div id="quantity_fields">
                        @foreach($productQuantities as $productId => $productQuantity)
                        <div class="form-group">
                            <label for="quantity_{{$productId}}">{{__('s.quantity_for')}} {{$products->find($productId)->name}}</label>
                            <input type="number" name="stock_quantity[]" value="{{ $productQuantity }}" class="form-control quantity_input" id="quantity_{{$productId}}" data-product-id="{{$productId}}" min="1">
                        </div>
                        @endforeach
                    </div>
                    <div id="product_total_price">
                        @foreach($productTotalPrices as $productId => $productTotalPrice)
                        <div class="form-group">
                            <label for="productTotalPriceField_{{$productId}}">{{__('s.product_total_price_for')}} {{$products->find($productId)->name}}</label>
                            <input type="text" name="total_price[]" value="{{ $productTotalPrice }}" class="form-control product_total_price" id="product_total_price_{{$productId}}" disabled>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="productTotalOfTotalPriceField">{{__('s.product_total_of_total_price_for')}}</label>
                        <div id="product_total_of_total_selected_price">
                            <input type="hidden" name="total_of_total_price" id="total_of_total_price_value" value="{{$orderPrice}}">
                            <input type="text" value="{{$orderPrice}}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group row selector-container">
                    <div id="product_price"></div>
                    <div id="quantity_fields"></div>
                    <div id="product_total_price"></div>
                    <div id="product_total_of_total_price">
                    </div>
                </div>

                <button id="formSubmitOrders" type="submit" class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('s.cancel') }}</a>
            </form>
            <!-- Form ends -->
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>
    var translations = {
        quantity_for: '{{ __("s.quantity_for") }}',
        product_price_for: '{{ __("s.product_price_for") }}',
        product_total_price_for: '{{__("s.product_total_price_for")}}',
        product_total_of_total_price_for: '{{__("s.product_total_of_total_price_for")}}',
        fillorderDate: '{{ __("s.fill_order_date") }}',
        length_order_price: '{{ __("s.length_order_price") }}',
        length_order_branch: '{{ __("s.length_order_branch") }}',
        fillCompany: '{{ __("s.fill_company") }}',
        fillBranch: '{{ __("s.fill_branch_name") }}',
        selectProduct: '{{ __("s.select_product_please") }}',
        fillQuantity: '{{ __("s.fill_quantity_number") }}',
        invalidQuantityFormat: '{{ __("s.invalid_quantity_format") }}',
        invalidProductPrice: '{{ __("s.invalid_product_price") }}',
        subtotalExceededLimit: '{{__("s.subtotal_length_exceeded")}}',
        select_branch: '{{__("s.select_branch")}}',
        no_products: '{{__("s.no_products")}}',
        no_branches: '{{__("s.no_branches")}}',
        productNotEnoughStock: '{{__("s.product_not_enough_stock")}}',
        final_total_price_for: '{{__("s.final_total_price_for")}}',
        statusNotChangeable:'{{__("s.status_not_changeable")}}',
    };
</script>
@endsection