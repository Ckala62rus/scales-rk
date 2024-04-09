<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Создание организации
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="createOrganization">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Организация <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Название организации"
                                    v-model="form.name"
                                    :class="{'is-invalid': errors.errorName}"
                                />
                                <div class="invalid-feedback">Название организации обязательно!</div>
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Полное название организации"
                                    v-model="form.description"
                                />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Создать</button>
                            <Link :href="route('organizations.index')" as="button" method="get" class="btn btn-primary font-weight-bolder">Назад</Link>
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
    name: "OrganizationCreate",
    components: {
        Link
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
        createOrganization() {
            this.resetErrors()

            axios.post('/admin/organizations', this.form)
                .then(res => {
                    if (res.status === 201){
                        this.$notify({
                            title: "Создание организации",
                            text: "Организация создана!",
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
                description: '',
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
