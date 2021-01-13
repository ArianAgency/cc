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
                            <th>برند</th>
                            <th>نام شرکت</th>
                            <th>سال تاسیس</th>
                            <th>فعالیت</th>
                            <th>موبایل</th>
                            <th>آدرس</th>
                            <th>وضعیت</th>
                            <th>لوگو</th>
                            <th></th>
                            <th>ویرایش</th>
                            <th>شعب</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(business,index) in $parent.data.data">

                            <td>{{ index + 1 }}</td>

                            <td>{{ business.brand_name }}</td>
                            <td>{{ business.company_name }}</td>
                            <td>{{ business.foundation_date }}</td>
                            <td>{{ business.company_field }}</td>
                            <td>{{ business.mobile }}</td>
                            <td>{{ business.address }}</td>
                            <td v-bind:id="'sw_lb_'+ business.id_businesses">
                                <span v-if=" business.is_active == 1 " class="badge badge-success">فعال</span>
                                <span v-else class="badge badge-secondary">غیر فعال</span>
                            </td>
                            <td v-if="business.logo_address != null ">
                                <!--                                {{business.logo_address}}-->

                                <progressive-img
                                    :src="'../storage/logo_img/'+business.logo_address"
                                />
                            </td>
                            <td v-else>
                                ندارد
                            </td>
                            <td><label class="switch switch-text switch-pill switch-info-outline-alt">
                                <input type="checkbox" class="switch-input" v-bind:checked="business.is_active"
                                       v-bind:id="'sw_'+business.id_businesses"
                                       v-on:click="check($event,business.id_businesses)">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label></td>
                            <th v-on:click="$parent.indexForEdit = index ,$parent.view = 'add',$parent.pageTitle = 'ویرایش اطلاعات کسب و کار'">
                                <a href="#">
                                    <i class="fa fa-edit"/>
                                </a>
                            </th>
                            <th v-on:click="$parent.parentID = business.id_businesses
                             ,$parent.pageTitle = 'لیست شعب'">
                                <a href="#">
                                    <i class="far fa-building"></i>
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
                                                                                   v-on:click="parent.getBusinessData(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.prev_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getBusinessData(data.prev_page_url)">{{
                                data.current_page
                                - 1
                            }}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{ data.current_page }}</a></li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="parent.getBusinessData(data.next_page_url)">{{
                                data.current_page
                                + 1
                            }}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="parent.getBusinessData(data.next_page_url)">بعدی</a>
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
import Vue from 'vue'
import VueProgressiveImage from 'vue-progressive-image'

Vue.use(VueProgressiveImage)

export default {
    components: {
        VueContentLoading,
    },
    data() {
        return {
            is_active_label: '',
            data: '',
            posts: []
        }
    },
    methods: {
        check(event, id_business) {
            const vm = this;
            var status = event.target.checked;
            if (status == true) {
                status = 1;
            } else {
                status = 0;
            }

            console.log('status : ' + status);
            console.log('event.id : ' + event.target.id);
            var label_id = event.target.id.substring(0, 3) + 'lb_' + id_business;
            console.log('label_id : ' + label_id);
            console.log('id_user : ' + id_business);

            axios.post('/admin-panel/business', {
                action: 'is_active',
                business_id: id_business,
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
        console.log('BusinessTableComponent created.')
        this.data = this.$parent.data
    },
    mounted: function () {
        console.log('BusinessTableComponent mounted.')
    },
}
</script>

<style>

</style>
