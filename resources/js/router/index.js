import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: () => import('@/views/Feed.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/Login.vue')
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('@/views/Register.vue')
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/views/NotFound.vue'),
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: 'active',
    routes
});

import { useAuthStore } from '@/stores/auth';

router.beforeEach(async (to) => {
    const authStore = useAuthStore();
    const isAuthenticate = await authStore.isAuthenticate();

    if ((to.path === '/login' || to.path === '/register') && isAuthenticate) return '/'
    else if (to.matched.some((record) => record.meta.requiresAuth) && !isAuthenticate) return '/login'
});

export default router;