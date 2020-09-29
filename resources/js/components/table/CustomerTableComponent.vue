<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <slot name="header"></slot>
                <div class="card-body">
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

                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="customer in data.data">

                            <td>100</td>

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
                                                                                   v-on:click="getTableData(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="getTableData(data.prev_page_url)">{{data.current_page
                            - 1}}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{data.current_page}}</a></li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="getTableData(data.next_page_url)">{{data.current_page
                            + 1}}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="getTableData(data.next_page_url)">بعدی</a>
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

            }
        },
        methods: {
            alert1() {
                // alert('bhdsjakl;scvmnbfvdnsam,lcm vnbdnsmkqlsdmnvbfsdnwjqk');
                // ???
                alert(this.is_active_label)
            },
            check(event, id_customer) {
                const vm = this;
                var status = event.target.checked;
                if (status == true) {
                    status = 1;
                } else {
                    status = 0;
                }

                console.log('status : ' + status);
                console.log('event.id : ' + event.target.id);
                var label_id = event.target.id.substring(0, 3) + 'lb_' + id_customer;
                console.log('label_id : ' + label_id);
                console.log('id_customer : ' + id_customer);

                axios.post('http://127.0.0.1:8000/admin-panel/customer', {
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
            getTableData(href) {

                axios.get(href)
                    .then(response => {
                        console.log(response.data.data)
                        this.data = response.data.data

                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            }

        },
        created: function () {
            this.getTableData(`http://127.0.0.1:8000/admin-panel/customer/index?page=1`)

        },
        mounted: function () {
            console.log('TableComponent mounted.')


        },
    }
</script>

<style scoped>


</style>
