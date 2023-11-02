const admin = [
    {
        path: "/admin",
        component: () => import("../Layout/admin.vue"),
        meta: {
            requiresAuth: true,
        },
        // // Quản lý user
        children: [
            {
                path: "users",
                name: "admin-users",
                component: () => import("../Pages/admin/user/index.vue"),
                meta: {
                    title: "Quản lý user",
                },
            },
            {
                path: "users/create",
                name: "admin-users-create",
                component: () => import("../Pages/admin/user/create.vue"),
                meta: {
                    title: "Quản lý user",
                },
            },
            {
                path: "users/:id/edit",
                name: "admin-users-edit",
                component: () => import("../Pages/admin/user/edit.vue"),
                meta: {
                    title: "Quản lý user",
                },
            },
            // Quản lý category
            {
                path: "category",
                name: "admin-category",
                component: () => import("../Pages/admin/category/index.vue"),
                meta: {
                    title: "Quản lý danh mục",
                },
            },
            // Quản lý news
            {
                path: "news",
                name: "admin-news",
                component: () => import("../Pages/admin/news/index.vue"),
                meta: {
                    title: "Quản lý tin tức",
                },
            },
            {
                path: "news/create",
                name: "admin-news-create",
                component: () => import("../Pages/admin/news/create.vue"),
                meta: {
                    title: "Quản lý tin tức",
                },
            },
            {
                path: "news/:id/edit",
                name: "admin-news-edit",
                component: () => import("../Pages/admin/news/edit.vue"),
                meta: {
                    title: "Quản lý tin tức",
                },
            },
            // Quản lý comment
            {
                path: "comment",
                name: "admin-comment",
                component: () => import("../Pages/admin/comment/index.vue"),
                meta: {
                    title: "Quản lý bình luận",
                },
            },
            // Proflie
            {
                path: "profile",
                name: "admin-profile",
                component: () => import("../Pages/admin/auth/profile.vue"),
                meta: {
                    title: "Hồ sơ cá nhân",
                },
            },
        ],
    },
    {
        path: "/login",
        name: "admin-login",
        component: () => import("../Pages/admin/auth/login.vue"),
        meta: {
            title: "Đăng nhập",
        },
    },
    {
        path: "/:catchAll(.*)",
        component: () => import("../Pages/404.vue"),
    },
];
export default admin;
