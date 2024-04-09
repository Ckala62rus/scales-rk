<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-flush h-md-100">

                    <div class="card-header">
                        <h3 class="card-title d-flex flex-center">
                            Edit device
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="createOrganization">
                        <div class="card-body">

                            <label>Организация</label>
                            <div class="form-group select-form_group">
                                <el-select
                                    v-model="form.organization_id"
                                    class="m-0 select-category w-100"
                                    placeholder="Организация"
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

                            <label>Тип оборудования</label>
                            <div class="form-group select-form_group">
                                <el-select
                                    v-model="form.equipment_id"
                                    class="m-0 select-category w-100"
                                    placeholder="Тип оборудования"
                                    size="large"
                                >
                                    <el-option
                                        v-for="equipment in equipments"
                                        :key="equipment.id"
                                        :label="equipment.name"
                                        :value="equipment.id"
                                    />
                                </el-select>
                                <div style="color: #F64E60" v-if="errors.equipment_id">{{error_messages.equipment_id}}</div>
                            </div>

                            <div class="form-group">
                                <label>Какие сервисы развернуты <span class="text-danger"></span></label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    placeholder="Comment"
                                    rows="10"
                                    v-model="form.description_service"
                                    :class="{'is-invalid': errors.description_service}"
                                />
                                <div class="invalid-feedback">{{error_messages.description_service}}</div>
                            </div>

                            <div class="form-group">
                                <label>Хост <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Hostname"
                                    v-model="form.hostname"
                                    :class="{'is-invalid': errors.hostname}"
                                />
                                <div class="invalid-feedback">{{error_messages.hostname}}</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <form @submit.prevent="createOrganization">
                        <div class="card-body">

                            <div class="form-group">
                                <label>Модель <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Model"
                                    v-model="form.model"
                                    :class="{'is-invalid': errors.model}"
                                />
                                <div class="invalid-feedback">{{error_messages.model}}</div>
                            </div>

                            <div class="form-group">
                                <label>Операционная система <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Operation system"
                                    v-model="form.operation_system"
                                    :class="{'is-invalid': errors.operation_system}"
                                />
                                <div class="invalid-feedback">{{error_messages.operation_system}}</div>
                            </div>
                            <div class="form-group">
                                <label>Модель и количество процессоров <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="CPU"
                                    v-model="form.cpu"
                                    :class="{'is-invalid': errors.cpu}"
                                />
                                <div class="invalid-feedback">{{error_messages.cpu}}</div>
                            </div>
                            <div class="form-group">
                                <label>Кол-во физ. Ядер <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Count Core"
                                    v-model="form.count_core"
                                    :class="{'is-invalid': errors.count_core}"
                                />
                                <div class="invalid-feedback">{{error_messages.count_core}}</div>
                            </div>
                            <div class="form-group">
                                <label>Кол-во ядер с учетом HT <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Count Core With HT"
                                    v-model="sum"
                                    disabled
                                    :class="{'is-invalid': errors.count_core_with_ht}"
                                />
                                <div class="invalid-feedback">{{error_messages.count_core_with_ht}}</div>
                            </div>
                            <div class="form-group">
                                <label>Оперетивная память, Gb <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Memory"
                                    v-model="form.memory"
                                    :class="{'is-invalid': errors.memory}"
                                />
                                <div class="invalid-feedback">{{error_messages.memory}}</div>
                            </div>

                            <div class="form-group">
                                <label>HDD, Tb (суммарный объем без учета raid)<span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="HDD, Tb"
                                    v-model="form.hdd"
                                    :class="{'is-invalid': errors.hdd}"
                                />
                                <div class="invalid-feedback">{{error_messages.hdd}}</div>
                            </div>
                            <div class="form-group">
                                <label>SSD, Tb (суммарный объем без учета raid)<span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="SSD, Tb"
                                    v-model="form.ssd"
                                    :class="{'is-invalid': errors.ssd}"
                                />
                                <div class="invalid-feedback">{{error_messages.ssd}}</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <!--begin::Form-->
                    <form @submit.prevent="createOrganization">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Где находится (адрес) <span class="text-danger"></span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Address"
                                    v-model="form.address"
                                    :class="{'is-invalid': errors.address}"
                                />
                                <div class="invalid-feedback">{{error_messages.address}}</div>
                            </div>

                            <div class="form-group">
                                <label>Дата покупки <span class="text-danger"></span></label>
                                <el-date-picker
                                    v-model="form.date_buy"
                                    type="date"
                                    placeholder="Date buy"
                                    :format="'YYYY-MM-DD'"
                                    :value-format="'YYYY-MM-DD'"
                                    :class="{'is-invalid': errors.date_buy}"
                                    :size="'large'"
                                    style="width: 100%"
                                />
                                <div class="invalid-feedback">{{error_messages.date_buy}}</div>
                            </div>

                            <div class="form-group">
                                <label>Желаемый срок замены <span class="text-danger"></span></label>
                                <el-date-picker
                                    v-model="form.date_update"
                                    type="date"
                                    placeholder="Date update"
                                    :format="'YYYY-MM-DD'"
                                    :value-format="'YYYY-MM-DD'"
                                    :class="{'is-invalid': errors.date_update}"
                                    :size="'large'"
                                    style="width: 100%"
                                />
                                <div class="invalid-feedback">{{error_messages.date_update}}</div>
                            </div>

                            <div class="form-group">
                                <label>Комментарий <span class="text-danger"></span></label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    placeholder="Comment"
                                    rows="10"
                                    v-model="form.comment"
                                    :class="{'is-invalid': errors.comment}"
                                />
                                <div class="invalid-feedback">{{error_messages.comment}}</div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="form__button">
                                <button type="submit" class="btn btn-success mr-2 button_width">Update</button>
                                <Link :href="route('devices.index')" as="button" method="get" class="btn btn-primary font-weight-bolder button_width">Back</Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link, usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "DeviceEdit",

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
                'hostname' : '',
                'model' : '',
                'date_buy' : '',
                'description_service' : '',
                'date_update' : '',
                'operation_system' : '',
                'cpu' : '',
                'count_core' : '',
                'count_core_with_ht' : '',
                'memory' : '',
                'hdd' : '',
                'ssd' : '',
                'address' : '',
                'comment' : '',
                'user_id' : '',
                'organization_id' : '',
                'equipment_id' : '',
            },
            organizations: null,
            equipments: null,
            errors: {
                hostname: false,
                model: false,
                date_buy: false,
                address: false,
                comment: false,
                count_core: false,
                count_core_with_ht: false,
                cpu: false,
                date_update: false,
                description_service: false,
                hdd: false,
                memory: false,
                operation_system: false,
                ssd: false,
                organization_id: false,
                equipment_id: false,
            },
            error_messages: {
                hostname: '',
                model: '',
                date_buy: '',
                address: '',
                comment: '',
                count_core: '',
                count_core_with_ht: '',
                cpu: '',
                date_update: '',
                description_service: '',
                hdd: '',
                memory: '',
                operation_system: '',
                ssd: '',
                organization_id: '',
                equipment_id: '',
            },
        }
    },

    computed: {
        sum: function() {
            let calculatedTotal = this.form.count_core === '1' ? 1 : this.form.count_core * 2;
            this.form.count_core_with_ht = calculatedTotal;
            return calculatedTotal;
        },
    },

    methods: {
        createOrganization() {
            this.resetErrors()

            axios.put('/admin/devices/' + this.id, this.form)
                .then(res => {
                    // console.log(res)
                    if (res.status === 200){
                        this.$notify({
                            title: "Обновление записи оборудования",
                            text: "Запись оборудования обновлена!",
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
                            hostname: errors.hasOwnProperty('hostname'),
                            model: errors.hasOwnProperty('model'),
                            date_buy: errors.hasOwnProperty('date_buy'),
                            address: errors.hasOwnProperty('address'),
                            comment: errors.hasOwnProperty('comment'),
                            count_core: errors.hasOwnProperty('count_core'),
                            count_core_with_ht: errors.hasOwnProperty('count_core_with_ht'),
                            cpu: errors.hasOwnProperty('cpu'),
                            date_update: errors.hasOwnProperty('date_update'),
                            description_service: errors.hasOwnProperty('description_service'),
                            equipment_id: errors.hasOwnProperty('equipment_id'),
                            hdd: errors.hasOwnProperty('hdd'),
                            memory: errors.hasOwnProperty('memory'),
                            operation_system: errors.hasOwnProperty('operation_system'),
                            ssd: errors.hasOwnProperty('ssd'),
                            organization_id: errors.hasOwnProperty('organization_id'),
                        };

                        this.error_messages = {
                            hostname: errors.hasOwnProperty('hostname') ? errors.hostname[0] : '',
                            model: errors.hasOwnProperty('model') ? errors.model[0] : '',
                            date_buy: errors.hasOwnProperty('date_buy') ? errors.date_buy[0] : '',
                            address: errors.hasOwnProperty('address') ? errors.address[0] : '',
                            comment: errors.hasOwnProperty('comment') ? errors.comment[0] : '',
                            count_core: errors.hasOwnProperty('count_core') ? errors.count_core[0] : '',
                            count_core_with_ht: errors.hasOwnProperty('count_core_with_ht') ? errors.count_core_with_ht[0] : '',
                            cpu: errors.hasOwnProperty('cpu') ? errors.cpu[0] : '',
                            date_update: errors.hasOwnProperty('date_update') ? errors.date_update[0] : '',
                            description_service: errors.hasOwnProperty('description_service') ? errors.description_service[0] : '',
                            hdd: errors.hasOwnProperty('hdd') ? errors.hdd[0] : '',
                            memory: errors.hasOwnProperty('memory') ? errors.memory[0] : '',
                            operation_system: errors.hasOwnProperty('operation_system') ? errors.operation_system[0] : '',
                            ssd: errors.hasOwnProperty('ssd') ? errors.ssd[0] : '',
                            organization_id: errors.hasOwnProperty('organization_id') ? errors.organization_id[0] : '',
                            equipment_id: errors.hasOwnProperty('equipment_id') ? errors.equipment_id[0] : '',
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
                name: '',
                description: '',
            };
        },

        resetErrors(){
            this.errors = {
                hostname: false,
                model: false,
                date_buy: false,
                address: false,
                comment: false,
                count_core: false,
                count_core_with_ht: false,
                cpu: false,
                date_update: false,
                description_service: false,
                hdd: false,
                memory: false,
                operation_system: false,
                ssd: false,
                equipment_id: false,
                organization_id: false
            };
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

        getDevice(){
            axios.get('/admin/devices/' + this.id)
                .then(res => {
                    this.form = res.data.data.device;
                })
        },
    },

    mounted() {
        this.getOrganizations();
        this.getEquipments();
        this.form.user_id = this.$page.props.auth.user.id;
        this.getDevice();
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
