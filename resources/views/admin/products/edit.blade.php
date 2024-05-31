@extends('layouts.master')
@section('title')
{{__('s.edit_product')}}
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
      <h3 class="page-title"> {{__('s.products')}} </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
              <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/products') }}">{{__('s.products')}}</a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > {{__('s.edit_product')}}</a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
              <form action="{{ route('products.update', ['id' => $product->id]) }}" class="forms-sample" method="POST"   enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName1">{{ __('s.product_name') }} <span>*</span></label>
                        <input type="text" value="{{ $product->name }}" autofocus name="product_name"
                        class="form-control" id="exampleInputName1"
                        placeholder="{{ __('s.product_name_placeholder') }}">
                    </div>
                    <div class="form-group">
                        <label for="company_id">{{ __('s.select_company') }}</label>
                        <select name="company_id" class="form-control" id="company_id">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">{{ __('s.select_category') }}</label>
                        <select name="category_id" class="form-control" id="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">{{ __('s.product_price') }} <span>*</span></label>
                        <input type="text" value="{{$product->price}}" autofocus name="product_price" class="form-control" id="productPrice" placeholder="{{ __('s.product_price_placeholder') }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">{{__('s.SKU')}} </label>
                        <input type="text" value="{{$product->sku}}" autofocus name="product_sku" class="form-control" id="productSKU" placeholder="{{ __('s.product_sku_placeholder') }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Barcode </label>
                        <input type="text" value="{{$product->barcode}}" autofocus name="product_barcode" class="form-control" id="productBarcode" placeholder="{{ __('s.product_barcode_placeholder') }}">
                    </div>
                    <!--dropzone form start-->
                    <div class="form-group dropzone" id="myDropzone" data-upload-route="{{ route('products.upload') }}">
                        <label class="form-label text-muted opacity-75 fw-medium" for="formImage">{{ __('s.file_upload') }}</label>
                        <div class="dropzone-drag-area form-control" id="previews">
                            <div class="dz-message text-muted opacity-50" data-dz-message>
                                <span>{{ __('s.drag_file_here') }}</span>
                            </div>
                            <div class="d-none" id="dzPreviewContainer">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-photo">
                                        <img id="imageInput" class="dz-thumbnail" data-dz-thumbnail>
                                    </div>
                                    <button class="dz-delete border-0 p-0 " type="button" data-dz-remove>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                                            <path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                                        </svg>
                                    </button>
                                    <div class="dz-upload-container">
                                        <div class="dz-upload-progress"></div>
                                        <div class="progress-text"></div>
                                        <i class="fas fa-check checkmark-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="imageInput2" name="image">
                        </div>
                    </div>
                    <!--dropzone form end-->
                    <div class="form-group">
            @if($product->image)
            <img src="{{ asset('uploads/' . $product->image) }}" id="productImage" class="productImage" alt="product Image">
            @else
            <img src="{{ asset('uploads/defaultproductImage.jpeg') }}"  class="userImage"  alt="">
          @endif
        </div>
                    <button id="formSubmitProduct" type="submit"
                        class="btn btn-gradient-primary me-2">{{ __('s.submit') }}</button>
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
         length_product_name: '{{ __("s.length_product_name") }}',
         length_product_price: '{{ __("s.length_product_price") }}',
         length_product_barcode: '{{ __("s.length_product_barcode") }}',
         length_product_SKU: '{{ __("s.length_product_SKU") }}',
         image_required: '{{ __("s.image_required") }}',
         invalid_product_price:'{{__("s.invalid_product_price") }}',
     };
    </script>
@endsection
