<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-flush h-md-100">

                    <div class="card-header">
                        <h3 class="card-title d-flex flex-center">
                            Update ISP
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

                        <label>Internet Speed</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.internet_speed_id"
                                class="m-0 select-category w-100"
                                placeholder="Internet Speed"
                                size="large"
                            >
                                <el-option
                                    v-for="speed in internetSpeed"
                                    :key="speed.id"
                                    :label="speed.name"
                                    :value="speed.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.organization_id">{{error_messages.organization_id}}</div>
                        </div>

                        <div class="form-group">
                            <label>Address connection<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Address"
                                v-model="form.address"
                                :class="{'is-invalid': errors.owner}"
                            />
                            <div class="invalid-feedback">{{error_messages.service}}</div>
                        </div>

                        <label>Channel type</label>
                        <div class="form-group select-form_group">
                            <el-select
                                v-model="form.channel_type_id"
                                class="m-0 select-category w-100"
                                placeholder="Channel type"
                                size="large"
                            >
                                <el-option
                                    v-for="channel in channelType"
                                    :key="channel.id"
                                    :label="channel.name"
                                    :value="channel.id"
                                />
                            </el-select>
                            <div style="color: #F64E60" v-if="errors.organization_id">{{error_messages.organization_id}}</div>
                        </div>



                        <div class="form-group">
                            <label>Static address<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Static address"
                                v-model="form.static_ip_address"
                                :class="{'is-invalid': errors.static_ip_address}"
                            />
                            <div class="invalid-feedback">{{error_messages.static_ip_address}}</div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <div class="card-body">

                        <div class="form-group">
                            <label>Стоимость участник 1<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 1"
                                v-model="form.cost_participant_1"
                                :class="{'is-invalid': errors.cost_participant_1}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_1}}</div>
                        </div>

                        <div class="form-group">
                            <label>Стоимость участник 2<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 2"
                                v-model="form.cost_participant_2"
                                :class="{'is-invalid': errors.cost_participant_2}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_2}}</div>
                        </div>

                        <div class="form-group">
                            <label>Стоимость участник 3<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 3"
                                v-model="form.cost_participant_3"
                                :class="{'is-invalid': errors.cost_participant_3}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_3}}</div>
                        </div>

                        <div class="form-group">
                            <label>Стоимость участник 4<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 4"
                                v-model="form.cost_participant_4"
                                :class="{'is-invalid': errors.cost_participant_4}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_4}}</div>
                        </div>

                        <div class="form-group">
                            <label>Стоимость участник 5<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 5"
                                v-model="form.cost_participant_5"
                                :class="{'is-invalid': errors.cost_participant_5}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_5}}</div>
                        </div>

                        <div class="form-group">
                            <label>Стоимость участник 6<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Стоимость участник 6"
                                v-model="form.cost_participant_6"
                                :class="{'is-invalid': errors.cost_participant_6}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost_participant_6}}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Схема организации канала провайдера<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Schema org channel provider"
                                v-model="form.schema_org_channel_provider"
                                :class="{'is-invalid': errors.schema_org_channel_provider}"
                            />
                            <div class="invalid-feedback">{{error_messages.schema_org_channel_provider}}</div>
                        </div>

                        <div class="form-group">
                            <label>Cost<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Cost"
                                v-model="form.cost"
                                :class="{'is-invalid': errors.cost}"
                            />
                            <div class="invalid-feedback">{{error_messages.cost}}</div>
                        </div>

                        <div class="form-group">
                            <label>Comment<span class="text-danger"></span></label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Comment"
                                v-model="form.comment"
                                :class="{'is-invalid': errors.comment}"
                            />
                            <div class="invalid-feedback">{{error_messages.comment}}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form @submit.prevent="updateISP">
                            <div class="form__button">
                                <button type="submit" class="btn btn-success mr-2 button_width">Update</button>
                                <Link :href="route('isp.index')" as="button" method="get" class="btn btn-primary font-weight-bolder button_width">Back</Link>
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
    name: "InternetServiceProviderCreate",

    components: {
        Link
    },

    props: {
        id: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            form: {
                'organization_id': '',
                'internet_speed_id': '',
                'address': '',
                'channel_type_id': '',
                'static_ip_address': '',
                'schema_org_channel_provider': '',
                'cost_participant_1': '',
                'cost_participant_2': '',
                'cost_participant_3': '',
                'cost_participant_4': '',
                'cost_participant_5': '',
                'cost_participant_6': '',
                'comment': '',
                'cost': '',
            },
            organizations: null,
            internetSpeed: null,
            channelType: null,
            errors: {
                service: false,
                owner: false,
                hostname: false,
                backup_object_id: false,
                backup_tool_id: false,
                comment: false,
                cost: false,
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
                cost: '',
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
        updateISP() {
            this.resetErrors()

            axios.put('/admin/isp/' + this.id, this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Обновление ISP",
                            text: "Строка ISP обновлена!",
                            speed: 1000,
                            duration: 1000,
                            type: 'success'
                        });
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
                            cost: errors.hasOwnProperty('cost'),
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

                            cost: errors.hasOwnProperty('cost')
                                ? errors.cost[0]
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
                cost: '',
                restricted_point: '',
                description_storage: '',
                backup_day_id: '',
                time_start: '',
                storage_server: '',
                storage_server_long_time: '',
                description_storage_long_time: '',
                organization_id: '',
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
                cost: false,
                restricted_point: false,
                description_storage: false,
                backup_day_id: false,
                time_start: false,
                storage_server: false,
                storage_server_long_time: false,
                description_storage_long_time: false,
            };
        },

        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },

        getInternetSpeed(){
            axios
                .get('/admin/internet-speed-all-collection')
                .then(res => {
                    this.internetSpeed = res.data.data.internetSpeed
                })
        },

        getChannelTypes(){
            axios
                .get('/admin/channel-types-all-collection')
                .then(res => {
                    this.channelType = res.data.data.channelType
                })
        },

        getIspById(){
            axios
                .get('/admin/isp/' + this.id)
                .then(res => {
                    this.form = res.data.data.isp
                })
        },
    },

    mounted() {
        this.getOrganizations();
        this.getInternetSpeed();
        this.getChannelTypes();
        this.getIspById();
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
