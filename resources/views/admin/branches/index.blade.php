@extends('layouts.master')
@section('title')
{{__('s.branches')}}
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
    <h3 class="page-title"> {{__('s.branches')}} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
        <li class="breadcrumb-item">{{__('s.branches')}}</li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href={{ route('branches.create') }} type="button" class="add-button btn btn-primary ">{{__('s.add_branch')}}</a>

          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="{{ route('branches.json') }}" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="name" >{{__('s.branch_name')}}</th>
              <th data-sortable="true" data-field="company_name">{{__('s.company_name')}}</th>
              <th data-sortable="true" data-field="image" data-formatter="imageFormatter">{{__('s.branch_image')}}</th>
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
    var translations1= {'Are you sure you want to delete this branch?': '{{ __("s.Are you sure you want to delete this branch?") }}'}
    var translations = {
        'Confirmation': '{{ __("s.Confirmation") }}',
        'Are you sure you want to delete this branch?': '{{ __("s.Are you sure you want to delete this branch?") }}',
        'Yes': '{{ __("s.Yes") }}',
        'No': '{{ __("s.No") }}',
        'deleting branch done:': '{{ __("s.deleting branch done:") }}',
        'Deletion canceled': '{{ __("s.Deletion canceled") }}'
    };


   function actionFormatter(value, row, index) {
       var editUrl = '{{ route('branches.edit', ['id' => ':id']) }}';
       var deleteUrl = '{{ route('branches.destroy', ['id' => ':id']) }}';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-branch-id="' + row.id + '" onclick="destroy(\'branch\', ' + row.id + ')">' +
     '<i class="fas fa-trash-alt text-danger"></i>' +
 '</a>'

       ].join('');
   }
   function imageFormatter(value, row) {
       if (!value) {
           // If value is empty or null, use the default placeholder image
           var imageUrl = "{{ asset('images/placeholder.png') }}";
       } else {
           var imageUrl = "{{ asset('uploads/') }}" + '/' + value;
       }
       return '<img src="' + imageUrl + '" width="100" alt="branch Image">';
   }

   // Define translations




</script>

@endsection
