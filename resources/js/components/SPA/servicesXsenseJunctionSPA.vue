<template>
    <div>
        <new-ser-xsens-creation-form :user="user" :indexForEdit="indexForEdit" v-if="dataIsReady">

            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>فرم ایجاد</span>
                    </div>
                </div>
            </template>
        </new-ser-xsens-creation-form>

        <jservices_xsense-table-component :data="SerXsenData" v-if="dataIsReady">
            <template slot="header">
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>لیست</span>
                    </div>
                </div>
            </template>
        </jservices_xsense-table-component>
    </div>

</template>


<script>

    export default {
        props: ['user'],
        data() {
            return {
                view: 'list',
                csrf: "",
                userID: this.user.id_users,
                data: '',
                dataIsReady: false,
                indexForEdit: -1,
                pageTitle: 'ثبت کاربر جدید',
                SerXsenData : {}
            }
        },
        methods: {
            viewController(event) {
                this.view = event;
            },
           async getSerXsenData(href) {
              await  axios.get(href)
                    .then(response => {
                        // console.log(response.data.data)
                        this.SerXsenData = response.data.data;
                        this.dataIsReady = true;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            }
        },
        mounted: function () {
            console.log('servicesXsenseJunction SPA mounted.');
            this.csrf = window.Laravel.csrfToken;
        },
        created: function () {
            console.log('servicesXsenseJunction SPA created.')
            this.getSerXsenData(`/admin-panel/serXsen/index?page=1`)
        },
        watch: {
            indexForEdit: function () {

            }
        }
    }


</script>


<style>
    .div-body {
        margin: 15px;
    }

    .fade1-enter-active, .fade1-leave-active {
        transition: opacity 150s
    }

    .fade1-enter, .fade1-leave-to /* .fade1-leave-active below version 2.1.8 */
    {
        opacity: 0
    }

    .card-header {
        display: flex;
    }

    .mytitle {
        width: 95%;
    }

    .mybtn .btn {
        border-radius: 10px;
        padding: 5px 30px 5px 30px;
        /*font-weight: 900;*/
    }

    .mybtn .btn i {
        font-size: 10px;
        /*font-weight: 100;*/
    }

    .btn-border {
        border-radius: 10px;
    }

    .w-30 {
        width: 37%;
    }

</style>
