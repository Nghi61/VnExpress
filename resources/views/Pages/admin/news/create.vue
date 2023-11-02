<template>
    <form @submit.prevent="createNews()">
        <a-card title="Tạo mới tin tức" style="width: 100%;">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label ">Tiêu đề <span class="text-danger ">*</span></label>
                        <a-input v-model:value="title" type="text" placeholder="Tiêu đề" />
                        <div class="w-100"></div>
                        <small v-if="errors.title" class="text-danger">{{ errors.title[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug <span class="text-danger ">*</span></label>
                        <a-input v-model:value="slug" type="text" placeholder="Slug" />
                        <div class="w-100"></div>
                        <small v-if="errors.slug" class="text-danger">{{ errors.slug[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label ">Danh mục <span class="text-danger ">*</span></label>
                        <div class="w-100"></div>
                        <a-select ref="select" v-model:value="category" style="width: 100%" :options="options">
                        </a-select>
                        <div class="w-100"></div>
                        <small v-if="errors.category" class="text-danger">{{ errors.category[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh <span class="text-danger ">*</span></label>
                        <div class="w-100"></div>
                        <a-upload :before-upload="beforeUpload" name="file" v-model:file-list="fileList" :max-count="1"
                            action="http://localhost:8000/api/upload/news">
                            <a-button class="center-icon" style="width: 100%">
                                <UploadOutlined />
                                Upload
                            </a-button>
                        </a-upload>
                        <div class="w-100"></div>
                        <small v-if="errors.image" class="text-danger">{{ errors.image[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label ">Mô tả <span class="text-danger ">*</span></label>
                        <a-textarea style="height: 200px;" v-model:value="description" type="text"
                            placeholder="Tóm tắt" />
                        <div class="w-100"></div>
                        <small v-if="errors.description" class="text-danger">{{ errors.description[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung <span class="text-danger ">*</span></label>
                        <QuillEditor toolbar="full" theme="snow" content-type="text" v-model:content="content"
                            style="height: 500px;"></QuillEditor>
                        <div class="w-100"></div>
                        <small v-if="errors.content" class="text-danger">{{ errors.content[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-grid d-sm-flex justify-content-sm-end mx-auto">
                    <a-button class="me-0 mb-3 me-sm-2 mb-sm-0">
                        <router-link :to="{ name: 'admin-news' }">
                            <span>Hủy</span>
                        </router-link>
                    </a-button>
                    <a-button type="primary" htmlType="submit">
                        <span>Tạo</span>
                    </a-button>
                </div>
            </div>
        </a-card>
    </form>
</template>
<script>
import { defineComponent, reactive, ref, toRefs, watchEffect } from 'vue';
import { menu } from '../../../stores/menu';
import { InboxOutlined, UploadOutlined } from '@ant-design/icons-vue';
import { message, Upload } from 'ant-design-vue';
import { useRouter } from 'vue-router';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import axios from 'axios';
export default defineComponent({
    components: {
        InboxOutlined,
        UploadOutlined,
        QuillEditor
    },
    setup() {
        const fileList = ref([]);
        const store = menu();
        store.onSlectedKeys(['admin-news']);
        const errors = ref({});
        const router = useRouter();
        const news = reactive({
            user_id: "",
            title: "",
            slug: "",
            category: "",
            image: "",
            description: "",
            content: ""
        });
        const removeAccents=(str)=> {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        watchEffect(() => {
            const slugWithoutDiacritics = removeAccents(news.title).toLowerCase().replace(/ /g, '-');
            news.slug = slugWithoutDiacritics;
        });
        const options = ref([
            {
                value: '',
                label: 'Chọn danh mục',
            },
        ]);
        const getCategory = () => {
            axios.get('http://localhost:8000/api/category')
                .then((response) => {
                    if (response.status == 200) {
                        options.value = options.value.concat(response.data.map(item => ({
                            value: item.id,
                            label: item.name,
                        })));
                    }
                })
                .catch(() => {
                    message.error('Lỗi tải danh mục');
                });
        }
        getCategory();
        const beforeUpload = file => {
            const allowedFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/svg+xml']; // Thêm các định dạng tệp bạn muốn hỗ trợ
            if (!allowedFileTypes.includes(file.type)) {
                message.error(`${file.name} định dạng không hỗ trợ!`);
                return Upload.LIST_IGNORE;
            }
        };
        const createNews = () => {
            const user = JSON.parse(localStorage.getItem('user'));
            news.user_id = user.id;
            if (fileList.value.length > 0) {
                news.image = fileList.value[0].response.file_path;
            }
            axios.post('http://localhost:8000/api/news', news)
                .then((response) => {
                    if (response.status == 200) {
                        message.success("Thêm tin tức thành công! ");
                        router.push({ name: "admin-news" });
                    }
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        }
        return {
            ...toRefs(news),
            errors,
            fileList,
            options,
            beforeUpload,
            createNews
        }
    }
})
</script>
