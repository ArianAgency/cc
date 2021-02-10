{{--@extends('layouts.coreui.admin')--}}
@extends('customer.master-customer-template')


@section('app-body-main-content')
    <!-- Breadcrumb -->

    <div class="container-fluid">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="btn btn-primary text-white " style="height: 150px; width: 100%">
                        <h4>لیست تخفیف ها</h4>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="btn btn-info text-white " style="height: 150px; width: 100%">
                        <h4>اعتبار</h4>
                        <div>
                            {{number_format(Auth::guard('customers')->user()->wallet,2,".",",")}}
                        </div>

                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="btn btn-warning text-white " style="height: 150px; width: 100%">

                        <h4>امتیاز</h4>
                        <div>
                            {{Auth::guard('customers')->user()->score}}
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3 ">
                    <div class="btn btn-danger text-white " style="height: 150px; width: 100%">
                        <h4>حجم خرید</h4>
                        <div>
                            {{number_format(Auth::guard('customers')->user()->CustomerShoppingVolume,2,".",",")}}
                        </div>
                    </div>
                </div>
                <!--/.col-->

            </div>
            <!--/.row-->

            <div class="card">
                <div class="card-body">
           <spa-main-template
           mode="table"
           ></spa-main-template>

                </div>
            </div>
            <!--/.card-->

        </div>

    </div>


@endsection


