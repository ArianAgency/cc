<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <ValidationObserver v-slot="{invalid, handleSubmit }">
                    <form ref="form" @submit.prevent="handleSubmit(xsens_new_form_submit($event))">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">

                                    <!--name & x_sens_name_en & business & creator_user-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text" id="name" name="name" class="form-control"
                                                               v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.name:NewformItems.name"
                                                               placeholder="نام"></div>
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
                                                        <input type="text" id="x_sens_name_en" name="x_sens_name_en"
                                                               class="form-control"
                                                               v-model="(indexForEdit>-1 ) ? formItems.x_sens_name_en:NewformItems.x_sens_name_en"
                                                               placeholder="En Name">
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
                                                        <input type="text" id="3" name="business" class="form-control"
                                                               v-model="(indexForEdit>-1) ? formItems.business_name : $parent.user.business.brand_name"
                                                               readonly
                                                               placeholder="کسب و کار مربوط">
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
                                                        <input type="text" id="33" name="creator_user"
                                                               class="form-control "
                                                               v-model="(indexForEdit>-1) ? formItems.creator_user_name : $parent.user.name"
                                                               placeholder="کاربر ایجاد کننده" readonly>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>

                                    <!--business & creator_user & created_at & expire_at-->
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
                                                               v-model="(indexForEdit>-1) ? formItems.business_name : $parent.user.business.brand_name"
                                                               readonly
                                                               placeholder="کسب و کار مربوط"></div>
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
                                                               v-model="(indexForEdit>-1) ? formItems.creator_user_name : $parent.user.name"
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
                                                               v-model="indexForEdit >= 0 ? formItems.created_at  : NewformItems.created_at"
                                                               readonly
                                                               placeholder="تاریخ ایجاد">
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
                                                        <input type="text" id="expire_at" name="expire_at"
                                                               class="form-control "
                                                               v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
                                                               placeholder="تاریخ انقضا">
                                                        <date-picker
                                                            v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
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

                                    <!--first_chord_id & mid_chord_id & last_chord_id & off_chord-->
                                    <div class="form-group">
                                        <div class="input-group-prepend ">
                                            <div class="mydiv">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                        <select id="first_chord_id" name="first_chord_id"
                                                                class="form-control h-100 "
                                                                v-model="formItems.first_chord_id">
                                                            <!--                                                            <option value="0"-->
                                                            <!--                                                                    v-bind:selected="$parent.indexForEdit < 0">نت آغازین-->
                                                            <!--                                                            </option>-->
                                                            <template v-for="chord in $parent.data.chords">
                                                                <option v-if="chord.chord_allowed == '1' "
                                                                        v-bind:value="chord.id_chords"
                                                                        :selected="formItems.first_chord_id === chord.id_chords">
                                                                    {{ chord.chord_name_fa }}
                                                                </option>
                                                            </template>
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
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                        <select id="mid_chord_id" name="mid_chord_id"
                                                                class="form-control h-100 "
                                                                v-model="formItems.mid_chord_id">
                                                            <!--                                                            <option value="0"-->
                                                            <!--                                                                    v-bind:selected="$parent.indexForEdit < 0">نت میانی-->
                                                            <!--                                                            </option>-->
                                                            <template v-for="chord in $parent.data.chords">
                                                                <option v-if="chord.chord_allowed == '2' "
                                                                        v-bind:value="chord.id_chords"
                                                                        :selected="formItems.mid_chord_id === chord.id_chords">
                                                                    {{ chord.chord_name_fa }}
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="mydiv">
                                                <ValidationProvider :rules="!offChordIsEnabled?'required':''"
                                                                    v-slot="{ errors }">
                                                    <div class="myinput">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                        <select id="last_chord_id" name="last_chord_id"
                                                                class="form-control h-100"
                                                                @change="handleChange"
                                                                v-model="formItems.last_chord_id">
                                                            <option value="0"
                                                                    v-bind:selected="$parent.indexForEdit < 0">نت پایانی
                                                            </option>
                                                            <template v-for="chord in $parent.data.chords">
                                                                <option v-if="chord.chord_allowed == '3' "
                                                                        v-bind:value="chord.id_chords"
                                                                        :selected="formItems.last_chord_id === chord.id_chords">
                                                                    {{ chord.chord_name_fa }}
                                                                </option>
                                                            </template>
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
                                                            <span class="input-group-text"><i
                                                                class="fa fa-venus-mars"></i></span>
                                                        <input type="text" id="off_chord" name="off_chord"
                                                               class="form-control"
                                                               v-model="(indexForEdit>-1 ) ? formItems.off_chord:NewformItems.off_chord"
                                                               v-bind:readonly="!offChordIsEnabled"
                                                               placeholder="نوت خارج">
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
                                                      v-model="(indexForEdit>-1 ) ? formItems.description:NewformItems.description"
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
                NewformItems: [],
                is_it_new_registration: 'true',
                offChordIsEnabled: true,
            }
        },
        methods: {

            async xsens_new_form_submit(event) {

                const isValid = await this.$refs.observer.validate();

                if (!isValid) {
                    // ABORT!!
                    swal("نا تمام!", "لطفا همه گزینه های اجباری را پر کنید", "error");
                    return
                }
                const formData = new FormData(this.$refs['form']); // reference to form element
                this.NewformItems.price = this.NewformItems.price + '.00'
                const data = {}; // need to convert it before using not with XMLHttpRequest
                for (let [key, val] of formData.entries()) {
                    Object.assign(data, {[key]: val})
                }
                Object.assign(data, {'is_it_new_registration': this.is_it_new_registration})

                if (this.is_it_new_registration === 'true') {
                    Object.assign(data, {'id_x_senses': 0})
                } else {
                    Object.assign(data, {'id_x_senses': this.formItems.id_x_senses})
                }
                Object.assign(data, {'id_business': this.$parent.user.businesse_id})
                // console.log('this.data = ')
                // console.log(this.data)
                // console.log('this.$parent.user = ')
                // console.log(this.$parent.user.businesse_id)

                axios.post('/admin-panel/xsens/new', data)
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
                this.lastNoteValue = '0'
                this.$parent.getXsensData(`/admin-panel/xsens/index?page=1`)
            },
            handleChange(e) {
                if (e.target.options.selectedIndex > 0) {
                    this.offChordIsEnabled = false
                } else {
                    this.offChordIsEnabled = true
                }
            }
        },
        created: function () {
            // console.log('newXsensCreationForm created ')
            this.data = this.$parent.data.data.data
            // console.log('this.$parent.data')
            // console.log(this.$parent.data)
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
                    this.formItems = this.data[this.$parent.indexForEdit]
                } else {
                    this.is_it_new_registration = 'true';
                    this.formItems = []
                }
                // console.log('indexForEdit is changed = ' + this.indexForEdit)
                // console.log('this.formItems = ')
                // console.log(this.formItems)
            },

        }
    }

</script>

<style>

</style>
