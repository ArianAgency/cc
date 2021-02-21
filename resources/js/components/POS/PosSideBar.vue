<template>
    <div class="card">
        <div class="card-body" style="height: 150px">
            <div class="d-flex justify-content-between">

                <div><strong>مبلغ کل</strong></div>
                <div class="d-flex flex-wrap">
                    <div>200,000</div>
                    <div class="mr-2">تومان</div>
                </div>
            </div>

        </div>

        <hr class="solid">
        <template v-for="item in items">
            <pos-invoice-item
                :item="item"></pos-invoice-item>
        </template>

    </div>
</template>

<script>
export default {
    name: "PosSideBar",
    props: ['basket'],
    data() {
        return {
            items: {
                0: {
                    name: 'نام محصول',
                    price: 'قیمت',
                    count: 'تعداد',
                    off: 'تخفیف'
                },
                1: {
                    name: 'نام محصول',
                    price: 'قیمت',
                    count: 'تعداد',
                    off: 'تخفیف'
                }
            }
        }
    },
    methods: {}
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
</style>
