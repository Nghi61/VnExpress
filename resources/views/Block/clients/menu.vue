<template>
    <a-menu class="border-0 container-fluid" v-model:selectedKeys="selectedKeys" v-model:openKeys="openKeys" :mode="isMobile ? 'inline' : 'horizontal'">
        <a-menu-item v-for="item in items" :key="item.key">
            <router-link v-if="item.key === 'Home'" :to="{ name: 'clients-home' }" class="text-decoration-none">
                <HomeOutlined/>
                <span>
                    {{ item.title }}
                </span>

            </router-link>
            <router-link v-else :to="{ name: 'clients-news', params: { slug: item.key } }" class="text-decoration-none">
                <span>
                    {{ item.title }}
                </span>
            </router-link>
        </a-menu-item>
    </a-menu>
</template>
<script>
import { defineComponent, ref, onMounted, onBeforeUnmount} from 'vue';
import { HomeOutlined } from '@ant-design/icons-vue';
import { storeToRefs } from 'pinia';
import axios from 'axios';
import { message } from 'ant-design-vue';
import { menu } from '../../stores/menu';

export default defineComponent({
    components: {
        HomeOutlined
    },
    setup() {
        const isMobile = ref(false);
        const cate = ref([]);
        const cateItems = ref([]);
        const store = menu();
        const items = ref([
            {
                key: 'Home',
                label: 'Trang chủ',
                title: 'Trang chủ',
            }
        ]);
        const getCategory = () => {
            axios.get('http://localhost:8000/api/category')
                .then(function (response) {
                    cate.value = response.data;
                    cateItems.value = cate.value.map((item) => {

                        return {
                            key: item.slug,
                            label: item.name,
                            title: item.name,
                        }
                    });
                    items.value.push(...cateItems.value.filter(item => item.key !== 'khong-xac-dinh'));
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        }
        const checkIfMobile = () => {
            isMobile.value = window.innerWidth <= 768; // Kiểm tra kích thước màn hình
        };
        onMounted(() => {
            checkIfMobile();
            getCategory();
            window.addEventListener('resize', checkIfMobile); // Thêm sự kiện resize để theo dõi sự thay đổi kích thước màn hình
        });

        onBeforeUnmount(() => {
            window.removeEventListener('resize', checkIfMobile); // Loại bỏ sự kiện khi component bị unmounted
        });
        return {
            items,
            isMobile,
            ...storeToRefs(store),
        }
    }
});
</script>
