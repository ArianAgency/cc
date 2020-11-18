<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <ValidationObserver ref="observer" v-slot="{invalid, handleSubmit ,validate }">
                    <!--                    <form ref="form" @submit.prevent="handleSubmit(customer_new_form_submit($event))">-->
                    <!--                    <form ref="form" @submit.prevent="customer_new_form_submit($event)">-->
                    <form ref="form" @submit.prevent="customer_new_form_submit($event)">

                        <div class="row">
                            <div class="col-6">
                                <div class="card-body">

                                    <!--name & family-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" id="name" name="name"
                                                               :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                               style=": #0a3d2e" v-model:value="formItems.name"
                                                               placeholder="نام">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="text" id="family" name="family"
                                                               :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                               v-model:value="formItems.family"
                                                               placeholder=" نام خوانوادگی">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--father_name & gender-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" id="father_name" name="father_name"
                                                               v-model:value="formItems.father_name"
                                                               :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                               placeholder=" نام پدر"></div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}</p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="" v-slot="{ errors }">
                                                    <div class="myinput">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-venus-mars"></i>
                                                                </span>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input" type="radio" id="m"
                                                                   :checked="formItems.gender==='مرد'"
                                                                   value="مرد" name="gender">

                                                            <label class="form-check-label" for="m">مرد</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input" type="radio" id="f"
                                                                   :checked="formItems.gender==='زن'"
                                                                   checked="checked"
                                                                   value="زن" name="gender">
                                                            <label class="form-check-label" for="f">زن</label>
                                                        </div>
                                                    </div>

                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}</p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--mobile & phone-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required|numeric|length:11"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-mobile"></i>
                                                            </span>
                                                        <!--                                                            <div class="input-group">-->
                                                        <input type="text" id="mobile" name="mobile"
                                                               :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                               maxlength="11"
                                                               v-model:value="formItems.mobile"
                                                               placeholder="0912xxxxxxx شماره موبایل">
                                                        <span
                                                            class="input-group-text bg-warning text-dark warning-sign">
                                                                    <i class="fa fa-exclamation-triangle "></i>
                                                                </span>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="required|numeric|length:11"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                                  <span class="input-group-text">
                                                                      <i class="fa fa-phone"></i>
                                                                  </span>
                                                        <input type="text" id="phone" name="phone" maxlength="11"
                                                               class="form-control"
                                                               v-model:value="formItems.phone"
                                                               placeholder="تلفن">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-if="errors">{{ errors[0] }}</p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--email-->
                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required|email"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                        <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                    class="fa fa-envelope"></i></span>
                                                        </div>
                                                        <input type="email" id="email" name="email"
                                                               class="form-control "
                                                               v-model:value="formItems.email"
                                                               placeholder="ایمیل">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--instagram & birthday-->
                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <div class="mydiv">
                                                <ValidationProvider rules=""
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                    <span class="input-group-text"><i
                                                        class="fab fa-instagram"></i></span>
                                                        <input type="text" id="social" name="social"
                                                               class="form-control"
                                                               v-model:value="formItems.social"
                                                               placeholder="اینستاگرام">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                           <span class="input-group-text"><i
                                                               class="fa fa-birthday-cake"></i></span>

                                                        <input type="text" id="birthday" name="birthday"
                                                               class="form-control"
                                                               v-model="formItems.birthday"
                                                               placeholder="تاریخ تولد">
                                                        <date-picker v-model="formItems.birthday" element="birthday"
                                                                     format="YYYY-MM-DD"></date-picker>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--national_code & marriage_status/marriage-date-->
                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                        <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                    class="far fa-id-card"></i></span>
                                                        </div>
                                                        <input type="text" id="national_code" name="national_code"
                                                               maxlength="10"
                                                               v-model:value="formItems.national_code"
                                                               class="form-control"
                                                               placeholder="کد ملی">

                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider :rules="married===1?'required':''"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-heart"></i></span>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input" type="radio" id="single"
                                                                   value="مجرد" name="marriage_status"
                                                                   :checked="formItems.marriage_status==='مجرد'"
                                                                   v-on:click="married=0">
                                                            <label class="form-check-label"
                                                                   for="single">مجرد</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input " type="radio" id="rel"
                                                                   value="متاهل" name="marriage_status"
                                                                   :checked="formItems.marriage_status==='متاهل'"
                                                                   v-on:click="married=1">
                                                            <label class="form-check-label" for="rel">متاهل</label>
                                                        </div>
                                                        <span class="input-group-addon"></span>
                                                        <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                    class="far fa-heart"></i></span>
                                                            <input type="text" id="marriage-date"
                                                                   name="marriage-date"
                                                                   class="form-control"
                                                                   v-model="formItems.wedding_anniversary"
                                                                   placeholder="تاریخ ازدواج"
                                                                   :readonly="married != 1">
                                                            <date-picker element="marriage-date"
                                                                         v-model=" formItems.wedding_anniversary"
                                                                         :disabled="married != 1"></date-picker>
                                                        </div>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--education & field-->
                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                        <select id="education" name="education"
                                                                class="form-control h-100 " style="width: 300px "
                                                                v-model="formItems.education">

                                                            <option value="زیر دیپلم"
                                                                    :selected="formItems.education === 'زیر دیپلم'">
                                                                زیر
                                                                دیپلم
                                                            </option>
                                                            <option value="دیپلم"
                                                                    :selected="formItems.education === 'دیپلم'">
                                                                دیپلم
                                                            </option>
                                                            <option value="فوق دیپلم"
                                                                    :selected="formItems.education === 'فوق دیپلم'">
                                                                فوق
                                                                دیپلم
                                                            </option>
                                                            <option value="کارشناسی"
                                                                    :selected="formItems.education === 'کارشناسی'">
                                                                کارشناسی
                                                            </option>
                                                            <option value="کارشناسی ارشد"
                                                                    :selected="formItems.education === 'کارشناسی ارشد'">
                                                                کارشناسی
                                                                ارشد
                                                            </option>
                                                            <option value="دکتری"
                                                                    :selected="formItems.education === 'دکتری'">
                                                                دکتری
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>

                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">

                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-briefcase"></i></span>

                                                        </div>
                                                        <input type="text" id="field" name="field"
                                                               class="form-control"
                                                               v-model="formItems.field"
                                                               placeholder="رشته">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>

                                        </div>
                                    </div>


                                    <!--address-->
                                    <div class="form-group">
                                        <div class="input-group-prepend">

                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">

                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-briefcase"></i></span>

                                                        </div>
                                                        <textarea class="form-control flex-fill" id="address"
                                                                  placeholder="آدرس"
                                                                  v-model="formItems.address"
                                                                  name="address" rows="2"
                                                        />
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>

                                        </div>
                                    </div>

                                    <!--orgin & website-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="orgin" name="orgin" class="form-control "
                                                       v-model="formItems.orgin"
                                                       placeholder="محل ثبت نام" readonly>
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i
                                                    class="fab fa-internet-explorer"></i></span>
                                                <input type="text" id="website" name="website" class="form-control"
                                                       v-model="formItems.website"
                                                       placeholder="وبسایت">
                                            </div>
                                        </div>
                                    </div>

                                    <!--finding_way & job-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">

                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-briefcase"></i></span>

                                                        </div>
                                                        <input type="text" id="finding_way" name="finding_way"
                                                               class="form-control "
                                                               v-model:value="formItems.finding_way"
                                                               placeholder="نحوه آشنایی"/>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                                  <span class="input-group-text">
                                                                      <i class="fa fa-phone"></i>
                                                                  </span>
                                                        <input type="text" id="job" name="job" class="form-control"
                                                               v-model:value="formItems.job"
                                                               placeholder="شغل"></div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-if="errors">{{ errors[0] }}</p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body">

                                    <!--card_numbe-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            </div>
                                            <input type="text" id="card_number" name="card_number" class="form-control"
                                                   v-bind:value="$parent.indexForEdit >= 0 ? $parent.splitedCardNumber(formItems.card_number,4)  : $parent.splitedCardNumber(availableCardNumber,4)"
                                                   placeholder="شماره کارت" readonly>
                                        </div>
                                    </div>

                                    <!--wallet & score-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                            <div class="input-group">
                                                <input type="number" id="wallet" name="wallet" class="form-control "
                                                       v-bind:value="formItems.wallet"
                                                       placeholder="کیف پول">
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i
                                                    class="fas fa-star-half-alt"></i></span>
                                                <input type="number" id="score" name="score" class="form-control"
                                                       v-bind:value="formItems.score"
                                                       placeholder="امتیاز">
                                            </div>
                                        </div>
                                    </div>


                                    <!--password-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">

                                                            <span class="input-group-text"><i
                                                                class="fa fa-asterisk"></i></span>

                                                        <input type="password" id="password" name="password"
                                                               class="form-control"
                                                               v-model="formItems.passwordtemp"
                                                               autocomplete="new-password" placeholder="رمز عبور">

                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="form-group form-actions col-2">
                                <button type="submit" value="submit" class="btn btn-border btn-success  w-75"
                                >
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
    import VueContentLoading from "vue-content-loading";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker'

    export default {
        components: {
            VueContentLoading,
            datePicker: VuePersianDatetimePicker
        },
        data() {
            return {
                is_active_label: '',
                data: '',
                birthday: '',
                marriageDate: '',
                posts: [],
                csrf: "",
                availableCardNumber: '',
                married: false,
                formItems: {
                    gender: 'مرد',
                    marriage_status: 'مجرد'
                },
                is_it_new_registration: 'true'
            }
        },
        methods: {
            async submit() {
                console.log('submitttttttttttttttt')
                const isValid = await this.$refs.observer.validate();
                console.log('isValid = ' + isValid)
                console.log(isValid)
                if (!isValid) {
                    // ABORT!!
                    swal("نا تمام!", "با خطا مواجه شد", "error");
                    return
                }
                swal("تمام!", "با موفقیت ثبت شد", "success");
                // 🐿 ship it
            },
            async customer_new_form_submit(event, is_it_new_registration) {

                const isValid = await this.$refs.observer.validate();

                if (!isValid) {
                    // ABORT!!
                    swal("نا تمام!", "لطفا همه گزینه های اجباری را پر کنید", "error");
                    return
                }

                const formData = new FormData(this.$refs['form']); // reference to form element
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                Object.assign(data, {'is_it_new_registration': this.is_it_new_registration})
                axios.post('/admin-panel/customer/new', data)
                    .then(response => {
                        console.log(response)

                        this.setToNewForm();
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        this.$refs.observer.reset();
                        this.$parent.view = 'list'
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
            getCardNumber(businessID) {
                console.log('getCardNumber')

                axios.get('/admin-panel/customer/get/availableCardNumber?businessID = ' + businessID)
                    .then(response => {
                        console.log(response)
                        this.availableCardNumber = response.data.availableCardNumber
                        console.log('availableCardNumber = ' + this.availableCardNumber)

                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            },
            populateFormInputIfIsForEdit() {

                if (this.$parent.indexForEdit >= 0) {
                    // console.log('populateFormInputIfIsForEdit = ')
                    // console.log(this.data[0])
                    this.formItems = this.data[this.$parent.indexForEdit]


                }
            },
            setToNewForm() {
                this.$parent.indexForEdit = -1
                this.formItems = '';
                this.$parent.getCustomerData(`/admin-panel/customer/index?page=1`)
            }
        },
        created: function () {
            this.data = this.$parent.data.data
        },
        mounted: function () {
            console.log('newCustomerCreationForm mounted ')
            this.csrf = window.Laravel.csrfToken
            this.getCardNumber(0)
            this.populateFormInputIfIsForEdit()
            if (this.$parent.indexForEdit >= 0) {
                this.is_it_new_registration = 'false';
            }
        },
    }

</script>

<style>
    .error {
        -moz-box-shadow: 0px 0px 4px #ff0002;
        -webkit-box-shadow: 0px 0px 4px #ff0002;
        box-shadow: 0px 0px 4px #ff0002;
    }

    .mydiv {
        padding: 0px 0px 0px 15px;
    }

    .myinput {
        display: flex;
    }

    .myinput input {
        padding: 10px 10px 10px 130px;
        border-radius: 5px 0px 0px 5px;
    }

    .myinput span {
        border-radius: 0px 5px 5px 0px;
    }

    /*phone number style*/
    .warning-sign {
        border-radius: 5px 0px 0px 5px !important;
    }

    .input-with-warning-sign input {
        padding: 10px 10px 10px 90px !important;
        border-radius: 0px !important;
    }
</style>
