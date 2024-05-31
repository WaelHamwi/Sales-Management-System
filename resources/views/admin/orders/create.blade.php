@extends('layouts.master')

@section('title')
{{__('s.add_order')}}
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
            <li class="breadcrumb-item active" aria-current="page"><a>{{__('s.create_order')}}</a></li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- Form starts -->
            <form action="{{ route('orders.store') }}" id="formDropzone" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                @csrf
                <input type="hidden" name="status" value="success" id="status">
                <div class="form-group">
                    <label for="exampleInputName1">{{ __('s.order_date') }} <span>*</span></label>
                    <input type="date" value={getCurrentDate()} name="order_date" class="form-control" id="order_date" placeholder="{{ __('s.order_date_placeholder') }}">
                </div>

                <div class="form-group">
                    <label for="company_id">{{ __('s.select_company') }}</label>
                    <select name="company_id" class="form-control" id="company_id">
                        <option disabled selected value="">{{__('s.select_company') }}</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="branch_select_wrapper" style="display: none;">
                    <div class="form-group" id="hidden-select-branch">
                        <label for="branch_id">{{ __('s.select_branch') }}</label>
                        <select name="branch_id" class="form-control" id="branch_id">
                            <option disabled selected value="">{{__('s.select_branch') }}</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="product_container" style="display: none;">
                    <div class="form-group" id="hidden-select-product">
                        <label for="product_id">{{ __('s.select_product') }}</label>
                        <select name="product_id[]" class="form-control" id="product_id" multiple>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row selector-container">
                    <div id="product_price"></div>
                    <div id="quantity_fields"></div>
                    <div id="product_total_price"></div>
                    <div id="product_total_of_total_price"></div>
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
        productNotEnoughStock:'{{__("s.product_not_enough_stock")}}'
    };
</script>
@endsection