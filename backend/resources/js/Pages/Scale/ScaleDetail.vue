<template>
    <div>
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom height-profile rdp_statistic_mg">
                        <!--                    <div class="card-header">-->
                        <!--                        <h3 class="card-title">-->
                        <!--                            {{ id }}-->
                        <!--                        </h3>-->
                        <!--                    </div>-->

                        <div class="container mt-5 pb-5">
                            <h2 class="mb-4 text-center">Весы</h2>
                            <Line id="my-chart-id"
                                  :options="chartOptions"
                                  :data="chartData"
                                  ref="chartRef"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mb-5 equipment__container">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-custom rdp_statistic_mg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <Link
                                        :href="route('scales.index')"
                                        as="button"
                                        method="get"
                                        class="btn btn-success mb-5 mr-5"
                                    >
                                        Назад
                                    </Link>

                                    <button
                                        type="submit"
                                        class="btn btn-primary mb-5 mr-5"
                                        @click.prevent="findByFilter"
                                    >Найти</button>

                                    <button
                                        type="reset"
                                        class="btn btn-secondary mb-5"
                                        @click="clearFilter"
                                    >Сброс</button>
                                </div>
                                <div class="col-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary mb-5 ml-5"
                                        @click="toExcel"
                                    >Export Excel</button>

                                    <button
                                        type="submit"
                                        class="btn btn-primary mb-5 ml-5"
                                        @click="zoomReset"
                                    >RESET ZOOM</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-2">
                                        <div class="form-group select-form_group">
                                            <label>Начальная дата:</label>
                                            <el-date-picker
                                                v-model="filter.date_start"
                                                type="datetime"
                                                placeholder="Select date and time"
                                                :shortcuts="shortcuts"
                                                :size="'default'"
                                                :value-format="'YYYY-MM-DD HH:mm:ss'"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group select-form_group">
                                            <label>Конечная дата:</label>
                                            <el-date-picker
                                                v-model="filter.date_end"
                                                type="datetime"
                                                placeholder="Select date and time"
                                                :shortcuts="shortcuts"
                                                :size="'default'"
                                                :value-format="'YYYY-MM-DD HH:mm:ss'"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <v-server-table
                                :url="url"
                                :columns="columns"
                                :options="options"
                                @loaded="onLoaded"
                                ref="scale"
                            ></v-server-table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { Line } from 'vue-chartjs'
import zoomPlugin from 'chartjs-plugin-zoom';

import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import {Link} from "@inertiajs/inertia-vue3";
ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

ChartJS.register(
    CategoryScale,
    LinearScale,
    Title,
    Tooltip,
    Legend,
    zoomPlugin
)

