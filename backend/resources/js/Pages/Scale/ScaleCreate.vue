<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-flush h-md-100">
                    <div class="card-header">
                        <h3 class="card-title d-flex flex-center">
                            Добавление новых весов
                        </h3>
                    </div>

                    <!--begin::Form-->
                    <form @submit.prevent="createScale">
                        <div class="card-body">
                            <div class="form-group">
                                <label>IP адрес весов <span class="text-danger">(пример: 127.0.0.1)</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="127.0.0.1"
                                    v-model="form.ip_address"
                                    :class="{'is-invalid': errors.ip_address}"
                                />
                                <div class="invalid-feedback">{{error_messages.ip_address}}</div>
                            </div>

                            <div class="form-group">
                                <label>Порт <span class="text-danger">(пример: 5001)</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="5001"
                                    v-model="form.port"
                                    :class="{'is-invalid': errors.port}"
                                />
                                <div class="invalid-feedback">{{error_messages.port}}</div>
                            </div>

                            <div class="form-group">
                                <label>Краткое описание</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    placeholder="Comment"
                                    rows="2"
                                    v-model="form.description"
                                    :class="{'is-invalid': errors.description}"
                                />
                                <div class="invalid-feedback">{{error_messages.description}}</div>
                            </div>
                        </div>

                        <div class="card-footer">
                        <div class="form__button">
                            <button type="submit" class="btn btn-success mr-2 button_width">Create</button>
                            <Link :href="route('scales.index')" as="button" method="get" class="btn btn-primary font-weight-bolder button_width">Back</Link>
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
    name: "ScaleCreate",

    components: {
        Link
    },

    data() {
        return {
            form: {
                ip_address: "",
                port: "",
                description: "",
            },
            error_messages: {
                ip_address: "",
                port: 0,
            },
            errors: {
                ip_address: false,
            },
        }
    },

    methods: {
        createScale() {
            axios.post('/admin/scales/', this.form)
                .then(res => {
                    if (res.status === 200){
                        this.$notify({
                            title: "Создание",
                            message: "Запись с весами создана!",
                            speed: 3000,
                            duration: 5000,
                            type: 'success'
                        });
                    }
                })
        },
    },
}
</script>

<style scoped>

</style>
