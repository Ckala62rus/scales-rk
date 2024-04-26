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
                                  ref="line"
                            />
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="container-fluid mb-5 equipment__container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom rdp_statistic_mg">
                        <!--                    <div class="card-header">-->
                        <!--                        <h3 class="card-title">-->
                        <!--                            Список оборудования-->
                        <!--                        </h3>-->
                        <!--                    </div>-->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <Link
                                        :href="route('scales.index')"
                                        as="button"
                                        method="get"
                                        class="btn btn-success mb-5"
                                    >
                                        Назад
                                    </Link>
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

ChartJS.register(CategoryScale, LinearScale, Title, Tooltip, Legend)

export default {
    name: "ScaleDetail",

    components: {
        Link,
        Line
    },

    props: {
        id: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            chartInterval: null,

            url: '/admin/scale-detail?id=' + this.id,

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
                // plugins: {
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
                // },
            },
        }
    },

    methods: {
        onLoaded(data) {
            let entities = data.data.data
            let scale = data.data.scale

            let labels = []
            let weight = []

            // console.log(scale)

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
    },

    unmounted() {
        clearInterval( this.chartInterval )
    },

    mounted() {
        this.chartInterval = setInterval(function() {
            this.refreshTable()
        }.bind(this), 2 * 60 * 1000);
    }
}
</script>

<style scoped>

</style>
