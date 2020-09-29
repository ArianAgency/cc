<template>

    <businesses-table-component v-if="view==='list'">

        <template slot="header">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>لیست کسب و کارها</span>
                </div>
                <div class="mybtn"  v-on:click="viewController('add')">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        افزودن
                    </button>
                </div>
            </div>
        </template>
    </businesses-table-component>
    <new-business-creation-form v-else-if="view==='add'">

        <template slot="header">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>ثبت کسب و کار جدید</span>
                </div>
                <div class="mybtn"  v-on:click="viewController('list')">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-list"></i>
                        لیست
                    </button>
                </div>
            </div>
        </template>
    </new-business-creation-form>


    <!--<new-business-creation-form></new-business-creation-form>-->


</template>


<script>

    export default {

        data() {
            return {
                view: 'list',
                csrf: "",
            }
        },
        methods: {
            viewController(event) {
                this.view = event;
                // alert('event.id : ' + event)
            }
        },
        mounted: function () {
            this.csrf = window.Laravel.csrfToken;
            console.log('TableComponent mounted.')

        },

    }


</script>

<style >
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

    .w-40 {
        width: 39%;
    }

</style>