export default {
    name: "ScaleDetail",

    components: {
        Link,
        Line,
    },

    props: {
        id: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            shortcuts: [
                {
                    text: 'Today',
                    value: new Date(),
                },
                {
                    text: 'Yesterday',
                    value: () => {
                        const date = new Date()
                        date.setTime(date.getTime() - 3600 * 1000 * 24)
                        return date
                    },
                },
                {
                    text: 'A week ago',
                    value: () => {
                        const date = new Date()
                        date.setTime(date.getTime() - 3600 * 1000 * 24 * 7)
                        return date
                    },
                },
            ],
            filter: {
                date_start: null,
                date_end: null,
                scale_id: null,
            },
            chartInterval: null,
            urlPrepare: '/admin/scale-detail?id=' + this.id + "&",
            url: '/admin/scale-detail?id=' + this.id + "&",

            columns: [
                'id',
                'weight',
                'created_at',
            ],

            options: {
                // see the options API
                // https://github.com/matfish2/vue-tables-2/blob/master/lib/config/defaults.js
                perPage: 500,
                editableColumns:['text'],
                headings: {
                    id: 'Идентификатор',
                    weight: 'Вес',
                    created_at: 'Дата создания',
                    // send_error_notification: 'Отправлено уведомление об ошибке',
                    // updated_at: 'Дата последнего обновления',
                },
                texts: {
                    limit: 'Вывод записей',
                    count: "Показано с {from} по {to} из {count} записей|{count} записей|Одна запись",
                    noResults: "Ничего не нашлось",
                    loading: "Загрузка...",
                },
                // perPageValues: [10,25,30,35,50,100],
                perPageValues: [],
                skin: "VueTables__table " +
                    "table " +
                    "table-striped " +
                    "table-bordered " +
                    "VueTables__child-row " +
                    "table-vue-width " +
                    "table-hover ",
                filterable: false,
                requestAdapter: function(data) {
                    return data;
                },
                responseAdapter: function(resp) {
                    var data = this.getResponseData(resp);

                    return {
                        data: data.data,
                        count: data.count
                    };
                },
            },

            // char documentation https://www.chartjs.org/docs/latest/configuration/elements.html
            chartData: {
                labels: [],
                datasets: []
            },

            chartOptions: {
                radius: 3,
                legend: {
                    display: true
                },
                responsive: true,
                plugins: {
                    // title: {
                    //     display: true,
                    //     text: 'Scale with ip 127.0.0.1'
                    // },
                    // tooltip: {
                    //     callbacks: {
                    //         title: function(context) {
                    //             console.log(context)
                    //             return 'title'
                    //         },
                    //         label: function(context) {
                    //             console.log(context)
                    //             return 'label'
                    //         }
                    //     }
                    // }
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'xy'
                        },
                        zoom: {
                            wheel: {
                                enabled: true,
                            },
                            pinch: {
                                enabled: true
                            },
                            mode: 'xy',
                        }
                    }
                },
            },
        }
    },

    methods: {
        onLoaded(data) {
            let entities = data.data.data
            let scale = data.data.scale

            let labels = []
            let weight = []

            entities.forEach((el) => {
                labels.push(el.created_at)
                weight.push(el.weight)
            })


            let dataForChart =
                {
                    labels: labels,
                    datasets: [
                        {
                            data: weight,
                            label: scale.ip_address,
                            fill: false,
                            borderColor: '#2554FF',
                            backgroundColor: '#2554FF',
                            borderWidth: 1
                        }
                    ]
                }

            this.chartData = dataForChart

        },

        refreshTable() {
            let table = this.$refs['scale']
            if (table !== null) {
                table.refresh()
            }
        },

        clearFilter() {
            this.filter = {
                date_start: new Date().toISOString().slice(0, 10) + " 00:00:00",
                date_end: this.currentDate(),
            }

            this.url = this.urlPrepare
            this.zoomReset()
        },

        findByFilter(){
            const params = new URLSearchParams();
            let oldUrl = this.url;

            if (this.filter.date_start != null) {
                params.append('date_start', this.filter.date_start)
            }

            if (this.filter.date_end != null) {
                params.append('date_end', this.filter.date_end)
            }

            if (params.toString().length > 0) {
                this.url = this.urlPrepare + params.toString();
            }

            if (this.url === oldUrl) {
                this.$refs['scale'].refresh();
            }
        },

        currentDate() {
            // console.log(new Date().toISOString())
            // return new Date().toISOString().slice(0, 10)
            return this.formatDate()
        },

        padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        },

        formatDate() {
            let date = new Date()
            return (
                [
                    date.getFullYear(),
                    this.padTo2Digits(date.getMonth() + 1),
                    this.padTo2Digits(date.getDate()),
                ].join('-') +
                ' ' +
                [
                    this.padTo2Digits(date.getHours()),
                    this.padTo2Digits(date.getMinutes()),
                    this.padTo2Digits(date.getSeconds()),
                ].join(':')
            );
        },

        toExcel(){
            let time = new Date()
            this.filter.scale_id = this.id

            axios({
                method:'GET',
                url: '/admin/export',
                responseType: 'blob',
                params: this.filter
            })
                .then((response) => {
                    if (response.status === 200){
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', `excel_devices_${time.toLocaleDateString() + '_' + time.toLocaleTimeString()}.xlsx`); //or any other extension
                        document.body.appendChild(link);
                        link.click();
                    }
                });
        },

        zoomReset() {
            this.$refs['chartRef'].chart.resetZoom()
        },
    },

    unmounted() {
        clearInterval( this.chartInterval )
    },

    mounted() {
        this.chartInterval = setInterval(function() {
            this.refreshTable()
        }.bind(this), 1 * 60 * 1000);

        this.filter = {
            date_start: new Date().toISOString().slice(0, 10) + " 00:00:00",
            date_end: this.currentDate(),
        }
    }
}
</script>

<style scoped>

</style>
