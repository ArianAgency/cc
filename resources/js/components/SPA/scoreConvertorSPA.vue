<template>

    <div >
        <div class="card div-body animated fadeIn" v-if="mode === 'form'">

            <template >
                <div class="card-header">
                    <div class="mytitle">
                        <i class="fa fa-align-justify"></i>
                        <span>تبدیل امتیاز</span>
                    </div>
                    <div class="mybtn" v-on:click="mode='table'">
                        <button href="#" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            لیست
                        </button>
                    </div>
                </div>

                <ValidationObserver ref="observer" v-slot="{invalid, handleSubmit }">
                    <form ref="form"
                          @submit.prevent="">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <!-- convertor_name & score_cost -->
                                        <div class="form-group row">
                                            <!-- convertor_name -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-tags"></i>
                                                        </span>
                                                        <input type="text" id="convertor_name" name="convertor_name"
                                                               class="form-control"
                                                               v-model:value="formItems.convertor_name"
                                                               placeholder="نام تبدیل">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <!-- score_cost -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-tags"></i>
                                                        </span>
                                                        <input type="number" id="score_cost" name="score_cost"
                                                               class="form-control"
                                                               v-model:value="formItems.score_cost"
                                                               placeholder="امتیاز مورد نیاز">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- off_percent & off_value -->
                                        <div class="form-group row">
                                            <!-- off_percent -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-tags"></i>
                                                        </span>
                                                        <input type="number" id="off_percent" name="off_percent"
                                                               class="form-control"
                                                               v-model:value="formItems.off_percent"
                                                               placeholder="درصد تخفیف">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <!-- off_value -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-tags"></i>
                                                        </span>
                                                        <input type="text" id="off_value" name="off_value"
                                                               class="form-control"
                                                               v-model:value="formItems.off_value"
                                                               placeholder="مبلغ تخفیف">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- available & expire -->
                                        <div class="form-group row">
                                            <!-- available -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                           <span class="input-group-text"><i
                                                               class="fa fa-birthday-cake"></i></span>

                                                        <input type="text" id="available" name="available"
                                                               class="form-control"
                                                               v-model="formItems.available"
                                                               placeholder="تاریخ شروع">
                                                        <date-picker v-model="formItems.available"
                                                                     element="available"
                                                                     format="YYYY-MM-DD"></date-picker>
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2 "
                                                       v-show="errors">{{ errors[0] }}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <!-- expire -->
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                           <span class="input-group-text"><i
                                                               class="fa fa-birthday-cake"></i></span>

                                                        <input type="text" id="expire" name="expire"
                                                               class="form-control"
                                                               v-model="formItems.expire"
                                                               placeholder="تاریخ اعتبار">
                                                        <date-picker v-model="formItems.expire"
                                                                     element="expire"
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="form-group form-actions col-2">

                                <button type="" class="btn btn-border btn-primary  w-100"
                                        v-on:click.prevent="resetForm($event)">
                                    <i class="far fa-file-alt ml-2"></i>جدید
                                </button>
                            </div>
                            <div class="form-group form-actions col-2 ml-2">
                                <button type="submit" value="submit" class="btn btn-border btn-success  w-75"
                                        @click.prevent="submitMode==='new' ?
                       handleSubmit(form_new_submit($event)):
                        handleSubmit(form_edit_submit($event)) ">
                                    <i class="fa fa-check-circle ml-1"></i>
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </form>
                </ValidationObserver>
            </template>

        </div>
        <table-template v-if="mode==='table'"
                               title="تبدیلات امتیاز"
                               :headers="['عنوان','مقدار تخفیف','درصد تخفیف','امتیاز لازم','اعتبار تا','فعال شده در']"
                               :value-keys="['convertor_name','off_value','off_percent','score_cost','expire','created_at']"
                               :get-url="'/admin-panel/score_convertor/get/convertor_list'"
                               :pagination="true"
                               :has-edit="true"
                               @edit="edit"
                               :has-add-button='true'
                               @change="mode='form'"
    />
    </div>

</template>

<script>

import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    components: {
        datePicker: VuePersianDatetimePicker
    },
    name: "scoreConvertorSPA",
    props: ['activeView'],
    data() {
        return {
            formItems: {
                convertor_name: '',
                score_cost: '',
                off_percent: '',
                off_value: '',
                description: '',
                available: '',
                expire: ''
            },
            mode: 'table',
            submitMode: 'new',
        }
    },

    methods: {
        resetForm() {
            this.formItems = {};
            this.submitMode = 'new';
        },
        async form_new_submit(event) {

            const isValid = await this.$refs.observer.validate();

            if (!isValid) {
                // ABORT!!
                swal("نا تمام!", "لطفا همه گزینه های اجباری را پر کنید", "error");
                return
            }
            if (!this.formItems.off_value.includes(".")) {
                this.formItems.off_value = this.formItems.off_value + '.00';
                $("#off_value").val(this.formItems.off_value);
            }

            const formData = new FormData(this.$refs['form']); // reference to form element

            const data = {}; // need to convert it before using not with XMLHttpRequest
            for (let [key, val] of formData.entries()) {
                Object.assign(data, {[key]: val})
            }

            // Object.assign(data, {'categories': JSON.stringify(this.formItems.category.selectedList)});
            // Object.assign(data, {'tags': JSON.stringify(this.formItems.tag.selectedList)});

            axios.post('/admin-panel/score_convertor/do/add_new', data)
                .then(response => {
                    console.log(response);
                    swal("تمام!", "با موفقیت ثبت شد", "success");
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
        async form_edit_submit(event) {

            const isValid = await this.$refs.observer.validate();

            if (!isValid) {
                // ABORT!!
                swal("نا تمام!", "لطفا همه گزینه های اجباری را پر کنید", "error");
                return
            }
            if (!this.formItems.off_value.includes(".")) {
                this.formItems.off_value = this.formItems.off_value + '.00';
                $("#off_value").val(this.formItems.off_value);
            }

            const formData = new FormData(this.$refs['form']); // reference to form element

            const data = {}; // need to convert it before using not with XMLHttpRequest
            for (let [key, val] of formData.entries()) {
                Object.assign(data, {[key]: val})
            }

            Object.assign(data, {'id_score_convertor': JSON.stringify(data.id_score_convertor)});

            // Object.assign(data, {'categories': JSON.stringify(this.formItems.category.selectedList)});
            // Object.assign(data, {'tags': JSON.stringify(this.formItems.tag.selectedList)});

            axios.post('/admin-panel/score_convertor/do/edit', data)
                .then(response => {
                    console.log(response);
                    swal("تمام!", "با موفقیت ثبت شد", "success");
                    this.$refs.observer.reset();
                    this.resetForm();
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
        edit(data) {
            this.mode = 'form';
            this.submitMode = 'edit';
            this.formItems = data;
        }
    },
    created: function () {
        this.mode = this.activeView;
    },
}
</script>

<style scoped>

</style>
