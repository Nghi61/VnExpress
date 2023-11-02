<template>
    <div class="container content">
        <template v-if="check == true">
            <div class="row">
                <div class="col-sm-8 mt-3">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between mb-3 p-sm-2 mx-sm-2">
                            <router-link class="text-decoration-none"
                                :to="{ name: 'clients-news', params: { slug: slug } }">
                                <h3 class="card-text"><small class="text-body-secondary">{{ category_id }}</small></h3>
                            </router-link>
                            <p class="card-text mt-sm-2 mx-3"><small class="text-body-secondary">{{ created_at }}</small>
                            </p>
                        </div>
                        <div class="col-12">
                            <h3 class="card-title">{{ title }}</h3>
                            <p class="card-text mt-2">{{ description }}</p>
                            <img :src="image" class="card-img">
                        </div>
                        <div class="col-12 p-2">
                            <div class="card-body">
                                <p class="card-text mt-2">{{ content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 d-sm-block d-none mt-3">
                    <div class="row g-0" v-if="related && related.length > 0">
                        <h4 class="mt-2" style="text-decoration: underline">Bạn có thể quan tâm</h4>
                        <div v-for="(singleNews, index) in related" :key="index">
                            <router-link class="text-decoration-none text-dark"
                                :to="{ name: 'clients-news-detail', params: { id: singleNews.id } }">
                                <div :class="index == 0 ? margin : 'row g-0'">
                                    <div class="col-sm-4 mt-1">
                                        <img :src="singleNews.image" class="card-img">
                                    </div>
                                    <div class="col-sm-7 mx-2">
                                        <div class="card-body">
                                            <h5 class="card-title text-detail">{{ singleNews.title }}</h5>
                                            <p class="card-text mt-1"><small class="text-body-secondary">{{
                                                singleNews.created_at
                                            }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </router-link>
                            <hr v-show="index < related.length - 1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-3">
                        <h4>Bình luận()</h4>
                    </div>
                    <div class="col-12 bg-danger">
                        <template>
                            <a-list class="comment-list" :header="`${data.length} replies`" item-layout="horizontal"
                                :data-source="data">
                                <template #renderItem="{ item }">
                                    <a-list-item>
                                        <a-comment :author="item.author" :avatar="item.avatar">
                                            <template #content>
                                                <p>
                                                    {{ item.content }}
                                                </p>
                                            </template>
                                            <template #datetime>
                                                <a-tooltip :title="item.datetime.format('YYYY-MM-DD HH:mm:ss')">
                                                    <span>{{ item.datetime.fromNow() }}</span>
                                                </a-tooltip>
                                            </template>
                                        </a-comment>
                                    </a-list-item>
                                </template>
                            </a-list>
                        </template>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <a-spin :indicator="indicator" />
            </div>
        </template>
    </div>
</template>

<script>
import { defineComponent, h, reactive, toRefs, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { message, Comment,List } from 'ant-design-vue';
import { LoadingOutlined } from '@ant-design/icons-vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);


export default defineComponent({
    setup() {
        const indicator = h(LoadingOutlined, {
            style: {
                fontSize: '40px',
            },
            spin: true,
        });
        const check = ref(['false']);
        const related = ref([]);
        const margin = 'row g-0 mt-4';
        const route = useRoute();
        const data = [
            {
                author: 'Han Solo',
                avatar: 'http://localhost:8000/storage/img/users/default.png',
                content:
                    'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.',
                datetime: dayjs().subtract(1, 'days'),
            },
            {
                author: 'Han Solo',
                avatar:'http://localhost:8000/storage/img/users/default.png',
                content:
                    'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.',
                datetime: dayjs().subtract(2, 'days'),
            },
        ];
        const news = reactive(
            {
                title: '',
                description: '',
                image: '',
                created_at: '',
                content: '',
                category_id: '',
                slug: '',
            }
        );
        const formatTimeStr = (timestamp) => {
            const date = new Date(timestamp);
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            const formattedDate = `${day}/${month}/${year}`;
            return formattedDate;
        };


        const getNews = () => {
            axios.get(`http://localhost:8000/api/news/${route.params.id}`)
                .then(function (response) {
                    news.title = response.data.title;
                    news.description = response.data.description;
                    news.image = response.data.image;
                    news.created_at = formatTimeStr(response.data.created_at);
                    news.content = response.data.content;
                    news.category_id = response.data.category_id;
                    news.slug = response.data.slug;
                    check.value = true;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        }
        const getRelated = () => {
            axios.get('http://localhost:8000/api/news')
                .then(function (response) {
                    if (response.data.length > 0) {
                        response.data.forEach(element => {
                            if (element.id == route.params.id) {
                                response.data.splice(response.data.indexOf(element), 1);
                            }
                        });
                        related.value = response.data;
                    }
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        }
        const getCategory = async () => {
            await axios.get(`http://localhost:8000/api/category`)
                .then(function (response) {
                    if (response.data.length > 0) {
                        response.data.forEach(element => {
                            if (element.id == news.category_id) {
                                news.category_id = element.name;
                                news.slug = element.slug;
                            }
                        });
                    }
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        }
        onMounted(() => {
            getNews();
            getCategory();
            getRelated()
        });
        return {
            ...toRefs(news),
            related,
            check,
            data,
            indicator,
            margin
        }
    }
});
</script>
<style>
.content {
    width: 70rem;
}

.text-detail {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    max-width: 1000px;
    text-decoration: none;
}

@media screen and (max-width: 768px) {
    .content {
        width: 100%;
    }

    .card-content {
        display: flex;
        width: 100%;
    }
}
</style>
