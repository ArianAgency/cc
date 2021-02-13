<template>
    <div>
        <table-template
            title="تبدیلات امتیاز"
            :headers="['عنوان','مقدار تخفیف','درصد تخفیف','امتیاز لازم','اعتبار تا','فعال شده در','فعال برای']"
            :value-keys="['convertor_name','off_value','off_percent','score_cost','expire','created_at','grouped_names']"
            :get-url="'/customer-panel/testTable/get/score_converts'"
            :pagination="false"
            :has-call-back="true"
            disable-call-back-on="created_at"
            @callback="convertScore"
        ></table-template>
    </div>
</template>

<script>
export default {
    name: "customerScoreConvertor",
    methods: {
        convertScore(data) {
            axios.get('../testTable/do/convertScore?id='+data.id_score_convertor)
                .then(response => {
                    this.data = response.data;
                    console.log('data = ');
                    console.log(this.data);
                    this.data = response.data.dataList;
                    if (this.pagination) {
                        this.dataList = response.data.dataList.data;
                    } else {
                        this.dataList = response.data.dataList;
                    }

                    console.log('this.data = ');
                    console.log(this.data);
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
</script>

<style scoped>

</style>
