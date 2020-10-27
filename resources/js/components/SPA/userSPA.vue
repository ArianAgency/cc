<template>

    <user-table-component v-if="view==='list' && dataIsReady">

        <template slot="header">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>لیست کاربران</span>
                </div>
                <div class="mybtn" v-on:click="viewController('add'),pageTitle = 'ثبت کاربر جدید'">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        افزودن
                    </button>
                </div>
            </div>
        </template>
    </user-table-component>

    <new-user-creation-form v-else-if="view==='add'">
        <template slot="header">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>{{pageTitle}}</span>
                </div>
                <div class="mybtn" v-on:click="viewController('list'),indexForEdit = -1">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-list"></i>
                        لیست
                    </button>
                </div>
            </div>
        </template>
    </new-user-creation-form>


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
                pageTitle: 'ثبت کاربر جدید'
            }
        },
        methods: {
            viewController(event) {
                this.view = event;
                // alert('event.id : ' + event)
            },
            splitedCardNumber: function (txt, num) {
                var txt = String(txt)
                var txtLength = String(txt).length;

                var result = '';
                for (var i = 0; i < txtLength; i += num) {
                    if (i != 0) {
                        result = result + '-';
                    }
                    result = result + (txt.substr(i, num));
                }
                console.log('splitedCardNumber result = ' + result)
                return result;
            },
            getUserData(href) {

                axios.get(href)
                    .then(response => {
                        console.log(response.data.data)
                        this.data = response.data.data
                        this.dataIsReady = true;
                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            }
        },
        mounted: function () {
            console.log('User SPA mounted.')
            this.csrf = window.Laravel.csrfToken;
            console.log(' props: [user] = ')
            console.log(this.user)
        },
        created: function () {
            console.log('User SPA created.')
            this.getUserData(`/admin-panel/user/index?page=1`)
        },
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
