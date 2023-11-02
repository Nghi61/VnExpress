<template>
    <a-card title="Bình luận" style="width: 100%;">
        <div class="row ">
            <div class="col-sm-4 col-12 mb-3 d-flex justify-content-sm-start">
                <a-input-search class="center-icon" allowClear v-model:value="query" placeholder="Tìm kiếm" enter-button
                    @search="onSearch" />
            </div>
            <div class="col-12">
                <a-table :dataSource="result.length > 0 ? result : comment" :columns="columns" :scroll="{ x: 576 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <a>
                                {{ index + 1 }}
                            </a>
                        </template>
                        <template v-if="column.key === 'action'">
                            <div class="d-flex justify-content-center">
                                <a-button type="primary" danger @click="() => deleteModal(record.content,record.id)" class="center-icon">
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
import { defineComponent, ref, createVNode} from 'vue';
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
        store.onSlectedKeys(['admin-comment']);
        const comment = ref([]);
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
                title: 'Nội dung',
                dataIndex: 'content',
                key: 'content',
                className: 'text-center',
            },
            {
                title: 'Bài viết',
                dataIndex: 'title',
                key: 'news_id',
                className: 'text-center',
            },
            {
                title: 'Người đăng',
                dataIndex: 'user_name',
                key: 'user_id',
                className: 'text-center',
            },
            {
                title: 'Ngày đăng',
                dataIndex: 'created_at',
                key: 'created_at',
                className: 'text-center',
            },
            {
                title: 'Thao tác',
                dataIndex: '',
                key: 'action',
                className: 'text-center',
            }
        ];
        const onSearch = () => {
            if (query.value === '') {
                result.value = [];
                getComment();
                return message.error('Vui lòng nhập từ khóa tìm kiếm!');
            }
            axios.get(`http://localhost:8000/api/comment/search/${query.value}`)
                .then(function (response) {
                    result.value = response.data;
                    if (result.value.length === 0)
                        message.error('Không tìm thấy kết quả!');
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        };
        const getComment = () => {
            axios.get('http://localhost:8000/api/comment')
                .then(function (response) {
                    comment.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        }
        getComment();
        const deleteModal = (content, id) => {
            console.log(name);
            Modal.confirm({
                title: 'Bạn có chắc là muốn xóa bình luận?',
                icon: createVNode(ExclamationCircleOutlined),
                content: createVNode('div', {}, [
                    'Bình luận ',
                    createVNode('span', { style: 'color: red;' }, `${content}`),
                    ' sẽ bị xóa vĩnh viễn'
                ]),
                okText: 'Có',
                okType: 'danger',
                cancelText: 'Không',
                onOk() {
                    deleteCategory(id);
                },
            });
        };
        const deleteCategory = (id) => {
            axios.delete(`http://localhost:8000/api/comment/${id}`)
                .then(function (response) {
                    if (response.status == 200)
                    comment.value = comment.value.filter(comment => comment.id !== id);
                    message.success('Xóa thành công!');
                })
                .catch(function () {
                    message.error('Xóa thất bại!');
                });
        }
        return {
            columns,
            comment,
            query,
            result,
            onSearch,
            deleteModal,
            deleteCategory,
        }
    }
});
</script>

