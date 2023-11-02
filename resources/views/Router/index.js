import { createRouter, createWebHistory } from "vue-router";
import admin from './admin.js';
import clients from './clients.js';
function checkUserSession() {
    return !!localStorage.getItem('user');
}

const router = createRouter({
    history: createWebHistory(),
    routes: [...admin,...clients]
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth && !checkUserSession()) {
        next('/login');
    } else {
        document.title = `${to.meta.title || 'Default Title'}`;
        next();
    }
});

export default router;
