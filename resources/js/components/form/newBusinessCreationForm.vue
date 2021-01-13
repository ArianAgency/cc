<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <ValidationObserver ref="observer" v-slot="{invalid, handleSubmit }">
                    <form ref="form" @submit.prevent="handleSubmit(business_new_form_submit($event))">
                        <div class="row">
                            <div class="col-6">
                                <div class="card-body">

                                    <!-- brand_name & company_name -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text"><i
                                                            class="far fa-building"></i></span>
                                                    <input type="text" id="brand_name" name="brand_name"
                                                           class="form-control"
                                                           v-model:value="formItems.brand_name"
                                                           placeholder="نام برند">
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
                                                    <input type="text" id="company_name" name="company_name"
                                                           class="form-control"
                                                           v-model:value="formItems.company_name"
                                                           placeholder=" نام شرکت">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- register_code & national_code & financial_code -->
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text"><i
                                                            class="far fa-file-excel"></i></span>
                                                    <input type="text" id="register_code" name="register_code"
                                                           class="form-control" v-model="formItems.register_code"
                                                           placeholder="شماره ثبت">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-passport"></i></span>
                                                    <input type="text" id="national_code" name="national_code"
                                                           class="form-control"
                                                           v-model:value="formItems.national_code"
                                                           placeholder=" شناسه ملی">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-money-check-alt"></i></span>
                                                    <input type="text" id="financial_code" name="financial_code"
                                                           class="form-control"
                                                           v-model:value="formItems.financial_code"
                                                           placeholder="کد اقتصادی">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- foundation_date & company_field -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text"><i
                                                            class="far fa-calendar-check"></i></span>
                                                    <input type="text" id="foundation_date" name="foundation_date"
                                                           class="form-control"
                                                           v-model="formItems.foundation_date"
                                                           placeholder="تاریخ ثبت">
                                                    <date-picker v-model="formItems.foundation_date"
                                                                 element="foundation_date"
                                                                 format="YYYY-MM-DD"></date-picker>
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
                                                                class="fa fa-layer-group"></i></span>
                                                    <input type="text" id="company_field" name="company_field"
                                                           class="form-control"
                                                           v-model:value="formItems.company_field"
                                                           placeholder="نوع فعالیت">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- address -->
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marked-alt"></i>
                                                        </span>
                                                    <textarea class="form-control flex-fill" id="address"
                                                              placeholder="آدرس"
                                                              name="address" rows="2"
                                                              v-model:value="formItems.address"
                                                    />
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </ValidationProvider>
                                        </div>

                                    </div>

                                    <!-- mobile & phone & support_phone -->
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-mobile-alt"></i>
                                                        </span>
                                                    <input type="text" id="mobile" name="mobile"
                                                           class="form-control"
                                                           maxlength="11"
                                                           v-model:value="formItems.mobile"
                                                           placeholder="شماره موبایل">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                    <input type="text" id="phone" name="phone" class="form-control"
                                                           v-model:value="formItems.phone"
                                                           placeholder="تلفن">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                    <input type="text" id="support_phone" name="support_phone"
                                                           v-model:value="formItems.support_phone"
                                                           class="form-control"
                                                           placeholder="تلفن پشتیبانی">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- email & work_time -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                        <span class="input-group-text"><i
                                                            class="far fa-envelope"></i></span>
                                                    <input type="email" id="email" name="email" class="form-control"
                                                           v-model:value="formItems.email"
                                                           placeholder="example@domain.com">
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
                                                                class="fa fa-info-circle"></i></span>
                                                    <input type="text" id="work_time" name="work_time"
                                                           class="form-control"
                                                           v-model:value="formItems.work_time"
                                                           placeholder="ساعت کاری">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- logo_address -->
                                    <div class="form-group row">
                                        <div class="input-group align-content-center  ">
                                            <input type="text" id="logo_address" name="logo_address" hidden
                                                   class="form-control "
                                                   v-bind:value="$parent.indexForEdit > -1 ? (formItems.logo_address!=null?formItems.logo_address:'--') : '-'"
                                                   readonly
                                                   placeholder="لوگو">
                                        </div>
                                    </div>

                                    <!-- file-pond -->
                                    <div class="form-group  ">
                                        <file-pond
                                            name="image"
                                            ref="pond"
                                            label-idle="Drop files here..."
                                            v-bind:allow-multiple="false"
                                            accepted-file-types="image/jpeg, image/png"
                                            allowImagePreview="true"
                                            imagePreviewHeight="200"
                                            imageCropAspectRatio="1:1"
                                            imageResizeTargetWidth="200"
                                            imageResizeTargetHeight="200"
                                            filePosterMaxHeight="200"
                                            :server="{
                                               process: {
                                                      url: '/upload/business_logo',
                                                      method: 'POST',
                                                      headers: {
                                                     'X-CSRF-TOKEN': csrf
                                                                  }
                                                      }
                                                          }"
                                            :files="formItems.logo_address?[ {
                                                        // the server file reference
                                                        // source: '../storage/logo_img/slide04_rtl_102620201442215f96af15f3104.jpg',
                                                        source: '../storage/logo_img/'+formItems.logo_address,

                                                        // set type to local to indicate an already uploaded file
                                                        options: {
                                                            type: 'local',
                                                             metadata: {
                                                                         // poster: '../storage/logo_img/slide04_rtl_102620201442215f96af15f3104.jpg'
                                                                         poster:'../storage/logo_img/'+ formItems.logo_address
                                                                     }
                                                        }
                                                    }]:''"
                                            v-on:init="handleFilePondInit"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body">

                                    <!-- instagram_id & company_size -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                    <select id="company_size" name="company_size"
                                                            class="custom-select"
                                                            v-model="formItems.company_size">
                                                        <option value="1"
                                                                :selected="formItems.company_size === 1">زیر 10
                                                        </option>
                                                        <option value="2"
                                                                :selected="formItems.company_size === 2">10-20
                                                        </option>
                                                        <option value="3"
                                                                :selected="formItems.company_size === 3">20-50
                                                        </option>
                                                        <option value="4"
                                                                :selected="formItems.company_size === 4">50-100
                                                        </option>
                                                        <option value="5"
                                                                :selected="formItems.company_size === 5">100-200
                                                        </option>
                                                        <option value="6"
                                                                :selected="formItems.company_size === 6">200+
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
                                                    <span class="input-group-text"><i
                                                        class="fas fa-briefcase"></i></span>

                                                    </div>
                                                    <input type="text" id="instagram_id" name="instagram_id"
                                                           class="form-control"
                                                           v-model:value="formItems.instagram_id"
                                                           placeholder="اینستاگرام">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!-- instagram_hashtag -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            </div>
                                            <input type="text" id="instagram_hashtag" name="instagram_hashtag"
                                                   class="form-control"
                                                   v-model:value="formItems.instagram_hashtag"
                                                   placeholder="هشتگ">
                                        </div>
                                    </div>

                                    <!-- orgin & website -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <div class="input-group ">
                                                <span class="input-group-text"><i
                                                    class="fas fa-search-location"></i></span>

                                                <input type="text" id="orgin" name="orgin" class="form-control "
                                                       v-model:value="formItems.orgin"
                                                       placeholder="محل ثبت نام" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group ">
                                                <span class="input-group-text"><i
                                                    class="fab fa-internet-explorer"></i></span>
                                                <input type="text" id="website" name="website" class="form-control"
                                                       v-model:value="formItems.website"
                                                       placeholder="وبسایت">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- bank_account & card_pre_number -->
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </span>
                                                <input type="text" id="bank_account" name="bank_account"
                                                       class="form-control"
                                                       v-model:value="formItems.bank_account"
                                                       placeholder=" شماره حساب">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fab fa-autoprefixer"></i>
                                            </span>
                                                <input type="text" id="card_pre_number" name="card_pre_number"
                                                       class="form-control"
                                                       v-bind:value="$parent.indexForEdit > -1 ? formItems.card_pre_number : availableCardPreNumber"
                                                       placeholder="پیش شماره کارت" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- wallet & score & score_limit -->
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                                <input type="number" id="wallet" name="wallet" class="form-control "
                                                       v-model:value="formItems.wallet"
                                                       placeholder="کیف پول">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                    class="fas fa-star-half-alt"></i></span>
                                                <input type="number" id="score" name="score" class="form-control"
                                                       v-model:value="formItems.score"
                                                       placeholder="امتیاز">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                    class="fas fa-funnel-dollar"></i></span>
                                                <input type="number" id="score_limit" name="score_limit"
                                                       class="form-control"
                                                       v-model:value="formItems.score_limit"
                                                       placeholder="سقف امتیاز">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- password -->
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
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
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="form-group form-actions col-2">
                                <button type="submit" class="btn btn-border btn-success  w-75">
                                    <i class="fa fa-check-circle ml-1"></i>ثبت
                                </button>
                            </div>
                        </div>

                    </form>
                </ValidationObserver>
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
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    // import vueFilePond from 'vue-filepond';
    import vueFilePond from 'vue-filepond';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import FilePondPluginFileMetadata from 'filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.esm.js';
    import FilePondPluginFileRename from 'filepond-plugin-file-rename';
    // Import styles
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

    // Import the plugin code
    import FilePondPluginFilePoster from 'filepond-plugin-file-poster';

    // Import the plugin styles
    import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';


    const FilePond = vueFilePond(FilePondPluginFileRename, FilePondPluginImagePreview, FilePondPluginFileMetadata, FilePondPluginFilePoster);


    export default {
        components: {
            VueContentLoading,
            datePicker: VuePersianDatetimePicker,
            FilePond
        },
        data() {
            return {
                is_active_label: '',
                data: '',
                foundation_date: '',
                foundationDate: '',
                posts: [],
                csrf: '',
                availableCardPreNumber: '',
                formItems: {
                    wallet: 0,
                    score: 0
                },
                is_it_new_registration: 'true',
                roles: '',
            }
        },
        methods: {
            getCardPreNumber() {
                console.log('getCardPreNumber')
                axios.get('/admin-panel/business/get/availableCardPreNumber')
                    .then(response => {
                        console.log(response)
                        this.availableCardPreNumber = response.data.availableCardPreNumber
                        console.log('availableCardPreNumber = ' + this.availableCardPreNumber)

                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            },
            handleFilePondInit: function () {
                console.log('handleFilePondInit csrf. = ' + this.csrf)
                this.csrf = window.Laravel.csrfToken
            },
            async business_new_form_submit(event, is_it_new_registration) {

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
                console.log('business_new_form_submit => ' + Object.keys(data.image).length)
                console.log('business_new_form_submit => ' + data.logo_address)
                data.image = (Object.keys(data.image).length > 0 ? data.image : '---')

                axios.post('/admin-panel/business/new', data)
                    .then(response => {
                        console.log(response)
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        this.$parent.view = 'list'
                        this.$refs.observer.reset();
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
            getFormInitData(businessID) {
                console.log('getFormInitData')

                axios.get('/admin-panel/user/get/formInitData?businessID=' + businessID)
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
                    console.log('this.formItems = ')
                    console.log(this.formItems)
                }
            },
            setToNewForm() {
                this.$parent.indexForEdit = -1
                this.formItems = {
                    wallet: 0,
                    score: 0
                };
                this.$parent.getUserData(`/admin-panel/user/index?page=1`)
            }
        },
        created: function () {
            console.log('newBusinessCreation created.')

            this.data = this.$parent.data.data
            this.csrf = window.Laravel.csrfToken

            console.log('this.csrf =.')
            console.log(this.csrf)
        },
        mounted: function () {
            console.log('newBusinessCreation mounted.')
            console.log('parent.indexForEdit = ' + this.$parent.indexForEdit)
            console.log(this.data)

            // this.getFormInitData(0);
            this.getCardPreNumber()
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
