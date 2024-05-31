<!DOCTYPE html>
<html lang="{{ App::currentLocale() ?? 'en' }}">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @include('layouts.head')
</head>

<body>
  @include('layouts.main-header')
  <div class="container-fluid page-body-wrapper">
    @include('layouts.main-sidebar')

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            @unless(Request::is('companies')||('companies/create'))
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              @if(Request::is('/'))
              <i class="mdi mdi-home"></i>
              @elseif(Request::is('profile/edit'))
              <i class="mdi mdi-account"></i>
              @endif
              @endunless
            </span> @yield('title1')
          </h3>

        </div>

        @yield('content')
      </div>
      <!-- content-wrapper ends -->
      @include('layouts.footer')

    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <div id="loader" class="loader-overlay">
  </div>

  <div id="spinner"></div>

  <script type="text/javascript">
    var dropzoneTranslations = {
      'default_message': "{{ __('s.default_message') }}",
      'fallback_message': "{{ __('s.fallback_message') }}",
      'invalid_file_type': "{{ __('s.invalid_file_type') }}",
      'file_too_big': "{{ __('s.file_too_big', ['fileSize' => ':filesize', 'maxFilesize' => ':maxFilesize']) }}",
      'response_error': "{{ __('s.response_error', ['statusCode' => ':statusCode']) }}",
      'cancel_upload': "{{ __('s.cancel_upload') }}",
      'cancel_upload_confirmation': "{{ __('s.cancel_upload_confirmation') }}",
      'remove_file': "{{ __('s.remove_file') }}",
      'max_files_exceeded': "{{ __('s.max_files_exceeded', ['maxFiles' => ':maxFiles']) }}"
    };
    var currentLocale = "{{ App::currentLocale() }}";
    var globalPosition = currentLocale === 'ar' ? 'bottom left' : 'bottom right';
  </script>
  <!-- container-scroller -->
  @include('layouts.footer-scripts')

</body>

</html>