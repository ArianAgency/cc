{{--@extends('layouts.coreui.admin')--}}
@extends('customer.master-customer-template')


@section('app-body-main-content')
    <!-- Breadcrumb -->

    <div class="container-fluid">

        <div class="animated fadeIn">

            <div class="card">
                <div class="card-body">
                    <table-template
                                    title="سابقه خرید"
                                    :headers="['شماره فاکتور','تعداد کالا','مبلغ نهایی','تاریخ']"
                                    :value-keys="['created_at','value_after_off_total','invoice_total_items','invoice_no']"
                                    :get-url="'/customer-panel/testTable/get/history'"
                                    has-more-info="true"
                                    :get-more-url="'/customer-panel/testTable/get/invoiceItems'"
                                    get-more-key="invoice_no"
                                    :headers2="['محصول','تعداد','قیمت','تخفیف تکی','تخفیف کل','مبلغ نهایی']"
                                    :value-keys2="['total_after_off_per_item','total_off_per_item','off_value_per_one','base_value_per_one','count','name']"
                                    :pagination="true"
                    ></table-template>

                </div>
            </div>
            <!--/.card-->

        </div>

    </div>


@endsection


