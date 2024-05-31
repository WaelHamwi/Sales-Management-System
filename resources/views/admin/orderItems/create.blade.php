@extends('layouts.master')
@section('title')
@endsection

@section('css')
@endsection

@section('title1')
    {{ __('s.create_order_item') }}
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
      <h3 class="page-title"> {{__('s.order_items')}} </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/order_items') }}">{{__('s.order_items')}}</a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > {{__('s.create_order_item')}}</a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
                <form action="{{ route('orderItems.store') }}" id="formDropzone" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
      @csrf
      <div class="form-group">
          <label for="exampleInputName1">{{ __('s.order_item_subtotal') }} <span>*</span></label>
          <input type="text" value="" autofocus name="order_item_subtotal" class="form-control" id="exampleInputName1" placeholder="{{ __('s.order_item_subtotal_placeholder') }}">
      </div>
      <div class="form-group">
          <label for="order_id">{{ __('s.select_order') }}</label>
          <select name="order_id" class="form-control" id="order_id">
              @foreach($orders as $order)
                  <option value="{{ $order->id }}">{{ $order->id }}</option>
              @endforeach
          </select>
      </div>

      <div class="form-group">
          <label for="product_id">{{ __('s.select_product') }}</label>
          <select name="product_id" class="form-control" id="order_id">
              @foreach($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
          </select>
      </div>
      <div class="form-group">
          <label for="exampleInputName1">{{ __('s.product_price') }} <span>*</span></label>
          <input type="text" value="" autofocus name="product_price" class="form-control" id="product_price" placeholder="{{ __('s.product_price_placeholder') }}">
      </div>
      <div class="form-group">
          <label for="exampleInputName1">{{ __('s.product_name') }} <span>*</span></label>
          <input type="text" value="" autofocus name="product_name" class="form-control" id="product_name" placeholder="{{ __('s.product_name_placeholder') }}">
      </div>
      <button id="formSubmit" type="submit" class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
      <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('s.cancel') }}</a>
  </form>

                <!-- Form  ends -->
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
    var translations = {
         length_orderItem_subtotal: '{{ __("s.length_orderItem_subtotal") }}',
         length_orderItem_price: '{{ __("s.length_orderItem_price") }}',
         length_product_name: '{{__("s.invalid_length_product_name")}}',
         numberOnly_orderItem_subtotal:'{{__("s.numberOnly_orderItem_subtotal")}}',
         invalid_orderItem_price:'{{__("s.invalid_orderItem_price")}}',
     };
    </script>
@endsection
