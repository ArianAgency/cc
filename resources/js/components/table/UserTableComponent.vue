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
                            <th>مهارت</th>
                            <th>کسب و کار</th>
                            <th>امتیاز</th>
                            <th>کیف پول</th>
                            <th>شماره کارت</th>
                            <th>وضعیت</th>
                            <th></th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(user,index) in $parent.data.data">

                            <td>{{index +1}}</td>

                            <td>{{user.name}}</td>
                            <td>{{user.family}}</td>
                            <td>{{user.gender}}</td>
                            <td>{{user.skill}}</td>
                            <td>{{user.business.brand_name}}</td>
                            <td>{{user.score}}</td>
                            <td>{{user.wallet}}</td>
                            <td>
                                {{$parent.splitedCardNumber(user.card_number,4)}}
                            </td>
                            <td v-bind:id="'sw_lb_'+ user.id_users">
                                <span v-if=" user.is_active == 1 " class="badge badge-success">فعال</span>
                                <span v-else class="badge badge-secondary">غیر فعال</span>
                            </td>
                            <td><label class="switch switch-text switch-pill switch-info-outline-alt">
                                <input type="checkbox" class="switch-input" v-bind:checked="user.is_active"
                                       v-bind:id="'sw_'+user.id_users"
                                       v-on:click="check($event,user.id_users)">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label></td>
                            <th v-on:click="$parent.indexForEdit = index ,$parent.view = 'add',$parent.pageTitle = 'ویرایش اطلاعات کاربر'">
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
                                                                                   v-on:click="parent.getUserData(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getUserData(data.prev_page_url)">{{data.current_page
                            - 1}}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{data.current_page}}</a></li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getUserData(data.next_page_url)">{{data.current_page
                            + 1}}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getUserData(data.next_page_url)">بعدی</a>
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
            check(event, id_user) {
                const vm = this;
                var status = event.target.checked;
                if (status == true) {
                    status = 1;
                } else {
                    status = 0;
                }

                console.log('status : ' + status);
                console.log('event.id : ' + event.target.id);
                var label_id = event.target.id.substring(0, 3) + 'lb_' + id_user;
                console.log('label_id : ' + label_id);
                console.log('id_user : ' + id_user);

                axios.post('/admin-panel/user', {
                    action: 'is_active',
                    id_user: id_user,
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
            this.data = this.$parent.data
        },
        mounted: function () {
            console.log('UserTableComponent mounted.')
        },
    }
</script>

<style>

</style>
