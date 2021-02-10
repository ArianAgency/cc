{{--@extends('layouts.coreui.admin')--}}
@extends('customer.master-customer-template')


@section('app-body-main-content')
    <!-- Breadcrumb -->

    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-body">
                    <table-template
                        title="تخفیفات جاری برای شما"
                        :headers="['عنوان','تخفیف','کش بک','امتیاز','اعتبار تا']"
                        :value-keys="['expire_at','score_percent','cash_back_percent','off_percent','x_sens_name_fa']"
                        :get-url="'/customer-panel/testTable/get/discounts'"
                        :pagination="false"
                    ></table-template>
                </div>
            </div>

        </div>
    </div>


@endsection


