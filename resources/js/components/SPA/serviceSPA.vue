<template>

    <div>
        <new-service-creation-form :indexForEdit="indexForEdit" v-if="dataIsReady">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                    <!--                <div class="mybtn" v-on:click="viewController('list'),indexForEdit = -1">-->
                    <!--                    <button href="#" class="btn btn-success">-->
                    <!--                        <i class="fas fa-list"></i>-->
                    <!--                        لیست-->
                    <!--                    </button>-->
                    <!--                </div>-->
                </div>
            </template>
        </new-service-creation-form>
        <service-table-component v-if="dataIsReady">
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
        props: ['userId'],
        data() {
            return {
                view: 'add',
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
                this.view = event;
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
                        this.user = response.data.user
                        console.log('user = ' + this.user)
                        console.log('user.name = ' + this.user.name)
                        console.log('user.business.brand_name = ' + this.user.business)
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            }
        },
        mounted: function () {
            console.log('Product SPA mounted.')
            this.csrf = window.Laravel.csrfToken;

        },
        created: function () {
            console.log('Product SPA created.')
            this.getUserData('http://127.0.0.1:8000/admin-panel/user/get/detail')
            this.getServiceData(`http://127.0.0.1:8000/admin-panel/service/index?page=1`)
        },
    }


</script>


<style>


</style>
