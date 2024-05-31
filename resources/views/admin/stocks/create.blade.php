@extends('layouts.master')

@section('title')
    {{ __('s.create_stock') }}
@endsection

@section('css')
    <!-- Include any additional CSS files here -->
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
        <h3 class="page-title"> {{__('s.stocks')}} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/stocks') }}">{{__('s.stocks')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a > {{__('s.create_stock')}}</a></li>
            </ol>
        </nav>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form starts -->
                <form action="{{ route('stocks.store') }}" id="stock_form" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    @csrf

                    <div class="form-group">
                        <label for="product_id">{{ __('s.select_product') }}</label>
                        <select name="product_id[]" class="form-control multiple-select" id="product_id" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="quantity_fields"></div>

                    <div class="form-group">
                        <label for="branch_id">{{ __('s.select_branch') }}</label>
                        <select name="branch_id" class="form-control" id="branch_id">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button id="formSubmitStock" type="submit" class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
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
            fillQuantityNumber: '{{ __("s.fill_quantity_number") }}',
            invalidQuantityFormat: '{{ __("s.invalid_quantity_format") }}',
            selectProduct: '{{ __("s.select_product_please") }}',
            duplicateProduct: '{{ __("s.duplicate_product_found") }}',
            no_branches:'{{__("s.no_branches")}}',
        };
      


    </script>
@endsection
