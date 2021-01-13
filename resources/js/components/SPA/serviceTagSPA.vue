<template>

    <div>

        <service-tag-form>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                </div>
            </template>
        </service-tag-form>

        <service-tag-table-component>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>نشانه های محصولات و خدمات</span>
                    </div>
                </div>
            </template>
        </service-tag-table-component>
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
                pageTitle: 'نشانه گذاری های محصولات و خدمات'
            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('serviceTag SPA mounted.')
            console.log('user = ')
            console.log(this.user)
            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('serviceTag SPA created.')

        },
    }


</script>


<style>


</style>
