<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <div class="  bg-dark text-white div-body p-2 ">
                    <div class="d-flex   justify-content-center">
                        <div class="col-md ">
                            <label>مشتری:</label>
                            <strong>{{customerDetail.name ? customerDetail.name
                                +' '+customerDetail.family:'-'}}</strong>
                        </div>
                        <div class="col-md">
                            <label>کد اشتراک:</label>
                            <strong>{{customerDetail.id_customers}}</strong>
                        </div>
                        <div class="col-md">
                            <label>کسب و کار مرجع:</label>
                            <strong>{{ customerDetail.business}}</strong>
                        </div>
                        <div class="col-md">
                            <label>امتیاز:</label>
                            <strong>{{customerDetail.score>0 ? customerDetail.score:'0'
                                }}</strong>
                        </div>
                        <div class="col-md">
                            <label>کیف پول:</label>
                            <strong>{{customerDetail.wallet>0 ? $parent.numberWithCommas(customerDetail.wallet):'0.00'
                                }}</strong>
                        </div>
                    </div>
                </div>
                <ValidationObserver v-slot="{handleSubmit }" ref="observer">
                    <form ref="form">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">

                                            <!--mobile-->
                                            <ValidationProvider rules="digits:11|required" v-slot="{ errors }">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <input type="text" id="mobile" name="mobile"
                                                               class="form-control"
                                                               v-model="formItems.mobile"
                                                               placeholder="شماره موبایل">
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-success" type="button"
                                                                v-on:click.prevent="getCustomerData(errors[0])">برو!
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </div>
                                            </ValidationProvider>

                                            <span class="input-group-addon"></span>

                                            <!--price-->
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <div class="input-group ">

                                                    <span class="input-group-text">
                                                        <i class="fas fa-wallet"></i>
                                                    </span>
                                                    <input type="number" id="wallet_charge" name="wallet_charge"
                                                           class="form-control"
                                                           v-model="formItems.walletCharge"
                                                           placeholder="مبلغ">
                                                </div>

                                                <div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </div>
                                            </ValidationProvider>

                                            <span class="input-group-addon"></span>

                                            <!--score-->
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <div class="input-group ">

                                                     <span class="input-group-text">
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </span>
                                                    <input type="number" id="score_charge" name="score_charge"
                                                           class="form-control"
                                                           v-model="formItems.scoreCharge"
                                                           placeholder="امتیاز">
                                                </div>

                                                <div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>


                                    <!--description-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                class="fas fa-audio-description"></i></span>
                                            </div>
                                            <textarea class="form-control flex-fill" id="description"
                                                      placeholder="توضیحات"
                                                      v-model="formItems.description"
                                                      name="description" rows="2"
                                            />
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="form-group form-actions col-2">

                                <button type="" class="btn btn-border btn-primary  w-100"
                                        v-on:click.prevent="resetForm($event)">
                                    <i class="far fa-file-alt ml-2"></i>جدید
                                </button>
                            </div>
                            <div class="form-group form-actions col-2 ml-2">
                                <button type="submit" value="submit" class="btn btn-border btn-success  w-75"
                                        @click.prevent="submitForm_customerInstantChargeForm">
                                    <i class="fa fa-check-circle ml-1"></i>ثبت
                                </button>
                            </div>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
        data() {
            return {
                data: '',
                csrf: "",
                formItems: {
                    walletCharge: 0,
                    scoreCharge: 0
                }
                ,
                mobile: '',
                customerDetail: []
            }
        },
        methods: {
            async submitForm_customerInstantChargeForm(event) {

                const isValid = await this.$refs.observer.validate();

                if (!isValid) {
                    // ABORT!!
                    swal("نا تمام!", "لطفا همه گزینه های اجباری را پر کنید", "error");
                    return
                }
                if (this.formItems.walletCharge === 0 && this.formItems.scoreCharge === 0) {
                    // ABORT!!
                    swal("نا تمام!", "هیچ گزینه ای شارژ نشد", "error");
                    return
                }
                if (this.customerDetail.length <= 0) {
                    // ABORT!!
                    swal("نا تمام!", "کاربری برای شارژ وجود ندارد", "error");
                    return
                }
                const formData = new FormData(this.$refs['form']); // reference to form element
                this.formItems.walletCharge = this.formItems.walletCharge + '.00'
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }

                Object.assign(data, {'id_target_customer': this.customerDetail.id_customers})
                axios.post('/admin-panel/customer/action/promotionalCharge', data)
                    .then(response => {
                        console.log(response)
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        this.resetForm();
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        // console.log(e)
                        // console.log('e.response.data.code = ' + e.response.data.code)
                        if (e.response.data.code == 2) {
                            swal("نا تمام!", "با خطا مواجه شد", "error");
                        } else {
                            alert('error')
                        }

                    })
            },
            resetForm() {
                this.formItems = [];
                this.formItems.walletCharge = 0;
                this.formItems.scoreCharge = 0;
                this.customerDetail = [];
                this.$refs.observer.reset();
            },
            getCustomerData(errors) {
                if (errors) {
                    // ABORT!!
                    swal("نا تمام!", "شماره موبایل اشتباه است", "error");
                    return
                }

                console.log('getCustomerData')
                console.log('mobile = ')
                console.log(this.formItems.mobile)
                axios.get('/admin-panel/customer/get/customerDetailByMobile?mobile=' + this.formItems.mobile)
                    .then(response => {
                        console.log('response = ')
                        console.log(response)
                        this.customerDetail = response.data.customerDetail
                        console.log('customerDetail = ')
                        console.log(this.customerDetail)
                        this.customerDetail.business = response.data.business

                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
        },
        created: function () {
            console.log('customerInstantChargeForm created ')
            this.data = this.$parent.data
        },
        mounted: function () {
            console.log('customerInstantChargeForm mounted ')
            this.csrf = window.Laravel.csrfToken
        },
        watch: {}
    }

</script>

<style>

</style>
