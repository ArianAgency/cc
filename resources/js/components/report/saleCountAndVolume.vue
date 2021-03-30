<template>
    <div>

        <v-chart class="chart" :option="option"/>

    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    name: "saleCountAndVolume",
    props: ['date'],
    data() {
        return {
            option: {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross'
                    }
                },
                grid: {
                    right: '20%'
                },
                toolbox: {
                    feature: {
                        saveAsImage: {show: true}
                    }
                },
                legend: {
                    data: ['حجم', 'تعداد']
                },
                xAxis: {
                    type: 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    data: ['1', '2', '3', '4', '5']
                },
                yAxis: [
                    {
                        type: 'value',
                        name: 'حجم',
                        position: 'right',
                        axisLine: {
                            show: true,
                        },
                        axisLabel: {
                            formatter: '{value} تومان'
                        }
                    },
                    {
                        type: 'value',
                        name: 'تعداد',
                        position: 'left',
                        axisLine: {
                            show: true,
                        },
                        axisLabel: {
                            formatter: '{value} نفر'
                        }
                    }
                ],
                series: [
                    {
                        name: 'حجم',
                        type: 'bar',
                        data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 262.2, 32.6, 20.0, 6.4, 3.3]
                    },
                    {
                        name: 'تعداد',
                        type: 'line',
                        smooth: true,
                        yAxisIndex: 1,
                        data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 523.0, 16.5, 12.0, 6.2]
                    }
                ],
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
            axios.get('/admin-panel/report/get/saleCountAndVolume?startDate=' + date.start + '&endDate=' + date.end)
                .then(response => {
                    console.log('getChartData =')
                    console.log(response)
                    console.log(response.data.dataList)
                    let totalSaleCount = [];
                    let totalSaleVolume = [];

                    let date = [];

                    response.data.dataList.forEach(function (data) {
                        totalSaleCount.push(data.totalSaleCount);
                        totalSaleVolume.push(data.totalSaleVolume);
                        date.push(data.date);
                    });

                    this.option.series[0].data = totalSaleVolume;
                    this.option.series[1].data = totalSaleCount;
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
