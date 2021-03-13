<template>
    <div>

        <header class="app-header navbar">
            <pos-header @customerDataUpdated="customerDataUpdated"
                        :service-categories="serviceCategories"
                        :get-service-data="getServiceData"

                        @ServiceCategoryFilterChanged="getCategoryFilter"></pos-header>
        </header>
        <div class="app-body">
            <div class="sidebar" id="pos-side-bar">
                <pos-side-bar :basket-items="basketItems"
                              :customer-detail="customerDetail"
                              @confirmPurchase="confirmPurchaseAndSendData"
                              @increase="increase"
                              @decrease="decrease"
                              @remove="remove"
                ></pos-side-bar>

            </div>
        </div>

        <main class="main" id="pos-main">
            <div>
                <modal-dialog
                    @isOpen="modal = false"
                    :list="list"
                    v-if="modal"></modal-dialog>
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <div class="card-body d-inline-flex justify-content-end "
                             v-for="service in services">
                            <simple-services-card-object
                                v-if="(serviceCategoryFilter==0 && serviceSearchNameResult==='')||
                                 service.id_services_category_name === serviceCategoryFilter||
                                 service.service_name === serviceSearchNameResult"
                                :service="service"
                                @select="select">
                            </simple-services-card-object>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>

import Swal from 'sweetalert2/dist/sweetalert2.js'
import jsPDF from "jspdf";

