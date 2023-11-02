<template>
    <div class="container mt-4 content">
        <div class="row g-0" v-if="pagedNews.length > 0">
            <router-link class="text-decoration-none text-dark"
                :to="{ name: 'clients-news-detail', params: { id: news[0].id } }">
                <div v-for="(singleNews, index) in pagedNews" :key="index" class="col-12">
                    <div class="row g-0 mt-3">
                        <div class="col-sm-4">
                            <img :src="singleNews.image" class="card-img">
                        </div>
                        <div class="col-sm-8 p-2">
                            <div class="card-body">
                                <h5 class="card-title">{{ singleNews.title }}</h5>
                                <p class="card-text mt-2">{{ singleNews.description }}</p>
                                <p class="card-text"><small class="text-body-secondary">{{ singleNews.created_at }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr class="d-sm-none ">
                </div>
            </router-link>
        </div>
        <template v-else>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <a-spin :indicator="indicator" />
            </div>
        </template>
        <div class="d-flex justify-content-end m-3">
            <a-pagination :current="currentPage" :total="news.length" :pageSize="pageSize" @change="handlePageChange" />
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch,h } from 'vue';
import { menu } from '../../../stores/menu';
import { useRoute } from 'vue-router';
import { LoadingOutlined } from '@ant-design/icons-vue'
import axios from 'axios';
import { message, Pagination } from 'ant-design-vue';

export default defineComponent({
    components: {
        Pagination
    },
    setup() {
        const indicator = h(LoadingOutlined, {
            style: {
                fontSize: '40px',
            },
            spin: true,
        });
        const route = useRoute();
        const news = ref([]);
        const slug = ref('');
        const currentPage = ref(1);
        const pageSize = 10;
        const pagedNews = ref([]);
        const store = menu();
        const calculatePagedNews = () => {
            const start = (currentPage.value - 1) * pageSize;
            const end = start + pageSize;
            pagedNews.value = news.value.slice(start, end);
        };
        const handlePageChange = (newPage) => {
            currentPage.value = newPage;
            calculatePagedNews();
        };
        const getNews = () => {
            axios.get(`http://localhost:8000/api/news/category/${slug.value}`)
                .then(function (response) {
                    news.value = response.data;
                    calculatePagedNews();
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        }

        onMounted(() => {
            if (route.params.slug) {
                slug.value = route.params.slug;
                store.onSlectedKeys([slug.value]);
                getNews();
            } else {
                message.error('Lỗi hệ thống!');
            }
        });

        watch(() => route.params.slug, (newSlug, oldSlug) => {
            if (newSlug !== oldSlug) {
                slug.value = newSlug;
                store.onSlectedKeys([slug.value]);
                getNews();
            }
        });

        return {
            indicator,
            news,
            currentPage,
            pageSize,
            pagedNews,
            handlePageChange
        }
    }
});
</script>
<style>
.content {
    width: 60rem;
}

@media screen and (max-width: 768px) {
    .content {
        width: 100%;
    }

}
</style>
