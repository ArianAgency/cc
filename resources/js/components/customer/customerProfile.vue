<template>
    <div class="animated fadeIn">
        <div class="card div-body">
            <div class="card-header">
                <div class="mytitle">
                    <i class="fa fa-align-justify"></i>
                    <span>پروفایل</span>
                </div>
            </div>

            <div class="col-12 mb-4">

                <ValidationObserver ref="observer" v-slot="{invalid, handleSubmit ,validate }">
                    <!--                    <form ref="form" @submit.prevent="handleSubmit(customer_new_form_submit($event))">-->
                    <!--                    <form ref="form" @submit.prevent="customer_new_form_submit($event)">-->
                    <form ref="form" @submit.prevent="customer_form_submit($event)">

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
                                                           style=": #0a3d2e" v-model:value="user.name"
                                                           placeholder="نام">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0] }}
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
                                                           v-model:value="user.family"
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
                                                           v-model:value="user.father_name"
                                                           :class="errors.length > 0 ? 'form-control error':'form-control'"
                                                           placeholder=" نام پدر"></div>

                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0] }}
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
                                                               :checked="user.gender==='مرد'"
                                                               value="مرد" name="gender">

                                                        <label class="form-check-label" for="m">مرد</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mr-1">
                                                        <input class="form-check-input" type="radio" id="f"
                                                               :checked="user.gender==='زن'"
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
                                                           v-model:value="user.mobile"
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
                                                    <input type="text" id="phone" name="phone"
                                                           maxlength="11"
                                                           class="form-control"
                                                           v-model:value="user.phone"
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
                                                           v-model:value="user.email"
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
                                                           v-model:value="user.social"
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
                                                           v-model="user.birthday"
                                                           placeholder="تاریخ تولد">
                                                    <date-picker v-model="user.birthday"
                                                                 element="birthday"
                                                                 format="YYYY-MM-DD"></date-picker>
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!--national_code-->
                                    <div class="form-group ">
                                        <div class="">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                    class="far fa-id-card"></i></span>
                                                    </div>
                                                    <input type="text" id="national_code"
                                                           name="national_code"
                                                           maxlength="10"
                                                           v-model:value="user.national_code"
                                                           class="form-control"
                                                           placeholder="کد ملی">

                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!--marriage_status/marriage-date-->
                                    <div class="form-group row">
                                        <div class="">

                                            <ValidationProvider :rules="married===1?'required':''"
                                                                v-slot="{ errors }">

                                                <div class="input-group flex-row ">
                                                    <div class="input-group col-7 ">

                                                            <span class="input-group-text"><i
                                                                class="fa fa-heart"></i></span>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input" type="radio"
                                                                   id="single"
                                                                   value="مجرد" name="marriage_status"
                                                                   :checked="user.marriage_status==='مجرد'"
                                                                   v-on:click="married=0">
                                                            <label class="form-check-label"
                                                                   for="single">مجرد</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mr-1">
                                                            <input class="form-check-input " type="radio"
                                                                   id="rel"
                                                                   value="متاهل" name="marriage_status"
                                                                   :checked="user.marriage_status==='متاهل'"
                                                                   v-on:click="married=1">
                                                            <label class="form-check-label"
                                                                   for="rel">متاهل</label>
                                                        </div>

                                                    </div>
                                                    <div class="input-group col-5">

                                                        <!--                                                                <span class="input-group-text"><i-->
                                                        <!--                                                                    class="far fa-heart"></i></span>-->
                                                        <input type="text" id="marriage-date"
                                                               name="marriage-date"
                                                               class="form-control "
                                                               v-model="user.wedding_anniversary"
                                                               placeholder="تاریخ ازدواج"
                                                               :readonly="married != 1">
                                                        <date-picker element="marriage-date"
                                                                     v-model=" user.wedding_anniversary"
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
                                                            v-model="user.education">
                                                        <option value="زیر دیپلم"
                                                                :selected="user.education === 'زیر دیپلم'">
                                                            زیر
                                                            دیپلم
                                                        </option>
                                                        <option value="دیپلم"
                                                                :selected="user.education === 'دیپلم'">
                                                            دیپلم
                                                        </option>
                                                        <option value="فوق دیپلم"
                                                                :selected="user.education === 'فوق دیپلم'">
                                                            فوق
                                                            دیپلم
                                                        </option>
                                                        <option value="کارشناسی"
                                                                :selected="user.education === 'کارشناسی'">
                                                            کارشناسی
                                                        </option>
                                                        <option value="کارشناسی ارشد"
                                                                :selected="user.education === 'کارشناسی ارشد'">
                                                            کارشناسی
                                                            ارشد
                                                        </option>
                                                        <option value="دکتری"
                                                                :selected="user.education === 'دکتری'">
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
                                                           v-model:value="user.field"
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
                                                              v-model:value="user.address"
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
                                                <input type="text" id="orgin" name="orgin"
                                                       class="form-control "
                                                       v-model:value="user.orgin"
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
                                                       v-model:value="user.website"
                                                       placeholder="وبسایت">
                                            </div>
                                        </div>
                                    </div>

                                    <!--finding_way & job-->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">

                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-briefcase"></i></span>

                                                    </div>
                                                    <input type="text" id="finding_way" name="finding_way"
                                                           class="form-control "
                                                           v-model:value="user.finding_way"
                                                           placeholder="نحوه آشنایی"/>
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
                                                                      <i class="fa fa-phone"></i>
                                                                  </span>
                                                    <input type="text" id="job" name="job"
                                                           class="form-control"
                                                           v-model:value="user.job"
                                                           placeholder="شغل"></div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-if="errors">{{ errors[0] }}</p>
                                            </ValidationProvider>
                                        </div>
                                    </div>


                                    <!--card_number-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-credit-card"></i></span>
                                            </div>
                                            <input type="text" id="card_number" name="card_number"
                                                   class="form-control"
                                                   v-bind:value=" splitedCardNumber(user.card_number,4)"
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
                                                       class="form-control " readonly
                                                       v-model:value="user.wallet"
                                                       placeholder="کیف پول">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                    <span class="input-group-text"><i
                                                        class="fas fa-star-half-alt"></i></span>
                                                <input type="number" id="score" name="score"
                                                       class="form-control" readonly
                                                       v-model:value="user.score"
                                                       placeholder="امتیاز">
                                            </div>
                                        </div>
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


</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    components: {
        datePicker: VuePersianDatetimePicker
    },
    name: "CustomerProfile",
    props: ['user'],
    data() {
        return {
            married: false,
        }
    },
    methods: {
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
        async customer_form_submit(event, is_it_new_registration) {

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
            Object.assign(data, {'is_it_new_registration': false})
            Object.assign(data, {'id_customer': JSON.stringify(this.user.id_customers)})


            axios.post('/customer-panel/do/complete-registration-form', data)
                .then(response => {
                    console.log(response)
                    swal("تمام!", "با موفقیت ثبت شد", "success");
                })
                .catch(e => {

                    if (e.response.data.code == 2) {
                        swal("نا تمام!", "با خطا مواجه شد", "error");
                    } else {
                        alert('error')
                    }

                })
        },
    },
    created: function () {
        console.log(this.user)
    }

}
</script>

<style scoped>

</style>
