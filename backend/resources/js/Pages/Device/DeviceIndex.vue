<template>

    <div class="container-fluid mb-5 equipment__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom rdp_statistic_mg">
<!--                    <div class="card-header">-->
<!--                        <h3 class="card-title">-->
<!--                            Все оборудование-->
<!--                        </h3>-->
<!--                    </div>-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <Link
                                    :href="route('devices.create')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5"
                                >
                                    Create new record
                                </Link>

                                <button
                                    type="submit"
                                    class="btn btn-info mb-5 ml-10"
                                    @click.prevent="findByFilter"
                                >Find</button>

                                <button
                                    type="submit"
                                    class="btn btn-dark mb-5 ml-5"
                                    @click.prevent="clearFilter"
                                >Clear filter</button>

                                <button
                                    type="submit"
                                    class="btn btn-primary mb-5 ml-5"
                                    @click="toExcel"
                                >Export Excel</button>
                            </div>
                            <div class="col-md-4">
                                <Link
                                    :href="route('equipments.index')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5 mr-5"
                                >Equipment type</Link>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <el-select
                                        v-model="filter.organization_id"
                                        class="m-0 select-category w-100"
                                        placeholder="Организация"
                                        size="large"
                                        :clearable=true
                                        @clear="eventClearOrganization"
                                    >
                                        <el-option
                                            label="All organization"
                                            :value=0
                                            :key=0
                                        />
                                        <el-option
                                            v-for="organization in organizations"
                                            :key="organization.id"
                                            :label="organization.name"
                                            :value="organization.id"
                                        />
                                    </el-select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <el-select
                                        v-model="filter.equipment_id"
                                        class="m-0 select-category w-100"
                                        placeholder="Тип оборудования"
                                        size="large"
                                        :clearable=true
                                        @clear="eventClearEquipment"
                                    >
                                        <el-option
                                            label="All equipment"
                                            :value=0
                                            :key=0
                                        />
                                        <el-option
                                            v-for="equipment in equipments"
                                            :key="equipment.id"
                                            :label="equipment.name"
                                            :value="equipment.id"
                                        />
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Hostname"
                                        v-model="filter.hostname"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Model"
                                        v-model="filter.model"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Description service"
                                        v-model="filter.description_service"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="CPU"
                                        v-model="filter.cpu"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Comment"
                                        v-model="filter.comment"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Operation system"
                                        v-model="filter.operation_system"
                                    />
                                </div>
                            </div>
                        </div>

                        <v-server-table
                                :url="url"
                                :columns="columns"
                                :options="options"
                                ref="devices-table"
                            >
                                <template v-slot:actions="{row}">

                                    <Link v-if="row.can_action" :href="route('devices.edit', {id: row.id})" method="get">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                    </Link>

                                    <a href="javascript:;" @click="deleteDevice(row)" v-if="row.can_action">
                                      <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-10-29-133027/theme/html/demo1/dist/../src/media/svg/icons/Home/Trash.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/>
                                                    <path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg><!--end::Svg Icon-->
                                      </span>
                                    </a>
                                </template>
                            </v-server-table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link, usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "DeviceIndex",
    components: {
        Link,
    },
    data() {
        return {
            urlPrepare: '/admin/devices-all-paginate?',
            url: '/admin/devices-all-paginate?',
            columns: [
                'organization.name',
                'equipment.name',
                'hostname',
                'model',
                'description_service',
                'operation_system',
                'cpu',
                'count_core',
                'count_core_with_ht',
                'memory',
                'hdd',
                'ssd',
                'address',
                'comment',
                'date_buy',
                'date_update',
                'actions'
            ],
            options: {
                // see the options API
                // https://github.com/matfish2/vue-tables-2/blob/master/lib/config/defaults.js
                perPage: 500,
                editableColumns:['text'],
                headings: {
                    hostname: 'Hostname-IP',
                    'organization.name': 'Org',
                    'equipment.name': 'Type',
                    description: 'Описание',
                    created_at: 'Время создания',
                    updated_at: 'Время обновления',
                    comment: 'Comment',
                    actions: 'Действия',
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
            organizations: null,
            equipments: null,
            filter: {
                organization_id: 0,
                equipment_id: 0,
                hostname: '',
                model: '',
                operation_system: '',
                description_service: '',
                cpu: '',
                comment: '',
            },
        }
    },
    methods: {
        deleteDevice(row) {
            Swal.fire({
                title: 'Удалить оборудование?',
                text: "Выбранное оборудование будет удалено",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да, удалить',
                cancelButtonText: 'Отмена',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/admin/devices/' + row.id).then(response => {
                        if (response.data.status === true) {
                            this.$notify({
                                group: 'foo',
                                type: 'success',
                                title: 'Удаление оборудования',
                                text: 'Оборудование успешно удалено'
                            });
                            Swal.fire(
                                'Удалено!',
                                'Оборудование удалено',
                                'success'
                            )
                            this.$refs['devices-table'].refresh();
                        }
                        if (response.data.status === false) {
                            this.$notify({
                                group: 'foo',
                                type: 'error',
                                title: 'Удаление оборудования',
                            });
                            Swal.fire(
                                'Ошибка!',
                                response.data.message,
                                'error'
                            )
                        }
                    });
                }
            })
        },

        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },

        getEquipments(){
            axios.get('/admin/equipments-all-collection')
                .then(res => {
                    this.equipments = res.data.data.equipments;
                })
        },

        findByFilter(){
            const params = new URLSearchParams();
            let oldUrl = this.url;

            if (this.filter.organization_id === 0) {
                params.append('organization_id', 0)
            }

            if (this.filter.organization_id != null && this.filter.organization_id != '0'){
                params.append('organization_id', this.filter.organization_id)
            }

            if (this.filter.equipment_id != null){
                params.append('equipment_id', this.filter.equipment_id)
            }

            if (this.filter.hostname.length > 0){
                params.append('hostname', this.filter.hostname)
            }

            if (this.filter.model.length > 0){
                params.append('model', this.filter.model)
            }

            if (this.filter.operation_system.length > 0){
                params.append('operation_system', this.filter.operation_system)
            }

            if (this.filter.description_service.length > 0){
                params.append('description_service', this.filter.description_service)
            }

            if (this.filter.cpu.length > 0){
                params.append('cpu', this.filter.cpu)
            }

            if (this.filter.comment.length > 0){
                params.append('comment', this.filter.comment)
            }

            this.setCacheFilter();

            if (params.toString().length > 0) {
                this.url = this.urlPrepare + params.toString();
            }

            if (this.url === oldUrl) {
                this.$refs['devices-table'].refresh();
            }
        },

        setCacheFilter(){
            localStorage.setItem('device', JSON.stringify(this.filter))
        },

        retrieveCacheFilterData(cache){
            this.filter = {
                organization_id:  cache.organization_id,
                equipment_id:  cache.equipment_id,
                hostname:  cache.hostname,
                model:  cache.model,
                operation_system:  cache.operation_system,
                description_service:  cache.description_service,
                cpu:  cache.cpu,
                comment:  cache.comment,
            };

            this.findByFilter()
        },

        clearFilter(){
            this.filter = {
                organization_id: 0,
                equipment_id: 0,
                hostname: '',
                model: '',
                operation_system: '',
                description_service: '',
                cpu: '',
                comment: '',
            };

            this.url = this.urlPrepare;

            localStorage.removeItem('device')
        },

        toExcel(){
            let time = new Date()

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

        eventClearOrganization(){
            this.filter.organization_id = 0
        },

        eventClearEquipment(){
            this.filter.equipment_id = 0
        },
    },

    // created() {
    //   window.Echo.channel('update_device')
    //       .listen('.update_device', res => {
    //           console.log(res)
    //       })
    // },
    //
    // unmounted() {
    //     Echo.leaveChannel(`update_device`);
    // },

    mounted() {
        if (localStorage.getItem('device') !== null) {
            this.retrieveCacheFilterData(JSON.parse(localStorage.getItem('device')));
        }
        this.getOrganizations();
        this.getEquipments();
    }
}
</script>

<style scoped>

</style>
