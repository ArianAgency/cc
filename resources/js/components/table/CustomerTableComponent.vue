<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <slot name="header"></slot>
                <div class="card-body">
                    <autocomplete
                        :search="search"
                        placeholder="مشتری را جستجو کنید"
                        :get-result-value="getResultValue"
                        :debounce-time="500"
                        @submit="handleSearchSubmit"
                    ></autocomplete>
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

                            <td>{{index +1}}</td>

                            <td>{{customer.name}}</td>
                            <td>{{customer.family}}</td>
                            <td>{{customer.gender}}</td>
                            <td>{{customer.score}}</td>
                            <td>{{customer.wallet}}</td>
                            <td>
                                {{$parent.splitedCardNumber(customer.card_number,4)}}
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
                    <!--                    @if( count($data) > 10)-->
                    <ul class="pagination">
                        <li class="page-item" v-if="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getCustomerData(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getCustomerData(data.prev_page_url)">{{data.current_page
                            - 1}}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{data.current_page}}</a></li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getCustomerData(data.next_page_url)">{{data.current_page
                            + 1}}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getCustomerData(data.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>
                    <li class="page-item text-center">صفحه {{data.last_page}} از {{data.current_page}}</li>

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
                console.log('You selected = ')
                console.log(result)
                console.log(this.data.data)
                this.data.data = [];
                if (typeof result !== 'undefined'){
                    console.log('CHECK 1')
                    this.data.data.push(result);
                }else {
                    console.log('CHECK 2')
                    console.log( this.$parent.data)
                    this.data = this.$parent.data
                }
            }
        },
        created: function () {

        },
        mounted: function () {
            console.log('CustomerTableComponent mounted.')
            this.$parent.getCustomerData(`/admin-panel/customer/index?page=1`)
            this.data = this.$parent.data
        },
    }
</script>

<style scoped>


</style>
