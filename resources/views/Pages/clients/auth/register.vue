<template>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card mt-3" style="border-radius: 1rem; width: 35rem;">
                <div class="row g-0">
                    <div class="card-body p-5 text-black">
                        <form @submit.prevent="signUp()">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <h5>ĐĂNG KÍ</h5>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Họ tên</label>
                                <input type="text" placeholder="Họ tên" name="name" v-model="name"
                                    class="form-control form-control-lg" />
                                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Email</label>
                                <input type="text" placeholder="Email" name="email" v-model="email"
                                    class="form-control form-control-lg" />
                                    <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" placeholder="Tài khoản" name="user_name" v-model="user_name"
                                    class="form-control form-control-lg" />
                                    <small v-if="errors.user_name" class="text-danger">{{ errors.user_name[0] }}</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" placeholder="Mật khẩu" name="password" autocomplete="on"
                                    v-model="password" class="form-control form-control-lg" />
                                    <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit">ĐĂNG KÍ</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <router-link class="text-decoration-none" :to="{ name: 'clients-login' }">Đăng
                                    nhập</router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, reactive, toRefs, ref } from 'vue';
import axios from 'axios';
import { message } from 'ant-design-vue';
import { useRouter } from 'vue-router';
export default defineComponent({
    setup() {
        const route=useRouter();
        const errors = ref({});
        const user = reactive({
            name: '',
            email: '',
            user_name: '',
            password: ''
        });
        const signUp = () => {
            axios.post('http://localhost:8000/api/register', user)
                .then((response) => {
                    if (response.data.status === 200) {
                        message.success('Đăng kí thành công');
                        route.push({ name: 'clients-login' });
                    }
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        };

        return {
            ...toRefs(user),
            errors,
            signUp
        }
    }
})
</script>
