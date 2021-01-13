<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <div class="card-header ">
                    <div class="offset-10">
                        <i class="fa fa-align-justify"></i>
                        <span>{{ title }}</span>
                    </div>
                </div>

                <div v-if="thereIsNoInvoiceItemsInList" class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <autocomplete
                                :search="search"
                                placeholder="فاکتور را جستجو کنید"
                                :get-result-value="getResultValue"
                                :debounce-time="500"
                                @submit="handleSearchSubmit"
                            ></autocomplete>
                        </div>
                        <div class="col-6 align-middle">
                            <div class="form-group row justify-content-end ">
                                <label class="col-md-3 col-form-label">
                                    جستجو بر اساس
                                </label>
                                <div class="col-md-5 col-form-label">
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode= 'invoice_no'" class="form-check-input"
                                               type="radio" checked="checked"
                                               id="invoice_no" value="invoice_no" name="inline-radios">
                                        <label class="form-check-label" for="invoice_no">شماره</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode='value_after_off_total'" class="form-check-input"
                                               type="radio" id="value_after_off_total"
                                               value="value_after_off_total" name="inline-radios">
                                        <label class="form-check-label" for="value_after_off_total">ارزش</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'created_at'" class="form-check-input" type="radio"
                                               id="filter_created_at"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">تاریخ</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'customer_mobile'" class="form-check-input"
                                               type="radio"
                                               id="customer_mobile"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">موبایل</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'customer_card_number'" class="form-check-input"
                                               type="radio"
                                               id="customer_card_number"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">کارت</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table class="table table-responsive-sm table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره فاکتور</th>
                            <th>تعداد اقلام</th>
                            <th>مبلغ نهایی</th>
                            <th>جمع نقدی</th>
                            <th>جمع امتیاز</th>
                            <th>جمع کیف پول</th>
                            <th>تاریخ ایجاد</th>
                            <th>جزییات</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(invoice,index) in historyList">

                            <td>{{ index + 1 }}</td>

                            <td>{{ invoice.invoice_no }}</td>
                            <td>{{ invoice.invoice_total_items }}</td>
                            <td>{{ invoice.value_after_off_total }}</td>
                            <td>{{ invoice.from_cash_total }}</td>
                            <td>{{ invoice.from_score_total }}</td>
                            <td>{{ invoice.from_wallet_total }}</td>
                            <td>{{ invoice.created_at }}</td>
                            <th v-on:click="getInvoiceItems(invoice.invoice_no),
                             thereIsNoInvoiceItemsInList = false">
                                <a href="#">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <template>
                        <vue-content-loading :width="500" :height="5">
                            <rect rx="1.5" ry="1.5" width="500" height="5"/>
                        </vue-content-loading>
                    </template>

                    <ul class="pagination">
                        <li class="page-item"
                            v-if="data.current_page>1 && data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getPurchaseHistoryList(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item"
                            v-show="data.current_page>1 && data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getPurchaseHistoryList(data.prev_page_url)">{{
                                data.current_page
                                - 1
                            }}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{ data.current_page }}</a>
                        </li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="getPurchaseHistoryList(data.next_page_url)">{{
                                data.current_page
                                + 1
                            }}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="getPurchaseHistoryList(data.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>

                    <li class="page-item text-center">صفحه {{ data.last_page }} از
                        {{ data.current_page }}
                    </li>

                </div>
                <div v-else class="card-body">
                    <div class="row">

                        <!--invoice_number-->
                        <div class="form-group col">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </span>
                                <input type="text" id="invoice_number" name="invoice_number"
                                       class="form-control "
                                       :value="invoiceItems[0].invoice_no"
                                       readonly="true">

                            </div>
                        </div>

                        <!--sale_user_name-->
                        <div class="form-group col">
                            <div class="input-group">
                                                <span class="input-group-text">
                                                   <i class="fas fa-user-friends"></i>
                                                </span>
                                <input type="text" id="sale_user_name" name="sale_user_name"
                                       class="form-control "
                                       :value="invoiceItems[0].sale_user_name"
                                       readonly="true">

                            </div>
                        </div>

                        <!--created_at-->
                        <div class="form-group col">
                            <div class="input-group">
                                                <span class="input-group-text">
                                                   <i class="fas fa-calendar-day"></i>
                                                </span>
                                <input type="text" id="created_at" name="created_at"
                                       class="form-control "
                                       :value="invoiceItems[0].created_at"
                                       readonly="true">
                            </div>
                        </div>
                        <!--items_count-->
                        <div class="form-group col-2">
                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-list-ol"></i>
                                                </span>
                                <input type="text" id="items_count" name="items_count"
                                       class="form-control "
                                       :value="invoiceItems.length"
                                       readonly="true">
                            </div>
                        </div>

                        <div class="row col justify-content-end">
                            <div class="form-group ml-2">
                                <button class="btn  btn-primary  "
                                        @click="thereIsNoInvoiceItemsInList = true">
                                    بازگشت <i class="fas fa-chevron-left"></i>
                                </button>
                            </div>
                            <div class="form-group ml-3">
                                <button class="btn  btn-danger   " @click="invoiceDelete(invoiceItems[0].invoice_no)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <table class="table table-responsive-sm table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>سرویس/خدمت</th>
                            <th>مبلغ خالص تکی</th>
                            <th>تعداد</th>
                            <th>نام تخفیف</th>
                            <th>مبلغ تخفیف تکی</th>
                            <th>جمع کل</th>

                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(item,index) in invoiceItems">

                            <td>{{ index + 1 }}</td>

                            <td>{{ item.name }}</td>
                            <td>{{ numberWithCommas(item.base_value_per_one) }}</td>
                            <td>{{ item.count }}</td>
                            <td>{{ item.x_sens_name_fa }}</td>
                            <td>{{ numberWithCommas(item.off_value_per_one) }}</td>
                            <td>{{ numberWithCommas(item.total_after_off_per_item) }}</td>

                        </tr>
                        </tbody>
                    </table>

                    <!--total_after_off-->
                    <div class="form-group float-left">
                        <div class="input-group ">
                            <input type="text" id="total_after_off" name="total_after_off"
                                   class="form-control bg-success text-white"
                                   :value=" numberWithCommas(totalCalculator(invoiceItems))"
                                   readonly="true">
                            <span class="input-group-text">
                                                  <i class="fas fa-money-check-alt"></i>
                                                </span>
                        </div>


                    </div>
                </div>

            </div>
        </div>


    </div>


