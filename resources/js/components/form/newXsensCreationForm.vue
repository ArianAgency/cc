<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>
                <form action="" method="post" ref="form" name="xsens_new_form" autocomplete="on">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="x_sens_name_fa" name="x_sens_name_fa"
                                                   class="form-control"
                                                   v-model="(indexForEdit>-1 ) ? formItems.x_sens_name_fa : NewformItems.x_sens_name_fa"
                                                   placeholder="نام">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                            <input type="text" id="x_sens_name_en" name="x_sens_name_en"
                                                   class="form-control"
                                                   v-model="(indexForEdit>-1 ) ? formItems.x_sens_name_en:NewformItems.x_sens_name_en"
                                                   placeholder="En Name">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                            <input type="text" id="3" name="business" class="form-control"
                                                   v-model="(indexForEdit>-1) ? formItems.business_name : $parent.user.business.brand_name"
                                                   readonly
                                                   placeholder="کسب و کار مربوط">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i
                                                class="fab fa-internet-explorer"></i></span>
                                            <input type="text" id="33" name="creator_user"
                                                   class="form-control "
                                                   v-model="(indexForEdit>-1) ? formItems.creator_user_name : $parent.user.name"
                                                   placeholder="کاربر ایجاد کننده" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                                        <div class="input-group">
                                            <input type="text" id="business" name="business" class="form-control"
                                                   v-model="(indexForEdit>-1) ? formItems.business_name : $parent.user.business.brand_name"
                                                   readonly
                                                   placeholder="کسب و کار مربوط">
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i
                                                class="fab fa-internet-explorer"></i></span>
                                            <input type="text" id="creator_user" name="creator_user"
                                                   class="form-control "
                                                   v-model="(indexForEdit>-1) ? formItems.creator_user_name : $parent.user.name"
                                                   placeholder="کاربر ایجاد کننده" readonly>
                                        </div>
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-text"><i
                                            class="fab fa-creative-commons-zero"></i></span>
                                        <input type="text" id="created_at" name="created_at" class="form-control"
                                               v-model="indexForEdit >= 0 ? formItems.created_at  : NewformItems.created_at"
                                               readonly
                                               placeholder="تاریخ ایجاد">
                                        <span class="input-group-addon"></span>
                                        <div class="input-group-prepend col-3">
                                            <span class="input-group-text"><i class="fas fa-trash"></i></span>
                                            <input type="text" id="expire_at" name="expire_at" class="form-control "
                                                   v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
                                                   placeholder="تاریخ انقضا">
                                            <date-picker
                                                v-model="indexForEdit >= 0 ? formItems.expire_at :NewformItems.expire_at "
                                                element="expire_at"
                                                format="YYYY-MM-DD"></date-picker>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        <div class="input-group">
                                            <select id="first_chord_id" name="first_chord_id"
                                                    class="form-control h-100 ">
                                                <option value="0"
                                                        v-bind:selected="$parent.indexForEdit < 0">نت آغازین
                                                </option>
                                                <template v-for="chord in $parent.data.chords">
                                                    <option v-if="chord.chord_allowed == '1' "
                                                            v-bind:value="chord.id_chords"
                                                            :selected="formItems.first_chord_id === chord.id_chords">
                                                        {{ chord.chord_name_fa }}
                                                    </option>
                                                </template>
                                            </select>

                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <select id="mid_chord_id" name="mid_chord_id" class="form-control h-100 ">
                                                <option value="0"
                                                        v-bind:selected="$parent.indexForEdit < 0">نت میانی
                                                </option>
                                                <template v-for="chord in $parent.data.chords">
                                                    <option v-if="chord.chord_allowed == '2' "
                                                            v-bind:value="chord.id_chords"
                                                            :selected="formItems.mid_chord_id === chord.id_chords">
                                                        {{ chord.chord_name_fa }}
                                                    </option>
                                                </template>
                                            </select>
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <select id="last_chord_id" name="last_chord_id" class="form-control h-100"
                                                    @change="handleChange">
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
                                            <span class="input-group-addon"></span>
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                            <input type="text" id="off_chord" name="off_chord" class="form-control"
                                                   v-model="(indexForEdit>-1 ) ? formItems.off_chord:NewformItems.off_chord"
                                                   v-bind:readonly="!offChordIsEnabled"
                                                   placeholder="نوت خارج">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                class="fas fa-audio-description"></i></span>
                                        </div>
                                        <textarea class="form-control flex-fill" id="description" placeholder="توضیحات"
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
                                    <button type="submit" class="btn btn-border btn-success  w-100"
                                            v-on:click="xsens_new_form_submit($event)">
                                        <i class="fa fa-check-circle ml-2"></i>ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

            xsens_new_form_submit: function (event) {
                event.preventDefault()
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

                axios.post('http://127.0.0.1:8000/admin-panel/xsens/new', data)
                    .then(response => {
                        console.log(response)
                        alert('با موفقیت ثبت شد')
                        this.setToNewForm();
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
                this.$parent.getXsensData(`http://127.0.0.1:8000/admin-panel/xsens/index?page=1`)
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
