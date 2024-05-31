@extends('layouts.master')

@section('title')
{{__('s.edit_stock')}}
@endsection

@section('css')
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
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
    <h3 class="page-title"> {{__('s.stocks')}} </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/stocks') }}">{{__('s.stocks')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> {{__('s.edit_stock')}}</a></li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card edit-stock-page">
    <div class="card">
        <div class="card-body">
            <!-- Default Edit Form starts -->
            <form id="default-edit-form" action="{{ route('stocks.update', ['id' => $stock->id]) }}" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="quantity">{{ __('s.quantity') }}</label>
                    <input type="text" name="stock_quantity" class="form-control" id="quantity" value="{{ $stock->quantity }}">
                </div>

                <button id="formSubmitStockEdit" type="submit" class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('s.cancel') }}</a>
            </form>
            <!-- Default Edit Form ends -->

            <!-- Button to reveal advanced edit form -->
            <a id="toggleFormButton" class="btn btn-gradient-primary me-2 mt-3 reveal-advanced" onclick="toggleAdvancedForm()">{{ __('s.edit_more_details') }}</a>

            <!-- more detials Edit Form starts (initially hidden) -->
            <form method="POST" id="stock_form" action="{{ route('stocks.updateAll', ['id' => $stock->id]) }}" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px; display:none;">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="product_id">{{ __('s.select_product') }}</label>
                    <select name="product_id" class="form-control single-select" id="product_id">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="branch_id">{{ __('s.select_branch') }}</label>
                    <select name="branch_id" class="form-control" id="branch_id">
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $stock->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="quantity_fields">
                <input type="text" name="stock_quantity" class="form-control" id="quantity" value="{{ $stock->quantity }}">
                </div>

                <button id="formSubmitStock" type="submit" class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('s.cancel') }}</a>
            </form>
            <!-- more details Edit Form ends -->
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var translations = {
        quantity_for: '{{ __("s.quantity_for") }}',
        fillQuantityNumber: '{{ __("s.fill_quantity_number") }}',
        invalidQuantityFormat: '{{ __("s.invalid_quantity_format") }}',
        selectProduct: '{{ __("s.select_product_please") }}',
        duplicateProduct: '{{ __("s.duplicate_product_found") }}',
        no_branches: '{{ __("s.no_branches") }}',
        editLessDetails: '{{ __("s.edit_less_details") }}',
        editMoreDetails: '{{ __("s.edit_more_details") }}'
        
    };
</script>
@endsection