</template>

<script>
import VueContentLoading from 'vue-content-loading';

export default {
    components: {
        VueContentLoading,
    },
    props: ['user'],
    data() {
        return {
            historyList: {},
            invoiceItems: [{
                sale_user_name: '-',
                invoice_no: '-'
            }],
            data: {},
            title: 'فاکتور های اخیر',
            thereIsNoInvoiceItemsInList: true,
            searchMode: 'invoice_no',
            url: '/admin-panel/purchase/get/history',
        }
    },
    methods: {
        getPurchaseHistoryList(url) {
            axios.get(url)
                .then(response => {
                    this.data = response.data;
                    console.log('data = ');
                    console.log(this.data);
                    this.historyList = response.data.historyList.data;
                    this.data = response.data.historyList;
                    console.log('this.data = ');
                    console.log(this.data);
                })
                .catch(e => {
                    console.log(e)
                })
        },
        async getInvoiceItems(invoice_number) {
            await axios.get('/admin-panel/purchase/get/invoiceItems?invoice_number=' + invoice_number)
                .then(response => {
                    console.log('response = ')
                    console.log(response);
                    this.invoiceItems = response.data.invoiceItems;
                    console.log('this.invoiceItems = ')
                    console.log(this.invoiceItems)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        invoiceDelete(invoice_number) {
            swal({
                title: "حذف فاکتور!",
                text: "این عمل موجب حذف فاکتور می گردد آیا اطمینان دارید؟",
                icon: "warning",
                buttons: ["خیر", "بله"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('/admin-panel/purchase/do/delete?invoice_number=' + invoice_number)
                        .then(response => {
                            swal("فاکتور شماره " + '\n' + invoice_number + '\n' + " با موفقیت حذف شد", {
                                icon: "success",
                            });
                            console.log('response = ')
                            console.log(response);
                        })
                        .catch(e => {
                            console.log(e)
                            swal(" با خطا مواجه شد" + '\n' + e, {
                                icon: "error",
                            });
                        })


                } else {

                }
            });
        },
        totalCalculator(items) {
            let total = 0;
            for (let i = 0; i < items.length; i++) {
                total += parseFloat(items[0].total_after_off_per_item);
            }
            console.log('total')
            console.log(total)
            return this.numberWithCommas(total);
        },
        numberWithCommas(string) {
            return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        //search
        search(input) {
            let searchResult;
            if (input.length <= 2) {
                console.log('input.length <= 2')
                this.getPurchaseHistoryList(this.url);
                return []
            }

            console.log('value = ')
            console.log(input)
            console.log('searchMode = ')
            console.log(this.searchMode)
            return new Promise(resolve => {
                axios.get('/admin-panel/purchase/get/historyByInput?filter=' + this.searchMode + '&value=' + input)
                    .then(response => {
                        console.log('response')
                        console.log(response)
                        searchResult = response.data.searchResult;
                        resolve(searchResult)
                        console.log('searchResult = ')
                        console.log(searchResult)
                    })
                    .catch(e => {
                        console.log(e);
                        searchResult = ['error']
                    })

                // return new Promise(searchResult)


            })
        },
        getResultValue(result) {
            //     console.log('getResultValue')
            //     console.log(result)
            return result.invoice_no
        },
        handleSearchSubmit(result) {
            console.log('You selected = ')
            console.log(result)
            console.log(this.historyList)
            this.historyList = [];
            if (typeof result !== 'undefined') {
                console.log('CHECK 1')
                this.historyList.push(result);
            } else {
                console.log('CHECK 2')
                console.log(this.data)
                this.historyList = this.data;
            }
        }
    },
    created: function () {
        console.log('PurchaseHistoryTableComponent created.');
        this.getPurchaseHistoryList(this.url);
    },
    mounted: function () {
        console.log('PurchaseHistoryTableComponent mounted.');
    },
    watch: {
        thereIsNoInvoiceItemsInList: function () {

            if (this.thereIsNoInvoiceItemsInList) {
                this.title = 'فاکتور های اخیر';
                this.getPurchaseHistoryList(this.url);
            } else {
                this.title = 'جزییات فاکتور ';
            }
        }
    }

}
</script>

<style>
.swal-text {
    background-color: #FEFAE3;
    padding: 17px;
    border: 1px solid #F0E1A1;
    display: block;
    margin: 22px;
    text-align: center;
    color: #61534e;
}


</style>
