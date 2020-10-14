<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <div class="card-body">
                    <form action="" method="post" ref="form">
                        <div class="row">
                            <div class="col-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="name" name="name" class="form-control"
                                                       v-bind:value="formItems.name"
                                                       placeholder="نام">
                                                <span class="input-group-addon"> </span>
                                                <input type="text" id="family" name="family" class="form-control"
                                                       v-bind:value="formItems.family"
                                                       placeholder=" نام خوانوادگی">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="father_name" name="father_name"
                                                       v-bind:value="formItems.father_name"
                                                       class="form-control"
                                                       placeholder=" نام پدر">
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>

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
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="mobile" name="mobile" class="form-control"
                                                       v-bind:value="formItems.mobile"
                                                       placeholder="شماره موبایل">
                                                <span class="input-group-text bg-warning text-dark ">
                                                <i class="fa fa-exclamation-triangle "></i></span>
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                <input type="text" id="phone" name="phone" class="form-control"
                                                       v-bind:value="formItems.phone"
                                                       placeholder="تلفن">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" id="email" name="email" class="form-control"
                                                   v-bind:value="formItems.email"
                                                   placeholder="ایمیل">
                                            <span class="input-group-text bg-warning text-dark ">
                                                <i class="fa fa-exclamation-triangle "></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            </div>
                                            <input type="text" id="social" name="social" class="form-control"
                                                   v-bind:value="formItems.social"
                                                   placeholder="اینستاگرام">
                                            <span class="input-group-addon"></span>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                    class="fa fa-birthday-cake"></i></span>

                                                <input type="text" id="birthday" name="birthday" class="form-control"
                                                       v-model="birthday.length > 0 ? birthday : formItems.birthday"
                                                       placeholder="تاریخ تولد">
                                                <date-picker v-model="birthday" element="birthday"
                                                             format="YYYY-MM-DD"></date-picker>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-id-card"></i></span>
                                            </div>
                                            <input type="text" id="national_code" name="national_code"
                                                   v-bind:value="formItems.national_code"
                                                   class="form-control"
                                                   placeholder="کد ملی">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fa fa-heart"></i></span>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" type="radio" id="single"
                                                       value="مجرد" name="marriage_status"
                                                       :checked="formItems.marriage_status==='مجرد'"
                                                       v-on:click="married=0">
                                                <label class="form-check-label" for="single">مجرد</label>
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
                                                <span class="input-group-text"><i class="far fa-heart"></i></span>
                                                <input type="text" id="marriage-date" name="marriage-date"
                                                       class="form-control"
                                                       v-model="marriageDate" placeholder="تاریخ ازدواج"
                                                       :readonly="married != 1">
                                                <date-picker element="marriage-date"
                                                             v-model="married.length > 0 ? marriageDate : formItems.wedding_anniversary"
                                                             :disabled="married != 1"></date-picker>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend w-30">
                                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                                <select id="education" name="education" class="form-control h-100 ">
                                                    <option value="-" :selected="formItems.education === '-'">>تحصیلات
                                                    </option>
                                                    <option value="زیر دیپلم"
                                                            :selected="formItems.education === 'زیر دیپلم'">زیر دیپلم
                                                    </option>
                                                    <option value="دیپلم" :selected="formItems.education === 'دیپلم'">
                                                        دیپلم
                                                    </option>
                                                    <option value="فوق دیپلم"
                                                            :selected="formItems.education === 'فوق دیپلم'">فوق دیپلم
                                                    </option>
                                                    <option value="کارشناسی"
                                                            :selected="formItems.education === 'کارشناسی'">
                                                        کارشناسی
                                                    </option>
                                                    <option value="کارشناسی ارشد"
                                                            :selected="formItems.education === 'کارشناسی ارشد'">کارشناسی
                                                        ارشد
                                                    </option>
                                                    <option value="دکتری" :selected="formItems.education === 'دکتری'">
                                                        دکتری
                                                    </option>
                                                </select>
                                            </div>
                                            <span class="input-group-addon"></span>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                            </div>
                                            <input type="text" id="field" name="field" class="form-control"
                                                   v-bind:value="formItems.field"
                                                   placeholder="رشته">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                    class="fas fa-map-marked-alt"></i></span>
                                            </div>
                                            <textarea class="form-control flex-fill" id="address" placeholder="آدرس"
                                                      v-bind:value="formItems.address"
                                                      name="address" rows="2"
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="orgin" name="orgin" class="form-control "
                                                       v-bind:value="formItems.orgin"
                                                       placeholder="محل ثبت نام" readonly>
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i
                                                    class="fab fa-internet-explorer"></i></span>
                                                <input type="text" id="website" name="website" class="form-control"
                                                       v-bind:value="formItems.website"
                                                       placeholder="وبسایت">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            </div>
                                            <input type="text" id="card_number" name="card_number" class="form-control"
                                                   v-bind:value="$parent.indexForEdit >= 0 ? $parent.splitedCardNumber(formItems.card_number,4) : $parent.splitedCardNumber(availableCardNumber,4)"
                                                   placeholder="شماره کارت" readonly>
                                        </div>
                                    </div>
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
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <div class="input-group">
                                                <input type="text" id="business" name="business" class="form-control "
                                                       v-bind:value="formItems.business.company_name"
                                                       placeholder="کسب و کار" readonly>
                                                <span class="input-group-addon"></span>
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                <select id="role_id" name="role_id" class="form-control h-100 ">
                                                    <option value="0">سطح دسترسی</option>
                                                    <option v-for="role in roles" v-bind:value="role.id_roles "
                                                            :selected="formItems.role_id === role.id_roles">
                                                        {{ role.name_fa }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                            </div>
                                            <input type="password" id="password" name="password" class="form-control"
                                                   autocomplete="new-password" placeholder="رمز عبور">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="form-group form-actions col-2">
                                <button type="submit" class="btn btn-border btn-success  w-75"
                                        v-on:click="user_new_form_submit($event)">
                                    <i class="fa fa-check-circle ml-1"></i>ثبت
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <!--        <span class="input-group-text"> <i class="fa fa-venus-mars"></i></span>-->
        <!--        <select id="select1" name="select1" class="form-control">-->
        <!--            <option value="0">جنسیت</option>-->
        <!--            <option value="1">مرد</option>-->
        <!--            <option value="2">زن</option>-->
        <!--        </select>-->

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
                formItems: [],
                is_it_new_registration: 'true',
                roles: '',
            }
        },
        methods: {
            user_new_form_submit: function (event) {
                event.preventDefault()
                const formData = new FormData(this.$refs['form']); // reference to form element
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                Object.assign(data, {'is_it_new_registration': this.is_it_new_registration})
                axios.post('http://127.0.0.1:8000/admin-panel/user/new', data)
                    .then(response => {
                        console.log(response)
                        alert('با موفقیت ثبت شد')
                        this.setToNewForm();
                        // var self = this;
                        // Object.keys(this.data.form).forEach(function (key, index) {
                        //     self.data.form[key] = '';
                        // });
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
            getCardNumber(businessID) {
                console.log('getCardNumber')

                axios.get('http://127.0.0.1:8000/admin-panel/user/get/availableCardNumber?businessID = ' + businessID)
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
            getFormInitData(businessID) {
                console.log('getFormInitData')

                axios.get('http://127.0.0.1:8000/admin-panel/user/get/formInitData?businessID=' + businessID)
                    .then(response => {
                        console.log(response)
                        console.log('response.data.roles = ' + response.data.roles[0].name_en)
                        this.availableCardNumber = response.data.availableCardNumber
                        this.roles = response.data.roles
                        console.log('roles = ' + response.data.roles)
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
                this.$parent.getUserData(`http://127.0.0.1:8000/admin-panel/user/index?page=1`)
            }
        },
        created: function () {
            this.data = this.$parent.data.data
        },
        mounted: function () {
            console.log('newUserCreation mounted.')
            console.log('parent.indexForEdit = ' + this.$parent.indexForEdit)
            this.csrf = window.Laravel.csrfToken
            this.getFormInitData(0);
            this.populateFormInputIfIsForEdit()
            if (this.$parent.indexForEdit >= 0) {
                this.is_it_new_registration = 'false';
            }
        },
    }

</script>

<style>


</style>
