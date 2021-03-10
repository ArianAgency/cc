<template>
    <div hidden>
        <div id="modal-content" class="card">
            <div v-wave class="btn " v-for="item in list" @click="$root.$emit('modalItemSelected',item)">
                <div class="row">
                    <div class="col">
                        <i class="fas fa-file-signature"></i>
                        {{ item.name }}
                    </div>
                    <div class="col">
                        <i class="fas fa-calendar-times"></i>
                        {{ item.exp }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <i class="fas fa-percent"></i>
                        {{ item.off_percent }}
                    </div>
                    <div class="col">
                        <i class="fas fa-hand-holding-usd"></i>
                        {{ item.off_value }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>

import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'

export default {
    props: ['list'],
    name: "ModalDialog",
    data() {
        return {}
    },
    methods: {
        test() {

        }
    },
    mounted() {
        // console.log('Modal mounted list = ');
        // console.log(this.list)
        Swal.fire({
            title: 'example',
            icon: 'info',
            html: document.getElementById('modal-content'),
            timer: 10000

        }).then((result) => {
            console.log(result);
        });

        this.$emit('isOpen');
    },
    created() {

    }
}
</script>

<style scoped>
.btn {
    border-radius: 10px;
    border: 0.1px solid #cacaca;
    background: #e5e1e1;
    margin: 5px;
}
i{
    margin: 3px;
}

</style>
