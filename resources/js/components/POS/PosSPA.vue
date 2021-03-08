<template>
    <div>

        <header class="app-header navbar">
            <pos-header @customerDataUpdated="customerDataUpdated"></pos-header>
        </header>
        <div class="app-body">
            <div class="sidebar" id="pos-side-bar">
                <pos-side-bar :basket-items="basketItems"
                              :customer-detail="customerDetail"
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
                    @mo="ModalItemSelected"
                    :list="list"
                    v-if="modal"></modal-dialog>
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <div class="card-body d-inline-flex justify-content-end "
                             v-for="service in services">
                            <simple-services-card-object
                                :service="service"
                                @select="select"></simple-services-card-object>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>

import Swal from 'sweetalert2/dist/sweetalert2.js'

export default {
    name: "PosSPA",
    data() {
        return {
            list: {
                name: 'name',
            },
            service: {
                name: 'name',
                price: 'price',
                sync_code: 'sync_code'
            },
            services: {},
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
            modal: false
        }
    },
    methods: {
        select(data) {
            if (data.count == null) {
                data.count = 1;
            }
            data.discount = 0;
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
            var t = 0;
            var i;
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
            this.getDiscounts(id_customers, service).then(res => {
                this.list = res;
                this.modal = true;
            });
            //TODO selection of discount if multiple is available
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
                    // console.log('getDiscounts = ')
                    // console.log(response.data.response.dataList)
                    console.log('response = ');
                    console.log(response);
                    res = response.data.response.dataList;
                    console.log(res);

                })
                .catch(e => {
                    console.log(e);
                })
            return res;
        },
        ModalItemSelected() {
            alert('ModalItemSelected')
            console.log('ModalItemSelected')
        }
    },
    created: function () {
        console.log('POS SPA created.');
        this.getServiceData('/admin-panel/purchase/get/purchaseList')

    },
    mounted() {
        this.$root.$on('modalItemSelected', function (data) {
            console.log(data);

            Swal.close();
        })
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
