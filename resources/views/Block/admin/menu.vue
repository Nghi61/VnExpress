<template>
    <div>
        <a-menu v-model:openKeys="openKeys" v-model:selectedKeys="selectedKeys" mode="inline">
            <a-menu-item key="admin-users">
                <router-link :to="{ name: 'admin-users' }">

                    <span>
                        <UserOutlined class="me-2" />
                        Tài khoản
                    </span>

                </router-link>
            </a-menu-item>
            <a-menu-item key="admin-category">
                <router-link :to="{ name: 'admin-category' }">
                    <span>
                        <TagOutlined class="me-2" /> Danh mục
                    </span>
                </router-link>
            </a-menu-item>
            <a-menu-item key="admin-news">
                <router-link :to="{ name: 'admin-news' }">
                    <span>
                        <FileTextOutlined class="me-2" /> Tin tức
                    </span>
                </router-link>
            </a-menu-item>
            <a-menu-item key="admin-comment">
                <router-link :to="{ name: 'admin-comment' }">
                    <span>
                        <CommentOutlined class="me-2" /> Bình luận
                    </span>
                </router-link>
            </a-menu-item>
        </a-menu>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import { menu } from "../../stores/menu";
import { UserOutlined, TagOutlined, CommentOutlined, FileTextOutlined } from '@ant-design/icons-vue';
import { storeToRefs } from 'pinia';
export default defineComponent({
    components: {
        UserOutlined,
        TagOutlined,
        FileTextOutlined,
        CommentOutlined
    },
    setup() {
        const store = menu();
        return {
            ...storeToRefs(store)
        }
    }
});
</script>
