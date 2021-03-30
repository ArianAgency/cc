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
    props: ['date'],
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
            axios.get('/admin-panel/report/get/customerAnalyzeVolume?startDate=' + date.start + '&endDate=' + date.end)
                .then(response => {
                    console.log('getChartData =')
                    console.log(response)
                    console.log(response.data.dataList)
                    let n = 0;
                    let x = 0;
                    let y = 0;
                    let w = 0;
                    let z = 0;

                    x = response.data.dataList[0].X;
                    y = response.data.dataList[0].Y;
                    w = response.data.dataList[0].W;
                    z = response.data.dataList[0].Z;

                    this.option.series[0].data[0].value = n; //مشتریان جدید
                    this.option.series[0].data[1].value = w; //مشتریان فعال
                    this.option.series[0].data[2].value = x;//بازگشته
                    this.option.series[0].data[3].value = y;//از دست رفته
                    this.option.series[0].data[4].value = z;//غیر فعال

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
