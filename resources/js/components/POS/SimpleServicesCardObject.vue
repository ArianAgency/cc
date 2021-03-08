<template>
    <div v-wave class=" btn ripple card service " @click="$emit('select',service)">
        <div class="card-body text-center">
            <img class="img " src="http://code.slicecrowd.com/labs/4/images/t-shirt.png" alt="">
            <div>{{ service.name }}</div>
            <div>{{ service.sync_code }}</div>
            <div class="price">{{ service.price }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ServicesCardObject",
    props: ['service'],
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
