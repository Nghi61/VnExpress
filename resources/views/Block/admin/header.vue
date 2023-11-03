<template>
    <div class="containter">
        <div class="row text-white" style="background-color: #0c713d; padding: 1rem">
            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawerLeft()">
                    <MenuOutlined />
                </span>
            </div>
            <div class="col-10 col-sm-3 d-flex justify-content-center">
                                <img :src="imgLogo" style="width: 130px;" alt="Avatar" />
            </div>
            <div class="col-sm-5 d-none d-sm-flex">
                <a-input-search allowClear class="center-icon" size="large" placeholder="Tìm kiếm" />
            </div>
            <div class="col-sm-3 col-1 d-flex justify-content-sm-end align-items-center justify-content-center">
                <a-dropdown>
                    <a class="ant-dropdown-link d-flex" @click.prevent>
                        <span class="me-2">
                                <a-avatar :size="{ xs: 24, xl: 30 }" :src="imgUser" alt="Avatar" />
                        </span>
                        <span class="d-sm-block d-none text-white">Chào, {{ user_name }}</span>
                    </a>
                    <template #overlay>
                        <a-menu class="mt-2">
                            <a-menu-item>
                                <a @click="Profile">Hồ sơ</a>
                            </a-menu-item>
                            <a-menu-item>
                                <a @click="Logout">Đăng xuất</a>
                            </a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
            </div>
        </div>
    </div>
    <a-drawer v-model:open="openLeft" title="Danh mục" placement="left">
        <Menu />
    </a-drawer>
</template>
<script>
import Menu from '../admin/menu.vue';
import { MenuOutlined, UserOutlined } from '@ant-design/icons-vue';
import { Drawer, Input, Dropdown} from 'ant-design-vue';
import { useRouter } from 'vue-router';
import { defineComponent, ref } from 'vue';
export default defineComponent({
    components: {
        Menu,
        MenuOutlined,
        UserOutlined
    },
    setup() {
        const user = JSON.parse(localStorage.getItem('admin'));
        const imgLogo = '/logo.svg';
        const imgUser = user.avatar;
        const user_name = user.user_name;
        const router = useRouter();
        const openLeft = ref(false);
        const showDrawerLeft = () => {
            openLeft.value = true;
        };
        const Logout = () => {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            router.push({name:'admin-login'});
        };
        const Profile = () => {
          router.push({name:'admin-profile'});
        };
        return {
            openLeft,
            imgLogo,
            imgUser,
            user_name,
            showDrawerLeft,
            Profile,
            Logout
        };
    },
});
</script>
