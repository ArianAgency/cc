<template>
    <div class="card  ">
        <div class="card-body" style="height: 150px">

            <div class="d-flex justify-content-between">
                <div><strong>مبلغ کل</strong></div>
                <div class="d-flex flex-wrap">
                    <div>{{ totalPrice.string }}</div>
                    <div class="mr-2">تومان</div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div><strong>مالیات</strong></div>
                <div class="d-flex flex-wrap">
                    <div>{{ tax.string }}</div>
                    <div class="mr-2">تومان</div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div><strong>تخفیف کل</strong></div>
                <div class="d-flex flex-wrap">
                    <div>{{ totalDiscount.string }}</div>
                    <div class="mr-2">تومان</div>
                </div>
            </div>

        </div>

        <hr class="solid">

        <div class="container-fluid scroll ">
            <template v-for="value in basketItems">
                <pos-invoice-item
                    class="animated fadeIn"
                    :Item="value"
                    @increase="increase"
                    @decrease="decrease"
                    @remove="remove"
                ></pos-invoice-item>
            </template>
        </div>

        <hr class="solid">
        <div class="card-body">
            <button class="btn btn-primary confirm-btn fixed-bottom "
            @click="$emit('confirmPurchase')">
                <i class="fas fa-shopping-cart"></i>
                چاپ فاکتور
            </button>
        </div>

    </div>
</template>

<script>
export default {
    name: "PosSideBar",
    props: ['basketItems', 'customerDetail'],
    data() {
        return {
            totalPrice: {
                int: 0,
                string: '0',
            },
            totalDiscount: {
                int: 0,
                string: '0',
            },
            tax: {
                int: 0,
                string: '0',
            }
        }
    },
    methods: {
        increase(item) {
            this.$emit('increase', item)
        },
        decrease(item) {
            this.$emit('decrease', item)
        },
        remove(item) {
            this.$emit('remove', item)
        },
        splitedNumber(txt) {
            let result = String(txt);
            while (/(\d+)(\d{3})/.test(result)) {
                result = result.replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return result;
        },
        calculateTotalPrice() {
            var i;
            let total = 0;
            let totalDis = 0;
            for (const key in this.basketItems) {
                total += this.basketItems[key]['count'] * this.basketItems[key]['price'];
                totalDis += this.basketItems[key]['count'] * this.basketItems[key]['off_value'];
                totalDis += ((this.basketItems[key]['count'] * this.basketItems[key]['off_percent']) / 100)
                    * this.basketItems[key]['price'];
            }

            this.totalPrice.int = total;
            this.totalPrice.string = this.splitedNumber(total);

            this.tax.int = total * 0.09;
            this.tax.string = this.splitedNumber(this.tax.int);

            this.totalDiscount.int = totalDis;
            this.totalDiscount.string = this.splitedNumber(totalDis);

            return total;
        },

    },
    watch: {
        basketItems: {
            handler: function (after, before) {
                this.calculateTotalPrice();
            }, deep: true
        }
    }
}
</script>

<style scoped>
hr.solid {
    border-top: 1.5px solid #bbb;
    width: 200px;
    margin: 0 auto;
}

.card {
    color: #1b1e21;
}

.scroll {
    overflow-y: scroll;
    overflow-x: hidden;
    max-height: 307px;
}

.confirm-btn {
    width: 290px;
    height: 60px;
    margin: 5px;

}
</style>
