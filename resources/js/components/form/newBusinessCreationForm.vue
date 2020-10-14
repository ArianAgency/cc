<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <form action="" method="post" ref="form" name="business_new_form">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="far fa-building"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="brand_name" name="brand_name" class="form-control"
                                                   v-bind:value="formItems.brand_name"
                                                   placeholder="نام برند">
                                            <span class="input-group-addon"> </span>
                                            <input type="text" id="company_name" name="company_name"
                                                   class="form-control"
                                                   v-bind:value="formItems.company_name"
                                                   placeholder=" نام شرکت">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="far fa-file-excel"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="register_code" name="register_code"
                                                   class="form-control" v-bind:value="formItems.register_code"
                                                   placeholder="شماره ثبت">

                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-passport"></i></span>

                                            <input type="text" id="national_code" name="national_code"
                                                   class="form-control" v-bind:value="formItems.national_code"
                                                   placeholder=" شناسه ملی">

                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>

                                            <input type="text" id="financial_code" name="financial_code"
                                                   class="form-control" v-bind:value="formItems.financial_code"
                                                   placeholder="کد اقتصادی">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                               <i class="far fa-calendar-check"></i></span>
                                            <input type="text" id="foundation_date" name="foundation_date"
                                                   class="form-control"
                                                   v-model="foundationDate.length > 0 ? foundationDate : formItems.foundation_date"
                                                   placeholder="تاریخ ثبت">
                                            <date-picker v-model="foundationDate" element="foundation_date"
                                                         format="YYYY-MM-DD"></date-picker>
                                        </div>
                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                        </div>
                                        <input type="text" id="company_field" name="company_field" class="form-control"
                                               v-bind:value="formItems.company_field" placeholder="نوع فعالیت">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                        </div>
                                        <textarea class="form-control flex-fill" id="address" placeholder="آدرس"
                                                  name="address" rows="2"
                                                  v-bind:value="formItems.address"
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
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
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <input type="text" id="support_phone" name="support_phone"
                                                   v-bind:value="formItems.support_phone"
                                                   class="form-control"
                                                   placeholder="تلفن پشتیبانی">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                        <div class="input-group">
                                            <input type="email" id="email" name="email" class="form-control"
                                                   v-bind:value="formItems.email"
                                                   placeholder="example@domain.com">
                                            <span class="input-group-text bg-warning text-dark ">
                                                <i class="fa fa-exclamation-triangle "></i></span>
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <input type="text" id="work_time" name="work_time"
                                                   class="form-control"
                                                   v-bind:value="formItems.work_time"
                                                   placeholder="ساعت کاری">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="input-group align-content-center  ">
                                        <div class="input-group-prepend  ">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                        </div>
                                        <input type="text" id="logo_address" name="logo_address"
                                               class="form-control "
                                               v-bind:value="$parent.indexForEdit > -1 ? (formItems.logo_address!=null?formItems.logo_address:'--') : '-'"
                                               readonly
                                               placeholder="لوگو">
                                        <!--          TODO load logo-->
                                    </div>

                                </div>
                                <div class="form-group  ">
                                    <!--                                    server="http://127.0.0.1:8000/upload/user-img"-->
                                    <file-pond
                                        :metadata=" {
                                        poster: 'https://pqina.nl/filepond/static/assets/social-square.png'
                                    }"
                                        name="image"
                                        ref="pond"
                                        label-idle="Drop files here..."
                                        v-bind:allow-multiple="false"
                                        accepted-file-types="image/jpeg, image/png"

                                        :server="{
                                               process: {
                                                      url: 'http://127.0.0.1:8000/upload/user-img',
                                                      method: 'POST',
                                                      headers: {
                                                     'X-CSRF-TOKEN': this.csrf
                                                                  }
                                                      },
                                                          }"
                                        v-on:init="handleFilePondInit"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        </div>
                                        <input type="text" id="social" name="social" class="form-control"
                                               v-bind:value="formItems.social"
                                               placeholder="اینستاگرام">
                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend w-40">
                                            <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                            <select id="" name="company_size" class="form-control h-100 ">
                                                <option value="0"
                                                        :selected="formItems.company_size === 0">اندازه شرکت
                                                </option>
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
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="bank_account" name="bank_account"
                                                   class="form-control"
                                                   v-bind:value="formItems.bank_account"
                                                   placeholder=" شماره حساب">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fab fa-autoprefixer"></i></span>

                                            <input type="text" id="card_pre_number" name="card_pre_number"
                                                   class="form-control"
                                                   v-bind:value="$parent.indexForEdit > -1 ? formItems.card_pre_number : availableCardPreNumber"
                                                   placeholder="پیش شماره کارت" readonly>
                                        </div>
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
                                            <span class="input-group-text"><i class="fas fa-star-half-alt"></i></span>
                                            <input type="number" id="score" name="score" class="form-control"
                                                   v-bind:value="formItems.score"
                                                   placeholder="امتیاز">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            <input type="number" id="score_limit" name="score_limit"
                                                   class="form-control"
                                                   v-bind:value="formItems.score_limit"
                                                   placeholder="سقف امتیاز">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        </div>
                                        <input type="text" id="have_hashtag" name="have_hashtag"
                                               class="form-control"
                                               v-bind:value="$parent.indexForEdit > -1 ? (formItems.have_hashtag!=null?formItems.have_hashtag:'--') : '-'"
                                               placeholder="هشتگ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                        </div>
                                        <input type="password" id="password" name="password" class="form-control"
                                               placeholder="رمز عبور">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10"></div>
                        <div class="form-group form-actions col-2">
                            <button type="submit" class="btn btn-border btn-success  w-75"
                                    v-on:click="business_new_form_submit($event)">
                                <i class="fa fa-check-circle ml-1"></i>ثبت
                            </button>
                        </div>
                    </div>

                </form>
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
    import vueFilePond, {setOptions} from 'vue-filepond';
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
                formItems: [],
                is_it_new_registration: 'true',
                roles: '',
            }
        },
        methods: {

            getCardPreNumber() {
                console.log('getCardPreNumber')
                axios.get('http://127.0.0.1:8000/admin-panel/business/get/availableCardPreNumber')
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
                this.csrf = window.Laravel.csrfToken
                console.log('handleFilePondInit csrf. = ' + this.csrf)

            },
            business_new_form_submit: function (event, is_it_new_registration) {
                event.preventDefault()
                const formData = new FormData(this.$refs['form']); // reference to form element
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                Object.assign(data, {'is_it_new_registration': this.is_it_new_registration})
                console.log('business_new_form_submit => ' + Object.keys(data.image).length)
                console.log('business_new_form_submit => ' + data.logo_address)
                data.image = (Object.keys(data.image).length > 0 ? data.image : '---')

                axios.post('http://127.0.0.1:8000/admin-panel/business/new', data)
                    .then(response => {
                        console.log(response)
                        alert('با موفقیت ثبت شد')
                        var self = this;
                        Object.keys(this.data.form).forEach(function (key, index) {
                            self.data.form[key] = '';
                        });
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
            console.log('newBusinessCreation mounted.')
            console.log('parent.indexForEdit = ' + this.$parent.indexForEdit)
            console.log(this.data)
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

    .filepond--panel-root {
        background-color: rgb(56, 193, 114);
    }

    .filepond--drop-label {
        color: rgb(255, 255, 255);
    }
</style>
