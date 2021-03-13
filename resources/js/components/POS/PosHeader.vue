<template>

    <div class="container-fluid row h-100 ">

        <div class="col">
            <div class="input-group ">
                <!--mobile-->
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input type="text" id="mobile" name="mobile"
                       class="form-control"
                       v-model="mobile"
                       placeholder="شماره موبایل">


                <button class="btn btn-success" type="button"
                        v-on:click.prevent="getCustomerData($event)">برو!
                </button>

            </div>
        </div>
        <div class="col">
            <div class="input-group ">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input type="text" id="user_name" name="user_name"
                       class="form-control"
                       placeholder="نام مشتری"
                       disabled
                       :value="customerDetail.name + ' ' +  customerDetail.family">


            </div>
        </div>
        <div class="col">
            <div class="input-group">
                 <span class="input-group-text">
                     <i class="fas fa-tag"></i>
                  </span>
                <select id="id_services_category_name" name="id_services_category_name"
                        class="custom-select"
                        v-model="ServiceSearchOptionCat">
                    <option value="0">همه</option>
                    <option v-for="serviceCategory in serviceCategories"
                            :value="serviceCategory.id_services_category_name">
                        {{ serviceCategory.category_name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col">
            <autocomplete
                :search="search"
                placeholder="محصول را جستجو کنید"
                :get-result-value="getResultValue"
                :debounce-time="500"
                @submit="handleSearchSubmit"
            ></autocomplete>
        </div>


    </div>

</template>

<script>
export default {
    props: ['serviceCategories', 'getServiceData'],
    name: "PosHeader",
    data() {
        return {
            mobile: '',
            serviceCategory: [],
            ServiceSearchOptionCat: '',
            customerDetail: {
                name: '',
                family: ''
            },
            dialogTimer: 2000,
        }
    },
    methods: {
        getCustomerData(event) {
            axios.get('/admin-panel/purchase/get/customerDetail?mobile=' + this.mobile)
                .then(response => {
                    console.log('getCustomerData response = ')
                    console.log(response)
                    this.handleGetCustomerDataResponse(response)
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
                this.$root.$emit('searchNameResultReady','')
                return []
            }

            console.log('Service Name To search = ')
            console.log(input)
            return new Promise(resolve => {
                axios.get('/admin-panel/purchase/get/purchaseListByNameSearch?serviceNameLike=' + input)
                    .then(response => {
                        // console.log('response')
                        // console.log(response)
                        searchResult = response.data.searchResult;
                        resolve(searchResult)
                        // console.log('searchResult = ')
                        // console.log(searchResult)
                    })
                    .catch(e => {
                        console.log(e);
                        searchResult = ['error']
                    })

                // return new Promise(searchResult)


            })
        },
        getResultValue(result) {
            //     console.log('getResultValue')
            //     console.log(result)
            return result.service_name;
        },
        handleSearchSubmit(result) {
            console.log('You selected = ')
            console.log(result)


            if (typeof result !== 'undefined') {
              this.$root.$emit('searchNameResultReady',result)
            } else {
                console.log('no result for search')

            }
        },
        handleGetCustomerDataResponse(response) {
            if (response.data.customerDetail.length > 0) {
                Swal.fire({
                    icon: 'success',
                    title: 'مشتری پیدا شد!',
                    timer: this.dialogTimer
                })
                this.customerDetail = response.data.customerDetail[0];
                this.$emit('customerDataUpdated', this.customerDetail)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'این شماره ثبت نشده است',
                    timer: this.dialogTimer
                })
            }
        }
    },
    watch: {
        ServiceSearchOptionCat: function (val, oldVal) {
            this.$emit('ServiceCategoryFilterChanged', val);
        }
    }
}
</script>

<style scoped>
.autocomplete-input {
    border-bottom-color: transparent;
    border-radius: 8px 8px 0 0;
    background-color: red;
}
</style>
