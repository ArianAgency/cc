<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <div class="card-body">
                    <ValidationObserver v-slot="{invalid, handleSubmit }" ref="observer">
                        <form ref="form" @submit.prevent="handleSubmit(user_new_form_submit($event))">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card-body">

                                        <!--name & family-->
                                        <div class="input-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-user"></i>
                                                            </span>
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
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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

                                        <!--father_name & gender-->
                                        <div class="input-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                             <span class="input-group-text"><i
                                                                 class="fa fa-user"></i></span>
                                                        <input type="text" id="father_name" name="father_name"
                                                               v-model:value="formItems.father_name"
                                                               :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                               placeholder=" نام پدر"></div>

                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-6">
                                                <ValidationProvider rules=""
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>

                                        <!--mobile & phone-->
                                        <div class="input-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required|numeric|length:11"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <!--                                                        <div class="">-->
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
                                            <div class="col-6">
                                                <ValidationProvider rules="required|numeric|length:11"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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

                                        <!--email-->
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <ValidationProvider rules="required|email"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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

                                        <!--instagram & birthday-->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules=""
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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

                                        <!--national_code & marriage_status/marriage-date-->
                                        <div class="form-group row">

                                            <div class="col-4">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
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
                                            <div class="col-8 ">

                                                <ValidationProvider :rules="married===1?'required':''"
                                                                    v-slot="{ errors }">

                                                    <div class="input-group flex-row row">
                                                        <div class="input-group col-7 ">

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

                                                        </div>
                                                        <div class="input-group col-5">

                                                            <!--                                                                <span class="input-group-text"><i-->
                                                            <!--                                                                    class="far fa-heart"></i></span>-->
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

                                        <!--education & field-->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-book"></i>
                                                            </span>
                                                        </div>
                                                        <select id="education" name="education"
                                                                class="custom-select"
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
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">

                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-briefcase"></i>
                                                    </span>

                                                        </div>
                                                        <input type="text" id="field" name="field"
                                                               class="form-control"
                                                               v-model:value="formItems.field"
                                                               placeholder="رشته">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>

                                        <!--address-->
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-briefcase"></i>
                                                    </span>
                                                        </div>
                                                        <textarea class="form-control flex-fill" id="address"
                                                                  placeholder="آدرس"
                                                                  v-model:value="formItems.address"
                                                                  name="address" rows="2"/>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card-body">

                                        <!--orgin & website-->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search-location"></i>
                                                </span>
                                                    <input type="text" id="orgin" name="orgin" class="form-control "
                                                           v-model:value="formItems.orgin"
                                                           placeholder="محل ثبت نام" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                <span class="input-group-text">
                                                        <i class="fab fa-internet-explorer"></i>
                                                    </span>
                                                    <input type="text" id="website" name="website"
                                                           class="form-control"
                                                           v-model:value="formItems.website"
                                                           placeholder="وبسایت">
                                                </div>
                                            </div>
                                        </div>

                                        <!--fa-credit-card-->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-credit-card"></i></span>
                                                </div>
                                                <input type="text" id="card_number" name="card_number"
                                                       class="form-control"
                                                       v-model:value="$parent.indexForEdit >= 0 ?
                                                   $parent.splitedCardNumber(formItems.card_number,4) :
                                                   $parent.splitedCardNumber(availableCardNumber,4)"
                                                       placeholder="شماره کارت" readonly>
                                            </div>
                                        </div>

                                        <!--wallet & score-->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-wallet"></i>
                                                    </span>
                                                    <input type="number" id="wallet" name="wallet"
                                                           class="form-control "
                                                           v-model:value="formItems.wallet"
                                                           placeholder="کیف پول">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-star-half-alt"></i></span>
                                                    <input type="number" id="score" name="score"
                                                           class="form-control"
                                                           v-model:value="formItems.score"
                                                           placeholder="امتیاز">
                                                </div>
                                            </div>
                                        </div>

                                        <!--business & role_id-->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-building"></i>
                                                            </span>

                                                        <input v-if="businessesList.length<=0" type="text"
                                                               id=" businesse_id"
                                                               name="businesse_id" class="form-control "
                                                               v-model:value="$parent.indexForEdit > -1 ? formItems.business.brand_name : user.business.brand_name"
                                                               placeholder="کسب و کار" readonly>

                                                        <select v-if="businessesList.length>0" name="businesse_id"
                                                                v-on:change="getCardNumber($event.target.value)"
                                                                class="custom-select"
                                                                v-model="formItems.businesse_id">
                                                            <!--                                                                <option value="0" selected="true">کسب و کار</option>-->
                                                            <option v-for="business in businessesList"
                                                                    :value="business.id_businesses"
                                                                    :selected="($parent.indexForEdit > -1 ? formItems.businesse_id:user.businesse_id)===business.id_businesses"
                                                            >
                                                                {{ business.brand_name }}
                                                            </option>
                                                        </select>

                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>

                                                </ValidationProvider>

                                            </div>
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">

                                                           <span class="input-group-text">
                                                               <i class="fas fa-user-tie"></i>
                                                           </span>

                                                        <select id="role_id" name="role_id"
                                                                class="custom-select"
                                                                v-model="formItems.role_id">
                                                            <!--                                                                <option value="0">سطح دسترسی</option>-->
                                                            <option v-for="role in roles"
                                                                    :value="role.id_roles"
                                                                    :selected="formItems.role_id === role.id_roles">
                                                                {{ role.name_fa }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>


                                        <!--password-->
                                        <div class="form-group ">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-asterisk"></i></span>
                                                    <input type="password" id="password" name="password"
                                                           class="form-control"
                                                           v-model="formItems.passwordtemp"
                                                           autocomplete="new-password"
                                                           placeholder="رمز عبور">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="form-group form-actions col-2">
                                    <button type="submit" value="submit"
                                            class="btn btn-border btn-success  w-75"
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
    </div>

</template>

<script>
    import VueContentLoading from "vue-content-loading";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker'


    export default {
        components: {
            VueContentLoading,
            datePicker: VuePersianDatetimePicker,
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
                is_it_new_registration: 'true',
                roles: '',
                user: '',
                businessesList: '',

            }
        },
        methods: {
            async user_new_form_submit(event) {
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
                axios.post('/admin-panel/user/new', data)
                    .then(response => {
                        console.log(response)
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        this.setToNewForm();
                        // var self = this;
                        // Object.keys(this.data.form).forEach(function (key, index) {
                        //     self.data.form[key] = '';
                        // });
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

                axios.get('/admin-panel/user/get/availableCardNumber?businessID=' + businessID)
                    .then(response => {
                        console.log(response)
                        console.log('getCardNumber = ' + response)
                        this.availableCardNumber = response.data.availableCardNumber
                        console.log('availableCardNumber = ' + this.availableCardNumber)
                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            },
            getFormInitData() {
                console.log('getFormInitData')

                var businessID = this.$parent.user.businesse_id

                axios.get('/admin-panel/user/get/formInitData?businessID=' + businessID)
                    .then(response => {
                        console.log(response)
                        this.availableCardNumber = response.data.availableCardNumber
                        this.roles = response.data.roles
                        this.user = response.data.user
                        this.businessesList = response.data.businessesIndex
                        console.log('roles = ' + response.data.roles)
                        console.log('user = ')
                        console.log(response.data.user)
                        console.log('availableCardNumber = ' + this.availableCardNumber)

                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            },
            populateFormInputIfIsForEdit() {
                if (this.$parent.indexForEdit >= 0) {
                    console.log('populateFormInputIfIsForEdit = ')
                    console.log(this.data[this.$parent.indexForEdit])
                    this.formItems = this.data[this.$parent.indexForEdit]
                }
            },
            setToNewForm() {
                this.$parent.indexForEdit = -1
                this.formItems = '';
                this.$parent.getUserData(`/admin-panel/user/index?page=1`)
            }
        },
        created: function () {
            console.log('newUserCreation created.')
            this.data = this.$parent.data.data
        },
        mounted: function () {
            console.log('newUserCreation mounted.')
            console.log('parent.indexForEdit = ' )
            console.log(this.$parent.indexForEdit)
            this.csrf = window.Laravel.csrfToken
            this.getFormInitData();
            this.populateFormInputIfIsForEdit()
            if (this.$parent.indexForEdit >= 0) {
                this.is_it_new_registration = 'false';
            }
        },
        watch: {
            formItems: function () {
                console.log('formItems  = ')
                console.log(this.formItems)
            }
        }
    }

</script>

<style>
    .error {
        -moz-box-shadow: 0px 0px 4px #ff0002;
        -webkit-box-shadow: 0px 0px 4px #ff0002;
        box-shadow: 0px 0px 4px #ff0002;
    }

    .mydiv {
        /*padding: 0px 0px 0px 15px;*/
    }

    .myinput {
        /*display: flex;*/
    }

    .myinput input {
        /*padding: 10px 10px 10px 130px;*/
        /*border-radius: 5px 0px 0px 5px;*/
    }

    .myinput span {
        /*border-radius: 0px 5px 5px 0px;*/
    }

    /*phone number style*/
    .warning-sign {
        /*border-radius: 5px 0px 0px 5px !important;*/
    }

    .input-with-warning-sign input {
        /*padding: 10px 10px 10px 90px !important;*/
        /*border-radius: 0px !important;*/
    }
</style>
