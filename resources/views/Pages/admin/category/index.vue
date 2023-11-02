<template>
    <a-card title="Danh mục" style="width: 100%;">
        <div class="row ">
            <div class="col-12 mb-3 d-flex">
                <div class="row">
                    <div class="col-8">
                        <a-input-search class="center-icon" allowClear v-model:value="query" placeholder="Tìm kiếm"
                            enter-button @search="onSearch" />
                    </div>
                    <div class="col-4">
                        <a-button type="primary" class="center-icon" @click="createModal">
                            <PlusOutlined /> Tạo
                        </a-button>
                        <a-modal okText="Lưu" cancelText="Hủy" v-model:open="openCreate" width="500px"
                            title="Tạo danh mục" @ok="createCategory()">
                            <a-input v-model:value="name" placeholder="Tên danh mục"
                                :class="{ 'text-danger': errors.name }" />
                            <div class="w-100"></div>
                            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                            <a-input class="mt-3" v-model:value="slug" placeholder="Slug "
                                :class="{ 'text-danger': errors.slug }" />
                            <div class="w-100"></div>
                            <small v-if="errors.slug" class="text-danger">{{ errors.slug[0] }}</small>
                        </a-modal>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a-table :dataSource="result.length > 0 ? result : category" :columns="columns" :scroll="{ x: 576 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <a>
                                {{ index + 1 }}
                            </a>
                        </template>
                        <template v-if="column.key === 'action' && record.name!=='Không xác định'">
                            <div class="d-flex justify-content-center">
                                <a-button type="primary" @click="editModal(record.id)" class="center-icon">
                                    <FormOutlined />
                                </a-button>
                                <a-modal okText="Lưu" cancelText="Hủy" v-model:open="openEdit" width="500px"
                                    title="Tạo danh mục" @ok="editCategory()">
                                    <a-input v-model:value="idCate" disabled />
                                    <div class="w-100"></div>
                                    <a-input class="mt-3" v-model:value="name" placeholder="Tên danh mục"
                                        :class="{ 'text-danger': errors.name }" />
                                    <div class="w-100"></div>
                                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                                    <a-input class="mt-3" v-model:value="slug" placeholder="Slug "
                                        :class="{ 'text-danger': errors.slug }" />
                                    <div class="w-100"></div>
                                    <small v-if="errors.slug" class="text-danger">{{ errors.slug[0] }}</small>
                                </a-modal>
                                <a-button type="primary" danger @click="() => deleteModal(record.name)" class="center-icon">
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
        store.onSlectedKeys(['admin-category']);
        const category = ref([]);
        const query = ref('');
        const result = ref([]);
        const openCreate = ref(false);
        const openEdit = ref(false);
        const idCate = ref('');
        const name = ref('');
        const slug = ref('');
        const errors = ref([]);
        const columns = [
            {
                title: 'STT',
                dataIndex: '',
                key: 'index',
                className: 'text-center',
            },
            {
                title: 'Tên danh mục',
                dataIndex: 'name',
                key: 'name',
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
                getCategory();
                return message.error('Vui lòng nhập từ khóa tìm kiếm!');
            }
            axios.get(`http://localhost:8000/api/category/search/${query.value}`)
                .then(function (response) {
                    result.value = response.data;
                    if (result.value.length === 0)
                        message.error('Không tìm thấy kết quả!');
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        };
        const getCategory = () => {
            axios.get('http://localhost:8000/api/category')
                .then(function (response) {
                    category.value = response.data;
                })
                .catch(function () {
                    message.error('Lỗi hệ thống!');
                })
        }
        getCategory();
        const createModal = () => {
            openCreate.value = true;
        }
        const createCategory = () => {
            const data = { name: name.value, slug: slug.value };
            axios.post(`http://localhost:8000/api/category`, data)
                .then(function (response) {
                    if (response.status == 200)
                        openCreate.value = false;
                    category.value.push(response.data.cate);
                    message.success('Thêm thành công!');
                })
                .catch(function (error) {
                    errors.value = error.response.data.errors;
                });
        }
        const editModal = (id) => {
            openEdit.value = true;
            axios.get(`http://localhost:8000/api/category/${id}`)
                .then(function (response) {
                    name.value = response.data.name;
                    slug.value = response.data.slug;
                    idCate.value = response.data.id;
                })
                .catch(function () {
                    message.error("Lỗi hệ thống!");
                })
        }
        const editCategory = () => {
            const data = { name: name.value, slug: slug.value, id: idCate.value };
            axios.put(`http://localhost:8000/api/category/${idCate.value}`, data)
                .then(function (response) {
                    if (response.status == 200)
                        openEdit.value = false;
                    category.value = category.value.map(category => category.id === idCate.value ? response.data : category);
                    message.success('Sửa thành công!');
                })
                .catch(function (error) {
                    errors.value = error.response.data.errors;
                });
        }
        const deleteModal = (name) => {
            Modal.confirm({
                title: 'Bạn có chắc là muốn xóa danh mục?',
                icon: createVNode(ExclamationCircleOutlined),
                content: createVNode('div', {}, [
                    'Danh mục ',
                    createVNode('span', { style: 'color: red;' }, `${name}`),
                    ' sẽ bị xóa vĩnh viễn'
                ]),
                okText: 'Có',
                okType: 'danger',
                cancelText: 'Không',
                onOk() {
                    deleteCategory(name);
                },
            });
        };
        const deleteCategory = (name) => {
            axios.delete(`http://localhost:8000/api/category/${name}`)
                .then(function (response) {
                    if (response.status == 200)
                        category.value = category.value.filter(category => category.name !== name);
                    message.success('Xóa thành công!');
                })
                .catch(function () {
                    message.error('Xóa thất bại!');
                });
        }
        return {
            columns,
            category,
            query,
            result,
            openCreate,
            openEdit,
            idCate,
            name,
            slug,
            errors,
            onSearch,
            createModal,
            editModal,
            deleteModal,
            createCategory,
            deleteCategory,
            editCategory
        }
    }
});
</script>

