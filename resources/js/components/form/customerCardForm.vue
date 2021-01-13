<template>
    <div>
        <div class="animated fadeIn">
            <div class="card div-body">
                <slot name="header"></slot>

                <form ref="form" @submit.prevent="service_new_form_submit">

                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">

                                <!-- cusetomer Search -->
                                <div class="form-group ">
                                    <autocomplete
                                        :search="search"
                                        placeholder="مشتری را جستجو کنید"
                                        :get-result-value="getResultValue"
                                        :debounce-time="500"
                                        @submit="handleSearchSubmit"
                                    ></autocomplete>
                                </div>

                                <!-- customer_name -->
                                <div class="form-group ">
                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-user"></i>
                                                        </span>
                                        <input type="text" id="customer_name" name="customer_name"
                                               class="form-control" readonly
                                               :value="customer.name + ' ' + customer.family"
                                               placeholder="مشتری">
                                    </div>
                                </div>

                                <!-- company_name -->
                                <div class="form-group ">
                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-building"></i>
                                                        </span>
                                        <input type="text" id="company_name" name="company_name"
                                               class="form-control" readonly
                                               :value="business.company_name"
                                               placeholder="نام شرکت">
                                    </div>
                                </div>

                                <!-- brand_name -->
                                <div class="form-group ">
                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="far fa-building"></i>
                                                        </span>
                                        <input type="text" id="brand_name" name="brand_name"
                                               class="form-control" readonly
                                               :value="business.brand_name"
                                               placeholder="نام برند">
                                    </div>
                                </div>

                                <!-- card_number -->
                                <div class="form-group ">
                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                           <i class="fas fa-credit-card"></i>
                                                        </span>
                                        <input type="text" id="card_number" name="card_number"
                                               class="form-control" readonly
                                               :value="customer.card_number"
                                               placeholder="شماره کارت">
                                    </div>
                                </div>

                                <!-- card_text -->
                                <div class="form-group ">
                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                          <i class="fas fa-font"></i>
                                                        </span>
                                        <input type="text" id="card_text" name="card_text"
                                               class="form-control"
                                               v-model:value="business.card_text"
                                               placeholder="متن روی کارت">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">

                                    <!-- Card BG view -->
                                    <div class="form-group row">
                                        <div class="col-12">

                                            <card-designer
                                                :address="business.card_bg"
                                                :getInitData="getInitData">
                                            </card-designer>

                                        </div>
                                    </div>


                                    <!-- QR & LOGO view-->
                                    <div class="form-group row">
                                        <!-- QR view -->
                                        <div id="qrr" ref="qrr"
                                             class="col-6 d-flex align-items-center justify-content-center">
                                            <qrcode-vue
                                                id="qr" ref="qr"
                                                renderAs="canvas"
                                                :value="customer.card_number"
                                                :size="size" level="H"></qrcode-vue>
                                        </div>

                                        <!-- LOGO view -->
                                        <div class="col-6">
                                            <card-designer
                                                :address="business.logo"
                                                :getInitData="getInitData">
                                            </card-designer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="form-group form-actions col-2">

                            <button type="" class="btn btn-border btn-primary  w-100"
                                    v-on:click.prevent="printTest3">
                                <i class="far fa-file-alt ml-2"></i>چاپ
                            </button>
                        </div>
                        <div class="form-group form-actions col-2 ml-2">
                            <button type="submit" value="submit" class="btn btn-border btn-success  w-75"
                                    @click.prevent="submitForm">
                                <i class="fa fa-check-circle ml-1"></i>ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>

    import QrcodeVue from 'qrcode.vue'
    import jsPDF from "jspdf";
    import VueHtml2Canvas from 'vue-html2canvas';
    import html2canvas from 'html2canvas'

    export default {
        components: {QrcodeVue,},
        data() {
            return {
                csrf: "",
                business: {
                    company_name: '',
                    brand_name: '',
                    card_text: '',
                    card_bg: '',
                    logo: ''
                },
                customer: {
                    card_number: '0000000000000000',
                    name: '',
                    family: ''
                },
                size: 100,
                filterForCustomerSearch: ['name', 'family']
            }
        },
        methods: {
            async submitForm(event) {

                const data = {}; // need to convert it before using not with XMLHttpRequest
                Object.assign(data, {'card_text': this.business.card_text})
                Object.assign(data, {'action': 'setCardText'})
                axios.post('/admin-panel/business', data)
                    .then(response => {
                        console.log(response)
                        if (response.data.status === 'Done') {
                            swal("تمام!", "با موفقیت ثبت شد", "success");
                        } else {
                            swal("نا تمام!", "با خطا مواجه شد", "error");
                        }

                    })
                    .catch(error => {
                        if (error.response) {
                            // Request made and server responded
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                    })
            },
             getInitData() {
                console.log('getInitData = ')
                 axios.get('/admin-panel/business/get/card_init')
                    .then(response => {
                        console.log(response)
                        this.business = response.data.response
                    })
                    .catch(e => {
                        // this.errors.push(e)
                        console.log(e);
                    })
            },
            //search
            search(input) {
                let searchResult;
                if (input.length <= 2) {
                    console.log('input.length <= 2')
                    return []
                }

                console.log('input = ')
                console.log(input)
                return new Promise(resolve => {
                    axios.get('/admin-panel/customer/get/customerByInput?input=' + input + '&filterForCustomerSearch=' + this.filterForCustomerSearch)
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
                console.log('getResultValue')
                console.log(result)
                return (result.name + ' ' + result.family)
            },
            handleSearchSubmit(result) {
                // console.log('You selected = ')
                // console.log(result)
                // console.log('this.business.card_bg_address = ')
                // console.log(this.business)
                if (typeof result !== 'undefined') {
                    this.customer.card_number = result.card_number;
                    this.customer.name = result.name;
                    this.customer.family = result.family;
                } else {
                    // console.log('CHECK 2')
                }
            },
            printPDF() {
                let card_w = 85;
                let card_h = 53;
                let card_left_up_x = 62.5;
                let card_left_up_y = 10;
                let card_center_x = 105;
                let card_center_y = 31.5;
                let card_corner_round = 3;

                let card_text_start_x_en = card_left_up_x + 10;
                let card_text_start_x_fa = card_left_up_x + 10;

                const doc = new jsPDF();
                doc.setFont('IRANSans');

                var img = new Image();
                img.src = this.business.card_bg
                doc.addImage(img, 'png', card_left_up_x, card_left_up_y, card_w, card_h)

                doc.text(this.business.card_text, card_text_start_x_en, card_center_y);
                doc.text(this.customer.name + ' ' +
                    this.customer.family, card_text_start_x_en, card_center_y + 10);
                doc.text(this.splitedCardNumber(this.customer.card_number, 4),
                    card_text_start_x_en, card_center_y + 20);
                // doc.rect(62.5, 10, 85, 53)
                doc.roundedRect(card_left_up_x, card_left_up_y,
                    card_w, card_h,
                    card_corner_round, card_corner_round);
                doc.save("a4.pdf");
            },
            printTest() {
                var w = document.getElementById("qr").offsetWidth;
                var h = document.getElementById("qr").offsetHeight;

                html2canvas(document.getElementById('app'), {imageTimeout: 5000, useCORS: true}).then(canvas => {
                    // document.getElementById('qr').appendChild(canvas)
                    let img = canvas.toDataURL('image/png')
                    console.log('img =')
                    console.log(img)
                    const pdf = new jsPDF();
                    pdf.addImage(img, 'JPEG', 50, 50, 200, 200)
                    pdf.save('relatorio-remoto.pdf')
                    document.getElementById('qr').innerHTML = ''
                })
            },
            printTest1() {
                var pdf = new jsPDF('p', 'pt', 'a4');
                pdf.html(document.getElementById('qrr'), {
                    callback: function (pdf) {
                        pdf.save('a4.pdf');
                    }
                });
            },
            printTest2() {
                let card_w = 85;
                let card_h = 53;
                let card_left_up_x = 62.5;
                let card_left_up_y = 10;
                let card_center_x = 105;
                let card_center_y = 31.5;
                let card_corner_round = 3;

                let card_text_start_x_en = card_left_up_x + 10;
                let card_text_start_x_fa = card_left_up_x + 10;

                // const doc = new jsPDF();
                const doc = new jsPDF('p', 'mm', 'a4');

                doc.setFont('IRANSans');

                var img = new Image();
                img.src = this.business.card_bg
                doc.addImage(img, 'png', card_left_up_x, card_left_up_y, card_w, card_h)

                doc.text(this.business.card_text, card_text_start_x_en, card_center_y);
                doc.text(this.customer.name + ' ' +
                    this.customer.family, card_text_start_x_en, card_center_y + 10);
                doc.text(this.splitedCardNumber(this.customer.card_number, 4),
                    card_text_start_x_en, card_center_y + 20);
                // doc.rect(62.5, 10, 85, 53)
                doc.roundedRect(card_left_up_x, card_left_up_y,
                    card_w, card_h,
                    card_corner_round, card_corner_round);
                doc.html(document.getElementById('qr'), {

                    x: 10,
                    y: 100,

                    callback: function (doc) {
                        doc.save('a4.pdf');
                    },
                });
            },
            printTest3() {
                let card_w = 85;
                let card_h = 53;
                let card_left_up_x = 62.5;
                let card_left_up_y = 10;
                let card_center_x = 105;
                let card_center_y = 31.5;
                let card_corner_round = 3;

                let card_text_start_x_en = card_left_up_x + 10;
                let card_text_start_x_fa = card_left_up_x + card_w - 10;

                // const doc = new jsPDF();
                const doc = new jsPDF('p', 'mm', 'a4');

                doc.setFont('IRANSans');

                var img = new Image();
                img.src = this.business.card_bg;
                doc.addImage(img, 'png', card_left_up_x, card_left_up_y, card_w, card_h);

                doc.setFillColor(242, 242, 242);
                doc.rect(card_left_up_x, card_center_y + 7, card_w, 21, 'F');
                doc.roundedRect(card_left_up_x, card_left_up_y,
                    card_w, card_h,
                    card_corner_round, card_corner_round, 'S');

                doc.setFillColor(255);
                doc.roundedRect(card_left_up_x + 5, card_left_up_y + 2,
                    25, 25, 1, 1, 'F');

                doc.roundedRect(card_left_up_x + card_w - 30, card_left_up_y + 2,
                    25, 25, 1, 1, 'F');

                var img_logo = new Image();
                img_logo.src = this.business.logo;
                doc.addImage(img_logo, 'png', card_left_up_x + card_w - 27.5, card_left_up_y + 5, 20, 20);

                doc.setFontSize(14);
                let card_text_length = doc.getTextWidth(this.business.card_text);
                doc.text(this.business.card_text, card_text_start_x_fa - card_text_length, card_center_y + 13);

                doc.setFontSize(12);
                let name_family_length = doc.getTextWidth(this.customer.name + ' ' +
                    this.customer.family);
                doc.text(this.customer.name + ' ' + this.customer.family,
                    card_text_start_x_fa - name_family_length, card_center_y + 19);

                doc.text(this.splitedCardNumber(this.customer.card_number, 4),
                    card_text_start_x_en, card_center_y + 26);

                doc.html(document.getElementById('qr'), {
                    html2canvas: {
                        // insert html2canvas options here, e.g.
                        scale: 0.19
                    },
                    x: card_left_up_x + 5,
                    y: card_left_up_y + 5,

                    callback: function (doc) {
                        doc.save('a4.pdf');
                    },
                });
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
                console.log('splitedCardNumber result = ' + result)
                return result;
            },
        },
        created: function () {
            console.log('customerCardForm created ')
            this.getInitData()
        },
        mounted: function () {
            console.log('customerCardForm mounted ')
            this.csrf = window.Laravel.csrfToken
            import("../../../../public/fonts/fontPDF/IRANSans-normal.js")
        },
        watch: {}
    }

</script>

<style>

</style>
