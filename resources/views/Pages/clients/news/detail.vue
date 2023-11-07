<template>
    <div class="container container-content">
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

                <div class="row" v-if="user">
                    <div class="col-sm-8 mt-4">
                        <h4>Bình luận({{ comments.length }})</h4>
                    </div>
                    <div class="col-sm-8">
                        <a-list v-if="comments.length" :data-source="pageComment" item-layout="horizontal">
                            <template #renderItem="{ item }">
                                <a-list-item>
                                    <a-comment :author="item.user_name" :avatar="item.avatar" :content="item.content"
                                        :datetime="item.created_at" />
                                </a-list-item>
                            </template>
                        </a-list>
                        <div class="d-flex justify-content-end m-3">
                            <a-pagination v-if="comments.length>=5" :current="currentPage" :total="comments.length"
                                :pageSize="pageSize" @change="handlePageChange" />
                        </div>
                        <a-comment>
                            <template #avatar>
                                <a-avatar :src="user.avatar" alt="Avatar" />
                            </template>
                            <template #content>
                                <a-form-item>
                                    <a-textarea v-model:value="value" :rows="4" />
                                </a-form-item>
                                <a-form-item>
                                    <a-button html-type="submit" :loading="submitting" type="primary" @click="handleSubmit">
                                        Bình luận
                                    </a-button>
                                </a-form-item>
                            </template>
                        </a-comment>
                    </div>
                </div>
                <div v-else class=" col-8 d-flex justify-content-center">
                    <router-link class="p-4" :to="{ name: 'clients-login' }">
                        <button class="btn btn-danger">Đăng nhập để bình luận</button>
                    </router-link>
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
import { defineComponent, h, reactive, toRefs, ref, watch, onMounted, watchEffect } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { message, Comment, List, Form, ListItem, FormItem, Pagination } from 'ant-design-vue';
import { LoadingOutlined } from '@ant-design/icons-vue';

export default defineComponent({
    components: {
        LoadingOutlined,
    },
    setup() {
        const getUser= JSON.parse(localStorage.getItem('user'));
        const user = getUser.user;
        const comments = ref([]);
        const submitting = ref(false);
        const value = ref('');
        const currentPage = ref(1);
        const pageSize = 5;
        const pageComment = ref([]);
        const check = ref(['false']);
        const related = ref([]);
        const margin = 'row g-0 mt-4';
        const route = useRoute();
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
        const getCategory = () => {
            axios.get(`http://localhost:8000/api/category`)
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
        const calculatePagedNews = () => {
            const start = (currentPage.value - 1) * pageSize;
            const end = start + pageSize;
            pageComment.value = comments.value.slice(start, end);
        };
        const handlePageChange = (newPage) => {
            currentPage.value = newPage;
            calculatePagedNews();
        };

        const getUsersComment = () => {
            axios.get(`http://localhost:8000/api/comment/detail/${route.params.id}`)
                .then(function (response) {
                    comments.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        };
        const handleSubmit = () => {
            if (!value.value) {
                message.warning('Vui lòng nhập bình luận!');
                return;
            }
            submitting.value = true;
            setTimeout(() => {
                submitting.value = false;
                axios.post('http://localhost:8000/api/comment', {
                    content: value.value,
                    user_id: user.id,
                    news_id: route.params.id,
                })
                    .then(function () {
                        const comment =
                            {
                                author: user.user_name,
                                avatar: user.avatar,
                                content: value.value,
                                datetime: 'Vừa xong',
                            };
                        pageComment.value.push(comment);
                        message.success('Bình luận thành công!');
                        value.value = '';
                    })
                    .catch(function () {
                        message.error('Lỗi hệ thống!');
                    });

            }, 1000);
        };
        const indicator = h(LoadingOutlined, {
            style: {
                fontSize: '40px',
            },
            spin: true,
        });

        const formatTimeStr = (timestamp) => {
            const date = new Date(timestamp);
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            const formattedDate = `${day}/${month}/${year}`;
            return formattedDate;
        };

        onMounted(() => {
            getNews();
            getRelated();
            getUsersComment();
            getCategory();
        });
        watchEffect(() => {
            calculatePagedNews();
            getCategory();
        });
        watch(
            () => route.params.id,
            (newId, oldId) => {
                getNews();
                getRelated();
                getUsersComment();
                calculatePagedNews();
                getCategory();
            }
        );

        return {
            ...toRefs(news),
            related,
            check,
            indicator,
            margin,
            comments,
            submitting,
            value,
            user,
            handleSubmit,
            currentPage,
            pageSize,
            pageComment,
            handlePageChange
        }
    }
});
</script>
<style>
.container-content {
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
    .container-content {
        width: 100%;
    }
}
</style>
