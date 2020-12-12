<template>

    <div>

        <customer-category-form>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>

                </div>
            </template>
        </customer-category-form>

        <category-table-component>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>دسته بندی های مشتریان</span>
                    </div>
                </div>
            </template>
        </category-table-component>
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
                pageTitle: 'دسته بندی مشتریان',
                indexForEdit:''
            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('customerCategory SPA mounted.')

            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('customerCategory SPA created.')

        },
    }


</script>


<style>


</style>
