@extends('layouts.master')
@section('title')
{{ __('s.dashboard') }}
@endsection

@section('css')
@endsection

@section('title1')

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
<div class="page-header">
    <h3 class="page-title"> {{__('s.inventory_details')}} </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}"> {{__('s.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/stocks') }}">{{__('s.stocks')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> {{__('s.inventory_details')}}</a></li>
        </ol>
    </nav>
</div>

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
</div>


<div class="card-container">

</div>

@endsection

@section('scripts')
<script>
    var translations = {
        'go_to_product': '{{__("s.go_to_product")}}',
        'select_branch': '{{__("s.select_branch")}}',
        'no_branches':'{{__("s.no_branches")}}',
    }
</script>
@endsection