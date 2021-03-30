<template>
    <div>

                <v-chart class="chart" :option="option"/>

    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    name: "customerAnalyze",
    props:['date'],
    data() {
        return {

            option: {
                title: {
                    text: 'تحلیل رفتار مشتریان'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['جدید', 'فعال', 'بازگشته', 'از دست رفته', 'غیر فعال']
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
                        step: 'start',
                        data: [120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name: 'فعال',
                        type: 'line',
                        step: 'middle',
                        data: [220, 282, 201, 234, 290, 430, 410]
                    },
                    {
                        name: 'بازگشته',
                        type: 'line',
                        step: 'end',
                        data: [450, 432, 401, 454, 590, 530, 510]
                    },
                    {
                        name: 'از دست رفته',
                        type: 'line',
                        step: 'end',
                        data: [440, 442, 441, 494, 520, 580, 520]
                    },
                    {
                        name: 'غیر فعال',
                        type: 'line',
                        step: 'end',
                        data: [550, 532, 501, 554, 690, 630, 610]
                    }
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
            axios.get('/admin-panel/report/get/customerAnalyze?startDate=' + date.start + '&endDate=' + date.end)
                .then(response => {
                    console.log('getChartData =')
                    console.log(response)
                    console.log(response.data.dataList)
                    let x = [];
                    let y = [];
                    let w = [];
                    let z = [];
                    let date = [];
                    response.data.dataList.forEach(function (data) {
                        x.push(data.X);
                        y.push(data.Y);
                        w.push(data.W);
                        z.push(data.Z);
                        date.push(data.date);
                    });
                    // this.option.series[0].data = '';
                    this.option.series[1].data = w; //مشتریان فعال
                    this.option.series[2].data = x;//بازگشته
                    this.option.series[3].data = y;//از دست رفته
                    this.option.series[4].data = z;//غیر فعال
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
