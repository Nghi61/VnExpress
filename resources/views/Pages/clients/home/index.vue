<template>
    <div class="container mt-4" v-if="news.length > 0">
        <div class="row mt-3 content">
            <div class="col-sm-7">
                <img :src="news[0].image" class="card-img">
            </div>
            <div class="col-sm-5 mt-2">
                <div class="card-body">
                    <h5 class="card-title">{{ news[0].title }}</h5>
                    <p class="card-text d-sm-none d-block mt-3">
                        <small class="text-body-secondary d-sm-none d-block">{{ news[0].created_at }}</small>
                    </p>
                    <p class="card-text mt-2 card-content">{{ news[0].content }}</p>
                    <router-link class="text-decoration-none text-dark"
                        :to="{ name: 'clients-news-detail', params: { id: news[0].id } }">
                        <a-button class="d-sm-flex d-none">Đọc thêm</a-button>
                    </router-link>
                </div>
            </div>
        </div>
        <hr class="mt-sm-3 mt-0 line">
        <div class="row content">
            <div v-for="(singleNews, index) in news.slice(1, -1)" :key="index" class="col-sm-4 col-12 mt-3">
                <router-link class="text-decoration-none text-dark"
                    :to="{ name: 'clients-news-detail', params: { id: singleNews.id } }">
                    <div class="col-12">
                        <img :src="singleNews.image" style="height: 12rem;" class="card-img">
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card-body">
                            <h6 class="card-title">{{ singleNews.title }}</h6>
                            <p class="card-text mt-3">
                                <small class="text-body-secondary d-sm-none d-block">{{ news[0].created_at }}</small>
                            </p>
                            <p class="card-text mt-2 d-sm-none">{{ singleNews.description }}</p>
                        </div>
                    </div>
                </router-link>
                <hr class="d-sm-none">
            </div>
        </div>
        <hr class="mt-sm-1 mt-0 line">
        <div class="row mt-3 content display">
            <div class="col-sm-5 mt-2">
                <div class="card-body">
                    <h5 class="card-title">{{ news[news.length - 1].title }}</h5>
                    <p class="card-text mt-2 card-content">{{ news[news.length - 1].content }}</p>
                    <router-link class="text-decoration-none text-dark"
                        :to="{ name: 'clients-news-detail', params: { id: news[0].id } }">
                        <a-button>Đọc thêm</a-button>
                    </router-link>
                </div>
            </div>
            <div class="col-sm-7">
                <img :src="news[news.length - 1].image" class="card-img">
            </div>
        </div>
    </div>
    <template v-else>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <a-spin :indicator="indicator" />
        </div>
    </template>
</template>

<script>
import { defineComponent, ref, toRefs, h } from 'vue';
import { menu } from '../../../stores/menu';
import { LoadingOutlined } from '@ant-design/icons-vue'
import axios from 'axios';
import { message } from 'ant-design-vue';

export default defineComponent({
    setup() {
        const indicator = h(LoadingOutlined, {
            style: {
                fontSize: '40px',
            },
            spin: true,
        });
        const news = ref([]);
        const store = menu();
        store.onSlectedKeys(['home']);
        const getNews = () => {
            axios.get(`http://localhost:8000/api/news`)
                .then(function (response) {
                    news.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                });
        }
        getNews();
        return {
            news,
            indicator
        }
    }
});

</script>
<style>
.content {
    margin: auto;
    width: 70rem;
}

.line {
    width: 68rem;
    margin: auto;
}

.card-content {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 10;
    max-width: 1000px;
    text-decoration: none;
}

@media screen and (max-width: 576px) {
    .container {
        width: 100%;
    }

    .content {
        width: 100%;
    }

    .display {
        display: none;
    }

    .card-img {
        width: 20rem;
    }

    .line {
        width: 20rem;
        margin-top: 15px;
    }

    .card-content {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 5;
        max-width: 1000px;
    }

}
</style>
