<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <div class="card-header ">
                    <div class="offset-10">
                        <i class="fa fa-align-justify"></i>
                        <span>{{ title }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <autocomplete
                                :search="search"
                                placeholder="شماره کارت را جستجو کنید"
                                :get-result-value="getResultValue"
                                :debounce-time="500"
                                @submit="handleSearchSubmit"
                            ></autocomplete>
                        </div>
                        <div class="col-6 align-middle">
                            <!--                            <div class="form-group row justify-content-end ">-->
                            <!--                                <label class="col-md-3 col-form-label">-->
                            <!--                                    جستجو بر اساس-->
                            <!--                                </label>-->
                            <!--                                <div class="col-md-5 col-form-label">-->
                            <!--                                    <div class="form-check form-check-inline mr-1">-->
                            <!--                                        <input @change="searchMode= 'invoice_no'" class="form-check-input"-->
                            <!--                                               type="radio" checked="checked"-->
                            <!--                                               id="invoice_no" value="invoice_no" name="inline-radios">-->
                            <!--                                        <label class="form-check-label" for="invoice_no">شماره</label>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="form-check form-check-inline mr-1">-->
                            <!--                                        <input @change="searchMode='value_after_off_total'" class="form-check-input"-->
                            <!--                                               type="radio" id="value_after_off_total"-->
                            <!--                                               value="value_after_off_total" name="inline-radios">-->
                            <!--                                        <label class="form-check-label" for="value_after_off_total">ارزش</label>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="form-check form-check-inline mr-1">-->
                            <!--                                        <input @change="searchMode = 'created_at'" class="form-check-input" type="radio"-->
                            <!--                                               id="filter_created_at"-->
                            <!--                                               value="created_at" name="inline-radios">-->
                            <!--                                        <label class="form-check-label" for="filter_created_at">تاریخ</label>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                    </div>


                    <table class="table table-responsive-sm table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره کارت</th>
                            <th>تاریخ ایجاد</th>
                            <th>حذف</th>


                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(card,index) in nullCardList">

                            <td>{{ index + 1 }}</td>

                            <td>{{ splitedCardNumber(card.card_number, 4) }}</td>

                            <td>{{ card.created_at }}</td>
                            <th v-on:click="deleteCard(card.id_customers)">
                                <a href="#">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <template>
                        <vue-content-loading :width="500" :height="5">
                            <rect rx="1.5" ry="1.5" width="500" height="5"/>
                        </vue-content-loading>
                    </template>

                    <ul class="pagination">
                        <li class="page-item"
                            v-if="data.current_page>1 && data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getPurchaseHistoryList(data.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item"
                            v-show="data.current_page>1 && data.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getPurchaseHistoryList(data.prev_page_url)">{{
                                data.current_page
                                - 1
                            }}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{ data.current_page }}</a>
                        </li>

                        <li class="page-item" v-show="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                     v-on:click="getPurchaseHistoryList(data.next_page_url)">{{
                                data.current_page
                                + 1
                            }}</a>
                        </li>


                        <li class="page-item" v-if="data.next_page_url !==null"><a class="page-link" href="#"
                                                                                   v-on:click="getPurchaseHistoryList(data.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>

                    <li class="page-item text-center">صفحه {{ data.last_page }} از
                        {{ data.current_page }}
                    </li>

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
    props: ['user'],
    data() {
        return {
            data: {},
            nullCardList: {},
            title: 'کارت های خام',
            url: {
                search: '/admin-panel/customer/get/' +
                    'customerByCardNumber?' +
                    'mode=null&'+
                    'card_number=',
                init:
                    '/admin-panel/customer/get/' +
                    'customerNullCardNumber',
                delete:'/admin-panel/customer/action/delete'

            }
        }
    },
    methods: {

        async getNullCards(url) {
            await axios.get(url)
                .then(response => {
                    console.log('response = ')
                    console.log(response);

                    this.data = response.data.nullCards;
                    this.nullCardList = response.data.nullCards.data;
                    console.log('this.nullCardList = ')
                    console.log(this.nullCardList)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        splitedCardNumber: function (txt, num) {
            var txt = String(txt)
            var txtLength = String(txt).length;
            // console.log('splitNChars + ' + txt)
            // console.log('txt.length = ' + txtLength)
            var result = '';
            for (var i = 0; i < txtLength; i += num) {
                if (i != 0) {
                    result = result + '-';
                }
                result = result + (txt.substr(i, num));
            }
            // console.log('splitedCardNumber result = ' + result)
            return result;
        },
        deleteCard(id) {
            console.log('id = ' + id);
            swal({
                title: "حذف فاکتور!",
                text: "این عمل موجب حذف کارت می گردد آیا اطمینان دارید؟",
                icon: "warning",
                buttons: ["خیر", "بله"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.post(this.url.delete, {
                        id: id,
                    }).then(response => {
                        this.getNullCards(this.url.init)
                        swal( " با موفقیت حذف شد", {
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
                    swal(" با خطا مواجه شد 2" + '\n' + e, {
                        icon: "error",})
                }
            })

        },
        //search
        search(input) {
            let searchResult;
            if (input.length <= 2) {
                console.log('input.length <= 2');
                this.getNullCards(this.url.init);
                return [];
            }
            return new Promise(resolve => {
                axios.get(this.url.search + input)
                    .then(response => {
                        console.log('response = ')
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
            return result.card_number
        },
        handleSearchSubmit(result) {
            console.log('You selected = ')
            console.log(result)

            this.nullCardList = [];
            if (typeof result !== 'undefined') {
                console.log('CHECK 1')
                this.nullCardList.push(result);
            } else {
                console.log('CHECK 2')
                console.log(this.data)
                this.nullCardList = this.data;
            }
        }
    },
    created: function () {
        console.log('PurchaseHistoryTableComponent created.');

    },
    mounted: function () {
        console.log('PurchaseHistoryTableComponent mounted.');
        this.getNullCards(this.url.init)
    }

}
</script>

<style>
.swal-text {
    background-color: #FEFAE3;
    padding: 17px;
    border: 1px solid #F0E1A1;
    display: block;
    margin: 22px;
    text-align: center;
    color: #61534e;
}

</style>
