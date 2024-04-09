<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit backup priority
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="updateBackupPriority">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Name backup priority<span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Short name"
                                    v-model="form.name"
                                    :class="{'is-invalid': errors.errorName}"
                                />
                                <div class="invalid-feedback">Name backup priority, is required!</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Update</button>
                            <Link
                                :href="route('backup-priorities.index')"
                                as="button"
                                method="get"
                                class="btn btn-primary font-weight-bolder"
                            >Back</Link>
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
    name: "BackupToolEdit",

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
                name: '',
            },
            errors: {
                errorName: false,
            },
        }
    },

    methods: {
        updateBackupPriority() {
            this.resetErrors()

            axios.put('/admin/backup-priorities/' + this.id, this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Обновление приоритета бэкапа",
                            text: "Приоритет бэкапа обновлен!",
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
                            errorName: errors.hasOwnProperty('name'),
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
            };
        },

        resetErrors(){
            this.errors = {
                errorName: false
            };
        },

        getBackupPriority(){
            axios
                .get(`/admin/backup-priorities/${this.id}`, this.form)
                .then(res => {
                    let data = res.data.data.backupPriority
                    this.form = {
                        name: data.name,
                    };
                })
        },
    },

    mounted() {
        this.getBackupPriority()
    }
}
</script>

<style scoped>

</style>
