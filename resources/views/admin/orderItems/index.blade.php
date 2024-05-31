@extends('layouts.master')
@section('title')
user page
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
    <h3 class="page-title"> {{__('s.order_items')}} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
            <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
        <li class="breadcrumb-item">{{__('s.order_items')}}</li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('orderItems.create') }}" type="button" class="add-orderItem btn btn-primary">{{__('s.add_order_item')}}</a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="{{ route('orderItems.json') }}" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th data-sortable="true" data-field="id" >{{__('s.order_item_id')}}</th>
              <th  data-sortable="true" data-field="subtotal" >{{__('s.order_item_subtotal')}}</th>
              <th data-sortable="true" data-field="product_price">{{__('s.product_price')}}</th>
              <th data-sortable="true" data-field="product_name">{{__('s.product_name')}}</th>
              <th data-sortable="true" data-field="product_id">{{__('s.product_id')}}</th>
              <th data-sortable="true" data-field="order_id">{{__('s.order_id')}}</th>
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
    var translations1= {'Are you sure you want to delete this orderItem?': '{{ __("s.Are you sure you want to delete this orderItem?") }}'}
    var translations = {
        'Confirmation': '{{ __("s.Confirmation") }}',
        'Are you sure you want to delete this orderItem?': '{{ __("s.Are you sure you want to delete this orderItem?") }}',
        'Yes': '{{ __("s.Yes") }}',
        'No': '{{ __("s.No") }}',
        'deleting order_item done:': '{{ __("s.deleting order_item done:") }}',
        'Deletion canceled': '{{ __("s.Deletion canceled") }}'
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '{{ route('orderItems.edit', ['id' => ':id']) }}';
       var deleteUrl = '{{ route('orderItems.destroy', ['id' => ':id']) }}';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-orderItem-id="' + row.id + '" onclick="destroy(\'orderItem\', ' + row.id + ')">' +
            '<i class="fas fa-trash-alt text-danger"></i>' +
        '</a>'

       ].join('');
   }



</script>

@endsection
