<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <ValidationObserver v-slot="{invalid, handleSubmit }">
                    <form ref="form" @submit.prevent="handleSubmit(xsens_new_form_submit($event))" autocomplete="on">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">


                                    <!--id_service & id_x_sense-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                            >
                                                                سرویس
                                                            </i>
                                                            </span>
                                                        <select id="id_service" name="id_service"
                                                                class="form-control h-100 "
                                                                v-model="formItems.id_service">
                                                            <!--                                                            <option value="0"-->
                                                            <!--                                                                    v-bind:selected="$parent.indexForEdit < 0">سرویس-->
                                                            <!--                                                            </option>-->
                                                            <template v-for="service in services_list">
                                                                <option
                                                                    v-bind:value="service.id_services"
                                                                    :selected="formItems.service_id === service.id_services">
                                                                    {{ service.name}}
                                                                </option>
                                                            </template>
                                                        </select></div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i>
                                                                شرط
                                                            </i></span>
                                                        <select id="id_x_sense" name="id_x_sense"
                                                                class="form-control h-100 "
                                                                v-model="formItems.id_x_senses">
                                                            <!--                                                            <option value="0"-->
                                                            <!--                                                                    v-bind:selected="$parent.indexForEdit < 0">شرط-->
                                                            <!--                                                            </option>-->
                                                            <template v-for="xsens in xsens_list">
                                                                <option
                                                                    v-bind:value="xsens.id_x_senses"
                                                                    :selected="formItems.x_sens_id === xsens.id_x_senses">
                                                                    {{ xsens.x_sens_name_fa }}
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--business & score_percent & cash_back_percent & cash_back_value-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="integer|required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="number" min="0" id="off_percent" name="off_percent"
                                                               class="form-control"
                                                               v-model=" formItems.off_percent "
                                                               placeholder="درصد تخفیف">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="integer|required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="number" id="score_percent" name="score_percent"
                                                               class="form-control "
                                                               v-model=" formItems.score_percent"
                                                               placeholder="درصد امتیاز">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider rules="integer|required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="number" min="0" id="cash_back_percent"
                                                               name="cash_back_percent"
                                                               class="form-control"
                                                               v-model=" formItems.cash_back_percent "
                                                               v-on:change="formItems.cash_back_percent > 0 ? formItems.cash_back_value=0:null"
                                                               placeholder="درصد کش بک">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider
                                                    :rules="formItems.cash_back_percent == 0 ?'integer|required':''"
                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="number" min="0" id="cash_back_value"
                                                               name="cash_back_value"
                                                               class="form-control"
                                                               v-model="formItems.cash_back_value"
                                                               v-bind:readonly="formItems.cash_back_percent != 0"
                                                               placeholder="مقدار کش بک">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--off_percent & creator_user & created_at & expire_at-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" id="business" name="business"
                                                               class="form-control"
                                                               v-model="formItems.business_name "
                                                               readonly
                                                               placeholder="کسب و کار مربوط">
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
                                                        <input type="text" id="creator_user" name="creator_user"
                                                               class="form-control "
                                                               v-model="formItems.creator_user_name"
                                                               placeholder="کاربر ایجاد کننده" readonly>
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
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="text" id="created_at" name="created_at"
                                                               class="form-control"
                                                               v-model="formItems.created_at"
                                                               readonly
                                                               placeholder="تاریخ ایجاد">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider
                                                    rules="required"
                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="text" id="expire_at" name="expire_at"
                                                               class="form-control "
                                                               v-model="formItems.expire_at "
                                                               placeholder="تاریخ انقضا">
                                                        <date-picker
                                                            v-model="formItems.expire_at "
                                                            element="expire_at"
                                                            format="YYYY-MM-DD"></date-picker>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
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
                                <div class="row">
                                    <div class="col-7"></div>
                                    <div class="form-group form-actions col-2">
                                        <button type="" class="btn btn-border btn-primary  w-100"
                                                v-on:click="xsens_new_form_new($event)">
                                            <i class="far fa-file-alt ml-2"></i>جدید
                                        </button>
                                    </div>
                                    <div class="form-group form-actions col-2 ml-2">
                                        <button type="submit" value="submit" class="btn btn-border btn-success  w-75"
                                                v-bind:disabled="invalid">
                                            <i class="fa fa-check-circle ml-1"></i>ثبت
                                        </button>
                                    </div>
                                </div>
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
        props: ['indexForEdit'],
        data() {
            return {
                is_active_label: '',
                data: '',
                expireDate: '',
                posts: [],
                csrf: "",
                formItems: [],
                is_it_new_registration: 'true',
                services_list: [],
                xsens_list: [],
            }
        },
        methods: {

            async xsens_new_form_submit (event) {

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

                if (this.is_it_new_registration === 'true') {
                    Object.assign(data, {'id_services_x_sense_junction': 0})
                } else {
                    Object.assign(data, {'id_services_x_sense_junction': this.formItems.id})
                }
                Object.assign(data, {'id_business': this.$parent.user.businesse_id})
                // console.log('this.data = ')
                // console.log(this.data)
                // console.log('this.$parent.user = ')
                // console.log(this.$parent.user.businesse_id)

                axios.post('/admin-panel/serXsen/new', data)
                    .then(response => {
                        console.log(response)
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        this.$refs.observer.reset();
                        this.setToNewForm();
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
            xsens_new_form_new: function (event) {
                event.preventDefault()
                this.formItems = []
                this.NewformItems = []
                this.$parent.indexForEdit = -1
                this.is_it_new_registration = "true"
                this.lastNoteValue = '0'
            },
            setToNewForm() {
                this.formItems = []
                this.NewformItems = []
                this.$parent.indexForEdit = -1
                this.is_it_new_registration = "true"
                this.$parent.getSerXsenData(`/admin-panel/serXsen/index?page=1`)
            },
            get_services_and_xsens_list() {
                axios.get('/admin-panel/serXsen/get/serXsenList')
                    .then(response => {
                        console.log('get_services_and_xsens_list = ')
                        console.log(response.data)
                        this.services_list = response.data.services
                        this.xsens_list = response.data.xsenses
                    })
                    .catch(e => {
                        this.errors.push(e)
                        console.log(e)
                    })
            },

        },
        created: function () {
            console.log('newXsensCreationForm created ')
            this.data = this.$parent.data.data
            console.log('this.data')
            console.log(this.data)
            this.get_services_and_xsens_list()
        },
        mounted: function () {
            // console.log('newXsensCreationForm mounted ')
            // console.log('this.$parent.indexForEdit = ' + this.$parent.indexForEdit)
            // console.log('this.formItems = ')
            // console.log(this.formItems.first_chord_id)

            this.csrf = window.Laravel.csrfToken
        },
        watch: {
            indexForEdit: function () {
                if (this.$parent.indexForEdit >= 0) {
                    this.is_it_new_registration = 'false';
                    this.data = this.$parent.data.data
                    this.formItems = this.data[this.$parent.indexForEdit]
                } else {
                    this.is_it_new_registration = 'true';
                    this.formItems = []
                }
                console.log('indexForEdit is changed = ' + this.indexForEdit)
                console.log('this.formItems = ')
                console.log(this.formItems)
            },
            NewformItems: function () {
                console.log('NewformItems = ')
                console.log(this.NewformItems)
            },
            formItems: function () {
                console.log('formItems = ')
                console.log(this.formItems)
            }

        }
    }

</script>

<style>

</style>
