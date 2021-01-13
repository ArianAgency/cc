<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <ValidationObserver v-slot="{invalid, handleSubmit } " ref="observer">
                    <form ref="form" @submit.prevent="handleSubmit(xsens_new_form_submit($event))">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">

                                    <!--x_sens_name_fa & x_sens_name_en & company_name & brand_name-->
                                    <div class="form-group row">
                                        <!--x_sens_name_fa-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-signature"></i>
                                                            </span>
                                                    <input type="text" id="x_sens_name_fa" name="x_sens_name_fa"
                                                           class="form-control"
                                                           v-model=" formItems.x_sens_name_fa"
                                                           placeholder="نام"></div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <!--x_sens_name_en-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-language"></i>
                                                            </span>
                                                    <input type="text" id="x_sens_name_en" name="x_sens_name_en"
                                                           class="form-control"
                                                           v-model="formItems.x_sens_name_en"
                                                           placeholder="En Name">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <!--company_name-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-building"></i>
                                                            </span>
                                                    <input type="text" id="3" name="company_name" class="form-control"
                                                           :value="(indexForEdit>-1) ? formItems.company_name : user.business.company_name"
                                                           readonly
                                                           placeholder="شرکت">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>

                                    </div>

                                    <!--creator_user & created_at & expire_at-->
                                    <div class="form-group row">
                                        <!--creator_user-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-user-friends"></i>
                                                            </span>
                                                    <input type="text" id="creator_user" name="creator_user"
                                                           class="form-control "
                                                           :value="(indexForEdit>-1) ? formItems.creator_user_name : (user.name+' '+user.family)"
                                                           placeholder="کاربر ایجاد کننده" readonly>
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <!--created_at-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-check"></i>
                                                            </span>
                                                    <input type="text" id="created_at" name="created_at"
                                                           class="form-control"
                                                           :value="indexForEdit >-1 ? formItems.created_at  :getTime()"
                                                           readonly
                                                           placeholder="تاریخ ایجاد">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <!--brand_name-->
                                        <div class="col-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                               <i class="far fa-building"></i>
                                                            </span>
                                                    <input type="text" name="brand_name"
                                                           class="form-control "
                                                           :value="(indexForEdit>-1) ? formItems.brand_name : user.business.brand_name"
                                                           placeholder="برند" readonly>
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>

                                        <!--expire_at-->
<!--                                        <div class="col-4">-->
<!--                                            <ValidationProvider rules="required"-->
<!--                                                                v-slot="{ errors }">-->
<!--                                                <div class="input-group">-->
<!--                                                            <span class="input-group-text">-->
<!--                                                                <i class="far fa-calendar-times"></i>-->
<!--                                                            </span>-->
<!--                                                    <input type="text" id="expire_at" name="expire_at"-->
<!--                                                           class="form-control "-->
<!--                                                           v-model="formItems.expire_at"-->
<!--                                                           placeholder="تاریخ انقضا">-->
<!--                                                    <date-picker-->
<!--                                                        v-model=" formItems.expire_at "-->
<!--                                                        element="expire_at"-->
<!--                                                        format="YYYY-MM-DD"></date-picker>-->
<!--                                                </div>-->
<!--                                                <p class="invalid-feedback d-inline-block mr-2 "-->
<!--                                                   v-show="errors">{{ errors[0] }}-->
<!--                                                </p>-->
<!--                                            </ValidationProvider>-->
<!--                                        </div>-->
                                    </div>

                                    <!--first_chord_id & mid_chord_id & last_chord_id & off_chord-->
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
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
                                        <div class="col-3">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
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
                                        <div class="col-3">
                                            <ValidationProvider :rules="!offChordIsEnabled?'required':''"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                class="fas fa-book"></i></span>
                                                    <select id="last_chord_id" name="last_chord_id"
                                                            class="form-control h-100"
                                                            @change="handleChange"
                                                            v-model="formItems.last_chord_id">
                                                        <option value="0"
                                                                v-bind:selected="indexForEdit < 0">نت پایانی
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
                                        <div class="col-3">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ errors }">
                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-power-off"></i>
                                                            </span>
                                                    <input type="text" id="off_chord" name="off_chord"
                                                           class="form-control"
                                                           v-model="formItems.off_chord"
                                                           :readonly="!offChordIsEnabled"
                                                           placeholder="نوت خارج">
                                                </div>
                                                <p class="invalid-feedback d-inline-block mr-2 "
                                                   v-show="errors">{{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>

                                    <!--description-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                               <i class="fas fa-audio-description"></i>
                                            </span>
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
                                                >
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
        props: ['indexForEdit', 'user','data'],
        data() {
            return {
                is_active_label: '',
                data: '',
                expireDate: '',
                posts: [],
                csrf: "",
                formItems: [],
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
                            alert('error');
                        }
                    })
            },
            xsens_new_form_new: function (event) {
                event.preventDefault();
                this.formItems = [];;
                this.NewformItems = [];
                this.$parent.indexForEdit = -1;
                this.is_it_new_registration = "true";
                this.lastNoteValue = '0';
            },
            setToNewForm() {
                this.formItems = [];
                this.NewformItems = [];
                this.$parent.indexForEdit = -1;
                this.is_it_new_registration = "true";
                this.lastNoteValue = '0';
                this.$parent.getXsensData(`/admin-panel/xsens/index?page=1`);
            },
            handleChange(e) {
             console.log('e.target.options.selectedIndex = ');
             console.log(e.target.options.selectedIndex);
                if (e.target.options.selectedIndex > 0) {
                    this.offChordIsEnabled = false;
                } else {
                    this.offChordIsEnabled = true;
                }
            },
            getTime() {
                // console.log('date = ');
                let date;
                date = new Date();
                date = date.getUTCFullYear() + '-' +
                    ('00' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('00' + date.getDate()).slice(-2);
                // + ' ' +
                // ('00' + date.getHours()).slice(-2) + ':' +
                // ('00' + date.getMinutes()).slice(-2) + ':' +
                // ('00' + date.getSeconds()).slice(-2);
                // console.log(date);
                return date;
            }
        },
        created: function () {
            console.log('newXsensCreationForm created ')
        },
        mounted: function () {
            console.log('newXsensCreationForm mounted ')
            this.csrf = window.Laravel.csrfToken
        },
        watch: {
            indexForEdit: function () {
                if (this.indexForEdit >-1) {;
                    this.is_it_new_registration = 'false';
                    this.formItems = this.data[this.indexForEdit]
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
