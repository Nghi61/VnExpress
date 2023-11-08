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
                                <form @submit.prevent="forgetPassword()">
                                    <div class="d-flex mb-5 ">
                                        <img :src="imgPath" alt="Logo">
                                    </div>
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <h5>QUÊN MẬT KHẨU</h5>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" placeholder="Email" name="user_name" v-model="email"
                                    class="form-control form-control-lg" />
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block w-100" htmlType="submit" :disabled="check">  <template v-if="check">
                            <Spin/>
                        </template><span v-else>Gửi mail</span> </button>
                            </div>
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
import { defineComponent, reactive, toRefs, ref } from 'vue';
import axios from 'axios';
import { message, Spin } from 'ant-design-vue';
import { useRouter } from 'vue-router';
export default defineComponent({
    components: {
        Spin
    },
    setup() {
        const imgPath = '/logo.svg';
        const route=useRouter();
        const check=ref(false)
        const email = reactive({
            email: ''
        });

        const forgetPassword = () => {
            check.value=true;
            axios.post('http://localhost:8000/api/forget-password', email)
                .then((response) => {
                    if (response.data.status === 200) {
                        message.success('Gửi mail thành công!');
                        route.push({name:'admin-login'});
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
            imgPath,
            check,
            forgetPassword
        }
    }
})
</script>
