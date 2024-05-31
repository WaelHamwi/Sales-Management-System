@extends('layouts.master')
@section('title')
{{ __('s.dashboard') }}
@endsection

@section('css')
@endsection

@section('title1')
@endsection

@section('title2')
overview
@endsection

@section('content')
@if (session('fail'))
<div class="alert alert-danger" role="alert">
    {{ session('fail') }}
</div>
@endif
<div class="page-header">
    <h3 class="page-title"> {{__('s.product')}} </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/stocks') }}">{{__('s.stocks')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> {{__('s.product_details')}}</a></li>
        </ol>
    </nav>
</div>



<div class="product-container">
    <div class="product-image">
        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="product-details">
        <h1 class="product-name" id="productName">{{$product->name}}</h1>
        <p class="product-price" id="productPrice"><span>Price:</span> {{$product->price}}</p>
        <p class="product-sku" id="productSku"><span>SKU:</span> {{$product->sku}}</p>
        <p class="product-barcode" id="productBarcode"><span>Barcode:</span> {{$product->barcode}}</p>
        <p class="product-category" id="productCategory"><span>Category:</span> {{$product->category->name}}</p>
        <p class="product-company" id="productCompany"><span>Company:</span>{{$product->company->name}}</p>
    </div>
</div>

@endsection

@section('scripts')

@endsection