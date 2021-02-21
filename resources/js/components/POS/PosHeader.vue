<template>
    <div class="container-fluid row h-100 ">
        <div class="col-4"></div>
        <div class="col-4">
            <div class="input-group">
                 <span class="input-group-text">
                     <i class="fas fa-tag"></i>
                  </span>
                <select id="role_id" name="role_id"
                        class="custom-select"
                        v-model="ServiceSearchOptionCat">
                    <!--<option value="0">سطح دسترسی</option>-->
                    <option v-for="serviceCategories in serviceCategory"
                            :value="serviceCategory.id_services_category_name">
                        {{ serviceCategory.category_name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-4">
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
    name: "PosHeader",
    data() {
        return {
            serviceCategory: [],
            ServiceSearchOptionCat: '',

        }
    },
    methods: {
        //search
        search(input) {
            let searchResult;
            if (input.length <= 2) {
                console.log('input.length <= 2')
                this.getData(this.getUrl);
                return []
            }

            console.log('value = ')
            console.log(input)
            console.log('searchMode = ')
            console.log(this.searchMode)
            return new Promise(resolve => {
                axios.get('/admin-panel/purchase/get/historyByInput?filter=' + this.searchMode + '&value=' + input)
                    .then(response => {
                        console.log('response')
                        console.log(response)
                        searchResult = response.data.searchResult;
                        resolve(searchResult)
                        console.log('searchResult = ')
                        console.log(searchResult)
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
            return result.invoice_no
        },
        handleSearchSubmit(result) {
            console.log('You selected = ')
            console.log(result)
            console.log(this.dataList)
            this.dataList = [];
            if (typeof result !== 'undefined') {
                this.dataList.push(result);
            } else {
                console.log(this.data)
                this.dataList = this.data;
            }
        },
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
