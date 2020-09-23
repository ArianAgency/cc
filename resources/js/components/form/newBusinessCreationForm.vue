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
                                                   placeholder="نام برند">
                                            <span class="input-group-addon"> </span>
                                            <input type="text" id="company_name" name="company_name"
                                                   class="form-control"
                                                   placeholder=" نام شرکت">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="far fa-file-excel"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="register_code" name="register_code"
                                                   class="form-control"
                                                   placeholder=" شماره حساب">

                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-passport"></i></span>

                                            <input type="text" id="national_code" name="national_code"
                                                   class="form-control"
                                                   placeholder=" شناسه ملی">

                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>

                                            <input type="text" id="financial_code" name="financial_code"
                                                   class="form-control"
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
                                                   v-model="register_date" placeholder="تاریخ ثبت">
                                            <date-picker v-model="register_date"
                                                         element="foundation_date"></date-picker>
                                        </div>
                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                        </div>
                                        <input type="text" id="company_field" name="company_field" class="form-control"
                                               placeholder="نوع فعالیت">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                        </div>
                                        <textarea class="form-control flex-fill" id="address" placeholder="آدرس"
                                                  name="address" rows="2"
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="mobile" name="mobile" class="form-control"
                                                   placeholder="شماره موبایل">
                                            <span class="input-group-text bg-warning text-dark ">
                                                <i class="fa fa-exclamation-triangle "></i></span>
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                   placeholder="تلفن">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <input type="text" id="support_phone" name="support_phone"
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
                                                   placeholder="example@domain.com">
                                            <span class="input-group-text bg-warning text-dark ">
                                                <i class="fa fa-exclamation-triangle "></i></span>
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <input type="text" id="work_time" name="work_time"
                                                   class="form-control"
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
                                               readonly
                                               placeholder="لوگو">
                                    </div>

                                </div>
                                <div class="form-group  ">
                                    <!--                                    server="http://127.0.0.1:8000/upload/user-img"-->
                                    <file-pond

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
                                                              }
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
                                               placeholder="اینستاگرام">
                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend w-40">
                                            <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                            <select id="" name="company_size" class="form-control h-100 ">
                                                <option value="0">اندازه شرکت</option>
                                                <option value="1">زیر 10</option>
                                                <option value="2">10-20</option>
                                                <option value="4">20-50</option>
                                                <option value="5">50-100</option>
                                                <option value="6">100-200</option>
                                                <option value="7">200+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="orgin" name="orgin" class="form-control "
                                                   placeholder="محل ثبت نام" readonly>
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i
                                                class="fab fa-internet-explorer"></i></span>
                                            <input type="text" id="website" name="website" class="form-control"
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
                                                   placeholder=" شماره حساب">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fab fa-autoprefixer"></i></span>

                                            <input type="text" id="card_pre_number" name="card_pre_number"
                                                   class="form-control"
                                                   v-bind:value="availableCardPreNumber"
                                                   placeholder="پیش شماره کارت" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                        <div class="input-group">
                                            <input type="number" id="wallet" name="wallet" class="form-control "
                                                   placeholder="کیف پول">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-star-half-alt"></i></span>
                                            <input type="number" id="score" name="score" class="form-control"
                                                   placeholder="امتیاز">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            <input type="number" id="score_limit" name="score_limit"
                                                   class="form-control"
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
    import vueFilePond from 'vue-filepond';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import FilePondPluginFileMetadata from 'filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.esm.js';
    import FilePondPluginFileRename from 'filepond-plugin-file-rename';
    // Import styles
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

    const FilePond = vueFilePond(FilePondPluginFileRename, FilePondPluginImagePreview, FilePondPluginFileMetadata);


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
                register_date: '',
                marriageDate: '',
                posts: [],
                csrf: '',
                image_name: '',
                availableCardPreNumber: '',

            }
        },
        methods: {
            alert1() {
                alert('bhdsjakl;scvmnbfvdnsam,lcm vnbdnsmkqlsdmnvbfsdnwjqk');
                // ???
                // alert(this.is_active_label)
            },
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

                // example of instance method call on pond reference
                // console.log(this.$refs.pond.getFiles());
                // this.$refs.pond.setOptions({
                //     fileRenameFunction: (file) => {
                //         return `my_new_name${file.extension}`;
                //     }
                // });
            },
            business_new_form_submit: function (event) {
                event.preventDefault()
                const formData = new FormData(this.$refs['form']); // reference to form element
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                console.log(data);


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
        },
        mounted: function () {
            this.csrf = window.Laravel.csrfToken
            console.log('newBusinessCreationForm mounted ')
            this.getCardPreNumber();
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
