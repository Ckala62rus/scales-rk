<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-flush h-md-100">

                    <div class="card-header">
                        <h3 class="card-title d-flex flex-center">
                            Create backup
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <div class="card-body">
                        <label>Organization</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.organization_id"
                                class="m-0 select-category w-100"
                                placeholder="Organization"
                                size="large"
                            >
                                <el-option
                                    v-for="organization in organizations"
                                    :key="organization.id"
                                    :label="organization.name"
                                    :value="organization.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.organization_id">{{error_messages.organization_id}}</div>
                        </div>

                        <div class="form-group">
                            <label>Service <span class="text-danger"></span></label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Service"
                                rows="5"
                                v-model="form.service"
                                :class="{'is-invalid': errors.service}"
                            />
                            <div class="invalid-feedback">{{error_messages.service}}</div>
                        </div>

                        <div class="form-group">
                            <label>Owner + date approve<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Owner"
                                v-model="form.owner"
                                :class="{'is-invalid': errors.owner}"
                            />
                            <div class="invalid-feedback">{{error_messages.owner}}</div>
                        </div>

                        <div class="form-group">
                            <label>Hostname<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Hostname"
                                v-model="form.hostname"
                                :class="{'is-invalid': errors.hostname}"
                            />
                            <div class="invalid-feedback">{{error_messages.hostname}}</div>
                        </div>

                        <label>Object</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.backup_object_id"
                                class="m-0 select-category w-100"
                                placeholder="Object"
                                size="large"
                            >
                                <el-option
                                    v-for="backupObject in backupObjects"
                                    :key="backupObject.id"
                                    :label="backupObject.name"
                                    :value="backupObject.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.backup_object_id">{{error_messages.backup_object_id}}</div>
                        </div>

                        <label>Tool</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.backup_tool_id"
                                class="m-0 select-category w-100"
                                placeholder="Tool"
                                size="large"
                                :clearable=true
                            >
                                <el-option
                                    v-for="backupTool in backupTools"
                                    :key="backupTool.id"
                                    :label="backupTool.name"
                                    :value="backupTool.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.backup_tool_id">{{error_messages.backup_tool_id}}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <div class="card-body">

                        <label>Day</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.backup_day_id"
                                class="m-0 select-category w-100"
                                placeholder="Day"
                                size="large"
                                :clearable=true
                            >
                                <el-option
                                    v-for="backupDay in backupDays"
                                    :key="backupDay.id"
                                    :label="backupDay.name"
                                    :value="backupDay.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.backup_day_id">{{error_messages.backup_day_id}}</div>
                        </div>

                        <div class="form-group">
                            <label>Time start<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Time start"
                                v-model="form.time_start"
                                :class="{'is-invalid': errors.time_start}"
                            />
                            <div class="invalid-feedback">{{error_messages.time_start}}</div>
                        </div>

                        <div class="form-group">
                            <label>Description storage policy<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Description storage"
                                v-model="form.description_storage"
                                :class="{'is-invalid': errors.description_storage}"
                            />
                            <div class="invalid-feedback">{{error_messages.description_storage}}</div>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label>Restricted point<span class="text-danger">*</span></label>-->
