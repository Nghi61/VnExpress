<template>
    <div>
        <a-card title="Hồ sơ cá nhán">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <form @submit.prevent="updateProfile(id)">
                            <div class="row g-0">
                                <div class="col-md-4 text-center text-white">
                                    <a-avatar :size="{ xs: 80, xl: 180 }" :src="avatar" class="mt-5" alt="Avatar" />
                                    <div class="w-100 mt-4"></div>
                                    <a-upload :before-upload="beforeUpload" @change="handleFileChange()" name="file"
                                        v-model:file-list="fileList" :max-count="1"
                                        action="http://localhost:8000/api/upload/user">
                                        <a-button type="primary" class="center-icon">
                                            <FormOutlined /> Chỉnh sửa
                                        </a-button>
                                        <small v-if="errors.avatar" class="text-danger">{{ errors.avatar[0] }}</small>
                                    </a-upload>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h6>Thông tin cá nhân</h6>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-sm-6 mb-3">
                                                <h6>Tên tài khoản</h6>
                                                <a-input placeholder="Tên tài khoản" v-model:value="user_name"
                                                    class="text-muted"></a-input>
                                                <small v-if="errors.user_name" class="text-danger">{{ errors.user_name[0]
                                                }}</small>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <h6>Vai trò</h6>
                                                <a-input disabled placeholder="Tên tài khoản" v-model:value="role"
                                                    class="text-muted"></a-input>
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-sm-6 mb-3">
                                                <h6>Họ tên</h6>
                                                <a-input placeholder="Họ tên" v-model:value="name"
                                                    class="text-muted"></a-input>
                                                <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <h6>Email</h6>
                                                <a-input placeholder="Họ tên" v-model:value="email"
                                                    class="text-muted"></a-input>
                                                <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                                            </div>
                                        </div>
                                        <h6 class="mt-3">Bảo mật</h6>
                                        <hr class="mt-0 mb-4">
                                        <div class="col-12 mb-3">
                                            <a-checkbox v-model:checked="changePassword">
                                                Đổi mật khẩu
                                            </a-checkbox>
                                        </div>
                                        <div v-if="changePassword === true" class="row pt-1">
                                            <div class="col-sm-6 mb-3">
                                                <h6>Mật khẩu mới</h6>
                                                <a-input-password allow-clear placeholder="Mật khẩu mới"
                                                    v-model:value="password" class="text-muted"></a-input-password>
                                                <small v-if="errors.password" class="text-danger">{{ errors.password[0]
                                                }}</small>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <h6>Xác nhận mật khẩu </h6>
                                                <a-input-password allow-clear placeholder="Xác nhận mật khẩu"
                                                    v-model:value="password_confirmation"
                                                    class="text-muted"></a-input-password>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-12 d-grid d-sm-flex justify-content-sm-end mx-auto">
                                                <a-button class="me-0 mb-3 me-sm-2 mb-sm-0">
                                                    <router-link :to="{ name: 'admin-users' }">
                                                        <span>Hủy</span>
                                                    </router-link>
                                                </a-button>
                                                <a-button type="primary" htmlType="submit">
                                                    <span>Lưu</span>
                                                </a-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </a-card>
    </div>
</template>
<script>
import { FormOutlined } from '@ant-design/icons-vue';
import { Input, message, Upload } from 'ant-design-vue';
import { useRouter } from 'vue-router';
import { defineComponent, reactive, ref, toRefs } from 'vue';
import axios from 'axios';
export default defineComponent({
    components: {
        FormOutlined,
    },
    setup() {
        const imgLogo = '/logo.svg';
        const fileList = ref([]);
        const errors = ref([]);
        const user = reactive({
            id: '',
            user_name: '',
            name: '',
            email: '',
            changePassword: false,
            password: '',
            password_confirmation: '',
            avatar: '',
            role: '',
        });
        const getInfor = JSON.parse(localStorage.getItem('admin'));
        const infor = getInfor.user;
        user.id = infor.id;
        user.user_name = infor.user_name;
        user.name = infor.name;
        user.email = infor.email;
        user.avatar = infor.avatar;
        user.role = infor.role;
        if (user.role == 0) {
            user.role = 'Quản trị viên';
        }
        const handleFileChange = () => {
            if (fileList.length > 0) {
                const file = fileList.value[0];
                if (file.status === "done" && file.response && file.response.file_path) {
                    user.avatar = file.response.file_path;
                }
            }
        }
        const beforeUpload = file => {
            const allowedFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/svg+xml']; // Thêm các định dạng tệp bạn muốn hỗ trợ
            if (!allowedFileTypes.includes(file.type)) {
                message.error(`${file.name} định dạng không hỗ trợ!`);
                return Upload.LIST_IGNORE;
            }
        };
        const updateProfile = (id) => {
            if (fileList.value.length > 0)
                user.avatar = fileList.value[0].response.file_path;
            axios.put(`http://localhost:8000/api/profile/${id}`, user)
                .then(res => {
                    if (res.data.status === 200) {
                        message.success('Cập nhật thành công!');
                        const response = res.data;
                        const userWithExpiry = {
                            user: response.user,
                            expiry: Date.now() + 24 * 60 * 60 * 1000
                        };
                        localStorage.setItem('admin', JSON.stringify(userWithExpiry));
                        user.id = response.user.id;
                        user.user_name = response.user.user_name;
                        user.name = response.user.name;
                        user.email = response.user.email;
                        user.avatar = response.user.avatar;
                        user.role = response.user.role;
                        window.location.reload();
                    }
                })
                .catch(err => {
                    errors.value = err.response.data.errors;
                })
        };

        return {
            ...toRefs(user),
            fileList,
            errors,
            imgLogo,
            beforeUpload,
            handleFileChange,
            updateProfile,
        };
    },
});
</script>
