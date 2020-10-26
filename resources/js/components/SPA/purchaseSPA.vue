<template>
    <div>
        <div class="container-fluid">
            <div class="animated fadeIn">

                <div class="card div-body ">
                    <div class="card-header ">
                        <div class="form-group">
                            <i class="fa fa-align-justify"></i>
                            <span>فاکتور فروش</span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="form-group col-7 mt-2 mr-2">
                            <div class="form-group">
                                <div class="controls">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <input type="text" id="mobile" name="mobile" class="form-control"
                                                   v-model="mobile"
                                                   placeholder="شماره موبایل">
                                        </div>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-success" type="button"
                                                    v-on:click.prevent="getUserData($event)">برو!
                                            </button>
                                        </div>
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        <input type="number" min="0" id="wallet_percent" name="wallet_percent"
                                               class="form-control "
                                               v-model="preferredPercents.wallet"
                                               placeholder="درصد ترجیحی از کیف پول">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">کیف پول</span>
                                        </div>
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        <input type="number" min="0" id="score_percent" name="score_percent"
                                               class="form-control "
                                               v-model="preferredPercents.score"
                                               placeholder="درصد ترجیحی از امتیاز">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">امتیاز</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="controls">
                                <button class="btn btn-primary mt-2 ml-5" type="button"
                                        :disabled="shoppingBasket.length===0 || customerDetail.length===0"
                                        v-on:click.prevent="confirmPurchaseAndSendData()">نهایی شدن خرید
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="  bg-dark text-white div-body p-2 ">
                        <div class="d-flex   justify-content-center">
                            <div class="col-md ">
                                <label>خریدار :</label>
                                <strong>{{customerDetail.name ? customerDetail.name
                                    +' '+customerDetail.family:'-'}}</strong>
                            </div>
                            <div class="col-md">
                                <label>تعداد اقلام :</label>
                                <strong>{{shoppingBasket.length}}</strong>
                            </div>
                            <div class="col-md">
                                <label>جمع کل :</label>
                                <strong>{{ totalPrice.string}}</strong>
                            </div>
                            <div class="col-md">
                                <label>کد اشتراک :</label>
                                <strong>{{customerDetail.id_customers}}</strong>
                            </div>
                            <div class="col-md">
                                <label>کیف پول:</label>
                                <strong>{{customerDetail.wallet>0 ? numberWithCommas(customerDetail.wallet):'-'
                                    }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped ">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>جمع</th>
                                <th>حذف</th>

                            </tr>
                            </thead>

                            <tbody class="animated fadeIn">

                            <tr v-for="(service,index) in shoppingBasket">

                                <td>{{index +1}}</td>

                                <td>{{service.service_name}}</td>
                                <td>{{service.price}}</td>
                                <td>{{service.unit}}</td>
                                <td>{{service.price * service.unit}}</td>
                                <td v-on:click.prevent="basketController('remove',index,$event)">
                                    <a href="#">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--                    @if( count($data) > 10)-->

                        <!--                    <li class="page-item text-center">صفحه {{data.last_page}} از {{data.current_page}}</li>-->
                    </div>
                </div>

                <div class="bg-secondary div-body" style="height: 5px">

                </div>

                <div class="card div-body">
                    <div class="card-header">
                        <div class="mytitle">
                            <i class="fa fa-align-justify"></i>
                            <span>لیست محصولات</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped mytable">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>انقضاء</th>
                                <th>افزودن</th>
                            </tr>
                            </thead>

                            <tbody class="animated fadeIn">

                            <tr v-for="(service,index) in services">

                                <td>{{index +1}}</td>

                                <td>{{service.service_name}}</td>
                                <td>{{service.price}}</td>
                                <td><input :id="'count_'+index" class="form-control col-3" type="number" min="0"
                                           placeholder="0">
                                </td>
                                <td>{{service.expire_at}}</td>
                                <td v-on:click.prevent="basketController('add',index)">
                                    <a href="#">
                                        <i class="fa fa-plus"/>
                                    </a>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                        <!--                    @if( count($data) > 10)-->

                        <!--                    <li class="page-item text-center">صفحه {{data.last_page}} از {{data.current_page}}</li>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {
        props: ['userId'],
        data() {
            return {
                csrf: "",
                shoppingBasket: [],
                services: '',
                customerDetail: '',
                mobile: '',
                totalPrice: [],
                preferredPercents: {
                    score: 0,
                    wallet: 0
                }
            }
        },
        methods: {
            getServiceData(href) {
                axios.get(href)
                    .then(response => {
                        this.services = response.data.services
                        console.log('this.services = ')
                        console.log(this.services)
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
            getUserData(event) {

                console.log('mobile = ')
                console.log(this.mobile)
                axios.get('/admin-panel/purchase/get/customerDetail?mobile=' + this.mobile)
                    .then(response => {
                        this.customerDetail = response.data.customerDetail[0]
                        console.log('this.customerDetail = ')
                        console.log(this.customerDetail)

                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
            basketController(addOrRemove, serviceIndex) {

                console.log('basketController = ')
                switch (addOrRemove) {
                    case 'add':
                        // var unit = (event.target.value);
                        var serviceId = 'count_' + serviceIndex;
                        var isItNewAddOrAddOn = -1;
                        var unit = document.getElementById(serviceId).value
                        var total = ''
                        document.getElementById(serviceId).value = 0;
                        console.log('unit = ')
                        console.log(unit)
                        if (unit > 0) {
                            var length = this.shoppingBasket.length;
                            for (var i = 0; i < length; i++) {
                                if (this.shoppingBasket[i].id_services === this.services[serviceIndex].id_services) {
                                    isItNewAddOrAddOn = i;
                                    break;
                                }
                            }
                            if (isItNewAddOrAddOn > -1) {
                                var index = Object.keys(this.shoppingBasket[isItNewAddOrAddOn]).indexOf('unit');
                                console.log('index unit = ')
                                console.log(index)
                                var newUnit = parseInt(this.shoppingBasket[isItNewAddOrAddOn].unit) + parseInt(unit);
                                // this.shoppingBasket[0].splice(index, 1, newUnit)
                                // this.$set(this.shoppingBasket[isItNewAddOrAddOn],'unit', newUnit)
                                Vue.delete(this.shoppingBasket[isItNewAddOrAddOn], 'unit')
                                Vue.set(this.shoppingBasket[isItNewAddOrAddOn], 'unit', newUnit)

                                Vue.delete(this.shoppingBasket[isItNewAddOrAddOn], 'total')
                                Vue.set(this.shoppingBasket[isItNewAddOrAddOn], 'total', unit * this.services[serviceIndex].price)

                            } else {
                                var tempArray = []
                                tempArray = this.services[serviceIndex];
                                tempArray['unit'] = unit;
                                total = unit * this.services[serviceIndex].price
                                tempArray['total'] = total;
                                this.shoppingBasket.push(this.services[serviceIndex]);
                            }

                            this.calculateTotalPrice();
                        } else {
                            alert('لطفا مقدارمعتبری وارد کنید')
                        }
                        break;
                    case 'remove':
                        this.shoppingBasket.splice(serviceIndex, 1)
                        break;
                }
                console.log(this.shoppingBasket)
            },
            calculateTotalPrice() {
                var t = 0;
                var i;
                for (i = 0; i < this.shoppingBasket.length; i++) {
                    t += this.shoppingBasket[i].total
                }
                this.totalPrice.int = t;
                this.totalPrice.string = this.numberWithCommas(t);
                return t;
            },
            numberWithCommas(string) {
                return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            confirmPurchaseAndSendData() {
                var purchaseData = {}
                purchaseData.services = this.shoppingBasket;
                purchaseData.customer = this.customerDetail;
                purchaseData.invoiceTotalItems = this.shoppingBasket.length;
                purchaseData.preferredPercents = this.preferredPercents;


                axios.post('/admin-panel/purchase/doPurchase', JSON.stringify(purchaseData))
                    .then(response => {
                        alert('با موفقیت انجام شد')
                        this.clearItems()
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e)
                    })
            },
            clearItems() {
                this.shoppingBasket = [];
                this.customerDetail = [];
                this.preferredPercents.score = 0
                this.preferredPercents.wallet = 0
                this.totalPrice = 0
            }

        },
        mounted: function () {
            console.log('Purchase SPA mounted.')
            this.csrf = window.Laravel.csrfToken;
        },
        created: function () {
            console.log('Purchase SPA created.')
            this.getServiceData('/admin-panel/purchase/get/purchaseList')
        }
    }


</script>


<style>


</style>
