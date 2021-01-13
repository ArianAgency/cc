<template>

    <businesses-table-component v-if="view==='list' && dataIsReady">

        <template slot="header">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>لیست کسب و کارها</span>
                </div>
                <div class="mybtn" v-on:click="viewController('add'),pageTitle = 'ثبت کسب و کار جدید'">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        افزودن
                    </button>
                </div>
                <div class="mybtn mr-1" v-on:click="pageTitle = 'ثبت کسب و کار جدید'">
                    <button href="#" class="btn btn-outline-primary active"
                            :disabled="parentID === '0'"
                            @click="parentID = '0'">
                        برگشت
                        <i class="fas fa-arrow-left mr-1"></i>
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
                    <span>{{ pageTitle }}</span>
                </div>
                <div class="mybtn" v-on:click="viewController('list'),indexForEdit = -1">
                    <button href="#" class="btn btn-success">
                        <i class="fas fa-list"></i>
                        لیست
                    </button>
                </div>
            </div>
        </template>
    </new-business-creation-form>


</template>


<script>

export default {
    props: ['userId'],
    data() {
        return {
            view: 'list',
            csrf: "",
            userID: this.userId,
            data: '',
            dataIsReady: false,
            indexForEdit: -1,
            pageTitle: 'ثبت کسب و کار جدید',
            parentID: '0'
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
            // console.log('splitNChars + ' + txt)
            // console.log('txt.length = ' + txtLength)
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
        getBusinessData() {
            axios.get(`/admin-panel/business/index?page=1&parent=` + this.parentID)
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
        console.log('Business SPA mounted.');
        this.csrf = window.Laravel.csrfToken;
        console.log('csrf = ');
        console.log(this.csrf);
    },
    created: function () {
        console.log('Business SPA created.');
        this.getBusinessData();

    },
    watch: {
        parentID: function () {
            this.getBusinessData();
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

.w-40 {
    width: 39%;
}

</style>
