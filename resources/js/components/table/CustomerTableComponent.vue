<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <slot name="header"></slot>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6 row align-middle">

                            <autocomplete class="col-10"
                                          :search="search"
                                          placeholder="مشتری را جستجو کنید"
                                          :get-result-value="getResultValue"
                                          :debounce-time="500"
                                          @submit="handleSearchSubmit"
                            ></autocomplete>

                            <span @click="qrScan" class="btn btn-outline-secondary align-self-center mb-2">
                                    <i class="fas fa-qrcode lgBtn"></i>
                            </span>

                        </div>
                        <div class="col-6 align-middle">
                            <div class="form-group row justify-content-end ">
                                <!--                                <label class="col-md-3 col-form-label">-->
                                <!--                                    نمایش-->
                                <!--                                </label>-->
                                <div class="col-md-5 col-form-label ">
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="onChange($event)" checked="checked" class="form-check-input"
                                               type="radio" id="rb_completed" value="completed" name="inline-radios">
                                        <label class="form-check-label" for="rb_completed">تکمیل شده</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="onChange($event)" class="form-check-input" type="radio"
                                               id="rb_null" value="null" name="inline-radios">
                                        <label class="form-check-label" for="rb_null">خالی</label>
                                    </div>
                                    <div @change="onChange($event)" class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" type="radio" id="rb_all" value="all"
                                               name="inline-radios">
                                        <label class="form-check-label" for="rb_all">همه</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-responsive-sm table-striped mytable">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>جنسیت</th>
                            <th>امتیاز</th>
                            <th>کیف پول</th>
                            <th>شماره کارت</th>
                            <th>وضعیت</th>
                            <th></th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(customer,index) in data.data">

                            <td>{{ index + 1 }}</td>

                            <td>{{ customer.name }}</td>
                            <td>{{ customer.family }}</td>
                            <td>{{ customer.gender }}</td>
                            <td>{{ customer.score }}</td>
                            <td>{{ customer.wallet }}</td>
                            <td>
                                {{ $parent.splitedCardNumber(customer.card_number, 4) }}
                            </td>
                            <td v-bind:id="'sw_lb_'+ customer.id_customers">
                                <span v-if=" customer.is_active == 1 " class="badge badge-success">فعال</span>
                                <span v-else class="badge badge-secondary">غیر فعال</span>
                            </td>
                            <td><label class="switch switch-text switch-pill switch-info-outline-alt">
                                <input type="checkbox" class="switch-input" v-bind:checked="customer.is_active"
                                       v-bind:id="'sw_'+customer.id_customers"
                                       v-on:click="check($event,customer.id_customers)">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label></td>
                            <th v-on:click="$parent.indexForEdit = index ,$parent.view = 'add',$parent.pageTitle = 'ویرایش اطلاعات مشتری'">
                                <a href="#">
                                    <i class="fa fa-edit"/>
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
                        <li class="page-item" v-if="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getCustomerData(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getCustomerData(data.prev_page_url)">{{
                                data.current_page
                                - 1
                            }}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{ data.current_page }}</a>
                        </li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getCustomerData(data.next_page_url)">{{
                                data.current_page
                                + 1
                            }}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getCustomerData(data.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>
                    <li class="page-item text-center">صفحه {{ data.last_page }} از {{ data.current_page }}</li>

                </div>

            </div>
        </div>


    </div>


</template>

<script>
import VueContentLoading from 'vue-content-loading';

export default {
    props: ['getCustomerData', 'data'],
    components: {
        VueContentLoading,
    },
    data() {
        return {
            is_active_label: '',
            data: '',
            posts: [],
            filterForCustomerSearch: ['name', 'family']
        }
    },
    methods: {
        check(event, id_customer) {
            const vm = this;
            var status = event.target.checked;
            if (status == true) {
                status = 1;
            } else {
                status = 0;
            }

            // console.log('status : ' + status);
            // console.log('event.id : ' + event.target.id);
            var label_id = event.target.id.substring(0, 3) + 'lb_' + id_customer;
            // console.log('label_id : ' + label_id);
            // console.log('id_customer : ' + id_customer);

            axios.post('/admin-panel/customer', {
                action: 'is_active',
                id_customer: id_customer,
                value: status
            })
                .then(function (response) {

                    if (status == 1) {
                        // $('#' + label_id).innerHTML = ' <span  class="badge badge-success">فعال</span>';
                        $('#' + label_id).html('<span  class="badge badge-success">فعال</span>');

                    } else {
                        // $('#' + label_id).innerHTML = '  <span  class="badge badge-secondary" >غیر فعال</span>';
                        $('#' + label_id).html(' <span  class="badge badge-secondary" >غیر فعال</span>');
                    }

                })
                .catch(function (error) {
                    console.log('error : ' + error);
                });
        },
        search(input) {
            let searchResult;
            if (input.length <= 2) {
                console.log('input.length <= 2')
                return []
            }

            console.log('input = ')
            console.log(input)
            return new Promise(resolve => {
                axios.get('/admin-panel/customer/get/customerByInput?input=' + input + '&filterForCustomerSearch=' + this.filterForCustomerSearch)
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
            console.log('getResultValue')
            console.log(result)
            return result.name
        },
        handleSearchSubmit(result) {
            // console.log('You selected = ')
            // console.log(result)
            // console.log(this.data.data)
            this.data.data = [];
            if (typeof result !== 'undefined') {
                // console.log('CHECK 1')
                this.data.data.push(result);
            } else {
                // console.log('CHECK 2')
                // console.log(this.$parent.data)
                this.data = this.$parent.data
            }
        },
        onChange(event) {
            let mode = event.target.value;
            this.getCustomerData(`/admin-panel/customer/index?page=1&mode=` + mode)
        },
        qrScan() {
            let searchResult;
            swal({
                text: 'بار کد QR',
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "بارکد را اسکن یا دستی وارد کنید",
                    },
                },
                button: {
                    text: "بگرد",
                    closeModal: false
                }
            })
                .then(qr => {
                    if (!qr) throw null;
                    return new Promise(resolve => {
                        axios.get('/admin-panel/customer/get/customerByCardNumber?card_number=' + qr)
                            .then(response => {
                                searchResult = response.data.searchResult;
                                resolve(searchResult)
                            })
                            .catch(e => {
                                console.log(e);
                                searchResult = ['error']
                            })
                    })
                })
                .then(searchResult => {
                    console.log('searchResult = ')
                    console.log(searchResult)
                    const customer = searchResult[0];

                    if (!customer) {
                        return swal("این شماره کارت پیدا نشد");
                    }

                    this.data.data = [];
                    this.data.data.push(searchResult[0]);
                    swal.stopLoading();
                    swal.close();
                })
                .catch(err => {
                    if (err) {
                        swal(err);
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
        }
    },
    created: function () {

    },
    mounted: function () {
        console.log('CustomerTableComponent mounted.');
        // this.getCustomerData('/admin-panel/customer/index?page=1&mode=all');
        // this.data = this.$parent.data;
    },
}
</script>

<style scoped>
.lgBtn {
    font-size: 25px !important;
}

</style>
