<template>

    <div>
        <div class="m-1">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#print" role="tab" aria-controls="home">چاپ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#list" role="tab" aria-controls="profile">لیست</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="print" role="tabpanel">
                    <customer-group-card-form>
                        <template slot="header">
                            <div class="card-header">
                                <div class="mytitle">
                                    <i class="fa fa-align-justify"></i>
                                    <span>{{ pageTitle }}</span>
                                </div>
                            </div>
                        </template>
                    </customer-group-card-form>
                </div>
                <div class="tab-pane" id="list" role="tabpanel">
                    <customer-group-card-table-component></customer-group-card-table-component>
                </div>
            </div>
        </div>

    </div>

</template>


<script>

export default {
    props: ['user'],
    data() {
        return {
            csrf: "",
            user: this.user,
            pageTitle: 'چاپ کارت گروهی',

        }
    },
    methods: {
        numberWithCommas(string) {
            return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
    mounted: function () {
        console.log('customerGroupCard SPA mounted.')
        console.log('user = ')
        console.log(this.user)
        this.csrf = window.Laravel.csrfToken;
        console.log('csrf = ')
        console.log(this.csrf)

    },
    created: function () {
        console.log('customerGroupCard SPA created.')

    },
}


</script>


<style>


</style>
