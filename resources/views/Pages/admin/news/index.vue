<template>
    <a-card title="Tin tức" style="width: 100%;">
        <div class="row ">
            <div class="col-12 mb-3 d-flex">
                <div class="row">
                    <div class="col-8">
                        <a-input-search class="center-icon" allowClear v-model:value="query" placeholder="Tìm kiếm"
                            enter-button @search="onSearch" />
                    </div>
                    <div class="col-4">
                        <router-link :to="{ name: 'admin-news-create' }">
                            <a-button type="primary" class="center-icon">
                                <PlusOutlined /> Tạo
                            </a-button>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a-table :dataSource="result.length > 0 ? result : news" :columns="columns" :scroll="{ x: 576 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <a>
                                {{ index + 1 }}
                            </a>
                        </template>
                        <template v-if="column.key === 'image'">
                            <img :src="record.image" alt="Ảnh bìa tin tức" class="avatar" />
                        </template>
                        <template v-if="column.key === 'action'">
                            <div class="d-flex justify-content-center">
                                <router-link :to="{ name: 'admin-news-edit', params: { id: record.id } }">
                                    <a-button type="primary" class="center-icon">
                                        <FormOutlined />
                                    </a-button>
                                </router-link>
                                <a-button type="primary" danger @click="() => showModal(record.title, record.id)"
                                    class="center-icon">
                                    <CloseSquareOutlined />
                                </a-button>
                            </div>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
    </a-card>
</template>
<script>
import { defineComponent, ref, createVNode } from 'vue';
import { menu} from '../../../stores/menu';
import { Modal, message } from 'ant-design-vue';
import { ExclamationCircleOutlined, PlusOutlined, FormOutlined, CloseSquareOutlined } from '@ant-design/icons-vue';
import axios from 'axios';
export default defineComponent({
    components: {
        PlusOutlined,
        FormOutlined,
        CloseSquareOutlined,
        ExclamationCircleOutlined,
    },
    setup() {
        const store = menu();
        store.onSlectedKeys(['admin-news']);
        const news = ref([]);
        const query = ref('');
        const result = ref([]);
        const columns = [
            {
                title: 'STT',
                dataIndex: '',
                key: 'index',
                className: 'text-center',
            },
            {
                title: 'Hình ảnh',
                dataIndex: 'image',
                key: 'image',
                className: 'text-center',
            },
            {
                title: 'Tiêu đề',
                dataIndex: 'title',
                key: 'title',
                className: 'text-center',
            },
            {
                title: 'Lượt xem',
                dataIndex: 'view',
                key: 'view',
                className: 'text-center',
            },
            {
                title: 'Ngày đăng',
                dataIndex: 'created_at',
                key: 'created_at',
                className: 'text-center',
            },
            {
                title: 'Danh mục',
                dataIndex: 'category_name',
                key: 'category_name',
                className: 'text-center',
            },
            {
                title: 'Thao tác',
                dataIndex: '',
                key: 'action',
                className: 'text-center',
            }

        ];
        const getNews = () => {
            axios.get('http://localhost:8000/api/news')
                .then(function (response) {
                    news.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        }
        getNews();
        const onSearch = () => {
            if (query.value === '') {
                result.value = [];
                getNews();
                return message.error('Vui lòng nhập từ khóa tìm kiếm!');
            }
            axios.get(`http://localhost:8000/api/news/search/${query.value}`)
                .then(function (response) {
                    result.value = response.data;
                    if (result.value.length === 0)
                        message.error('Không tìm thấy kết quả!');
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        };
        const showModal = (title, id) => {
            Modal.confirm({
                title: 'Bạn có chắc là muốn xóa tài khoản?',
                icon: createVNode(ExclamationCircleOutlined),
                content: createVNode('div', {}, [
                    'Bài viết ',
                    createVNode('span', { style: 'color: red;' }, `${title}`),
                    ' sẽ bị xóa vĩnh viễn'
                ]),
                okText: 'Có',
                okType: 'danger',
                cancelText: 'Không',
                onOk() {
                    deleteNews(id);
                },
            });
        };
        const deleteNews = (id) => {
            axios.delete(`http://localhost:8000/api/news/${id}`)
                .then(function (response) {
                    if (response.status == 200)
                        news.value = news.value.filter(news => news.id !== id);
                    message.success('Xóa thành công!');
                })
                .catch(function () {
                    message.error('Xóa thất bại!');
                });
        }
        return {
            columns,
            news,
            query,
            result,
            onSearch,
            showModal,
            deleteNews
        }
    }
});
</script>

