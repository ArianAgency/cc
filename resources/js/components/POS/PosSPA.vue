<template>
    <div>
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
</template>

<script>
export default {
    name: "PosSPA",
    data() {
        return {
            service: {
                name: 'name',
                price: 'peice',
                sync_code: 'sync_code'
            },
            services: {}
        }
    },
    methods: {
        select(data) {
            console.log(data)
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
    },
    created: function () {
        console.log('POS SPA created.');
        this.getServiceData('/admin-panel/purchase/get/purchaseList')
    },
}
</script>

<style scoped>

</style>
