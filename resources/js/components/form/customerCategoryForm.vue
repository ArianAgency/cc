<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>

                <ValidationObserver v-slot="{handleSubmit }" ref="observer">
                    <form ref="form">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <!-- brand_name & company_name -->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ errors }">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-tag"></i>
                                                        </span>
                                                        <input type="text" id="category_name" name="category_name"
                                                               class="form-control"
                                                               v-model:value="formItems.category_name"
                                                               placeholder="نام دسته بندی">
                                                    </div>
                                                    <p class="invalid-feedback d-inline-block mr-2"
                                                       v-show="errors">{{ errors[0]}}
                                                    </p>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-6">

                                                <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="far fa-building"></i>
                                                            </span>
                                                    <input type="text" id="company_name" name="company_name"
                                                           class="form-control"
                                                           readonly="true"
                                                           v-model:value="company_name"
                                                           placeholder=" نام شرکت">
                                                </div>

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
                                        @click.prevent="submitForm_customerCategoryForm">
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
    export default {
        components: {},
        data() {
            return {
                csrf: "",
                formItems: {
                    category_name: '',
                    description: '',
                    categoryId: 0
                },
                company_name: '-',
                newPostURL: '/admin-panel/customer/action/createNewCategory',
                editPostURL: '/admin-panel/customer/action/editCategory',
                postURL: this.newPostURL
            }
        },
        methods: {
            async submitForm_customerCategoryForm(event) {

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
                if (this.formItems.categoryId !== 0) {
                    Object.assign(data, {'id_category': this.formItems.categoryId})
                }

                axios.post(this.postURL, data)
                    .then(response => {
                        console.log(response)
                        if (response.data.status === 'Done') {
                            swal("تمام!", "با موفقیت ثبت شد", "success");
                            this.$root.$emit('NewCategoryAdded')
                            this.resetForm();
                        } else {
                            swal("نا تمام!", "با خطا مواجه شد", "error");
                        }

                    })
                    .catch(e => {
                        if (e.response.data.code == 2) {
                            swal("نا تمام!", "با خطا مواجه شد", "error");
                        } else {
                            alert('error')
                        }
                    })
            },
            resetForm() {
                this.formItems.category_name = ''
                this.formItems.description = ''
                this.customerDetail = [];
                this.$refs.observer.reset();
                this.postURL = this.newPostURL
            },
            async getUserBusiness() {
                var businesse_id = this.$parent.user.businesse_id;
                console.log('businesse_id = ')
                console.log(businesse_id)
                await axios.get('/admin-panel/business/get/bussinessNameByID?businesse_id=' + businesse_id)
                    .then(response => {
                        this.company_name = response.data.response.company_name;
                        // console.log('company_name response= ');
                        // console.log( this.company_name);
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e);
                    })
            },

        },
        created: function () {
            console.log('customerInstantChargeForm created ')

        }
        ,
        mounted: function () {
            console.log('customerInstantChargeForm mounted ')
            this.csrf = window.Laravel.csrfToken
            this.getUserBusiness();
            // console.log ('getUserBusiness = ');
            // console.log (this.getUserBusiness);
            this.$root.$on('EditCategory', (toEdit) => {
                // your code goes here
                this.formItems.category_name = toEdit.category_name;
                this.formItems.description = toEdit.description;
                this.formItems.categoryId = toEdit.id_category;
                this.postURL = this.editPostURL
            })
        }
        ,
        watch: {}
    }

</script>

<style>

</style>
