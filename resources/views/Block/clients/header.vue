<template>
    <div class="containter">
        <div class="row p-4 border-bottom">
            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawerLeft()">
                    <MenuOutlined />
                </span>
            </div>
            <div class="col-10 col-sm-3 d-flex justify-content-center">
                <img :src="imgLogo" style="width: 140px;" alt="Avatar" />
            </div>
            <div class="col-sm-4 mt-1 d-none d-sm-flex justify-content-sm-start">
                <span>Hồ Chí Minh</span>
                <span class="mx-2">|</span>
                <span>{{ formattedDate }}</span>
            </div>
            <div class="col-sm-3 d-none d-sm-table">
                <a-input-search allowClear class="center-icon position-relative" @change="fetchNews()" v-model:value="data"
                    size="large" placeholder="Tìm kiếm">
                </a-input-search>
                <template v-if="result.length > 0 && !clickedResult">
                    <a-list class="position-absolute search" :data-source="result">
                        <template #renderItem="{ item }">
                            <a-list-item>
                                <a-list-item-meta>
                                    <template #title>
                                        <router-link class="text-decoration-none"
                                            :to="{ name: 'clients-news-detail', params: { id: item.id } }"
                                            @click="handleClickResult">{{ item.title }}</router-link>
                                    </template>
                                    <template #avatar>
                                        <a-avatar :src="item.image" />
                                    </template>
                                </a-list-item-meta>
                            </a-list-item>
                        </template>
                    </a-list>
                </template>
                <template v-if="loading">
                    <div class="loading p-2 position-absolute">
                        <a-spin />
                    </div>
                </template>
            </div>
            <div class="col-sm-2 col-1 d-sm-flex justify-content-sm-center align-items-center justify-content-center">
                <a-dropdown>
                    <a class="ant-dropdown-link d-flex text-decoration-none" @click.prevent>
                        <span class="me-2">
                            <a-avatar :size="{ xs: 24, xl: 30 }" :src="user ? user.avatar : imgUser" alt="Avatar" />
                        </span>
                        <span v-if="user" class="d-sm-block d-none text-dark">Chào, {{ user.name }}</span>
                        <router-link v-else :to="{ name: 'clients-login' }" class="text-decoration-none text-dark">
                            <span class="d-sm-block d-none">Đăng nhập</span>
                        </router-link>
                    </a>
                    <template v-if="user" #overlay>
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
        <a-input-search allowClear class="center-icon position-relative" @change="fetchNews()" v-model:value="data"
                    size="large" placeholder="Tìm kiếm">
                </a-input-search>
                <template v-if="result.length > 0 && !clickedResult">
                    <a-list class="position-absolute search" :data-source="result">
                        <template #renderItem="{ item }">
                            <a-list-item>
                                <a-list-item-meta>
                                    <template #title>
                                        <router-link class="text-decoration-none"
                                            :to="{ name: 'clients-news-detail', params: { id: item.id } }"
                                            @click="handleClickResult">{{ item.title }}</router-link>
                                    </template>
                                    <template #avatar>
                                        <a-avatar :src="item.image" />
                                    </template>
                                </a-list-item-meta>
                            </a-list-item>
                        </template>
                    </a-list>
                </template>
                <template v-if="loading">
                    <div class="loading p-2 position-absolute">
                        <a-spin />
                    </div>
                </template>
        <Menu :mode="inline" />
    </a-drawer>
</template>
<script>
import Menu from './menu.vue';
import { MenuOutlined, UserOutlined, SearchOutlined } from '@ant-design/icons-vue';
import { Drawer, message } from 'ant-design-vue';
import { defineComponent, ref, reactive, toRefs } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { debounce } from 'lodash-es';

export default defineComponent({
    components: {
        Menu,
        MenuOutlined,
        UserOutlined,
        SearchOutlined,
    },
    setup() {
        const data = ref('');
        const result = ref([]);
        const loading = ref(false);
        const clickedResult = ref(false);

        const imgLogo = '/logo.svg';
        const imgUser = 'http://localhost:8000/storage/img/users/default.png';

        const daysOfWeek = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
        const monthsOfYear = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

        const getUser = JSON.parse(localStorage.getItem('user'));
        const user=ref(null);
        if(getUser){
            user.value=getUser.user;
        }

        const currentDate = new Date();
        const dayOfWeek = daysOfWeek[currentDate.getDay()];
        const dayOfMonth = currentDate.getDate();
        const month = monthsOfYear[currentDate.getMonth()];
        const year = currentDate.getFullYear();

        const formattedDate = `${dayOfWeek}, ${dayOfMonth} ${month} ${year}`;

        const openLeft = ref(false);

        const showDrawerLeft = () => {
            openLeft.value = true;
        };

        const inline = ref('inline');
        const router = useRouter();

        const Logout = () => {
            localStorage.removeItem('user');
            window.location.reload();
        };

        const Profile = () => {
            router.push({ name: 'clients-profile' });
        };

        const handleClickResult = () => {
            clickedResult.value = true;
            data.value = '';
        }
        const fetchNews = debounce(() => {
            loading.value = true;
            axios.get(`http://localhost:8000/api/news/search/${data.value}`)
                .then(response => {
                    if (response.data.length === 0) {
                        result.value = [];
                        loading.value = false;

                    } else {
                        result.value = response.data;
                        loading.value = false;
                    }
                })
                .catch(error => {
                    message.error('Lỗi hệ thống!');
                });
        }, 300);

        return {
            user,
            data,
            result,
            loading,
            imgLogo,
            imgUser,
            formattedDate,
            openLeft,
            showDrawerLeft,
            Profile,
            Logout,
            clickedResult,
            handleClickResult,
            inline,
            fetchNews
        };

    },
});
</script>
<style>
.search {
    z-index: 1000;
    width: 19rem;
    background-color: whitesmoke;
    max-height: 270px;
  overflow-y: auto;
}

.loading {
    z-index: 1000;
    width: 17rem;
    margin-left: 10px;
}</style>
