<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit backup tool
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="updateBackupObject">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Name backup object type <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Short name"
                                    v-model="form.name"
                                    :class="{'is-invalid': errors.errorName}"
                                />
                                <div class="invalid-feedback">Name backup object type, is required!</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Description"
                                    v-model="form.description"
                                />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Update</button>
                            <Link
                                :href="route('backup-tools.index')"
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
                description: '',
            },
            errors: {
                errorName: false,
            },
        }
    },

    methods: {
        updateBackupObject() {
            this.resetErrors()

            axios.put('/admin/backup-tools/' + this.id, this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Обновление типа бэкапа",
                            text: "Типа бэкапа обновлен!",
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
                description: '',
            };
        },

        resetErrors(){
            this.errors = {
                errorName: false
            };
        },

        getBackupObject(){
            axios
                .get(`/admin/backup-tools/${this.id}`, this.form)
                .then(res => {
                    let data = res.data.data.backupTool
                    this.form = {
                        name: data.name,
                        description: data.description
                    };
                })
        },
    },

    mounted() {
        this.getBackupObject()
    }
}
</script>

<style scoped>

</style>
