<template>
    <div class="pr-1 pb-1">
        <div class="d-flex align-items-center item-header row">
            <div class="col services-header">{{ Item.name }}</div>
            <div class="col services-header">{{ calculateItemTotalDiscount() }}</div>
        </div>

        <div class="row align-items-center">
            <div class="col services-text">
                {{ Item.price }}
            </div>
            <div class="d-flex align-items-center col">
                <button class="btn btn-primary"
                        @click="$emit('increase',Item)"
                >+
                </button>
                <div class="p-2 services-text">{{ Item.count }}</div>
                <button class="btn btn-danger"
                        @click="$emit('decrease',Item)"
                >-
                </button>
                <button class="btn btn-warning m-1"
                        @click="$emit('remove',Item)"
                >x
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PosInvoiceItem",
    props: ['Item'],
    methods: {
        calculateItemTotalDiscount() {
            let it = this.Item;
            let totalDis = 0;

            totalDis += ((it.price * it.off_percent) / 100) * it.count;
            totalDis += parseInt(it.off_value) * it.count;
            return totalDis;
        }
    }
}
</script>

<style scoped>
.item-header {
    background: rgb(0, 11, 154);
    background: linear-gradient(180deg, rgba(0, 11, 154, 1) 0%,
    rgba(71, 71, 159, 1) 52%,
    rgba(0, 212, 255, 0.6558998599439776) 100%);
    border-radius: 15px 50px;
    height: 40px;
    margin-bottom: 5px;
    margin-top: 5px;
}

.services-text {
    color: black;
}

.services-header {
    color: white;
}
</style>