<!--                            <input-->
<!--                                type="text"-->
<!--                                class="form-control"-->
<!--                                placeholder="Restricted point"-->
<!--                                v-model="form.restricted_point"-->
<!--                                :class="{'is-invalid': errors.restricted_point}"-->
<!--                            />-->
<!--                            <div class="invalid-feedback">{{error_messages.restricted_point}}</div>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label>Storage server<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Storage server"
                                v-model="form.storage_server"
                                :class="{'is-invalid': errors.storage_server}"
                            />
                            <div class="invalid-feedback">{{error_messages.storage_server}}</div>
                        </div>

                        <div class="form-group">
                            <label>Storage server long time<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Storage server long time"
                                v-model="form.storage_server_long_time"
                                :class="{'is-invalid': errors.storage_server_long_time}"
                            />
                            <div class="invalid-feedback">{{error_messages.storage_server_long_time}}</div>
                        </div>

                        <div class="form-group">
                            <label>Description storage long time policy<span class="text-danger"></span></label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Description storage long time"
                                rows="5"
                                v-model="form.description_storage_long_time"
                                :class="{'is-invalid': errors.description_storage_long_time}"
                            />
                            <div class="invalid-feedback">{{error_messages.description_storage_long_time}}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <div class="card-body">

                        <div class="form-group">
                            <label>Test date<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Test date"
                                v-model="form.test_date"
                                :class="{'is-invalid': errors.test_date}"
                            />
                            <div class="invalid-feedback">{{error_messages.test_date}}</div>
                        </div>

                        <label>Priority</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.backup_priority_id"
                                class="m-0 select-category w-100"
                                placeholder="Backup priority"
                                size="large"
                                :clearable=true
                                @clear="eventClearPriority"
                            >
                                <el-option
                                    :key="0"
                                    :label="'No priority'"
                                    :value="0"
                                />
                                <el-option
                                    v-for="backupPriority in backupPriorities"
                                    :key="backupPriority.id"
                                    :label="backupPriority.name"
                                    :value="backupPriority.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.backup_priority_id">{{error_messages.backup_priority_id}}</div>
                        </div>

                        <div class="form-group">
                            <label>OS version<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="OS version"
                                v-model="form.os_version"
                                :class="{'is-invalid': errors.os_version}"
                            />
                            <div class="invalid-feedback">{{error_messages.os_version}}</div>
                        </div>

                        <div class="form-group">
                            <label>Comment <span class="text-danger"></span></label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Comment"
                                rows="5"
                                v-model="form.comment"
                                :class="{'is-invalid': errors.comment}"
                            />
                            <div class="invalid-feedback">{{error_messages.comment}}</div>
                        </div>

                        <div class="form-group">
                            <label>Proposals<span class="text-danger"></span></label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Description storage long time"
                                rows="5"
                                v-model="form.proposals"
                                :class="{'is-invalid': errors.proposals}"
                            />
                            <div class="invalid-feedback">{{error_messages.proposals}}</div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <form @submit.prevent="createOrganization">
                            <div class="form__button">
                                <button type="submit" class="btn btn-success mr-2 button_width">Add</button>
                                <Link :href="route('backups.index')" as="button" method="get" class="btn btn-primary font-weight-bolder button_width">Back</Link>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {Link, usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "BackupCreate",

    components: {
        Link
    },

    data() {
        return {
            form: {
                'service': '',
                'owner': '',
                'hostname': '',
                'backup_tool_id': '',
                'comment': '',
                'restricted_point': '',
                'description_storage': '',
                'backup_day_id': '',
                'time_start': '',
                'storage_server': '',
                'storage_server_long_time': '',
                'description_storage_long_time': '',
                'organization_id': '',
                'backup_object_id': '',
                'backup_priority_id': 0,
                'test_date': '',
                'proposals': '',
                'os_version': '',
            },
            organizations: null,
            backupObjects: null,
            backupDays: null,
            backupTools: null,
            backupPriorities: null,
            errors: {
                service: false,
                owner: false,
                hostname: false,
                backup_object_id: false,
                backup_tool_id: false,
                comment: false,
                restricted_point: false,
                description_storage: false,
                backup_day_id: false,
                time_start: false,
                storage_server: false,
                storage_server_long_time: false,
                description_storage_long_time: false,
            },
            error_messages: {
                service: '',
                owner: '',
                hostname: '',
                backup_object_id: '',
                backup_tool_id: '',
                comment: '',
                restricted_point: '',
                description_storage: '',
                backup_day_id: '',
                time_start: '',
                storage_server: '',
                storage_server_long_time: '',
                description_storage_long_time: '',
            },
        }
    },

    methods: {
        createOrganization() {
            this.resetErrors()

            axios.post('/admin/backups', this.form)
                .then(res => {
                    if (res.status === 201){
                        this.$notify({
                            title: "Создание бэкапа",
                            text: "Строка бэкапа создана!",
                            speed: 1000,
                            duration: 1000,
                            type: 'success'
                        });

                        this.resetForm();
                    }
                })
                .catch(err => {
                    let errors = err.response.data.errors

                    if (err.response.status === 422) {
                        this.errors = {
                            service: errors.hasOwnProperty('service'),
                            owner: errors.hasOwnProperty('owner'),
                            hostname: errors.hasOwnProperty('hostname'),
                            backup_object_id: errors.hasOwnProperty('backup_object_id'),
                            backup_tool_id: errors.hasOwnProperty('backup_tool_id'),
                            comment: errors.hasOwnProperty('comment'),
                            restricted_point: errors.hasOwnProperty('restricted_point'),
                            description_storage: errors.hasOwnProperty('description_storage'),
                            backup_day_id: errors.hasOwnProperty('backup_day_id'),
                            time_start: errors.hasOwnProperty('time_start'),
                            storage_server: errors.hasOwnProperty('storage_server'),
                            storage_server_long_time: errors.hasOwnProperty('storage_server_long_time'),
                            description_storage_long_time: errors.hasOwnProperty('description_storage_long_time'),
                            organization_id: errors.hasOwnProperty('organization_id'),
                        };

                        this.error_messages = {
                            service: errors.hasOwnProperty('service')
                                ? errors.service[0]
                                : '',

                            owner: errors.hasOwnProperty('owner')
                                ? errors.owner[0]
                                : '',

                            hostname: errors.hasOwnProperty('hostname')
                                ? errors.hostname[0]
                                : '',

                            backup_object_id: errors.hasOwnProperty('backup_object_id')
                                ? errors.backup_object_id[0]
                                : '',

                            backup_tool_id: errors.hasOwnProperty('backup_tool_id')
                                ? errors.backup_tool_id[0]
                                : '',

                            comment: errors.hasOwnProperty('comment')
                                ? errors.comment[0]
                                : '',

                            restricted_point: errors.hasOwnProperty('restricted_point')
                                ? errors.restricted_point[0]
                                : '',

                            description_storage: errors.hasOwnProperty('type')
                                ? errors.description_storage[0]
                                : '',

                            backup_day_id: errors.hasOwnProperty('backup_day_id')
                                ? errors.backup_day_id[0]
                                : '',

                            time_start: errors.hasOwnProperty('time_start')
                                ? errors.time_start[0]
                                : '',

                            storage_server: errors.hasOwnProperty('storage_server')
                                ? errors.storage_server[0]
                                : '',

                            storage_server_long_time: errors.hasOwnProperty('storage_server_long_time')
                                ? errors.storage_server_long_time[0]
                                : '',

                            description_storage_long_time: errors.hasOwnProperty('description_storage_long_time')
                                ? errors.description_storage_long_time[0]
                                : '',

                            organization_id: errors.hasOwnProperty('organization_id')
                                ? errors.organization_id[0]
                                : '',
                        };

                        this.$notify({
                            title: "Ошибка",
                            text: "Ошибка в заполнении полей",
                            speed: 1000,
                            duration: 1000,
                            type: 'error'
                        });
                    }
                })
        },

        resetForm(){
            this.form = {
                service: '',
                owner: '',
                hostname: '',
                backup_object_id: '',
                backup_tool_id: '',
                comment: '',
                restricted_point: '',
                description_storage: '',
                backup_day_id: '',
                time_start: '',
                storage_server: '',
                storage_server_long_time: '',
                description_storage_long_time: '',
                organization_id: '',
                backup_priority_id: null,
                test_date: '',
                proposals: '',
                os_version: '',
            };
        },

        resetErrors(){
            this.errors = {
                service: false,
                owner: false,
                hostname: false,
                backup_object_id: false,
                backup_tool_id: false,
                comment: false,
                restricted_point: false,
                description_storage: false,
                backup_day_id: false,
                time_start: false,
                storage_server: false,
                storage_server_long_time: false,
                description_storage_long_time: false,
            };
        },

        eventClearPriority(){
            this.form.backup_priority_id = 0;
        },

        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },

        getBackupObjects(){
            axios
                .get('/admin/backup-objects-all-collection')
                .then(res => {
                    this.backupObjects = res.data.data.backupObjects
                })
        },

        getBackupDays(){
            axios
                .get('/admin/backup-days-all-collection')
                .then(res => {
                    this.backupDays = res.data.data.backupDays
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
        this.getOrganizations();
        this.getBackupObjects();
        this.getBackupDays();
        this.getBackupTools();
        this.getBackupPriorities();
    }
}
</script>

<style scoped>
.form__button {
    display: flex;
    justify-content: space-between;
}

.button_width {
    width: 50%;
}
</style>
