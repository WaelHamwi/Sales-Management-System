@extends('layouts.master')
@section('title')
{{__('s.stocks')}}
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
    <h3 class="page-title"> {{__('s.stocks')}} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
        <li class="breadcrumb-item">{{__('s.stocks')}}</li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('stocks.create') }}" type="button" class="add-button btn btn-primary">{{__('s.add_stock')}}</a>

          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="{{ route('stocks.json') }}" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>

              <th  data-sortable="true" data-field="quantity" >{{__('s.stock_quantity')}}</th>
              <th data-sortable="true" data-field="product_id">{{__('s.product_name')}}</th>
              <th data-sortable="true" data-field="company_id">{{__('s.company_name')}}</th>
              <th data-sortable="true" data-field="branch_id">{{__('s.branch_name')}}</th>
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
    var translations1= {'Are you sure you want to delete this stock?': '{{ __("s.Are you sure you want to delete this stock?") }}'}
    var translations = {
        'Confirmation': '{{ __("s.Confirmation") }}',
        'Are you sure you want to delete this stock?': '{{ __("s.Are you sure you want to delete this stock?") }}',
        'Yes': '{{ __("s.Yes") }}',
        'No': '{{ __("s.No") }}',
        'deleting stock done:': '{{ __("s.deleting stock done:") }}',
        'Deletion canceled': '{{ __("s.Deletion canceled") }}'
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '{{ route('stocks.edit', ['id' => ':id']) }}';
       var deleteUrl = '{{ route('stocks.destroy', ['id' => ':id']) }}';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-stock-id="' + row.id + '" onclick="destroy(\'stock\', ' + row.id + ')">' +
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
       return '<img src="' + imageUrl + '" width="100" alt="stock Image">';
   }

  




</script>

@endsection
