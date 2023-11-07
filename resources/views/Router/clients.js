const clients = [
    {
        path: "/",
        name: "clients",
        component: () => import("../Layout/clients.vue"),
        meta: {
            title: "Trang chủ",
        },
        children: [
            {
                path: "home",
                name: "clients-home",
                component: () => import("../Pages/clients/home/index.vue"),
                meta: {
                    title: 'Trang chủ',
                },
            },
            {
                path: "news/:slug",
                name: "clients-news",
                component: () => import("../Pages/clients/news/index.vue"),
                meta: {
                    title: 'Tin tức',
                },
            },
            {
                path: "news/detail/:id",
                name: "clients-news-detail",
                component: () => import("../Pages/clients/news/detail.vue"),
                meta: {
                    title: 'Tin tức',
                },
            },
            {
                path: "profile",
                name: "clients-profile",
                component: () => import("../Pages/clients/auth/profile.vue"),
                meta: {
                    title: "Hồ sơ cá nhân",
                    authencation:true
                },
            },
            {
                path: "login",
                name: "clients-login",
                component: () => import("../Pages/clients/auth/login.vue"),
                meta: {
                    title: "Đăng nhập",
                },
            },
            {
                path: "forget-password",
                name: "clients-forget-password",
                component: () => import("../Pages/clients/auth/forgetPassword.vue"),
                meta: {
                    title: "Quên mật khẩu",
                },
            },
            {
                path: "sign-up",
                name: "clients-sign-up",
                component: () => import("../Pages/clients/auth/register.vue"),
                meta: {
                    title: "Đăng ký",
                },
            },
        ],
    },
    {
        path: "/:catchAll(.*)",
        name: "404",
        component: () => import("../Pages/404.vue"),
        meta: {
            title: "404",
        },
    },

];
export default clients;
