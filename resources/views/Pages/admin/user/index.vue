<template>
    <a-card title="Tài khoản" style="width: 100%;">
        <div class="row ">
            <div class="col-12 mb-3 d-flex">
                <div class="row">
                    <div class="col-8">
                        <a-input-search class="center-icon" allowClear v-model:value="query" placeholder="Tìm kiếm"
                            enter-button @search="onSearch" />
                    </div>
                    <div class="col-4">
                        <router-link :to="{ name: 'admin-users-create' }">
                            <a-button type="primary" class="center-icon">
                                <PlusOutlined /> Tạo
                            </a-button>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a-table :dataSource="result.length > 0 ? result : users" :columns="columns" :scroll="{ x: 576 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <a>
                                {{ index + 1 }}
                            </a>
                        </template>
                        <template v-if="column.key === 'avatar'">
                            <img :src="record.avatar" alt="Ảnh người dùng" class="avatar" />
                        </template>
                        <template v-if="column.key === 'action'">
                            <div class="d-flex justify-content-center">
                                <router-link :to="{ name: 'admin-users-edit', params: { id: record.id } }">
                                    <a-button type="primary" class="center-icon">
                                        <FormOutlined />
                                    </a-button>
                                </router-link>
                                <a-button type="primary" danger @click="() => showModal(record.user_name)"
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
import { menu } from '../../../stores/menu';
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
        store.onSlectedKeys(['admin-users']);
        const users = ref([]);
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
                title: 'Hình đại diện',
                dataIndex: 'avatar',
                key: 'avatar',
                className: 'text-center',
            },
            {
                title: 'Tài Khoản',
                dataIndex: 'user_name',
                key: 'user_name',
                className: 'text-center',
            },
            {
                title: 'Họ Tên',
                dataIndex: 'name',
                key: 'name',
                className: 'text-center',
            },
            {
                title: 'Email',
                dataIndex: 'email',
                key: 'email',
                className: 'text-center',
            },
            {
                title: 'Vai trò',
                dataIndex: 'role',
                key: 'role',
                className: 'text-center',
            },
            {
                title: 'Thao tác',
                dataIndex: '',
                key: 'action',
                className: 'text-center',
            }

        ];
        const getUsers = () => {
            axios.get('http://localhost:8000/api/users')
                .then(function (response) {
                    users.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        }
        getUsers();
        const onSearch = () => {
            if (query.value === '') {
                result.value = [];
                getUsers();
                return message.error('Vui lòng nhập từ khóa tìm kiếm!');
            }
            axios.get(`http://localhost:8000/api/users/search/${query.value}`)
                .then(function (response) {
                    result.value = response.data;
                    if (result.value.length === 0)
                        message.error('Không tìm thấy kết quả!');
                })
                .catch(function () {
                   message.error('Lỗi hệ thống!');
                })
        };
        const showModal = (user_name) => {
            Modal.confirm({
                title: 'Bạn có chắc là muốn xóa tài khoản?',
                icon: createVNode(ExclamationCircleOutlined),
                content: createVNode('div', {}, [
                    'Tài khoản ',
                    createVNode('span', { style: 'color: red;' }, `${user_name}`),
                    ' sẽ bị xóa vĩnh viễn'
                ]),
                okText: 'Có',
                okType: 'danger',
                cancelText: 'Không',
                onOk() {
                    deleteUser(user_name);
                },
            });
        };
        const deleteUser = (user_name) => {
            axios.delete(`http://localhost:8000/api/users/${user_name}`)
                .then(function (response) {
                    if (response.status == 200)
                        users.value = users.value.filter(user => user.user_name !== user_name);
                    message.success('Xóa thành công!');
                })
                .catch(function () {
                    message.error('Xóa thất bại!');
                });
        }
        return {
            columns,
            users,
            query,
            result,
            onSearch,
            showModal,
            deleteUser
        }
    }
});
</script>

