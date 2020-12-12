<template>

    <div>
        <customer-instant-charge-form>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>

                </div>
            </template>
        </customer-instant-charge-form>

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
                pageTitle: 'شارژ سریع مشتریان'
            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('userInstantCharge SPA mounted.')
            console.log('user = ')
            console.log(this.user)
            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('userInstantCharge SPA created.')

        },
    }


</script>


<style>


</style>
