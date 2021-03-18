<template>
    <div>
        <div class=" row m-3 d-flex align-items-center">

            <!--days BTNs-->
            <div class="col">
                <button class="btn btn-success btn-sm "
                        @click="calculateSecondReportDate(30)"> 30 روز
                </button>
                <button class="btn btn-success btn-sm "
                        @click="calculateSecondReportDate(60)"> 60 روز
                </button>
                <button class="btn btn-success btn-sm "
                        @click="calculateSecondReportDate(90)"> 90 روز
                </button>
                <button class="btn btn-success btn-sm "
                        @click="calculateSecondReportDate(120)"> 120 روز
                </button>
            </div>
            <!--startDate-->
            <div class="col">
                <div class="input-group">
                                                           <span class="input-group-text"><i
                                                               class="fa fa-birthday-cake"></i></span>

                    <input type="text" id="startDate" name="startDate"
                           class="form-control"
                           v-model="date.start"
                           placeholder="تاریخ شروع">
                    <date-picker v-model="date.start"
                                 element="startDate"
                                 format="YYYY-MM-DD"></date-picker>
                </div>
            </div>
            <!--endDate-->
            <div class="col">
                <div class="input-group">
                <span class="input-group-text">
                       <i class="far fa-calendar-times"></i>
                </span>

                    <input type="text" id="endDate" name="endDate"
                           class="form-control"
                           v-model="date.end"
                           placeholder="تاریخ پایان">
                    <date-picker v-model="date.end"
                                 element="endDate"
                                 format="YYYY-MM-DD"></date-picker>
                </div>
            </div>
        </div>
        <v-chart class="chart" :option="option"/>
    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    name: "HelloWorld",
    components: {
        datePicker: VuePersianDatetimePicker
    },
    data() {
        return {
            date: {
                start: '',
                end: '',
                defaultDif: 90
            },
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
        getTodayDate() {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();

            return (yyyy + '-' + mm + '-' + dd);
        },
        calculateSecondReportDate(difDays) {
            let past = new Date();
            past.setDate(new Date().getDate() - difDays);
            let dd = String(past.getDate()).padStart(2, '0');
            let mm = String(past.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = past.getFullYear();

            this.date.start = (yyyy + '-' + mm + '-' + dd);
        }
    },
    mounted() {
        this.date.end = this.getTodayDate();
        this.calculateSecondReportDate(this.date.defaultDif);
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
