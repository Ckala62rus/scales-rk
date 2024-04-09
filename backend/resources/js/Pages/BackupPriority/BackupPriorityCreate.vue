<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Create backup priority
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="createBackupPriority">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Name backup priority type <span class="text-danger">*</span></label>
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
                            <button type="submit" class="btn btn-success mr-2">Create</button>
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
    name: "BackupPriorityCreate",

    components: {
        Link
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
        createBackupPriority() {
            this.resetErrors()

            axios.post('/admin/backup-priorities', this.form)
                .then(res => {
                    if (res.status === 201){
                        this.$notify({
                            title: "Создание приоритета бэкапа",
                            text: "Приоритет бэкапа, создан!",
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
    },
}
</script>

<style scoped>

</style>
