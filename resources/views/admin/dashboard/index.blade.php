@extends('layouts.master')
@section('title')
{{ __('s.dashboard') }}
@endsection

@section('css')
@endsection

@section('title1')
{{ __('s.dashboard') }}
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


<div class="form-group row selector-container">
    <div class="form-group dashboard-input">
        <select name="company" id="company_id" class="form-control dashboard-input input-lg dynamic filter btn-gradient-primary  select-arrow" data-dependent="state">
            <option value="">{{ __('s.all_companies') }}</option>
            @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
        <div class="arrow-down"></div>
    </div>
    <div class="form-group dashboard-input">
        <select name="branch" id="branch_id" class="form-control  dashboard-input input-lg dynamic filter btn-gradient-primary" data-dependent="state">
            <option selected disabled value="">{{ __('s.select_branch') }}</option>
            @foreach ($branches as $branch)
            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
        <div class="arrow-down"></div>
    </div>
    <div class="dropdown-menu">
        @foreach ($companies as $company)
        <a class="dropdown-item btn-gradient-primary" href="#" id="{{ $company->id }}">{{ $company->name }}</a>
        @endforeach
        <div role="separator" class="dropdown-divider"></div>
        <a class="dropdown-item btn-gradient-primary" href="#">Separated link</a>
    </div>
    <div class="form-group dashboard-input input-lg dynamic filter">
        <div id="reportrange">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3"> {{ __('s.sales') }} <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                </h4>
                {{ __('s.sum_of_sales') }}
                <h2 class="mb-5 countOfPriceSales"></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3"> {{ __('s.orders') }} <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                </h4>
                {{ __('s.sum_of_orders') }}
                <h2 class="mb-5 countOfSuccessSales"></h2>

            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">{{ __('s.inventory_details') }} <i class="mdi mdi-information mdi-24px float-right"></i>
                </h4>
                {{ __('s.number_of_products_in_the_stock') }}
                <h2 class="mb-5 numOfProducts"></h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var translations = {
        'select_branch': '{{__("s.select_branch")}}',
        'no_branches':'{{__("s.no_branches")}}',
    }
</script>

@endsection