<template>
    <div>

        <v-chart class="chart" :option="option"/>

    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    name: "salePerCustomerType",
    props:['date'],
    data() {
        return {

            option: {
                title: {
                    text: 'فروش بر اساس نوع مشتری'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['جدید', 'قدیمی', 'کل فروش']
                },
                textStyle: {
                    fontFamily: 'Samim'
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name: 'جدید',
                        type: 'line',
                        step: 'middle',
                        data: [120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name: 'قدیمی',
                        type: 'line',
                        step: 'middle',
                        data: [220, 282, 201, 234, 290, 430, 410]
                    },
                    {
                        name: 'کل فروش',
                        type: 'line',
                        step: 'middle',
                        data: [220, 282, 201, 234, 290, 430, 410]
                    },
                ],

                animation: true,
                animationThreshold: 2000,
                animationDuration: 1000,
                animationEasing: 'cubicOut',
                animationDelay: 100,
            }
        }
    },
    methods: {
        getChartData(date) {
            axios.get('/admin-panel/report/get/salePerCustomerType?startDate=' + date.start + '&endDate=' + date.end+ '&business_id=' + date.businesse_id)
                .then(response => {
                    console.log('getChartData =')
                    console.log(response)
                    console.log(response.data.dataList)
                    let newSale = [];
                    let oldSale = [];
                    let totalSale = [];

                    let date = [];
                    response.data.dataList.forEach(function (data) {
                        newSale.push(data.newSale);
                        oldSale.push(data.oldSale);
                        totalSale.push(data.totalSale);
                        date.push(data.date);
                    });

                    this.option.series[0].data = newSale; //مشتریان جدید
                    this.option.series[1].data = oldSale; //مشتریان قدیمی
                    this.option.series[2].data = totalSale; //تعداد کل فروش
                    this.option.xAxis.data = date;

                })
                .catch(e => {
                    this.errors.push(e)
                    console.log(e)
                })
        },
    },
    mounted() {
        this.getChartData(this.date)
    },
    watch: {
        date: {
            handler: function (newDate) {
                // console.log('Current vaules:' + newValue.end );
                if (this.date.start.length > 0 && this.date.end.length > 0) {
                }

                this.getChartData(this.date);
            },
            deep: true
        }
    }
};
</script>

<style scoped>
.chart {
    height: 400px;
    width: 900px;
    margin: 0 auto;

}
</style>
