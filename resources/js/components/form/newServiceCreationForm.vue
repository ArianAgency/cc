<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>

                <div class="col-12 mb-4">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#individual" role="tab"
                               aria-controls="individual">تکی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#group" role="tab"
                               aria-controls="group">گروهی</a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="individual" role="tabpanel">
                            <ValidationObserver ref="observer" v-slot="{invalid, handleSubmit }">


                                <form ref="form" @submit.prevent="handleSubmit(service_new_form_submit($event))">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="card-body">

                                                <!--name & sync_code-->
                                                <div class="form-group row">
                                                    <div class="col-6">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-concierge-bell"></i>
                                                            </span>
                                                                <input type="text" id="name" name="name"
                                                                       class="form-control"
                                                                       v-model=" formItems.name"
                                                                       placeholder="نام"></div>
                                                            <p class="invalid-feedback d-inline-block mr-2"
                                                               v-show="errors">{{ errors[0] }}
                                                            </p>
                                                        </ValidationProvider>
                                                    </div>
                                                    <div class="col-6">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                            <span class="input-group-text">
                                                          <i class="fas fa-sync-alt"></i>
                                                            </span>
                                                                <input type="text" id="sync_code" name="sync_code"
                                                                       class="form-control"
                                                                       v-model=" formItems.sync_code"
                                                                       placeholder="کد همگام سازی">
                                                            </div>
                                                            <p class="invalid-feedback d-inline-block mr-2 "
                                                               v-show="errors">{{ errors[0] }}
                                                            </p>
                                                        </ValidationProvider>
                                                    </div>
                                                </div>

                                                <!--price-->
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>
                                                                <input type="text" id="price" name="price"
                                                                       class="form-control"
                                                                       v-model=" formItems.price"
                                                                       placeholder="قیمت">
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
                                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                class="fas fa-audio-description"></i></span>
                                                        </div>
                                                        <textarea class="form-control flex-fill" id="description"
                                                                  placeholder="توضیحات"
                                                                  v-model=" formItems.description"
                                                                  name="description" rows="2"
                                                        />
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card-body">

                                                <!--business & creator_user-->
                                                <div class="form-group row">
                                                    <div class="col-6">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-building"></i>
                                                            </span>
                                                                <input type="text" id="business" name="business"
                                                                       class="form-control"
                                                                       v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.business.brand_name : $parent.user.business.brand_name"
                                                                       readonly
                                                                       placeholder="کسب و کار مربوط"></div>
                                                            <p class="invalid-feedback d-inline-block mr-2"
                                                               v-show="errors">{{ errors[0] }}
                                                            </p>
                                                        </ValidationProvider>
                                                    </div>
                                                    <div class="col-6">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-user-friends"></i>
                                                            </span>
                                                                <input type="text" id="creator_user" name="creator_user"
                                                                       class="form-control "
                                                                       v-model="(indexForEdit>-1 && getAllDataForServiceEditReady) ? formItems.user.name : $parent.user.name"
                                                                       placeholder="کاربر ایجاد کننده" readonly>
                                                            </div>
                                                            <p class="invalid-feedback d-inline-block mr-2 "
                                                               v-show="errors">{{ errors[0] }}
                                                            </p>
                                                        </ValidationProvider>
                                                    </div>
                                                </div>

                                                <!--created_at & expire_at-->
                                                <div class="form-group row">
                                                    <div class="col-6">
                                                        <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </span>
                                                            <input type="text" id="created_at" name="created_at"
                                                                   class="form-control"

                                                                   v-model="indexForEdit >= 0 ? formItems.created_at  : NewformItems.created_at"
                                                                   readonly
                                                                   placeholder="تاریخ ایجاد">
                                                        </div>

                                                    </div>
                                                    <div class="col-6">
                                                        <ValidationProvider rules="required"
                                                                            v-slot="{ errors }">
                                                            <div class="input-group">
                                                           <span class="input-group-text">
                                                               <i class="fas fa-calendar-times"></i>
                                                           </span>
                                                                <input type="text" id="expire_at" name="expire_at"
                                                                       class="form-control"
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

                                                <!--Category-->
                                                <div class="form-group ">
                                                    <div class="input-group">
                                                        <multiselect
                                                            v-model="formItems.category.selectedList" id=""
                                                            track-by="category_name" placeholder="افزودن دسته بندی"
                                                            open-direction="bottom"
                                                            :options="formItems.category.rawList"
                                                            :multiple="true" :searchable="true"
                                                            :loading="formItems.category.isLoading"
                                                            :internal-search="true"
                                                            :clear-on-select="false" :close-on-select="false"
                                                            :options-limit="300" :limit="3" :limit-text="limitText"
                                                            :max-height="600" :show-no-results="false"
                                                            :hide-selected="true" @search-change="asyncFindCategory"
                                                            label="category_name"
                                                            :custom-label="nameFormatter">
                                                            <template slot="tag" slot-scope="{ option, remove }">
                                                <span class="custom__tag">
                                                    <span>{{ option.category_name }}</span>
                                                    <span class="custom__remove" @click="remove(option)">❌</span>
                                                </span>
                                                            </template>
                                                            <template slot="clear" slot-scope="props">
                                                                <div class="multiselect__clear"
                                                                     v-if="formItems.category.selectedList.length"
                                                                     @mousedown.prevent.stop="clearAll(props.search)"></div>
                                                            </template>
                                                            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                                                        </multiselect>
                                                    </div>
                                                </div>

                                                <!--Tag-->
                                                <div class="form-group ">
                                                    <div class="input-group">
                                                        <multiselect
                                                            v-model="formItems.tag.selectedList"
                                                            track-by="tag_name" placeholder="افزودن نشانه"
                                                            open-direction="bottom"
                                                            :options="formItems.tag.rawList"
                                                            :multiple="true" :searchable="true"
                                                            :loading="formItems.tag.isLoading"
                                                            :internal-search="true"
                                                            :clear-on-select="false" :close-on-select="false"
                                                            :options-limit="300" :limit="3" :limit-text="limitText"
                                                            :max-height="600" :show-no-results="false"
                                                            :hide-selected="true" @search-change="asyncFindTag"
                                                            label="tag_name"
                                                            :custom-label="nameFormatter_tag">
                                                            <template slot="tag" slot-scope="{ option, remove }">
                                                <span class="custom__tag">
                                                    <span>{{ option.tag_name }}</span>
                                                    <span class="custom__remove" @click="remove(option)">❌</span>
                                                </span>
                                                            </template>
                                                            <template slot="clear" slot-scope="props">
                                                                <div class="multiselect__clear"
                                                                     v-if="formItems.tag.selectedList.length"
                                                                     @mousedown.prevent.stop="clearAll(props.search)"></div>
                                                            </template>
                                                            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                                                        </multiselect>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7"></div>
                                        <div class="form-group form-actions col-2">

                                            <button type="" class="btn btn-border btn-primary  w-100"
                                                    v-on:click.prevent="service_new_form_new($event)">
                                                <i class="far fa-file-alt ml-2"></i>جدید
                                            </button>
                                        </div>
                                        <div class="form-group form-actions col-2 ml-2">
                                            <button type="submit" value="submit"
                                                    class="btn btn-border btn-success  w-75">
                                                <i class="fa fa-check-circle ml-1"></i>ثبت
                                            </button>
                                        </div>

                                    </div>

                                </form>
                            </ValidationObserver>
                        </div>

                        <div class="tab-pane" id="group" role="tabpanel">
                            <div>
                                <vue-csv-import
                                    v-model="csv"
                                    url="/admin-panel/service/new/group"
                                    :callback="submit"
                                    :map-fields="{
                                     id_business:'کد کسب و کار',
                                     name: 'نام خدمت یا محصول',
                                     sync_code:'کد همگام سازی',
                                     description:'توضیحات',
                                     price:'قیمت',
                                     expire_at:'انقضا',
                                    }"
                                    :autoMatchFields="true">
                                    <template slot="hasHeaders" slot-scope="{headers, toggle}">
                                        <label>
                                            <input type="checkbox" id="hasHeaders" :value="headers" @change="toggle">
                                            فایل دارای هدر است؟
                                        </label>
                                    </template>

                                    <template slot="error">
                                        File type is invalid
                                    </template>

                                    <template slot="thead">
                                        <tr>
                                            <th>ورودی ها</th>
                                            <th>ستون</th>
                                        </tr>
                                    </template>

                                    <template slot="next" slot-scope="{load}">
                                        <button class="btn-blue" @click.prevent="load">بارگذاری</button>
                                    </template>

                                    <template slot="submit" slot-scope="{submit}">
                                        <button class="btn-green" @click.prevent="submit">ارسال!</button>
                                    </template>


                                </vue-csv-import>
                            </div>
                        </div>
                    </div>
                </div>
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
            csv: [],
            is_active_label: '',
            data: '',
            expireDate: '',
            posts: [],
            csrf: "",
            formItems: {
                category: {
                    isLoading: false,
                    selectedList: [],
                    rawList: []
                },
                tag: {
                    isLoading: false,
                    selectedList: [],
                    rawList: []
                },
            },
            NewformItems: [],
            is_it_new_registration: 'true',
            Now: '',
            getAllDataForServiceEditReady: false,

        }
    },
    methods: {
        submit() {
            // console.log('csv = ');
            // console.log(this.csv);
            swal("تمام!", "با موفقیت ثبت شد", "success");
        },
        async service_new_form_submit(event) {

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
            Object.assign(data, {'is_it_new_registration': this.is_it_new_registration});

            if (this.is_it_new_registration === 'true') {
                Object.assign(data, {'id_services': 0})
            } else {
                Object.assign(data, {'id_services': this.formItems.id_services})
            }

            Object.assign(data, {'id_business': this.$parent.user.businesse_id});

            Object.assign(data, {'categories': JSON.stringify(this.formItems.category.selectedList)});
            Object.assign(data, {'tags': JSON.stringify(this.formItems.tag.selectedList)});

            console.log('this.data = ');
            console.log(this.data);
            // console.log('this.$parent.user = ')
            // console.log(this.$parent.user.businesse_id)

            axios.post('/admin-panel/service/new/individual', data)
                .then(response => {
                    console.log(response);
                    swal("تمام!", "با موفقیت ثبت شد", "success");
                    this.$refs.observer.reset();
                    this.$parent.indexForEdit = -1;
                    this.$parent.initData();
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
        service_new_form_new: function (event) {
            event.preventDefault()
            this.getAllDataForServiceEditReady = true
            this.formItems = []
            this.$parent.indexForEdit = -1
        },
        getAllDataForServiceEdit(businessID, userID) {
            console.log('getAllDataForServiceEdit')
            this.getAllDataForServiceEditReady = false
            axios.get('/admin-panel/service/get/getAllDataForServiceEdit?businessID=' + businessID + '&userID=' + userID)
                .then(response => {
                    console.log('response = ' + response)
                    this.formItems.business = response.data.business
                    this.formItems.user = response.data.user
                    console.log('formItems[business] = ' + response.data.business.brand_name)
                    console.log('formItems[business] = ' + this.formItems.business.brand_name)
                    console.log('formItems[user] = ' + this.formItems.user.name)
                })
                .catch(e => {
                    // this.errors.push(e)
                    console.log(e)
                })
        },
        populateFormInputIfIsForEdit() {
            console.log('populateFormInputIfIsForEdit');
            console.log('this.$parent.indexForEdit = ');
            console.log(this.$parent.indexForEdit);
            if (this.$parent.indexForEdit >= 0) {

                this.mix(this.data[this.$parent.indexForEdit], this.formItems);
                axios.get('/admin-panel/service/get/selectedCategoriesAndTags?id_services=' + this.formItems.id_services)
                    .then(response => {
                        console.log(response);
                        this.formItems.category.selectedList = response.data.serviceSelectedCategoriesName;
                        this.formItems.tag.selectedList = response.data.serviceSelectedTagsName;
                        console.log('CatSelectedList = ');
                        console.log(this.formItems.category.selectedList);
                        console.log('TagSelectedList = ');
                        console.log(this.formItems.tag.selectedList);
                    })
                    .catch(e => {
                        console.log(e)
                    })
                // console.log('after = ')
                // console.log(this.formItems)
            }
        },
        setToNewForm() {
            console.log('setToNewForm*******');
            let tempObj = {
                category: {
                    isLoading: false,
                    selectedList: [],
                    rawList: []
                },
                tag: {
                    isLoading: false,
                    selectedList: [],
                    rawList: []
                },
            };

            console.log('tempObj = ');
            console.log(tempObj);
            this.formItems = tempObj;
            this.is_it_new_registration = "true";
            this.$parent.getServiceData(`/admin-panel/service/index?page=1`);
            if (this.$parent.indexForEdit >= 0) {
                this.$parent.indexForEdit = -1;
            }
        },
        getNow: function () {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            console.log(dateTime)
            this.Now = dateTime;
        },
        //multi select box
        limitText(count) {
            return `and ${count} `
        },
        asyncFindCategory(query) {
            if (query.length === 0) {
                this.formItems.category.rawList = [];
                return;
            }
            console.log(query)
            this.formItems.category.isLoading = true
            axios.get('/admin-panel/service/get/categoriesByBusiness?filter=' + query)
                .then(response => {
                    console.log('response = ')
                    console.log(response)
                    this.formItems.category.rawList = response.data.categoriesByBusiness;
                    this.formItems.category.isLoading = false
                })
                .catch(e => {
                    console.log(e)
                })
        },
        asyncFindTag(query) {
            if (query.length === 0) {
                this.formItems.tag.rawList = [];
                return;
            }
            this.formItems.tag.isLoading = true
            axios.get('/admin-panel/service/get/tagsByBusiness?filter=' + query)
                .then(response => {
                    console.log('response = ')
                    console.log(response)
                    this.formItems.tag.rawList = response.data.tagsByBusiness;
                    this.formItems.tag.isLoading = false
                })
                .catch(e => {
                    console.log(e)
                })
        },
        clearAll() {
            this.formItems.category.selectedList = []
        },
        nameFormatter({category_name}) {
            return `${category_name}`;
        },
        nameFormatter_tag({tag_name}) {
            return `${tag_name}`;
        },
        mix(source, target) {
            // console.log('source');
            // console.log(source);
            // console.log('target');
            // console.log(target);
            for (var key of Object.keys(source)) {
                if (source.hasOwnProperty(key)) {
                    target[key] = source[key];
                    // console.log('target = ')
                    // console.log(target)
                }
            }
        },
        setAll(obj, val) {
            /* Duplicated with @Maksim Kalmykov
                for(index in obj) if(obj.hasOwnProperty(index))
                    obj[index] = val;
            */
            Object.keys(obj).forEach(function (index) {
                obj[index] = val
            });
        }
    },
    created: function () {
        console.log('newCustomerCreationForm created ');
        this.data = this.$parent.data.data.data;
        console.log('this.data  = ');
        console.log(this.data);
    },
    mounted: function () {
        console.log('newCustomerCreationForm mounted ');
        this.csrf = window.Laravel.csrfToken;
        this.populateFormInputIfIsForEdit();
        if (this.$parent.indexForEdit >= 0) {
            this.is_it_new_registration = 'false';
        }
        this.getNow();
    },
    watch: {
        indexForEdit: function () {
            this.populateFormInputIfIsForEdit();
            if (this.$parent.indexForEdit >= 0) {
                this.is_it_new_registration = 'false';
            } else {
                this.is_it_new_registration = 'true';
                this.setToNewForm();
            }
        },

    }
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

</style>
