<template>

    <div>
        <div class="animated fadeIn">
            <div class="card div-body">

                <slot name="header"></slot>
                <div class="card-body">
                    <table class="table table-responsive-sm table-striped mytable">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>کسب و کار</th>
                            <th>وضعیت</th>
                            <th></th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>

                        <tbody class="animated fadeIn">

                        <tr v-for="(tagList,index) in tagList">

                            <td>{{index +1}}</td>

                            <td>{{tagList.tag_name}}</td>
                            <td>{{tagList.id_business}}</td>

                            <td v-bind:id="'sw_lb_'+ tagList.id_tag">
                                <span v-if=" tagList.is_active == 1 " class="badge badge-success">فعال</span>
                                <span v-else class="badge badge-secondary">غیر فعال</span>
                            </td>
                            <td><label class="switch switch-text switch-pill switch-info-outline-alt">
                                <input type="checkbox" class="switch-input" v-bind:checked="tagList.is_active"
                                       v-bind:id="'sw_' + tagList.id_tag"
                                       v-on:click="check($event,tagList.id_tag)">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label></td>
                            <th v-on:click="DataToManipulateForm(tagList)">
                                <a href="#">
                                    <i class="fa fa-edit"/>
                                </a>
                            </th>
                        </tr>


                        </tbody>
                    </table>
                    <template>
                        <vue-content-loading :width="500" :height="5">
                            <rect rx="1.5" ry="1.5" width="500" height="5"/>
                        </vue-content-loading>
                    </template>

                    <ul class="pagination">
                        <li class="page-item" v-if="data.response.current_page>1 && data.response.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getTags(data.response.prev_page_url)">قبلی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">قبلی</a></li>

                        <li class="page-item" v-show="data.response.current_page>1 && data.response.prev_page_url !==null"><a
                            class="page-link" href="#"
                            v-on:click="getTags(data.response.prev_page_url)">{{data.response.current_page
                            - 1}}</a>
                        </li>


                        <li class="page-item active"><a class="page-link" href="#">{{data.response.current_page}}</a></li>

                        <li class="page-item" v-show="data.response.next_page_url !==null"><a class="page-link" href="#"
                                                                                          v-on:click="getTags(data.response.next_page_url)">{{data.response.current_page
                            + 1}}</a>
                        </li>


                        <li class="page-item" v-if="data.response.next_page_url !==null"><a class="page-link" href="#"
                                                                                        v-on:click="getTags(data.response.next_page_url)">بعدی</a>
                        </li>
                        <li class="page-item disabled" v-else><a class="page-link " href="#">بعدی</a></li>

                    </ul>

                    <li class="page-item text-center">صفحه {{data.response.last_page}} از {{data.response.current_page}}</li>

                </div>
            </div>
        </div>


    </div>


</template>

<script>
    import VueContentLoading from 'vue-content-loading';

    export default {
        components: {
            VueContentLoading,
        },
        data() {
            return {
                data: '',
                tagList: {}
            }
        },
        methods: {
            check(event, id_tag) {
                const vm = this;
                var status = event.target.checked;
                if (status == true) {
                    status = 1;
                } else {
                    status = 0;
                }

                // console.log('status : ' + status);
                // console.log('event.id : ' + event.target.id);
                var label_id = event.target.id.substring(0, 3) + 'lb_' + id_tag;
                // console.log('label_id : ' + label_id);
                // console.log('id_customer : ' + id_customer);

                axios.post('/admin-panel/customer/action/tagActivationStatus', {
                    id_tag: id_tag,
                    value: status
                })
                    .then(function (response) {
                        if (status == 1) {
                            // $('#' + label_id).innerHTML = ' <span  class="badge badge-success">فعال</span>';
                            $('#' + label_id).html('<span  class="badge badge-success">فعال</span>');
                        } else {
                            // $('#' + label_id).innerHTML = '  <span  class="badge badge-secondary" >غیر فعال</span>';
                            $('#' + label_id).html(' <span  class="badge badge-secondary" >غیر فعال</span>');
                        }
                    })
                    .catch(function (error) {
                        console.log('error : ' + error);
                    });
            },
            getTags(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data
                        console.log('data = ')
                        console.log(this.data)
                        this.tagList = response.data.response.data;
                        console.log('response = ')
                        console.log(this.tagList)
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            DataToManipulateForm(toEdit){
                this.$root.$emit('EditTag',toEdit)
            }
        },
        created: function () {
            console.log('ServiceTableComponent created.')

        },
        mounted: function () {
            console.log('ServiceTableComponent mounted.')
            this.getTags('/admin-panel/customer/get/tags');

            this.$root.$on('NewTagAdded', () => {
                // your code goes here
                this.getTags('/admin-panel/customer/get/tags');
            })
        },

    }
</script>

<style scoped>


</style>
