<template>

    <div>

        <service-category-form>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>

                </div>
            </template>
        </service-category-form>

        <service-category-table-component>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>دسته بندی های مشتریان</span>
                    </div>
                </div>
            </template>
        </service-category-table-component>
    </div>
</template>


<script>

    export default {
        props: ['user'],
        data() {
            return {
                view: 'add',
                csrf: "",
                user: this.user,
                pageTitle: 'دسته بندی خدمات و محصولات',
                indexForEdit:''
            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('serviceCategory SPA mounted.')

            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('serviceCategory SPA created.')

        },
    }


</script>


<style>


</style>
