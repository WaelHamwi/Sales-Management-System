@extends('layouts.master')
@section('title')
{{__('s.companies')}}
@endsection

@section('css')

@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ __(session('success')) }}
    </div>
@endif

<!-- Check if there is an error message -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ __(session('error')) }}
    </div>
@endif
  <div class="page-header">
    <h3 class="page-title"> {{__('s.companies')}} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
        <li class="breadcrumb-item">{{__('s.companies')}}</li>
      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href={{ route('companies.create') }} type="button" class="add-button btn btn-primary ">{{__('s.add_company')}}</a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="{{ route('companies.json') }}" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="name" >{{__('s.company_name')}}</th>
              <th  data-sortable="true" data-field="currency" >{{__('s.company_currency')}}</th>
              <th data-sortable="true" data-field="image" data-formatter="imageFormatter">{{__('s.company_image')}}</th>
              <th data-formatter="actionFormatter">{{__('s.action')}}</th>
          </tr>
      </thead>
      <tbody>

</tbody>
  </table>





        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script>
    var translations = {
        'Confirmation': '{{ __("s.Confirmation") }}',
        'Are you sure you want to delete this company?': '{{ __("s.Are you sure you want to delete this company?") }}',
        'Yes': '{{ __("s.Yes") }}',
        'No': '{{ __("s.No") }}',
        'deleting company done:': '{{ __("s.deleting company done:") }}',
        'Deletion canceled': '{{ __("s.Deletion canceled") }}'
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '{{ route('companies.edit', ['id' => ':id']) }}';
       var deleteUrl = '{{ route('companies.destroy', ['id' => ':id']) }}';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-company-id="' + row.id + '" onclick="destroy(\'company\', ' + row.id + ')">' +
                          '<i class="fas fa-trash-alt text-danger"></i>' +
                      '</a>'
       ].join('');
   }
   function imageFormatter(value, row) {
       if (!value) {
           var imageUrl = "{{ asset('images/placeholder.png') }}";
       } else {
           var imageUrl = "{{ asset('uploads/') }}" + '/' + value;
       }
       return '<img src="' + imageUrl + '" width="100" alt="Company Image">';
   }


</script>

@endsection
