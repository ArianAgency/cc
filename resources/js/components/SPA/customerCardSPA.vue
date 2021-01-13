<template>

    <div>
        <customer-card-form >
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                </div>
            </template>
        </customer-card-form>

    </div>

</template>


<script>

    export default {
        props: ['user'],
        data() {
            return {
                csrf: "",

                pageTitle: 'چاپ کارت مشتری',

            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('customerCard SPA mounted.')
            console.log('user = ')
            console.log(this.user)
            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('customerCard SPA created.')

        },
    }


</script>


<style>


</style>
