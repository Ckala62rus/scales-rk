<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom height-profile">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit channel type
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="updateChannelType">
                        <div class="card-body">
                            <div class="form-group mb-8">
                            </div>
                            <div class="form-group">
                                <label>Name backup day type <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Short name"
                                    v-model="form.name"
                                    :class="{'is-invalid': errors.errorName}"
                                />
                                <div class="invalid-feedback">Name backup day type, is required!</div>
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
                                :href="route('channel-types.index')"
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
    name: "ChannelTypeEdit",

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
        updateChannelType() {
            this.resetErrors()

            axios.put('/admin/channel-types/' + this.id, this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Обновление типа канала",
                            text: "Типа канала обновлен!",
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

        getBackupDay(){
            axios
                .get(`/admin/channel-types/${this.id}`, this.form)
                .then(res => {
                    let data = res.data.data.channelType

                    this.form = {
                        name: data.name,
                        description: data.description
                    };
                })
        },
    },

    mounted() {
        this.getBackupDay()
    }
}
</script>

<style scoped>

</style>
