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
                                <input type="password" placeholder="Mật khẩu" name="password" autocomplete="on"
                                    v-model="password" class="form-control form-control-lg" />
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit"
                                    :disabled="block"><span v-show="block == false">ĐĂNG
                                        NHẬP</span> <span v-if="block">{{ formattedTime }}</span> </button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <router-link class="small text-muted" :to="{ name: 'clients-forget-password' }">Quên mật
                                    khẩu?</router-link>
                                <router-link class="text-decoration-none" :to="{ name: 'clients-sign-up' }"><span>Tạo tài
                                        khoản</span></router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, reactive, ref, toRefs, watch, onMounted } from 'vue';
import axios from 'axios';
import { message } from 'ant-design-vue';

export default defineComponent({
    setup() {
        const user = reactive({
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
        const startTimer = () => {
            const interval = setInterval(() => {
                if (time.value > 0) {
                    time.value--;
                    localStorage.setItem('savedTime', time.value.toString());
                } else {
                    clearInterval(interval);
                    localStorage.removeItem('savedTime');
                }
            }, 1000);
        };
        onMounted(() => {
            const savedTime = localStorage.getItem('savedTime');
            if (savedTime) {
                time.value = parseInt(savedTime);
                startTimer();
            }
        });
        watch(time, () => {

            formattedTime.value = formatTime(time.value);
            if (time.value === 0) {
                block.value = false;
            } else {
                block.value = true;
            }
        });

        const login = () => {
            if (loginAttempts >= 5) {
                message.error('Bạn đã vượt quá số lần cho phép đăng nhập. Vui lòng thử lại sau 5 phút');
                time.value = 300;
                startTimer();
            }

            axios.post('http://localhost:8000/api/login', user)
                .then((response) => {
                    if (response.data.status === 200 && response.data.user) {
                        const userWithExpiry = {
                            user: response.data.user,
                            expiry: Date.now() + 24 * 60 * 60 * 1000
                        };
                        localStorage.setItem('user', JSON.stringify(userWithExpiry));
                        message.success('Đăng nhập thành công');
                        window.location.href = '/home';
                    }
                    if (response.data.status === 401) {
                        loginAttempts++;
                        message.error('Tài khoản hoặc mật khẩu không đúng!');
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
            block,
            formattedTime,
            login
        };
    }
});
</script>
