@extends('layouts.master')
@section('title')
{{__('s.edit_category')}}
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
      <h3 class="page-title"> {{__('s.categories')}} </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/categories') }}">{{__('s.categories')}}</a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > {{__('s.edit_category')}}</a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
              <form action="{{ route('categories.update', ['id' => $category->id]) }}" class="forms-sample" method="POST"   enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName1">{{ __('s.category_name') }} <span>*</span></label>
                        <input type="text" value="{{ $category->name }}" autofocus name="category_name"
                        class="form-control" id="exampleInputName1"
                        placeholder="{{ __('s.category_name_placeholder') }}">
                    </div>
                    <div class="form-group">
                        <label for="company_id">{{ __('s.select_company') }}</label>
                        <select name="company_id" class="form-control" id="company_id">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--dropzone form start-->
                    <div class="form-group dropzone" id="myDropzone" data-upload-route="{{ route('categories.upload') }}">
                        <label class="form-label text-muted opacity-75 fw-medium"
                            for="formImage">{{ __('s.file_upload') }}</label>
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
                                            <path fill="#FFFFFF"
                                                d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div class="dz-upload-container">
                                        <div class="dz-upload-progress"></div>
                                        <div class="progress-text"></div>
                                        <i class="fas fa-check checkmark-icon" ></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="imageInput2" name="image">
                        </div>
                    </div>
                    <!--dropzone form end-->
                    <div class="form-group">
            @if($category->image)
            <img src="{{ asset('uploads/' . $category->image) }}" id="categoryImage" class="categoryImage" alt="category Image">
            @else
            <img src="{{ asset('uploads/defaultcategoryImage.jpeg') }}"  class="userImage"  alt="">
          @endif
        </div>
                    <button id="formSubmitCategory" type="submit"
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
           fillCategoryName: '{{ __("s.fill_category_name") }}',
           categoryNameMax: '{{ __("s.category_name_max", ["max" => 35]) }}',
           imageRequired: '{{ __("s.image_required") }}'
       };
    </script>
@endsection
