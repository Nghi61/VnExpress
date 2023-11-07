<template>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card mt-5" style="border-radius: 1rem; width: 35rem;">
                <div class="row g-0">
                    <div class="card-body p-5 text-black">
                        <form @submit.prevent="forgetPassword()">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <h5>QUÊN MẬT KHẨU</h5>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" placeholder="Email" name="user_name" v-model="email"
                                    class="form-control form-control-lg" />
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit">Gửi mail</button>
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
import { useRouter } from 'vue-router';
export default defineComponent({
    setup() {
        const route=useRouter();
        const email = reactive({
            email: ''
        });

        const forgetPassword = () => {
            axios.post('http://localhost:8000/api/forget-password', email)
                .then((response) => {
                    if (response.data.status === 200) {
                        message.success('Gửi mail thành công!');
                        route.push({name:'clients-login'});
                    }
                    if(response.data.status === 401) {
                        message.error('Email không tồn tại!');
                    }
                })
                .catch((error) => {
                 error.response.data.errors.email.forEach((item) => {
                     message.warning(item);
                 });
                });
        };

        return {
            ...toRefs(email),
            forgetPassword
        }
    }
})
</script>
