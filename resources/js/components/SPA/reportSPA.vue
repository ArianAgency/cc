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
            <!--Branch Selector-->
            <div class="col animated fadeIn" v-if="chartView==='salePerCustomerType' ||
                chartView==='clubSummary'">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-building"></i>
                        </span>
                    </div>
                    <select id="education" name="education"
                            class="custom-select"
                            v-model="date.businesse_id">
                        <option :value="user.businesse_id"
                                :selected="date.businesse_id === user.businesse_id">
                            اصلی
                        </option>
                        <template v-for="Branch in Branches">
                            <option :value="Branch.id_businesses"
                                    :selected="date.businesse_id === Branch.id_businesses">
                                {{ Branch.brand_name + ' ' + Branch.company_name }}
                            </option>
                        </template>
                    </select>
                </div>

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
                <button class="btn btn-primary m-1 btn-block " @click="chartView='salePerCustomerType'">
                    فروش / نوع مشتری
                </button>
                <button class="btn btn-primary m-1 btn-block " @click="chartView='saleCountAndVolume'">
                    تعداد و حجم فروش
                </button>
                <button class="btn btn-primary m-1 btn-block " @click="chartView='clubSummary'">
                    وضعیت باشگاه
                </button>
            </div>
            <div class="col-10">
                <customer-analyze class="animated fadeIn"
                                  v-if="chartView === 'customerAnalyze'" :date="date"/>
                <customer-analyze-volume-percent
                    class="animated fadeIn"
                    v-if="chartView === 'customerAnalyzeVolumePercent'" :date="date"/>
                <sale-per-customer-type
                    class="animated fadeIn"
                    v-if="chartView === 'salePerCustomerType'" :date="date"/>
                <sale-count-and-volume
                    class="animated fadeIn"
                    v-if="chartView === 'saleCountAndVolume'" :date="date"/>
                <club-summary
                    class="animated fadeIn"
                    v-if="chartView === 'clubSummary'" :date="date"/>
            </div>

        </div>

    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import VueContentLoading from "vue-content-loading";

export default {
    props: ['user'],
    name: "reportSPA",
    components: {
        datePicker: VuePersianDatetimePicker
    },
    data() {
        return {
            date: {
                start: '',
                end: '',
                defaultDif: 90,
                businesse_id: this.user.businesse_id
            },
            chartView: 'customerAnalyze',
            Branches: []
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
        },
        getBranches() {
            axios.get('/admin-panel/report/get/businessBranches')
                .then(response => {
                    console.log('getBranches =')
                    console.log(response)
                    this.Branches = response.data.dataList;
                })
                .catch(e => {
                    this.errors.push(e)
                    console.log(e)
                })
        }
    },
    mounted() {
        this.date.end = this.getTodayDate();
        this.calculateSecondReportDate(this.date.defaultDif);
        this.getBranches();
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
