<template>

    <div>
        <new-xsens-creation-form :indexForEdit="indexForEdit" :user="user" :data="data.data.data" v-if="dataIsReady">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>{{pageTitle}}</span>
                    </div>
                </div>
            </template>
        </new-xsens-creation-form>

        <xsens-table-component v-if="dataIsReady">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>لیست X-sens</span>
                    </div>
                </div>
            </template>
        </xsens-table-component>
    </div>
</template>


<script>
    import axios from 'axios'

    export default {
        props: ['user'],
        data() {
            return {
                view: 'add',
                csrf: "",
                data: '',
                dataIsReady: false,
                indexForEdit: -1,
                pageTitle: 'ثبت X-sens جدید'
            }
        },
        methods: {
            viewController(event) {
                this.view = event;
                // alert('event.id : ' + event)
            },
            getXsensData(href) {
                axios.get(href)
                    .then(response => {
                        this.data = response.data;
                        this.dataIsReady = true;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },
        },
        mounted: function () {
            console.log('Xsens SPA mounted.')
            this.csrf = window.Laravel.csrfToken;
        },
        created: function () {
            console.log('Xsens SPA created.')
            this.getXsensData(`/admin-panel/xsens/index?page=1`)
        },
    }


</script>


<style>


</style>