export default {
    name: "PosSPA",
    props: ['user'],
    data() {
        return {
            list: {
                name: 'name',
            },
            modalSelectedOffers: [],
            service: {
                name: 'name',
                price: 'price',
                sync_code: 'sync_code'
            },
            services: {},
            serviceCategories: [],
            serviceCategoryFilter: 0,
            serviceSearchNameResult: '',
            basketItems: {},
            invoiceData: {
                totalPrice: {
                    int: 0,
                    string: ''
                }
            },
            customerDetail: {
                id_customers: 0
            },
            url: {
                getCategory: '/pos-panel/get/serviceCategories'
            },
            modal: false,
        }
    },
    methods: {
        initialState() {
            return {
                list: {
                    name: 'name',
                },
                modalSelectedOffers: [],
                serviceCategories: [],
                serviceCategoryFilter: 0,
                serviceSearchNameResult: '',
                basketItems: {},
                invoiceData: {
                    totalPrice: {
                        int: 0,
                        string: ''
                    }
                },
                customerDetail: {
                    id_customers: 0
                },
                url: {
                    getCategory: '/pos-panel/get/serviceCategories'
                },
                modal: false
            }
        },
        select(data) {
            if (data.count == null) {
                data.count = 1;
            }
            data.off_percent = 0;
            data.off_value = 0;
            data.type = '';
            data.type_id = 0;
            this.checkForDiscount(this.customerDetail.id_customers, data);

            this.basketController('add', data);

        },
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
        getServiceCategories(href) {
            axios.get(href)
                .then(response => {
                    console.log('getServiceCategories = ')
                    console.log(response)
                    this.serviceCategories = response.data.response.dataList;
                    console.log('this.serviceCategories = ')
                    console.log(this.serviceCategories)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        basketController(addOrRemove, service) {

            switch (addOrRemove) {
                case 'add':
                    if (service.id_services in this.basketItems) {
                        let tempCount = this.basketItems[service.id_services].count + 1;
                        this.$delete(this.basketItems[service.id_services], 'count');
                        this.$set(this.basketItems[service.id_services], 'count', tempCount);
                    } else {
                        service.count = 1;
                        this.$set(this.basketItems, service.id_services, service)
                    }
                    break;
                case 'remove':
                    this.shoppingBasket.splice(serviceIndex, 1);
                    this.calculateTotalPrice();
                    break;
            }
            this.$emit('pos-basket-updated', this.basketItems);
        },
        numberWithCommas(string) {
            return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        calculateTotalPrice() {
            let t = 0;
            let i;
            for (i = 0; i < this.basketItems.length; i++) {
                t += this.basketItems[i].total;
            }
            this.invoiceData.totalPrice.int = t;
            this.invoiceData.totalPrice.string = this.numberWithCommas(t);
            return t;
        },
        increase(item) {
            console.log('item = ')
            console.log(item)
            let tempCount = item.count + 1;
            this.$delete(this.basketItems[item.id_services], 'count');
            this.$set(this.basketItems[item.id_services], 'count', tempCount);
        },
        decrease(item) {
            console.log('item = ');
            console.log(item);
            let tempCount = item.count - 1;

            if (tempCount <= 0) {
                this.remove(item)
            } else {
                this.$delete(this.basketItems[item.id_services], 'count');
                this.$set(this.basketItems[item.id_services], 'count', tempCount);
            }
        },
        remove(item) {
            this.$delete(this.basketItems, item.id_services);
        },
        customerDataUpdated(data) {
            this.customerDetail = data;
        },
        checkForDiscount(id_customers, service) {
            if (id_customers == 0) {
                return 0;
            }
            this.getDiscounts(id_customers, service)
                .then(res => {
                    console.log('res =')
                    console.log(res)
                    // if (typeof res !== 'undefined'){
                    if (res.length > 0) {
                        this.list = res;
                        this.modal = true;
                    }
                });
        },
        async getDiscounts(id_customers, service) {
            let count = service.count;
            let id_services = service.id_services;
            let res;
            console.log('service =');
            console.log(service);
            await axios.get('./get/discounts?id_customers=' + id_customers
                + '&id_services=' + id_services
                + '&count=' + count)
                .then(response => {
                    console.log('getDiscounts = ')
                    console.log(response.data.response.dataList)
                    console.log('response = ');
                    console.log(response);
                    res = response.data.response;
                    for (let i = 0; i < res.length; i++) {
                        res[i].id = service.id_services;
                    }
                    // console.log('res = ');
                    // console.log(res);

                })
                .catch(e => {
                    console.log(e);
                })
            return res;
        },
        getCategoryFilter(catFilter) {
            this.serviceCategoryFilter = catFilter;
        },
        getSearchServiceNameResult(result) {
            console.log('result')
            console.log(result)
            console.log(result.length)
            if (result.length === 0) {
                this.serviceSearchNameResult = '';
            } else {
                this.serviceSearchNameResult = result.service_name;
            }

        },
        confirmPurchaseAndSendData() {
            let purchaseData = {}
            purchaseData.services = this.basketItems;
            purchaseData.customer = this.customerDetail;
            purchaseData.invoiceTotalItems = Object.keys(this.basketItems).length;

            // axios.post('/admin-panel/purchase/doPurchase', JSON.stringify(purchaseData))
            axios.post('/pos-panel/purchase/doPurchase', JSON.stringify(purchaseData))
                .then(response => {
                    swal("تمام!", "با موفقیت ثبت شد", "success");
                    console.log('response = ');
                    console.log(response);
                    this.printInvoice8cm(response.data.response);
                    this.reset();
                })
                .catch(e => {
                    swal("نا تمام!", "با خطا مواجه شد", "error");
                    console.log(e);
                })
        },
        reset() {
            Object.assign(this.$data, this.initialState());
        },
        //Print
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
            console.log('purchaseData = ')
            console.log(purchaseData)
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
                doc.line(firstTableLineX, y, firstTableLineX, y + 20);
                doc.line(secondTableLineX, y, secondTableLineX, y + 20);
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
                let unit = item.count;
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
                // xfa = Math.round(xfa * 10) / 10;
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
    created: function () {
        console.log('POS SPA created.');
        this.getServiceData('/admin-panel/purchase/get/purchaseList')

    },
    mounted() {

        let vm = this;
        import("../../../../public/fonts/fontPDF/IRANSans-normal.js");// pdf font
        this.$root.$on('modalItemSelected', function (item) {
            let service_id = item.id;
            for (let key in vm.basketItems) {
                if (key == service_id) {
                    this.$delete(vm.basketItems[key], 'off_percent');
                    this.$set(vm.basketItems[key], 'off_percent', item.off_percent);
                    this.$delete(vm.basketItems[key], 'off_value');
                    this.$set(vm.basketItems[key], 'off_value', item.off_value);
                    this.$delete(vm.basketItems[key], 'type_id');
                    this.$set(vm.basketItems[key], 'type_id', item.type_id);
                    this.$delete(vm.basketItems[key], 'type');
                    this.$set(vm.basketItems[key], 'type', item.type);
                }
            }
            this.modalSelectedOffers = item;
            Swal.close();
        })
        this.$root.$on('searchNameResultReady', function (result) {

            vm.getSearchServiceNameResult(result);
        })
        this.getServiceCategories(this.url.getCategory);
        console.log('user from prop = ');
        console.log(this.user);
    }
}
</script>

<style scoped>


@media screen and (max-width: 700px) {
    .box {
        width: 70%;
    }

    .popup {
        width: 70%;
    }
}
</style>
