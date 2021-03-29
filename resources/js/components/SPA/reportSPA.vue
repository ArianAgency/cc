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
        <div class="row m-2">
            <div class="col-2  ">
                <button class="btn btn-primary m-1 btn-block" @click="chartView='customerAnalyze'">
                    رفتار خرید
                </button>
                <button class="btn btn-primary m-1 btn-block " @click="chartView='customerAnalyzeVolumePercent'">
                    درصد تجمعی
                </button>
            </div>
            <div class="col-10">
                <customer-analyze class="animated fadeIn"
                                  v-if="chartView === 'customerAnalyze'" :date="date"/>
                <customer-analyze-volume-percent
                    class="animated fadeIn"
                    v-if="chartView === 'customerAnalyzeVolumePercent'" :date="date"/>
            </div>

        </div>

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
            chartView: 'customerAnalyze'
        }
    },
    methods: {
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

};
</script>

<style scoped>
.chart {
    height: 400px;
    width: 900px;
    margin: 0 auto;

}
</style>
