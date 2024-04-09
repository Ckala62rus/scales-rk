<template>
    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Создание пользователя
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="createUser">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Your name"
                                    v-model="form_profile.name"
                                    :class="{'is-invalid': errors.errorName}"
                                />
                                <div class="invalid-feedback">Имя обязательно!</div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">Email <span class="text-danger">*</span></label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleInputPassword"
                                    placeholder="Your email address"
                                    v-model="form_profile.email"
                                    :class="{'is-invalid': errors.errorEmail}"
                                />
                                <div class="invalid-feedback">{{errors.errorEmailText}}</div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="exampleInputPassword1"
                                    placeholder="Password"
                                    v-model="form_profile.password"
                                    :class="{'is-invalid': errors.errorPassword}"
                                />
                                <div class="invalid-feedback">{{errors.errorPasswordText}}</div>
                                <div class="invalid-feedback">{{errors.errorPasswordConfirmation}}</div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword2">Password confirmation<span class="text-danger">*</span></label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="exampleInputPassword2"
                                    placeholder="Password confirmation"
                                    v-model="form_profile.password_confirmation"
                                    :class="{'is-invalid': errors.errorPassword}"
                                />
                                <div class="invalid-feedback">{{errors.errorPasswordConfirmation}}</div>
                            </div>

                            <div class="form-group">
                                <label>Роль<span class="text-danger">*</span></label>
                                <el-select v-model="form_profile.role_id" class="w-100" placeholder="Select" size="large">
                                    <el-option
                                        v-for="item in roles"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id"
                                    />
                                </el-select>
                                <div style="color: #F64E60" v-if="errors.errorRole">{{error_messages.role_id}}</div>
                            </div>

                            <label>Организация<span class="text-danger">*</span></label>
                            <div class="form-group select-form_group">
                                <el-select
                                    v-model="form_profile.organization_id"
                                    class="m-0 select-category w-100"
                                    placeholder="Организация"
                                    size="large"
                                >
                                    <el-option
                                        label="Нет"
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
                                <div style="color: #F64E60" v-if="errors.errorOrganization">{{error_messages.organization_id}}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Создать</button>
                            <Link :href="route('metronic.user.index')" as="button" method="get" class="btn btn-primary font-weight-bolder">Назад</Link>
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
    name: "Profile",

    components: {
        Link
    },

    data() {
        return {
            form_profile: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                organization_id : null,
                role_id: null,
            },
            errors: {
                errorName: false,
                errorEmail: false,
                errorPassword: false,
                errorPasswordConfirmation: false,
                errorPasswordText: '',
                errorEmailText: '',
                errorRole: false,
                errorOrganization: false,
            },
            error_messages: {
                role_id: '',
                organization_id: '',
            },
            roles: {},
            organizations: [
                {
                    id: 0,
                    name: "Нет",
                },
            ],
        }
    },

    methods: {
       createUser(){
           this.resetErrors()

           axios.post('/admin/user', this.form_profile)
               .then(res => {
                   if (res.status === 201){
                       this.$notify({
                           title: "Создание пользователя",
                           text: "Пользователь создан!",
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
                       console.log(errors)
                       this.errors = {
                           errorName: errors.hasOwnProperty('name'),
                           errorEmail: errors.hasOwnProperty('email'),
                           errorPassword: errors.hasOwnProperty('password'),
                           errorPasswordConfirmation: errors.hasOwnProperty('password') ? errors.password[0] : '',
                           errorEmailText: errors.hasOwnProperty('email') ? errors.email[0] : '',
                           errorRole: errors.hasOwnProperty('role_id'),
                           errorOrganization: errors.hasOwnProperty('organization_id'),
                       };
                       this.error_messages = {
                           role_id: errors.hasOwnProperty('role_id') ? errors.role_id[0] : '',
                           organization_id: errors.hasOwnProperty('organization_id') ? errors.organization_id[0] : '',
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
           this.form_profile = {
               name: '',
               email: '',
               password: '',
               password_confirmation: '',
           };
       },

        resetErrors(){
            this.errors = {
                errorName: false,
                errorEmail: false,
                errorPassword: false,
                errorEmailText: '',
                errorPasswordConfirmation: '',
                errorRole: false,
                errorOrganization: false,
            };
            this.error_messages = {
                role_id: '',
                organization_id: '',
            };
        },

        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },

        getRoles(){
            axios.get('/admin/role/all')
                .then(response => {
                    this.roles = response.data.data.roles
                })
        },
    },

    mounted() {
        this.getOrganizations()
        this.getRoles()
    }
}
</script>

<style scoped>
    .height-profile {
        height: 100%;
    }
</style>
