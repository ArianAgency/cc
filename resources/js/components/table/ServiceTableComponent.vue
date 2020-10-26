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
                            <th>کد همگام سازی</th>
                            <th>قیمت</th>
                            <th>ایجاد شده در</th>
                            <th>تاریخ انقضا</th>
                            <th>وضعیت</th>
                            <th></th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(service,index) in $parent.data.data.data">

                            <td>{{index +1}}</td>

                            <td>{{service.name}}</td>
                            <td>{{service.sync_code}}</td>
                            <td>{{service.price}}</td>
                            <td>{{service.created_at}}</td>
                            <td>{{service.expire_at}}</td>

                            <td v-bind:id="'sw_lb_'+ service.id_services">
                                <span v-if=" service.is_active == 1 " class="badge badge-success">فعال</span>
                                <span v-else class="badge badge-secondary">غیر فعال</span>
                            </td>
                            <td><label class="switch switch-text switch-pill switch-info-outline-alt">
                                <input type="checkbox" class="switch-input" v-bind:checked="service.is_active"
                                       v-bind:id="'sw_' + service.id_services"
                                       v-on:click="check($event,service.id_services)">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label></td>
                            <th v-on:click="$parent.indexForEdit = index ,$parent.view = 'add',$parent.pageTitle = 'ویرایش اطلاعات سرویس'">
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

                        <li class="page-item" v-if="data.data.current_page>1 && data.data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="parent.getServiceData(data.data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.data.current_page>1 && data.data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="parent.getServiceData(data.data.prev_page_url)">{{data.data.current_page
                            - 1}}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{data.data.current_page}}</a></li>

                        <li class="page-item" v-show="data.data.next_page_url !==null"><a class="page-link" href="#"
                                                                                          v-on:click="parent.getServiceData(data.data.next_page_url)">{{data.data.current_page
                            + 1}}</a>
                        </li>


                        <li class="page-item" v-if="data.data.next_page_url !==null"><a class="page-link" href="#"
                                                                                        v-on:click="parent.getServiceData(data.data.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>
                    <li class="page-item text-center">صفحه {{data.data.last_page}} از {{data.data.current_page}}</li>

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
            check(event, id_service) {
                const vm = this;
                var status = event.target.checked;
                if (status == true) {
                    status = 1;
                } else {
                    status = 0;
                }

                // console.log('status : ' + status);
                // console.log('event.id : ' + event.target.id);
                var label_id = event.target.id.substring(0, 3) + 'lb_' + id_service;
                // console.log('label_id : ' + label_id);
                // console.log('id_customer : ' + id_customer);

                axios.post('/admin-panel/service', {
                    action: 'is_active',
                    id_service: id_service,
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
        },
        created: function () {
            console.log('ServiceTableComponent created.')
            this.data = this.$parent.data
            console.log(this.data)
            console.log(this.$parent.data)
        },
        mounted: function () {
            console.log('ServiceTableComponent mounted.')

        },

    }
</script>

<style scoped>


</style>
