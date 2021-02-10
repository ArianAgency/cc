{{--@extends('layouts.coreui.admin')--}}
@extends('customer.master-customer-template')


@section('app-body-main-content')
    <!-- Breadcrumb -->
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-body">
                   <customer-score-convertor ></customer-score-convertor>
                </div>
            </div>
        </div>
    </div>


@endsection


