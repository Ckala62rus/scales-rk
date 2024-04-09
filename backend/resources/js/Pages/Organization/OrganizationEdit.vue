<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Редактирование организации
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
                            <button type="submit" class="btn btn-success mr-2">Обновить</button>
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
    name: "OrganizationEdit",

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
        createOrganization() {
            axios.put('/admin/organizations/' + this.id, this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Редактирование организации",
                            text: "Данные отредактированны!",
                            speed: 1000,
                            duration: 1000,
                            type: 'success'
                        });
                    }
                    console.log(res)
                })
                .catch(err => {
                    console.log(err)
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

        getOrganizationById(){
          axios.get('/admin/organizations/' + this.id)
              .then(res => {
                  this.form = res.data.data.organization;
              })
        },
    },

    mounted() {
        this.getOrganizationById();
    }
}
</script>

<style scoped>

</style>
