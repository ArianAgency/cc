<template>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!--totalCustomersInRange-->
                <div class="col">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="h1 text-muted text-right mb-4">
                                <i class="icon-people"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.totalCustomersInRange) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">تعداد مشتریان</small>
                        </div>
                    </div>
                </div>
                <!--totalSalesCountInRange-->
                <div class="col">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="h1 text-muted text-right mb-4">
                                <i class="icon-user-follow"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.totalSalesCountInRange) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">تعداد فروش</small>
                        </div>
                    </div>
                </div>
                <!--totalSaleVolumeInRange-->
                <div class="col">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="h1 text-muted text-right mb-4">
                                <i class="icon-pie-chart"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.totalSaleVolumeInRange) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">میزان فروش</small>
                        </div>
                    </div>
                </div>
                <!--availableCredit-->
                <div class="col">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="h1 text-muted text-right mb-4">
                                <i class="icon-speedometer"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.availableCredit) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">میزان اعتبار در دسترس</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--todayNewCustomers-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 text-info text-right mb-4 ">
                                <i class="icon-people"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.todayNewCustomers) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">مشتریان جدید امروز</small>
                        </div>
                    </div>
                </div>
                <!--todaySalesCount-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 text-success text-right mb-4">
                                <i class="icon-user-follow"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.todaySalesCount) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">تعداد فروش امروز</small>
                        </div>
                    </div>
                </div>
                <!--todaySaleVolume-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 text-primary text-right mb-4">
                                <i class="icon-pie-chart"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.todaySaleVolume) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">میزان فروش امروز</small>
                        </div>
                    </div>
                </div>
                <!--todayCreditBonusVolume-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="h1 text-danger text-right mb-4">
                                <i class="icon-speedometer"></i>
                            </div>
                            <div class="h4 mb-0">{{ numberWithCommas(dataToShow.todayCreditBonusVolume) }}</div>
                            <small class="text-muted text-uppercase font-weight-bold">میزان پاداش اعتبار امروز</small>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
    </div>
</template>

<script>
export default {
    name: "clubSummary",
    props: ['date'],
    data() {
        return {
            dataToShow: {
                totalCustomersInRange: 0,
                totalSalesCountInRange: 0,
                totalSaleVolumeInRange: 0,
                availableCredit: 0,
                todayNewCustomers: 0,
                todaySalesCount: 0,
                todaySaleVolume: 0,
                todayCreditBonusVolume: 0,
            }
        }
    },
    methods: {
        getChartData(date) {
            axios.get('/admin-panel/report/get/clubSummary?startDate=' + date.start + '&endDate=' + date.end + '&business_id=' + date.businesse_id)
                .then(response => {
                    console.log('getChartData =')
                    console.log(response)
                    console.log(response.data.dataList)
                    this.dataToShow.totalCustomersInRange = response.data.dataList[0].totalCustomersInRange;
                    this.dataToShow.totalSalesCountInRange = response.data.dataList[0].totalSalesCountInRange;
                    this.dataToShow.totalSaleVolumeInRange = response.data.dataList[0].totalSaleVolumeInRange;
                    this.dataToShow.availableCredit = response.data.dataList[0].availableCredit;
                    this.dataToShow.todayNewCustomers = response.data.dataList[0].todayNewCustomers;
                    this.dataToShow.todaySalesCount = response.data.dataList[0].todaySalesCount;
                    this.dataToShow.todaySaleVolume = response.data.dataList[0].todaySaleVolume;
                    this.dataToShow.todayCreditBonusVolume = response.data.dataList[0].todayCreditBonusVolume;
                })
                .catch(e => {
                    this.errors.push(e)
                    console.log(e)
                })
        },
        numberWithCommas(string) {
            return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
    mounted() {
        this.getChartData(this.date);
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
}
</script>

<style scoped>

</style>
