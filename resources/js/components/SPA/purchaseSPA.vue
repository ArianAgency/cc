import jsPDF from "jspdf";
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
                    <ValidationObserver v-slot="{invalid, handleSubmit }" ref="observer">
                        <div class="row justify-content-around">
                            <div class="form-group col-10 mt-2 mr-2 ">
                                <!--                            <div class="form-group">-->
                                <!--                                <div class="controls">-->

                                <div class="row row-cols-auto">

                                    <!--mobile-->
                                    <div class="form-group col">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <div class="input-group">
                                                <!--mobile-->
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                <input type="text" id="mobile" name="mobile"
                                                       class="form-control"
                                                       v-model="mobile"
                                                       placeholder="شماره موبایل">


                                                <button class="btn btn-success" type="button"
                                                        v-on:click.prevent="getCustomerData($event)">برو!
                                                </button>

                                            </div>
                                            <div>
                                                <p class="invalid-feedback d-inline-block mr-2"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </div>
                                        </ValidationProvider>
                                    </div>

                                    <!--                                    <span class="input-group-addon"></span>-->

                                    <!--wallet_percent-->
                                    <div class="form-group col">
                                        <ValidationProvider :rules="'max_value:'+10"
                                                            v-slot="{ errors }">
                                            <div class="input-group ">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                <input type="number" min="0" :max="walletAllowedValue"
                                                       id="wallet_percent"
                                                       name="wallet_percent"
                                                       class="form-control"
                                                       v-model="preferredPercents.wallet"
                                                       placeholder="درصد ترجیحی از کیف پول">
                                                <span class="input-group-text">کیف پول</span>
                                            </div>
                                            <div>
                                                <p class="invalid-feedback d-inline-block mr-2 " style="width: 50px"
                                                   v-show="errors">{{ errors[0]}}
                                                </p>
                                            </div>
                                        </ValidationProvider>
                                    </div>

                                    <!--                                    <span class="input-group-addon"></span>-->

                                    <!--remain_cash-->
                                    <div class="form-group col">
                                        <ValidationProvider rules="" v-slot="{ errors }">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </span>
                                                <input type="text" id="remain_cash" name="remainCash"
                                                       class="form-control "
                                                       :value="remainCash"
                                                       readonly="true"
                                                       placeholder="0.00">
                                                <span class="input-group-text">تومان</span>
                                            </div>
                                        </ValidationProvider>
                                    </div>

                                </div>

                                <!--                                </div>-->
                                <!--                            </div>-->
                            </div>
                            <div class="form-group ">
                                <div class="controls">
                                    <button class="btn btn-primary mt-2 ml-5" type="button"
                                            v-on:click.prevent="handleSubmit(confirmPurchaseAndSendData())">
                                        <!--                                    v-on:click.prevent="handleSubmit(printInvoice8cm(''))">-->
                                        چاپ فاکتور
                                    </button><!--  :disabled="shoppingBasket.length===0 || customerDetail.length===0"-->
                                </div>
                            </div>
                        </div>
                    </ValidationObserver>

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
                                <strong>{{customerDetail.wallet>0 ? numberWithCommas(customerDetail.wallet):'0.00'
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

    import jsPDF from "jspdf";

    export default {
        props: ['user'],
        data() {
            return {
                csrf: "",
                shoppingBasket: [],
                services: '',
                customerDetail: {
                    wallet: 0
                },
                mobile: '',
                totalPrice: [],
                preferredPercents: {
                    score: 0,
                    wallet: 0
                },
                cash: {
                    remain: 0.00
                },
                business: {
                    brand_name: '',
                    company_name: '',
                    address: '',
                    financial_code: '',
                    logo_address: '',
                    instagram_id: ''
                },
                invoice: {
                    invoice_no: '',
                    created_at: ''
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
            getCustomerData(event) {

                console.log('mobile = ');
                console.log(this.mobile);
                axios.get('/admin-panel/purchase/get/customerDetail?mobile=' + this.mobile)
                    .then(response => {
                        this.customerDetail = response.data.customerDetail[0];
                        console.log('this.customerDetail = ');
                        console.log(this.customerDetail);

                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e);
                    })
            },
            basketController(addOrRemove, serviceIndex) {

                console.log('basketController = ');
                switch (addOrRemove) {
                    case 'add':
                        // var unit = (event.target.value);
                        var serviceId = 'count_' + serviceIndex;
                        var isItNewAddOrAddOn = -1;
                        var unit = document.getElementById(serviceId).value;
                        var total = '';
                        document.getElementById(serviceId).value = 0;
                        console.log('unit = ');
                        console.log(unit);
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
                                var tempArray = [];
                                tempArray = this.services[serviceIndex];
                                tempArray['unit'] = unit;
                                total = unit * this.services[serviceIndex].price;
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
                        this.calculateTotalPrice();
                        break;
                }
                console.log(this.shoppingBasket)
            },
            calculateTotalPrice() {
                var t = 0;
                var i;
                for (i = 0; i < this.shoppingBasket.length; i++) {
                    t += this.shoppingBasket[i].total;
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

                // axios.post('/admin-panel/purchase/doPurchase', JSON.stringify(purchaseData))
                axios.post('/admin-panel/purchase/doPurchase', JSON.stringify(purchaseData))
                    .then(response => {
                        swal("تمام!", "با موفقیت ثبت شد", "success");
                        console.log('response = ');
                        console.log(response);
                        this.printInvoice8cm(response.data.response);
                        this.clearItems();
                    })
                    .catch(e => {
                        swal("نا تمام!", "با خطا مواجه شد", "error");
                        console.log(e);
                    })
            },
            clearItems() {
                this.shoppingBasket = [];
                this.customerDetail = [];
                this.preferredPercents.score = 0;
                this.preferredPercents.wallet = 0;
                this.totalPrice = 0;
            },
            printInvoice8cm(purchaseData) {
                let context = this;

                let paperCenterX = 40;
                let paperLeftMargin = 5;
                let paperRightMargin = 75;
                let tableRightMargin = 73;
                let tableCenterMargin = 38;
                let primaryFontSize = 12;
                let secondaryFontSize = 8;
                let firstTableLineX = 35;
                let secondTableLineX = 23;
                let tableBase_y = 110;
                let table_row_h = 20;
                let after_rows_y = tableBase_y + (purchaseData.items.length * table_row_h);
                let text_start_after_table_y = after_rows_y + 5;
                let h = text_start_after_table_y + 110;
                //***************************************************
                let doc = new jsPDF('p', 'mm', [80, h]);

                let title = 'فاکتور فروش';
                let address_title = 'آدرس: ';
                let financial_code_title = 'کد اقتصادی: ';
                let invoice_number_title = ' :شماره فاکتور';
                let invoice_time_title = ' :زمان';
                let customer_title = ' :مشتری';
                let user_title = ' :صندوقدار';
                let service_name_title = 'نام کالا';
                let currency_title = '(فی واحد) ريال';
                let unit_title = '/تعداد' + "\n" + 'وزن';
                let total_price_title = 'مجموع قیمت' + "\n" + '(ریال)';
                let invoiceTotalItems_title = ' :تعداد ردیف';
                let invoice_total_value_title = ' :مبلغ فاکتور';
                let invoice_total_off_title = ' :کل تخفیف';
                let cash_to_pay_title = ' :مبلغ قابل پرداخت';
                let cash_paid_title = 'پرداخت نقدی';
                let score_paid_title = 'پرداخت امتیاز';
                let wallet_paid_title = 'پرداخت کیف پول';
                let thankyou_title = 'با تشکر از خرید شما';
                let see_you_again_title = 'به امید دیدار شما در اینجا';
                //***************************************************
                let company_name = this.user.business.company_name;
                let brand_name = this.user.business.brand_name;
                let address = this.user.business.address;
                let invoice_date = this.getFaDate();
                let invoice_time = this.getTime();
                let customer = this.customerDetail.name + ' ' + this.customerDetail.family;
                let user = this.user.family;
                let invoiceTotalItems = purchaseData.items.length;
                let parentBusinessName = ''
                let invoice_total_value = 0;
                let invoice_total_off = 0;
                let cash_to_pay = 0;
                let cash_paid = 0;
                let score_paid = 0;
                let wallet_paid = 0;
                let Qr = purchaseData.Qr;
                //***************************************************
                let invoice_number = purchaseData.invoice_number;
                doc.setFont('IRANSans');

                addText_Fa(title, paperRightMargin, 10, secondaryFontSize);
                addText_Fa(company_name, paperRightMargin, 15, secondaryFontSize);
                addText_Fa(brand_name, paperRightMargin, 20, secondaryFontSize);
                addText_Fa(address_title + address, paperRightMargin, 25, secondaryFontSize);
                addText_Fa(financial_code_title + this.user.business.financial_code, paperRightMargin, 30, 8);
                addText_Fa(invoice_date, 55, 40, 20);
                doc.addImage('/storage/logo_img/' + this.user.business.logo_address,
                    'PNG', 5, 27, 15, 15, '', 'NONE', 0);
                addText_Fa('**********************', 60, 50, primaryFontSize);
                addText_Fa('--------------------', 50, 55, primaryFontSize);

                createDataRow(65, 10);
                addText_Fa(invoice_number_title, tableRightMargin, 71, secondaryFontSize);
                addText_Fa(invoice_number,
                    tableRightMargin - doc.getTextWidth(invoice_number_title),
                    71,
                    primaryFontSize);
                addText_Fa(invoice_time_title, tableCenterMargin, 71, secondaryFontSize);
                addText_Fa(invoice_time,
                    tableCenterMargin - doc.getTextWidth(invoice_time_title),
                    71,
                    primaryFontSize);

                createDataRow(75, 10);
                addText_Fa(customer_title, tableRightMargin, 81, secondaryFontSize);
                addText_Fa(customer,
                    tableRightMargin - doc.getTextWidth(customer_title),
                    81,
                    secondaryFontSize);
                addText_Fa(user_title, tableCenterMargin, 81, secondaryFontSize);
                addText_Fa(user,
                    tableCenterMargin - doc.getTextWidth(user_title),
                    81,
                    secondaryFontSize);

                //Table Header
                createTableHeader(90);
                doc.line(firstTableLineX, 101, tableRightMargin + 2, 101);
                addText_Fa(service_name_title, tableRightMargin, 96, primaryFontSize);
                addText_Fa(currency_title, tableRightMargin, 106, secondaryFontSize);
                addText_Fa(unit_title, firstTableLineX + 3, 101, secondaryFontSize);
                addText_Fa(total_price_title, secondTableLineX + 7, 101, secondaryFontSize);

                //Table row
                const promises = [];
                for (let i = 0; i < invoiceTotalItems; i++) {
                    promises.push(createTableRow(i, purchaseData.items, tableBase_y, table_row_h));
                    invoice_total_value += parseFloat(purchaseData.items[i].inserted_invoice_item_data.base_value_total);
                    invoice_total_off += parseFloat(purchaseData.items[i].inserted_invoice_item_data.off_value_total);
                    cash_to_pay += parseFloat(purchaseData.items[i].inserted_invoice_item_data.payed_by_cash_total);
                    cash_paid += parseFloat(purchaseData.items[i].inserted_invoice_item_data.payed_by_cash_total);
                    score_paid += parseFloat(purchaseData.items[i].inserted_invoice_item_data.payed_by_scores);
                    wallet_paid += parseFloat(purchaseData.items[i].inserted_invoice_item_data.payed_by_wallet);
                }

                addText_Fa(invoiceTotalItems_title, tableRightMargin, text_start_after_table_y, secondaryFontSize);
                addText_Fa(invoiceTotalItems + '',
                    tableRightMargin - doc.getTextWidth(invoiceTotalItems_title),
                    text_start_after_table_y,
                    primaryFontSize);

                createDataRow(text_start_after_table_y + 10, 10);
                addText_Fa(invoice_total_value_title, tableRightMargin,
                    text_start_after_table_y + 16, primaryFontSize);
                addNum_Fa(invoice_total_value, tableCenterMargin - 2,
                    text_start_after_table_y + 16, primaryFontSize);

                createDataRow(text_start_after_table_y + 20, 10);
                addText_Fa(invoice_total_off_title, tableRightMargin,
                    text_start_after_table_y + 26, primaryFontSize);
                addNum_Fa(invoice_total_off, tableCenterMargin - 2,
                    text_start_after_table_y + 26, primaryFontSize);

                doc.setFillColor(0);
                doc.rect(5, text_start_after_table_y + 30, 70, 10, 'F');
                doc.setFillColor(255);
                doc.setTextColor(255);
                addText_Fa(cash_to_pay_title, tableRightMargin,
                    text_start_after_table_y + 36, primaryFontSize);
                addNum_Fa(cash_to_pay, tableCenterMargin - 2,
                    text_start_after_table_y + 36, primaryFontSize);
                doc.setTextColor(0);

                addText_Fa(cash_paid_title, tableRightMargin - 8,
                    text_start_after_table_y + 50, secondaryFontSize);
                addText_Fa(wallet_paid_title, tableRightMargin - 8,
                    text_start_after_table_y + 55, secondaryFontSize);
                addText_Fa(score_paid_title, tableRightMargin - 8,
                    text_start_after_table_y + 60, secondaryFontSize);

                addNum_Fa(cash_paid, tableCenterMargin - 2,
                    text_start_after_table_y + 50, secondaryFontSize);
                addNum_Fa(wallet_paid, tableCenterMargin - 2,
                    text_start_after_table_y + 55, secondaryFontSize);
                addNum_Fa(score_paid, tableCenterMargin - 2,
                    text_start_after_table_y + 60, secondaryFontSize);

                doc.line(10, text_start_after_table_y + 70, 70, text_start_after_table_y + 70);
                addText_Fa_Center(thankyou_title,
                    text_start_after_table_y + 75, secondaryFontSize);
                addText_Fa_Center(see_you_again_title,
                    text_start_after_table_y + 80, secondaryFontSize);

                // console.log('QR = ');
                // console.log(Qr);

                doc.addImage(Qr, 'JPEG', 30,
                    text_start_after_table_y + 85, 20, 20, 'Qr', 'NONE', 0);

                //-------------------------------------------------------
                Promise.all(promises)
                    .then((success) => {
                        console.log('promises = ');
                        console.log(promises);
                        // doc.output('dataurlnewwindow');
                        doc.save('invoice.pdf');
                    })
                    .catch((e) => {
                        console.log(e);
                    });

                function createDataRow(y, h) {
                    doc.rect(5, y, 70, h, 'S');
                    doc.line(paperCenterX, y, paperCenterX, y + h);
                }

                function createTableHeader(y) {
                    doc.rect(5, y, 70, 20, 'S');
                    doc.line(firstTableLineX, y, firstTableLineX, y+20);
                    doc.line(secondTableLineX, y, secondTableLineX, y+20);
                }

                function createTableRow(rowIndex, items, tableBase_y, table_row_h) {
                    doc.setPage(1);
                    console.log('items = ');
                    console.log(items[rowIndex]);
                    //******************************
                    let base_y = tableBase_y;
                    let h = table_row_h;
                    let y_rec = base_y + (rowIndex * h);
                    let y_name = y_rec + 5;
                    let y_base_price = y_name + 5;
                    let y_off_price = y_base_price + 5;
                    let x_count_unit = (firstTableLineX + secondTableLineX) / 2;

                    let y_base_value_total_title = y_rec + 3;
                    let y_base_value_total = y_base_value_total_title + 5;
                    let y_after_off_value_total_title = y_base_value_total + 5;
                    let y_after_off_value_total = y_after_off_value_total_title + 5;
                    let x_X_value_total = secondTableLineX - 2;
                    let item = items[rowIndex];
                    //******************************
                    let base_value_per_one_title = '       قیمت اصلی';
                    let after_off_total_title = '     قیمت تخفیفی';
                    let base_value_total_title = 'جمع اصلی';
                    let value_after_off_total_title = 'جمع تخفیفی';
                    //******************************
                    let service_name = item.service_name;
                    let base_value_per_one = item.inserted_invoice_item_data.base_value_per_one;
                    let value_after_off_per_one = item.inserted_invoice_item_data.value_after_off_per_one;
                    let base_value_total = item.inserted_invoice_item_data.base_value_total;
                    let unit = item.unit;
                    let value_after_off_total = item.inserted_invoice_item_data.value_after_off_total;
                    //******************************
                    doc.rect(5, y_rec, 70, 20, 'S');
                    doc.line(firstTableLineX, y_rec, firstTableLineX, y_rec + h);
                    doc.line(secondTableLineX, y_rec, secondTableLineX, y_rec + h);
                    addText_Fa(service_name, tableRightMargin, y_name, primaryFontSize);

                    addText_Fa(base_value_per_one_title,
                        tableRightMargin, y_base_price, secondaryFontSize);
                    addText_Fa(base_value_per_one,
                        tableRightMargin - doc.getTextWidth(base_value_per_one_title),
                        y_base_price, secondaryFontSize);

                    addText_Fa(after_off_total_title,
                        tableRightMargin, y_off_price, secondaryFontSize);
                    addText_Fa(value_after_off_per_one,
                        tableRightMargin - doc.getTextWidth(after_off_total_title),
                        y_off_price, secondaryFontSize);

                    addText_Fa(unit, x_count_unit, y_base_price, primaryFontSize);

                    addText_Fa(base_value_total_title, x_X_value_total, y_base_value_total_title, secondaryFontSize);
                    addText_Fa(base_value_total, x_X_value_total, y_base_value_total, secondaryFontSize);

                    addText_Fa(value_after_off_total_title,
                        x_X_value_total, y_after_off_value_total_title, secondaryFontSize);
                    addText_Fa(value_after_off_total,
                        x_X_value_total, y_after_off_value_total, secondaryFontSize);

                    return new Promise(function (resolve, reject) {
                        setTimeout(function () {

                            resolve();
                        }, 100);
                    }).then(function () {
                        return " end";
                    });
                }

                /**
                 * @return {number}
                 */
                function addText_Fa(text, x, y, fontSize) {
                    text += '';
                    doc.setFontSize(fontSize);
                    let xfa = x;
                    let length = doc.getTextWidth(text);
                    xfa = xfa - length;
                    doc.text(text, xfa, y);
                }

                function addText_Fa_Center(text, y, fontSize) {
                    text += '';
                    doc.setFontSize(fontSize);
                    let xfa = paperCenterX;
                    let length = doc.getTextWidth(text) / 2;
                    xfa = xfa - length;
                    doc.text(text, xfa, y);
                }

                function addNum_Fa(text, x, y, fontSize) {
                    text += '';
                    text = context.splitedNumber(text);
                    doc.setFontSize(fontSize);
                    let xfa = x;
                    let length = doc.getTextWidth(text);
                    xfa = xfa - length;
                    doc.text(text, xfa, y);
                }
            },
            getFaDate() {
                // console.log('date = ');
                let date;
                date = new Date().toLocaleDateString('fa-Ir');
                // date = date.getUTCFullYear() + '-' +
                //     ('00' + (date.getMonth() + 1)).slice(-2) + '-' +
                //     ('00' + date.getDate()).slice(-2);
                // + ' ' +
                // ('00' + date.getHours()).slice(-2) + ':' +
                // ('00' + date.getMinutes()).slice(-2) + ':' +
                // ('00' + date.getSeconds()).slice(-2);
                // console.log(date);

                return date;
            },
            getTime() {
                // console.log('date = ');
                let date;
                date = new Date();
                date = ('00' + date.getHours()).slice(-2) + ':' +
                    ('00' + date.getMinutes()).slice(-2) + ':' +
                    ('00' + date.getSeconds()).slice(-2);
                console.log(date);

                return date;
            },
            splitedNumber(txt) {
                let result = String(txt);
                while (/(\d+)(\d{3})/.test(result)) {
                    result = result.replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
                }
                return result;
            },
        },
        mounted: function () {
            console.log('Purchase SPA mounted.');
            this.csrf = window.Laravel.csrfToken;
            import("../../../../public/fonts/fontPDF/IRANSans-normal.js");// pdf font
        },
        created: function () {
            console.log('Purchase SPA created.');
            this.getServiceData('/admin-panel/purchase/get/purchaseList')
        },
        computed: {
            remainCash: function () {
                console.log('Before this.cash.remain = ' + this.cash.remain);
                this.totalPrice.string;
                if (this.preferredPercents.wallet <= 100) {
                    console.log('this.preferredPercents.wallet <= 100 ');
                    this.cash.remain = this.totalPrice.int - ((this.totalPrice.int * (this.preferredPercents.score / 100)) + (this.totalPrice.int * (this.preferredPercents.wallet / 100)));
                } else {
                    console.log('this.preferredPercents.wallet > 100 ');
                    this.cash.remain = this.totalPrice.int - ((this.totalPrice.int * (this.preferredPercents.score / 100)) + ((this.preferredPercents.wallet)));
                }
                this.cash.remain = Math.round(this.cash.remain)
                console.log('After this.cash.remain = ' + this.cash.remain)
                return this.numberWithCommas(this.cash.remain)

            },
            walletAllowedValue: function () {
                if (this.customerDetail.wallet <= 0) {
                    console.log('walletAllowedValue = ' + ' return 0')
                    return 0;
                }
                if (this.preferredPercents.wallet < 100) {
                    console.log('walletAllowedValue = ' + (this.customerDetail.wallet / this.totalPrice.int) * 100)
                    return (parseFloat(this.customerDetail.wallet) / this.totalPrice.int) * 100
                }
                console.log('walletAllowedValue = ')
                console.log(parseFloat(this.customerDetail.wallet))
                return parseFloat(this.customerDetail.wallet)
            }
        },
        watch: {
            preferredPercents: function (val) {
                console.log("val = " + val)
                if (val > this.walletAllowedValue) {
                    val = this.walletAllowedValue
                }
            }
        }
    }


</script>


<style>


</style>
