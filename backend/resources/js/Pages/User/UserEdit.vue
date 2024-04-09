<template>
    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Редактирование пользователя
                        </h3>
                    </div>

                    <form @submit.prevent="updateUser">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Имя <span class="text-danger">*</span></label>
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
                                <label>Роль<span class="text-danger">*</span></label>
                                <el-select v-model="form_profile.role_id" class="w-100" placeholder="Select" size="large">
                                    <el-option
                                        v-for="item in roles"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id"
                                    />
                                </el-select>
                            </div>

                            <label>Организация</label>
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
                                <div style="color: #F64E60" v-if="errors.organization_id">{{error_messages.organization_id}}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Сохранить</button>
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
    name: "UserEdit",

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
            form_profile: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role_id: null,
                organization_id : null,
            },
            errors: {
                errorName: false,
                errorEmail: false,
                errorEmailText: ''
            },
            roles: {},
            options: [],
            organizations: [
                {
                    id: 0,
                    name: "Нет",
                },
            ],
        }
    },

    methods: {
       updateUser(){
           axios.put('/admin/user/' + this.id, this.form_profile)
               .then(res => {
                   if (res.status === 200){
                       this.$notify({
                           title: "Редактирование пользователя",
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

        getUser(){
           axios.get('/admin/user/' + this.id)
               .then(response => {
                   let role_id = response.data.data.role.length > 0 ? response.data.data.role[0].id : null
                   let user = response.data.data.user;
                   this.form_profile = {
                       name: user.name,
                       email: user.email,
                       role_id: role_id,
                       organization_id: user.organization_id,
                   };
               })
               .catch(error => {
                   console.log(error)
               })
        },

        getRoles(){
           axios.get('/admin/role/all')
               .then(response => {
                   this.roles = response.data.data.roles
               })
        },

        getOrganizations(){
            axios.get('/admin/organization-all-collection')
                .then(res => {
                    this.organizations = res.data.data.organizations;
                })
        },
    },

    mounted() {
        this.getUser()
        this.getRoles()
        this.getOrganizations()
    }
}
</script>

<style scoped>
    .height-profile {
        height: 100%;
    }
</style>
