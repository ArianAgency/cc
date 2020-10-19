<template>
    <div>
        <div class="container-fluid">
            <div class="animated fadeIn">

                <div class="card div-body ">
                    <div class="card-header ">
                        <div>
                            <div class="form-group">
                                <i class="fa fa-align-justify"></i>
                                <span>فاکتور فروش</span>
                            </div>
                        </div>
                    </div>
                    <div class="  bg-dark text-white div-body  ">
                        <div class="d-flex mt-3  justify-content-center">
                            <div class="col-md ">
                                <label>خریدار :</label>
                                <strong>علی حاتمی کیا نسب</strong>
                            </div>
                            <div class="col-md">
                                <label>تعداد اقلام :</label>
                                <strong>234</strong>
                            </div>
                            <div class="col-md">
                                <label>جمع کل :</label>
                                <strong>342,000</strong>
                            </div>
                            <div class="col-md">
                                <label>کد اشتراک :</label>
                                <strong>3520</strong>
                            </div>
                            <div class="col-md">
                                <label>مبداء :</label>
                                <strong>Arian DG</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped ">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>جمع</th>
                                <th>حذف</th>

                            </tr>
                            </thead>

                            <tbody class="animated fadeIn">

                            <tr v-for="(service,index) in shoppingBasket">

                                <td>{{index +1}}</td>

                                <td>{{service.service_name}}</td>
                                <td>{{service.price}}</td>
                                <td>{{service.price * service.unit}}</td>
                                <td>{{service.unit}}</td>
                                <td v-on:click="">
                                    <a href="#">
                                        <i class="fa fa-plus"/>
                                    </a>
                                </td>

                            </tr>


                            </tbody>
                        </table>
                        <template>
                            <vue-content-loading :width="500" :height="5">
                                <rect rx="1.5" ry="1.5" width="500" height="5"/>
                            </vue-content-loading>
                        </template>
                        <!--                    @if( count($data) > 10)-->

                        <!--                    <li class="page-item text-center">صفحه {{data.last_page}} از {{data.current_page}}</li>-->
                    </div>
                </div>

                <div class="bg-secondary div-body" style="height: 5px">

                </div>

                <div class="card div-body">
                    <div class="card-header">
                        <div class="mytitle">
                            <i class="fa fa-align-justify"></i>
                            <span>لیست محصولات</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped mytable">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>انقضاء</th>
                                <th>افزودن</th>

                            </tr>
                            </thead>

                            <tbody class="animated fadeIn">

                            <tr v-for="(service,index) in shoppingBasket">

                                <td>{{index +1}}</td>

                                <td>{{service.service_name}}</td>
                                <td>{{service.price}}</td>
                                <td>{{service.price * service.unit}}</td>
                                <td>{{service.unit}}</td>
                                <td v-on:click="">
                                    <a href="#">
                                        <i class="fa fa-plus"/>
                                    </a>
                                </td>

                            </tr>


                            </tbody>
                        </table>
                        <template>
                            <vue-content-loading :width="500" :height="5">
                                <rect rx="1.5" ry="1.5" width="500" height="5"/>
                            </vue-content-loading>
                        </template>
                        <!--                    @if( count($data) > 10)-->

                        <!--                    <li class="page-item text-center">صفحه {{data.last_page}} از {{data.current_page}}</li>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {
        props: ['userId'],
        data() {
            return {
                csrf: "",
                shoppingBasket: '',
                services: ''
            }
        },
        methods: {
            getServiceData(href) {
                axios.get(href)
                    .then(response => {
                        this.services = response.data.services

                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            }
        },
        mounted: function () {
            console.log('Purchase SPA mounted.')
            this.csrf = window.Laravel.csrfToken;
        },
        created: function () {
            console.log('Purchase SPA created.')
            this.getUserData('http://127.0.0.1:8000/admin-panel/user/get/detail')
        },
    }


</script>


<style>


</style>
