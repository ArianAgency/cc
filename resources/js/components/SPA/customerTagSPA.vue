<template>

    <div>

        <customer-tag-form>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                </div>
            </template>
        </customer-tag-form>

        <tag-table-component>
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>نشانه های مشتریان</span>
                    </div>
                </div>
            </template>
        </tag-table-component>
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
                pageTitle: 'نشانه گذاری های مشتریان'
            }
        },
        methods: {
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            console.log('customerTag SPA mounted.')
            console.log('user = ')
            console.log(this.user)
            this.csrf = window.Laravel.csrfToken;
            console.log('csrf = ')
            console.log(this.csrf)

        },
        created: function () {
            console.log('customerTag SPA created.')

        },
    }


</script>


<style>


</style>
