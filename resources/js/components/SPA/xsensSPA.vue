<template>

    <div>
        <new-xsens-creation-form :indexForEdit="indexForEdit" v-if="dataIsReady">
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
                        this.data = response.data
                        this.dataIsReady = true;
                        // console.log('this.data = ')
                        // console.log( this.data)
                        // console.log('this.data.chords = ')
                        // console.log( this.data.chords)
                        // console.log('response = ')
                        // console.log( response)
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
            console.log('Xsens SPA mounted.')
            this.csrf = window.Laravel.csrfToken;
        },
        created: function () {
            console.log('Xsens SPA created.')
            this.getUserData('http://127.0.0.1:8000/admin-panel/user/get/detail')
            this.getXsensData(`http://127.0.0.1:8000/admin-panel/xsens/index?page=1`)
        },
    }


</script>


<style>


</style>
