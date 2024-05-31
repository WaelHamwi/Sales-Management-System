@extends('layouts.master')
@section('title')
{{__('s.orders')}}
@endsection

@section('css')

@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<!-- Check if there is an error message -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ __(session('error')) }}
    </div>
@endif
  <div class="page-header">
    <h3 class="page-title"> {{__('s.orders')}} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
        <li class="breadcrumb-item">{{__('s.orders')}}</li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href={{ route('orders.create') }} type="button" class="add-button btn btn-primary ">{{__('s.add_order')}}</a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="{{ route('orders.json') }}" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="date" >{{__('s.order_date')}}</th>
              <th  data-sortable="true" data-field="price" >{{__('s.order_price')}}</th>
              <th  data-sortable="true" data-field="currency_symbol" >{{__('s.currency')}}</th>
              <th data-sortable="true" data-field="branch_name">{{__('s.branch_name')}}</th>
              <th  data-sortable="true" data-field="status" >{{__('s.order_status')}}</th>
              <th data-formatter="actionFormatter">{{__('s.action')}}</th>
          </tr>
      </thead>

  </table>
  <!-- Modal -->
        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">{{__('s.order_details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div id="orderDetails"></div>
                <table id="table" class="table-order-details" data-toggle="table"   class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th data-sortable="true" data-field="product_name">{{__('s.product_name')}}</th>
              <th data-sortable="true" data-field="quantity">{{__('s.quantity')}}</th>
              <th data-sortable="true" data-field="subtotal">{{__('s.subtotal')}}</th>
              <th  data-sortable="true" data-field="currency_symbol" >{{__('s.currency')}}</th>
          </tr>
      </thead>
  </table>

              </div>
            </div>
          </div>
        </div>
  <!-- Modal -->
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script>
    var translations1= {'Are you sure you want to delete this order?': '{{ __("s.Are you sure you want to delete this order?") }}'}
    var translations = {
        'Confirmation': '{{ __("s.Confirmation") }}',
        'Are you sure you want to delete this order?': '{{ __("s.Are you sure you want to delete this order?") }}',
        'Yes': '{{ __("s.Yes") }}',
        'No': '{{ __("s.No") }}',
        'deleting order done:': '{{ __("s.deleting_order_done:") }}',
        'Deletion canceled': '{{ __("s.Deletion canceled") }}',
        'ID':'{{__("s.ID")}}',
        'product_name':'{{__("s.product_name")}}',
        'product_id':'{{__("s.product_id")}}',
        'subtotal':'{{__("s.subtotal")}}',
        'product_price':'{{__("s.product_price")}}',
        'total_price':'{{__("s.total_price")}}',
        'payment_method':'{{__("s.payment_method")}}',
        'order_date':'{{__("s.order_date")}}',
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '{{ route('orders.edit', ['id' => ':id']) }}';
       var deleteUrl = '{{ route('orders.destroy', ['id' => ':id']) }}';
       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
             '<a href="javascript:void(0)" class="delete-button" data-order-id="' + row.id + '" onclick="destroy(\'order\', ' + row.id + ')">' +
               '<i class="fas fa-trash-alt text-danger"></i>' +
           '</a>',
           '<a id="view-order-' + row.id + '" class="text-primary mr-3 view-order-btn">',
           '<i class="fas fa-eye"></i>',
           '</a>'
       ].join('');
   }


   // Define translations




</script>

@endsection
