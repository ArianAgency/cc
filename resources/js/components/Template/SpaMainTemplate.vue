<template>

    <table-template v-if="Mode==='table'"
                    title="تخفیفات"
                    :headers="['شماره فاکتور','erwe']"
                    :value-keys="['invoice_no']"
                    :get-url="'/customer-panel/testTable/get/history'"
                    search-bar="true"
                    has-delete="true"
                    :delete-url="'/customer-panel/testTable/do/delete'"
                    delete-by="invoice_no"
                    has-more-info="true"
                    :get-more-url="'/customer-panel/testTable/get/invoiceItems'"
                    get-more-key="invoice_number"
                    has-edit="true"
                    has-disable="true"
                    :disable-url="'/customer-panel/testTable/do/disable'"
                    disable-by="invoice_no"
                    @edit="edit"
    ></table-template>

</template>

<script>
export default {
    name: "SpaMainTemplate",
    props: ['Mode'],
    methods: {

        edit(data) {
            this.Mode = 'form';
            console.log(data);
        }
    }

}
</script>

<style scoped>

</style>
