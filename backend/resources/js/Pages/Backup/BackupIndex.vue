<template>

    <div class="container-fluid mb-5 equipment__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom rdp_statistic_mg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <Link
                                    :href="route('backups.create')"
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
                                    :href="route('backup-days.index')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5 mr-5"
                                >Backup day</Link>
                                <Link
                                    :href="route('backup-objects.index')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5 mr-5"
                                >Backup object</Link>
                                <Link
                                    :href="route('backup-tools.index')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5 mr-5"
                                >Backup tools</Link>
                                <Link
                                    :href="route('backup-priorities.index')"
                                    as="button"
                                    method="get"
                                    class="btn btn-success mb-5"
                                >Backup priority</Link>
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
                                        @clear="eventClear"
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
                                        placeholder="Service"
                                        v-model="filter.service"
                                    />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Storage server"
                                        v-model="filter.storage_server"
                                    />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <el-select
                                        v-model="filter.backup_priority_id"
                                        class="m-0 select-category w-100"
                                        placeholder="Backup priority"
                                        size="large"
                                        :clearable=true
                                        @clear="eventClearPriority"
                                    >
                                        <el-option
                                            label="All priorities"
                                            :value=0
                                            :key=0
                                        />
                                        <el-option
                                            v-for="backupPriority in backupPriorities"
                                            :key="backupPriority.id"
                                            :label="backupPriority.name"
                                            :value="backupPriority.id"
                                        />
                                    </el-select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Owner"
                                        v-model="filter.owner"
                                    />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <el-select
                                        v-model="filter.backup_object_id"
                                        class="m-0 select-category w-100"
                                        placeholder="Object"
                                        size="large"
                                        :clearable=true
                                        @clear="eventClearObject"
                                    >
                                        <el-option
                                            label="All objects"
                                            :value=0
                                            :key=0
                                        />
                                        <el-option
                                            v-for="backupObject in backupObjects"
                                            :key="backupObject.id"
                                            :label="backupObject.name"
                                            :value="backupObject.id"
                                        />
                                    </el-select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group select-form_group">
                                    <el-select
                                        v-model="filter.backup_tool_id"
                                        class="m-0 select-category w-100"
                                        placeholder="All tools"
                                        size="large"
                                        :clearable=true
                                        @clear="eventClearTool"
                                    >
                                        <el-option
                                            label="All tools"
                                            :value=0
                                            :key=0
                                        />
                                        <el-option
                                            v-for="backupTool in backupTools"
                                            :key="backupTool.id"
                                            :label="backupTool.name"
                                            :value="backupTool.id"
                                        />
                                    </el-select>
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
                        </div>

                        <v-server-table
                                :url="url"
                                :columns="columns"
                                :options="options"
                                ref="backups-table"
                            >
                                <template v-slot:actions="{row}">

                                    <Link :href="route('backups.edit', {id: row.id})" method="get" v-if="row.can_action">
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

                                    <a href="javascript:;" @click="deleteBackup(row)" v-if="row.can_action">
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
    name: "BackupIndex",
    components: {
        Link,
    },
    data() {
        return {
            urlPrepare: '/admin/backups-all-paginate?',
            url: '/admin/backups-all-paginate?',
            columns: [
                'organization.name',
                'service',
                'owner',
                'hostname',
                'object',
                'tool',
                'storage_server',
                'description_storage',
                'day',
                'time_start',
                // 'restricted_point',
                'storage_server_long_time',
                'description_storage_long_time',
                'test_date',
                'backup_priority',
                'comment',
                'proposals',
                'os_version',
                'actions'
            ],
            options: {
                // see the options API
                // https://github.com/matfish2/vue-tables-2/blob/master/lib/config/defaults.js
                perPage: 500,
                editableColumns:['text'],
                headings: {
                    // created_at: 'Время создания',
                    // updated_at: 'Время обновления',
                    'organization.name': 'Org',
                    comment: 'Comment',
                    actions: 'Actions',
                },
                texts: {
                    limit: 'Вывод записей',
                    count: "Показано с {from} по {to} из {count} записей|{count} записей|Одна запись",
                    noResults: "Ничего не нашлось",
                    loading: "Загрузка...",
                },
                // perPageValues: [2,10,25,30,35,50,100],
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
            backupObjects: null,
            backupTools: null,
            backupPriorities: null,
            filter: {
                organization_id: 0,
                backup_object_id: 0,
                backup_tool_id: 0,
                backup_priority_id: 0,
                hostname: '',
                service: '',
                owner: '',
                comment: '',
                storage_server: '',
            },
        }
    },

    methods: {
        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },

        deleteBackup(row){
            Swal.fire({
                title: 'Удалить бэкап?',
                text: "Выбранный бэкап будет удален",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да, удалить',
                cancelButtonText: 'Отмена',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/admin/backups/' + row.id).then(response => {
                        if (response.data.status === true) {
                            this.$notify({
                                group: 'foo',
                                type: 'success',
                                title: 'Удаление бэкапа',
                                text: 'Бэкап успешно удален'
                            });
                            Swal.fire(
                                'Удалено!',
                                'Бэкап удален',
                                'success'
                            )
                            this.$refs['backups-table'].refresh();
                        }
                        if (response.data.status === false) {
                            this.$notify({
                                group: 'foo',
                                type: 'error',
                                title: 'Удаление бэкапа',
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

        findByFilter(){
            const params = new URLSearchParams();
            let oldUrl = this.url;

            if (this.filter.organization_id === 0) {
                params.append('organization_id', 0)
            }

            if (typeof this.filter.organization_id === 'string') {
                this.filter.organization_id = 0
            }

            if (this.filter.organization_id != null && this.filter.organization_id != '0'){
                params.append('organization_id', this.filter.organization_id)
            }

            if (this.filter.hostname != null){
                params.append('hostname', this.filter.hostname)
            }

            if (this.filter.service != null){
                params.append('service', this.filter.service)
            }

            if (this.filter.owner != null){
                params.append('owner', this.filter.owner)
            }

            if (this.filter.backup_object_id != null){
                params.append('backup_object_id', this.filter.backup_object_id)
            }

            if (this.filter.backup_tool_id != null){
                params.append('backup_tool_id', this.filter.backup_tool_id)
            }

            if (this.filter.backup_priority_id != null){
                params.append('backup_priority_id', this.filter.backup_priority_id)
            }

            if (this.filter.comment != null){
                params.append('comment', this.filter.comment)
            }

            if (this.filter.storage_server != null){
                params.append('storage_server', this.filter.storage_server)
            }

            this.setCacheFilter();

            if (params.toString().length > 0) {
                this.url = this.urlPrepare + params.toString();
            }

            if (this.url === oldUrl) {
                this.$refs['backups-table'].refresh();
            }
        },

        setCacheFilter(){
            localStorage.setItem('backup', JSON.stringify(this.filter))
        },

        retrieveCacheFilterData(cache){
            this.filter = {
                backup_tool_id: cache.backup_tool_id,
                owner: cache.owner,
                backup_object_id: cache.backup_object_id,
                service: cache.service,
                organization_id: cache.organization_id,
                hostname: cache.hostname,
                comment: cache.comment,
                storage_server: cache.storage_server,
                backup_priority_id: cache.backup_priority_id
            };

            this.findByFilter()
        },

        clearFilter(){
            this.filter = {
                organization_id: 0,
                hostname: '',
                service: '',
                owner: '',
                backup_object_id: 0,
                tool: '',
                comment: '',
                storage_server: '',
                backup_priority_id: 0,
            };

            this.url = this.urlPrepare;

            localStorage.removeItem('backup')
        },

        toExcel(){
            let time = new Date()

            axios({
                method:'GET',
                url: '/admin/export-backup',
                responseType: 'blob',
                params: this.filter
            })
            .then((response) => {
                // console.log(response)
                if (response.status === 200){
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `excel_backups_${time.toLocaleDateString() + '_' + time.toLocaleTimeString()}.xlsx`); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                }
            });
        },

        eventClear(){
            this.filter.organization_id = 0
        },

        eventClearObject(){
            this.filter.backup_object_id = null
        },

        eventClearTool(){
            this.filter.backup_tool_id = 0
        },

        eventClearPriority(){
            this.filter.backup_priority_id = 0
        },

        getBackupObjects(){
            axios
                .get('/admin/backup-objects-all-collection')
                .then(res => {
                    this.backupObjects = res.data.data.backupObjects
                })
        },

        getBackupTools(){
            axios
                .get('/admin/backup-tools-all-collection')
                .then(res => {
                    this.backupTools = res.data.data.backupTools
                })
        },

        getBackupPriorities(){
            axios
                .get('/admin/backup-priorities-all-collection')
                .then(res => {
                    this.backupPriorities = res.data.data.backupPriorities
                })
        },
    },

    mounted() {
        if (localStorage.getItem('backup') !== null) {
            this.retrieveCacheFilterData(JSON.parse(localStorage.getItem('backup')));
        }
        this.getOrganizations();
        this.getBackupObjects();
        this.getBackupTools();
        this.getBackupPriorities();
    }
}
</script>

<style scoped>

</style>
