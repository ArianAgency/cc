<template>

    <div>
        <new-service-creation-form :indexForEdit="indexForEdit" v-if="dataIsReady && activeView==='add'">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                                    <div class="mybtn" v-on:click="viewController('list'),indexForEdit = -1">
                                        <button href="#" class="btn btn-success">
                                            <i class="fas fa-list"></i>
                                            لیست
                                        </button>
                                    </div>
                </div>
            </template>
        </new-service-creation-form>
        <service-table-component :data="data" v-if="dataIsReady && activeView ==='list'">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>لیست محصولات</span>
                    </div>
                    <!--                <div class="mybtn" v-on:click="viewController('add'),pageTitle = 'ثبت محصول جدید'">-->
                    <!--                    <button href="#" class="btn btn-success">-->
                    <!--                        <i class="fas fa-plus"></i>-->
                    <!--                        افزودن-->
                    <!--                    </button>-->
                    <!--                </div>-->
                </div>
            </template>
        </service-table-component>
    </div>
</template>


<script>

    export default {
        props: ['userId','activeView'],
        data() {
            return {
                activeView: this.activeView,
                csrf: "",
                userID: this.userId,
                data: '',
                user: {},
                dataIsReady: false,
                indexForEdit: -1,
                pageTitle: 'ثبت محصول جدید'
            }
        },
        methods: {
            viewController(event) {
                this.activeView = event;
                // alert('event.id : ' + event)
            },
            getServiceData(href) {
                axios.get(href)
                    .then(response => {
                        this.data = response.data
                        this.dataIsReady = true;
                        console.log('getServiceData = ')
                        console.log( this.data)
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
            getUserData(href) {
                axios.get(href)
                    .then(response => {
                        this.user = response.data.user;
                        console.log('user = ' + this.user);
                        console.log('user.name = ' + this.user.name);
                        console.log('user.business.brand_name = ' + this.user.business);
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e);
                    })
            },
            initData(){
                this.getUserData('/admin-panel/user/get/detail');
                this.getServiceData('/admin-panel/service/index');
            }
        },
        mounted: function () {
            console.log('Product SPA mounted.');
            this.csrf = window.Laravel.csrfToken;

        },
        created: function () {
            console.log('Product SPA created.');
           this.initData();
        },
    }


</script>


<style>


</style>
