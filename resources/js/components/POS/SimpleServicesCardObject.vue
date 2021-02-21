<template>
    <div v-wave class=" btn ripple card service " @click="$emit('select',Service)">
        <div class="card-body text-center">
            <img class="img " src="http://code.slicecrowd.com/labs/4/images/t-shirt.png" alt="">
            <div>{{ Service.name }}</div>
            <div>{{ Service.sync_code }}</div>
            <div class="price">{{ Service.price }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ServicesCardObject",
    props: ['Service'],
    methods: {}
}
</script>

<style scoped>
.card {
    background-color: #fcfcfc;

}
.service {
    width: 200px;
}
.card-body{
    padding: 0;
}

</style>
