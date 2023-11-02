<template>
    <form @submit.prevent="updateUser()">
        <a-card title="Cập nhật tài khoản tài khoản" style="width: 100%;">
            <div class="row mb-3">
                <div class="col-12 col-sm-4 mb-4">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-3">
                            <a-avatar shape="square" :size="200">
                                <template #icon>
                                    <img :src="avatar" alt="Avatar">
                                </template>
                            </a-avatar>
                        </div>
                        <div class="col-12 text-center">
                            <a-upload :before-upload="beforeUpload" @change="handleFileChange()" name="file" v-model:file-list="fileList" :max-count="1"
                                action="http://localhost:8000/api/upload/user">
                                <a-button class="center-icon">
                                    <upload-outlined></upload-outlined>
                                    Đổi Avatar
                                </a-button>
                            </a-upload>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-8">
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span :class="{ 'text-danger': errors.user_name }">Tên tài khoản</span>

                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Tên tài khoản" allow-clear v-model:value="user_name"
                                :class="{ 'input-danger': user_name }" />
                            <div class="w-100"></div>
                            <small v-if="errors.user_name" class="text-danger">{{ errors.user_name[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span :class="{ 'text-danger': errors.name }">Họ tên</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Họ tên" allow-clear v-model:value="name"
                                :class="{ 'input-danger': name }" />
                            <div class="w-100"></div>
                            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span :class="{ 'text-danger': errors.email }">Email</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Email" allow-clear v-model:value="email"
                                :class="{ 'input-danger': email }" />
                            <div class="w-100"></div>
                            <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">

                        </div>
                        <div class="col-12 col-sm-5">
                            <a-checkbox v-model:checked="changePassword">
                                Đổi mật khẩu
                            </a-checkbox>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="changePassword == true">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span :class="{ 'text-danger': errors.password }">Mật khẩu</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Mật khẩu" allow-clear v-model:value="password"
                                :class="{ 'input-danger': password }" />
                            <div class="w-100"></div>
                            <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="changePassword == true">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span>Xác nhận mật khẩu</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Xác nhận mật khẩu" allow-clear
                                v-model:value="password_confirmation" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label for="">
                                <span class="text-danger me-1">*</span>
                                <span :class="{ 'text-danger': errors.role }">Vai trò</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-radio-group v-model:value="role">
                                <a-radio value="0">Quản lý</a-radio>
                                <a-radio value="1">Người dùng</a-radio>
                            </a-radio-group>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
        </a-card>
    </form>
</template>
<script>
import { defineComponent, reactive, ref, toRefs } from 'vue';
import { menu } from '../../../stores/menu';
import { message, Upload } from 'ant-design-vue';
import { UploadOutlined } from '@ant-design/icons-vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
export default defineComponent({
    components: {
        UploadOutlined
    },
    setup() {
        const fileList = ref([]);
        const store = menu();
        store.onSlectedKeys(['admin-users']);
        const errors = ref({});
        const router = useRouter();
        const route = useRoute();
        const users = reactive({
            user_name: "",
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            avatar: "",
            changePassword: false,
            role: "",
        });
        const getUser = () => {
            axios.get(`http://localhost:8000/api/users/${route.params.id}`)
                .then(function (response) {
                    users.user_name = response.data.user_name;
                    users.name = response.data.name;
                    users.email = response.data.email;
                    users.avatar = response.data.avatar;
                    users.role = response.data.role;
                })
                .catch(function () {
                    message.error("Lỗi hệ thống!");
                })
        }
        getUser();
        const handleFileChange = () => {
            if (fileList.length > 0) {
                const file = fileList.value[0];
                if (file.status === "done" && file.response && file.response.file_path) {
                    users.avatar = file.response.file_path;
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
        const updateUser = () => {
            if(fileList.value.length > 0)
            users.avatar=fileList.value[0].response.file_path;
            axios
                .put(`http://127.0.0.1:8000/api/users/${route.params.id}`, users)
                .then((response) => {
                    if (response.status == 200) {
                        message.success("Cập nhật thành công!");
                        router.push({ name: "admin-users" });
                    }
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        };

        return {
            ...toRefs(users),
            fileList,
            errors,
            beforeUpload,
            handleFileChange,
            updateUser
        }
    },
})
</script>

