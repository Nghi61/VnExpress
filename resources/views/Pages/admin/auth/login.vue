<template>
    <div class="container py-4">
        <div class="row d-flex justify-content-center align-items-center">
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
                                        <input type="text" placeholder="Tài khoản" name="user_name" v-model="user_name"
                                            class="form-control form-control-lg" />
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Mật khẩu</label>
                                        <input type="password" placeholder="Mật khẩu" name="password" autocomplete="true"
                                            v-model="password" class="form-control form-control-lg" />
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit"
                                            :disabled="block"><span v-show="block == false">ĐĂNG
                                                NHẬP</span> <span v-if="block">{{ formattedTime }}</span></button>
                                    </div>
                                    <router-link class="small text-muted" :to="{ name: 'admin-forget-password' }">Quên mật
                                        khẩu?</router-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, reactive, toRefs, ref, watch, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { message } from 'ant-design-vue';
export default defineComponent({
    setup() {
        onMounted(() => {
            const blockTime = localStorage.getItem('blockTime');
            if (blockTime) {
                time.value = parseInt(blockTime);
                startTimer();
            }
        });
        const imgPath = '/logo.svg';
        const router = useRouter();
        const admin = reactive({
            user_name: '',
            password: ''
        });
        let loginAttempts = 0;
        const block = ref(false);
        let time = ref(0);
        const formatTime = (seconds) => {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes} phút ${remainingSeconds} giây`;
        };
        const formattedTime = ref(formatTime(time.value));
        watch(time, () => {
            formattedTime.value = formatTime(time.value);
            if (time.value === 0) {
                block.value = false;
            } else {
                block.value = true;
            }
        });

        const startTimer = () => {
            const interval = setInterval(() => {
                if (time.value > 0) {
                    time.value--;
                    localStorage.setItem('blockTime', time.value.toString());
                } else {
                    clearInterval(interval);
                    localStorage.removeItem('blockTime');
                }
            }, 1000);
        };

        const login = () => {
            if (loginAttempts >= 5) {
                message.error('Bạn đã vượt quá số lần cho phép đăng nhập. Vui lòng thử lại sau 5 phút');
                time.value = 300;
                startTimer();
            }
            axios.post('http://localhost:8000/api/isadmin', admin)
                .then((response) => {
                    if (response.status === 200 && response.data.status === 'success') {
                        const userWithExpiry = {
                            user: response.data.admin,
                            expiry: Date.now() + 24 * 60 * 60 * 1000
                        };
                        localStorage.setItem('admin', JSON.stringify(userWithExpiry));
                        message.success('Đăng nhập thành công');
                        router.push({ path: '/admin/users' });
                    } else if (response.data.status === 'error') {
                        message.error('Tài khoản không có quyền truy cập');
                    } else {
                        message.error('Tài khoản hoặc mật khẩu không đúng');
                        loginAttempts++;
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
                    } else {
                        message.error('Đã xảy ra lỗi không mong muốn');
                    }
                });
        };
        return {
            ...toRefs(admin),
            imgPath,
            block,
            formattedTime,
            login
        }
    }
})
</script>
