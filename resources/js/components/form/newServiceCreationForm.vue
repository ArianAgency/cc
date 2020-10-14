<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <form action="" method="post" ref="form" name="customer_new_form" autocomplete="on">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="name" name="name" class="form-control"
                                                   v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.name:NewformItems.name"
                                                   placeholder="نام">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                            <input type="text" id="sync_code" name="sync_code" class="form-control"
                                                   v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.sync_code:NewformItems.sync_code"
                                                   placeholder="کد همگام سازی">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="price" name="price" class="form-control"
                                                   v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.price:NewformItems.price"
                                                   placeholder="قیمت">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                class="fas fa-audio-description"></i></span>
                                        </div>
                                        <textarea class="form-control flex-fill" id="description" placeholder="توضیحات"
                                                  v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.description:NewformItems.description"
                                                  name="description" rows="2"
                                        />
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="business" name="business" class="form-control"
                                                   v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.business.brand_name : $parent.user.business.brand_name"
                                                   readonly
                                                   placeholder="کسب و کار مربوط">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i
                                                class="fab fa-internet-explorer"></i></span>
                                            <input type="text" id="creator_user" name="creator_user"
                                                   class="form-control "
                                                   v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.user.name : $parent.user.name"
                                                   placeholder="کاربر ایجاد کننده" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                    class="fab fa-creative-commons-zero"></i></span>
                                        </div>

                                        <input type="text" id="created_at" name="created_at" class="form-control"

                                               v-model="indexForEdit >= 0 ? formItems.created_at  : NewformItems.created_at"
                                               readonly
                                               placeholder="تاریخ ایجاد">

                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-trash"></i></span>
                                            <input type="text" id="expire_at" name="expire_at" class="form-control"
                                                   v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
                                                   placeholder="تاریخ انقضا">
                                            <date-picker
                                                v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
                                                element="expire_at"
                                                format="YYYY-MM-DD"></date-picker>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="form-group form-actions col-2">

                            <button type="" class="btn btn-border btn-primary  w-100"
                                    v-on:click="service_new_form_new($event)">
                                <i class="far fa-file-alt ml-2"></i>جدید
                            </button>
                        </div>
                        <div class="form-group form-actions col-2 ml-2">
                            <button type="submit" class="btn btn-border btn-success  w-100"
                                    v-on:click="service_new_form_submit($event)">
                                <i class="fa fa-check-circle ml-2"></i>ثبت
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import VueContentLoading from "vue-content-loading";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker'


    export default {
        components: {
            VueContentLoading,
            datePicker: VuePersianDatetimePicker
        },
        props: ['indexForEdit'],
        data() {
            return {
                is_active_label: '',
                data: '',
                expireDate: '',
                posts: [],
                csrf: "",
                formItems: [],
                NewformItems: [],
                is_it_new_registration: 'true',
                Now: '',
                getAllDataForServiceEditReady: false,
            }
        },
        methods: {
            service_new_form_submit: function (event) {
                event.preventDefault()
                const formData = new FormData(this.$refs['form']); // reference to form element
                this.NewformItems.price = this.NewformItems.price + '.00'
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                Object.assign(data, {'is_it_new_registration': this.is_it_new_registration})

                if (this.is_it_new_registration === 'true') {
                    Object.assign(data, {'id_services': 0})
                } else {
                    Object.assign(data, {'id_services': this.formItems.id_services})
                }

                Object.assign(data, {'id_business': this.$parent.user.businesse_id})
                // console.log('this.data = ')
                // console.log(this.data)
                // console.log('this.$parent.user = ')
                // console.log(this.$parent.user.businesse_id)

                axios.post('http://127.0.0.1:8000/admin-panel/service/new', data)
                    .then(response => {
                        console.log(response)
                        alert('با موفقیت ثبت شد')
                        this.setToNewForm();
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        // console.log(e)
                        // console.log('e.response.data.code = ' + e.response.data.code)
                        if (e.response.data.code == 2) {
                            alert('Duplication error')
                        } else {
                            alert('error')
                        }

                    })
            },
            service_new_form_new: function (event) {
                event.preventDefault()
                this.getAllDataForServiceEditReady = true
                this.formItems = []
                this.$parent.indexForEdit = -1
            },
            getAllDataForServiceEdit(businessID, userID) {
                console.log('getAllDataForServiceEdit')
                this.getAllDataForServiceEditReady = false
                axios.get('http://127.0.0.1:8000/admin-panel/service/get/getAllDataForServiceEdit?businessID=' + businessID + '&userID=' + userID)
                    .then(response => {
                        console.log('response = ' + response)
                        this.formItems.business = response.data.business
                        this.formItems.user = response.data.user
                        console.log('formItems[business] = ' + response.data.business.brand_name)
                        console.log('formItems[business] = ' + this.formItems.business.brand_name)
                        console.log('formItems[user] = ' + this.formItems.user.name)
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
            populateFormInputIfIsForEdit() {
                this.data = this.$parent.data.data.data
                console.log('populateFormInputIfIsForEdit')
                console.log('this.data  = ')
                console.log(this.data)
                if (this.$parent.indexForEdit >= 0) {
                    // console.log('populateFormInputIfIsForEdit = ')
                    // console.log(this.data[0])
                    this.formItems = this.data[this.$parent.indexForEdit]
                    console.log('this.formItems  = ')
                    console.log(this.formItems)
                    this.getAllDataForServiceEdit(this.formItems.id_business, this.formItems.creator_user_id);

                }
            },
            setToNewForm() {
                this.$parent.indexForEdit = -1
                this.formItems = '';
                this.is_it_new_registration = "true"
                this.$parent.getServiceData(`http://127.0.0.1:8000/admin-panel/service/index?page=1`)
            },
            getNow: function () {
                const today = new Date();
                const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date + ' ' + time;
                console.log(dateTime)
                this.Now = dateTime;
            }
        },
        created: function () {
            this.data = this.$parent.data
        },
        mounted: function () {
            console.log('newCustomerCreationForm mounted ')
            this.csrf = window.Laravel.csrfToken
            this.populateFormInputIfIsForEdit()
            if (this.$parent.indexForEdit >= 0) {
                this.is_it_new_registration = 'false';
            }
            this.getNow();
        },
        watch: {
            indexForEdit: function () {
                this.populateFormInputIfIsForEdit()
                if (this.$parent.indexForEdit >= 0) {
                    this.is_it_new_registration = 'false';
                } else {
                    this.is_it_new_registration = 'true';
                    this.formItems = []

                }
            },

        }
    }

</script>

<style>

</style>
