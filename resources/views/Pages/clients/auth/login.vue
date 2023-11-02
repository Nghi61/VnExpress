<template>
    <div>
        <section class="vh-100" style="background-color: #9A616D;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                        alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">
                                        <form @submit.prevent="login()">
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <img :src="imgPath" alt="Logo">
                                            </div>

                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Đăng nhập</h5>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Tài khoản</label>
                                                <input type="text" placeholder="Tài khoản" name="user_name"
                                                    v-model="user_name" class="form-control form-control-lg" />
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Mật khẩu</label>
                                                <input type="password" placeholder="Mật khẩu" name="password"
                                                    v-model="password" class="form-control form-control-lg" />
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit">ĐĂNG
                                                    NHẬP</button>
                                            </div>

                                            <a class="small text-muted" href="#!">Quên mật khẩu?</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import { defineComponent, reactive, ref, toRefs } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { message } from 'ant-design-vue';
export default defineComponent({
    setup() {
        const imgPath = '/logo.svg';
        const router = useRouter();
        const user = reactive({
            user_name: '',
            password: ''
        });
        const login = () => {
            axios.post('http://localhost:8000/api/isadmin', user)
                .then((response) => {
                    if (response.status === 200 && response.data.status === 'success') {
                        localStorage.setItem('user', JSON.stringify(response.data.user));
                        message.success('Đăng nhập thành công');
                        router.push({ path: '/admin/users' });
                    } else if (response.data.status === 'error') {
                        message.error('Tài khoản không có quyền truy cập');
                    } else {
                        message.error('Tài khoản hoặc mật khẩu không đúng');
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        const { user_name, password } = error.response.data.errors;
                        if (user_name) {
                            message.error(user_name);
                        }
                        if (password) {
                            message.error(password);
                        }
                    } else {
                        message.error('Đã xảy ra lỗi không mong muốn');
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
