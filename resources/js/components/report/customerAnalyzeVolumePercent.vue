<template>
    <div>

        <v-chart class="chart" :option="option"/>

    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    name: "customerAnalyzeVolumePercent",
    components: {
        datePicker: VuePersianDatetimePicker
    },
    props:['date'],
    data() {
        return {

            option: {
                title: {
                    text: 'نمودار تجمعی کل مشتریان باشگاه برای هر کسب و کار',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                },
                series: [
                    {
                        name: 'درصد از کل',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            {value: 1048, name: 'جدید'},
                            {value: 735, name: 'فعال'},
                            {value: 580, name: 'بازگشته'},
                            {value: 484, name: 'از دست رفته'},
                            {value: 300, name: 'غیر فعال'}
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
                //
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                textStyle: {
                    fontFamily: 'Samim'
                },
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
