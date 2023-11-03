<template>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card mt-5" style="border-radius: 1rem; width: 35rem;">
                <div class="row g-0">
                    <div class="card-body p-5 text-black">
                        <form @submit.prevent="login()">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <h5>ĐĂNG NHẬP</h5>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Tài khoản</label>
                                <input type="text" placeholder="Tài khoản" name="user_name" v-model="user_name"
                                    class="form-control form-control-lg" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" placeholder="Mật khẩu" name="password" autocomplete="on" v-model="password"
                                    class="form-control form-control-lg" />
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit">ĐĂNG
                                    NHẬP</button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <router-link class="small text-muted" :to="{name:'admin-login'}">Quên mật khẩu?</router-link>
                                <router-link class="text-decoration-none" :to="{name:'admin-login'}"><span>Tạo tài khoản</span></router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, reactive, toRefs } from 'vue';
import axios from 'axios';
import { message } from 'ant-design-vue';
export default defineComponent({
    setup() {
        const imgPath = '/logo.svg';
        const user = reactive({
            user_name: '',
            password: ''
        });
        const login = () => {
            axios.post('http://localhost:8000/api/login', user)
                .then((response) => {
                    if (response.data.status === 200 && response.data.user) {
                        localStorage.setItem('user', JSON.stringify(response.data.user));
                        message.success('Đăng nhập thành công');
                        window.location.href = '/home';
                    }
                    if(response.data.status === 401){
                        message.error('Tài khoản hoặc mật khẩu không đúng');
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        const { user_name, password } = error.response.data.errors;
                        if (user_name) {
                            message.warning(user_name);
                        }
                        if (password) {
                            message.warning(password);
                        }
                    }
                });
        };

        return {
            ...toRefs(user),
            imgPath,
            login
        }
    }
})
</script>
