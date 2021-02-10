<template>
    <!--
     <table-template v-if="Mode==='table'"
                        title="تخفیفات"                                                 #page title
                        :headers=  "['erwe']"                                           #table headers title / Array
                        :value-keys="['invoice_no']"                                    #table key values / Array
                        :get-url="'/customer-panel/testTable/get/history'"              #get url
                        search-bar="true"                                               #true if has search bar
                        has-delete="true"                                               #true if has delete btn
                        :delete-url="'/customer-panel/testTable/do/delete'"             #delete url
                        delete-by="invoice_no"                                          #delete from table with this key
                        has-more-info="true"                                            #true if need second more data
                        :get-more-url="'/customer-panel/testTable/get/invoiceItems'"    #get more url
                        get-more-key="invoice_number"                                   #get more with this key
                        has-edit="true"                                                 #true if has edit btn
                        has-disable="true"                                              #true if has disable btn
                        :disable-url="'/customer-panel/testTable/do/disable'"           #url for disabling item
                        disable-by="invoice_no"                                         #disable from db with this key
                        @edit="edit "                                                   #edit function to call when edit btn pressed
                        pagination                                                      #true if api has pagination support
        ></table-template>
    -->
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <div class="card-header d-flex justify-content-between">
                    <div >
                        <i class="fa fa-align-justify pl-1"></i>
                        <span>{{ tableTitle }}</span>
                    </div>
                    <div class="mybtn">
                        <button href="#" class="btn btn-success"
                                v-on:click="changeToForm"
                                v-if="hasAddButton">
                            <i class="fas fa-plus"></i>
                            افزودن
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row " v-if="!noMoreDataIsAvailable">

                        <!--invoice_number-->
                        <div class="form-group col">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </span>
                                <input type="text" id="invoice_number" name="invoice_number"
                                       class="form-control "
                                       :value="items[0].invoice_no"
                                       readonly="true">

                            </div>
                        </div>

                        <!--created_at-->
                        <div class="form-group col">
                            <div class="input-group">
                                                <span class="input-group-text">
                                                   <i class="fas fa-calendar-day"></i>
                                                </span>
                                <input type="text" id="created_at" name="created_at"
                                       class="form-control "
                                       :value="items[0].created_at"
                                       readonly="true">
                            </div>
                        </div>

                        <!--items_count-->
                        <div class="form-group col-2">
                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-list-ol"></i>
                                                </span>
                                <input type="text" id="items_count" name="items_count"
                                       class="form-control "
                                       :value="items.length"
                                       readonly="true">
                            </div>
                        </div>

                        <div class="row col justify-content-end">
                            <div class="form-group ml-2">
                                <button class="btn  btn-primary  "
                                        @click="noMoreDataIsAvailable = true">
                                    بازگشت <i class="fas fa-chevron-left"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="row" v-if="searchBar">
                        <div class="col-6">
                            <autocomplete
                                :search="search"
                                placeholder="فاکتور را جستجو کنید"
                                :get-result-value="getResultValue"
                                :debounce-time="500"
                                @submit="handleSearchSubmit"
                            ></autocomplete>
                        </div>
                        <div class="col-6 align-middle">
                            <div class="form-group row justify-content-end ">
                                <label class="col-md-3 col-form-label">
                                    جستجو بر اساس
                                </label>
                                <div class="col-md-5 col-form-label">
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode= 'invoice_no'" class="form-check-input"
                                               type="radio" checked="checked"
                                               id="invoice_no" value="invoice_no" name="inline-radios">
                                        <label class="form-check-label" for="invoice_no">شماره</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode='value_after_off_total'" class="form-check-input"
                                               type="radio" id="value_after_off_total"
                                               value="value_after_off_total" name="inline-radios">
                                        <label class="form-check-label" for="value_after_off_total">ارزش</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'created_at'" class="form-check-input" type="radio"
                                               id="filter_created_at"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">تاریخ</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'customer_mobile'" class="form-check-input"
                                               type="radio"
                                               id="customer_mobile"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">موبایل</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input @change="searchMode = 'customer_card_number'" class="form-check-input"
                                               type="radio"
                                               id="customer_card_number"
                                               value="created_at" name="inline-radios">
                                        <label class="form-check-label" for="filter_created_at">کارت</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table class="table table-responsive-sm table-striped ">

                        <!--Main Table Header-->
                        <thead v-if="noMoreDataIsAvailable">
                        <tr>
                            <th>ردیف</th>
                            <th v-for="(headerTitle,index) in headers">
                                {{ headerTitle }}
                            </th>
                        </tr>
                        </thead>

                        <!--More Data table Header-->
                        <thead v-else>
                        <tr>
                            <th>ردیف</th>
                            <th v-for="(headerTitle,index) in headers2">
                                {{ headerTitle }}
                            </th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <!--Main Table data-->
                        <tr v-for="(data,index) in dataList" v-if="noMoreDataIsAvailable">
                            <td>{{ index + 1 }}</td>

                            <!--                            <td v-for="(value,key) in data"-->
                            <!--                                v-if=" valueKeys.includes(key)">-->
                            <!--                                {{'data['+key+'] = ' + data[key]}}-->
                            <!--                            </td>-->

                            <td v-for="(key) in valueKeys">
                                {{ data[key] }}
                            </td>


                            <td v-if="hasDisable">
                                <label class="switch switch-text switch-pill switch-info-outline-alt">
                                    <input type="checkbox" class="switch-input" v-bind:checked="data.is_active"
                                           v-bind:id="'sw_'+data[disableBy]"
                                           v-on:click="check($event,data[disableBy])">
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </td>

                            <!--get more-->
                            <td v-on:click="getMore(data)"
                                v-if="hasMoreInfo">
                                <a href="#">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>

                            <!--delete-->
                            <td v-on:click="deleteRow(data)"
                                v-if="hasDelete">
                                <a href="#">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                            <!--Edit-->
                            <td v-on:click="editRowData(data)"
                                v-if="hasEdit">
                                <a href="#">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                            <!--callback-->
                            <template v-if="hasCallBack">
                                <td v-on:click="callBackData(data)"
                                    v-if="typeof data[disableCallBackOn] === 'undefined' ">
                                    <a href="#">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                </td>
                                <td v-on:click="callBackData(data)"
                                    v-else-if=" data[disableCallBackOn]===null ">
                                    <a href="#">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                </td>
                                <td v-else class="activated" >
                                    فعال
                                </td>


                            </template>


                        </tr>

                        <!--More Data table data-->

                        <tr v-for="(item,index) in items" v-if="!noMoreDataIsAvailable">
                            <td>{{ index + 1 }}</td>
                            <td v-for="(value,key) in item"
                                v-if=" valueKeys2.includes(key)">
                                {{ value }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <template>
                        <vue-content-loading :width="500" :height="5">
                            <rect rx="1.5" ry="1.5" width="500" height="5"/>
                        </vue-content-loading>
                    </template>

                    <template v-if="pagination">
                        <ul class="pagination">
                            <li class="page-item"
                                v-if="data.current_page>1 && data.prev_page_url !==null"><a
                                class="page-link" href="#"
                                v-on:click="getData(data.prev_page_url)">قبلی</a>
                            </li>
                            <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                            <li class="page-item"
                                v-show="data.current_page>1 && data.prev_page_url !==null"><a
                                class="page-link" href="#"
                                v-on:click="getData(data.prev_page_url)">{{
                                data.current_page
                                - 1
                                }}</a>
                            </li>


                            <li class="page-item active"><a class="page-link" href="#">{{ data.current_page }}</a>
                            </li>

                            <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                         v-on:click="getData(data.next_page_url)">{{
                                data.current_page
                                + 1
                                }}</a>
                            </li>


                            <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                       v-on:click="getData(data.next_page_url)">بعدی</a>
                            </li>
                            <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                        </ul>

                        <li class="page-item text-center" v-if="noMoreDataIsAvailable">صفحه {{ data.last_page }} از
                            {{ data.current_page }}
                        </li>
                    </template>


                </div>
            </div>
        </div>
    </div>


</template>

<script>
import VueContentLoading from 'vue-content-loading';

export default {
    components: {
        VueContentLoading,
    },
    props: ['user', 'title', 'moreTitle', 'getUrl', 'deleteUrl', 'pagination',
        'getMoreUrl', 'disableUrl', 'getMoreKey', 'headers', 'headers2', 'valueKeys', 'valueKeys2',
        'hasMoreInfo', 'hasDelete', 'deleteBy', 'hasEdit', 'searchBar',
        'disableBy', 'hasDisable', 'hasCallBack',
        'disableCallBackOn','hasAddButton'],
    data() {
        return {
            dataList: {},
            items: {},
            data: {},
            tableTitle: this.title,
            noMoreDataIsAvailable: true,
            searchMode: 'invoice_no',

        }
    },
    methods: {
        getData(url) {
            axios.get(url)
                .then(response => {
                    this.data = response.data;
                    console.log('data = ');
                    console.log(this.data);
                    this.data = response.data.dataList;
                    if (this.pagination) {
                        this.dataList = response.data.dataList.data;
                    } else {
                        this.dataList = response.data.dataList;
                    }

                    console.log('this.data = ');
                    console.log(this.data);
                })
                .catch(e => {
                    console.log(e)
                })
        },

        getMore(data) {
            console.log('getMore(data) = ')
            console.log(data)
            axios.get(this.getMoreUrl + '?' + this.getMoreKey + '=' + data[this.getMoreKey])
                .then(response => {
                    console.log('response = ')
                    console.log(response);
                    this.items = response.data.items;
                    console.log('this.items = ')
                    console.log(this.items)
                    this.noMoreDataIsAvailable = false
                })
                .catch(e => {
                    console.log(e)
                })
        },
        deleteRow(data) {
            swal({
                title: "حذف!",
                text: "این عمل موجب حذف آیتم می گردد آیا اطمینان دارید؟",
                icon: "warning",
                buttons: ["خیر", "بله"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    console.log('data = ')
                    console.log(data)
                    axios.get(this.deleteUrl + '?' + this.deleteBy + '=' + data[this.deleteBy])
                        .then(response => {
                            this.getData(this.getUrl);
                            swal(" با موفقیت حذف شد", {
                                icon: "success",
                            });
                            console.log('response = ')
                            console.log(response);
                        })
                        .catch(e => {
                            console.log(e)
                            swal(" با خطا مواجه شد" + '\n' + e, {
                                icon: "error",
                            });
                        })

                } else {

                }
            });
        },
        editRowData(data) {
            this.$emit('edit', data);
        },
        changeToForm() {
            this.$emit('change');
        },
        callBackData(data) {
            this.$emit('callback', data);
        },

        check(event, id) {
            const vm = this;
            var status = event.target.checked;
            if (status == true) {
                status = 1;
            } else {
                status = 0;
            }

            console.log('status : ' + status);
            console.log('event.id : ' + event.target.id);
            var label_id = event.target.id.substring(0, 3) + 'lb_' + id;
            console.log('label_id : ' + label_id);
            console.log('id_user : ' + id);

            axios.get(this.disableUrl + '?disableBy=' + this.disableBy + '&value=' + id + '&status=' + status)
                .then(function (response) {

                    if (status == 1) {
                        // $('#' + label_id).innerHTML = ' <span  class="badge badge-success">فعال</span>';
                        $('#' + label_id).html('<span  class="badge badge-success">فعال</span>');
                    } else {
                        // $('#' + label_id).innerHTML = '  <span  class="badge badge-secondary" >غیر فعال</span>';
                        $('#' + label_id).html(' <span  class="badge badge-secondary" >غیر فعال</span>');
                    }
                })
                .catch(function (error) {
                    console.log('error : ' + error);
                });
        },

        numberWithCommas(string) {
            return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        //search
        search(input) {
            let searchResult;
            if (input.length <= 2) {
                console.log('input.length <= 2')
                this.getData(this.getUrl);
                return []
            }

            console.log('value = ')
            console.log(input)
            console.log('searchMode = ')
            console.log(this.searchMode)
            return new Promise(resolve => {
                axios.get('/admin-panel/purchase/get/historyByInput?filter=' + this.searchMode + '&value=' + input)
                    .then(response => {
                        console.log('response')
                        console.log(response)
                        searchResult = response.data.searchResult;
                        resolve(searchResult)
                        console.log('searchResult = ')
                        console.log(searchResult)
                    })
                    .catch(e => {
                        console.log(e);
                        searchResult = ['error']
                    })

                // return new Promise(searchResult)


            })
        },
        getResultValue(result) {
            //     console.log('getResultValue')
            //     console.log(result)
            return result.invoice_no
        },
        handleSearchSubmit(result) {
            console.log('You selected = ')
            console.log(result)
            console.log(this.dataList)
            this.dataList = [];
            if (typeof result !== 'undefined') {
                this.dataList.push(result);
            } else {
                console.log(this.data)
                this.dataList = this.data;
            }
        },
    },
    created: function () {
        console.log('TableTemplateComponent created.');
        this.getData(this.getUrl);
        console.log('this.disableBy = ')
        console.log(this.disableBy)
    },
    mounted: function () {
        console.log('TableTemplateComponent mounted.');
        console.log('headers')
        console.log(this.headers)
    },
    watch: {
        thereIsNoItemsInList: function () {

            if (this.thereIsNoItemsInList) {
                // this.tableTitle = this.title;
                // this.getData(this.getUrl);
            } else {
                // this.tableTitle = this.moreTitle;
            }
        },
    }

}
</script>

<style scope>
.swal-text {
    background-color: #FEFAE3;
    padding: 17px;
    border: 1px solid #F0E1A1;
    display: block;
    margin: 22px;
    text-align: center;
    color: #61534e;
}
.activated {
    color : white;
    text-align: center;
    background-color: green;
}
</style>


