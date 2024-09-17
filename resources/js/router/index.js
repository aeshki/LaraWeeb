import { createRouter, createWebHistory } from 'vue-router';

import routes from './routes';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: 'active',
    linkExactActiveClass: 'exact-active',
    routes
});

import { useAuthStore } from '@/stores/auth';

router.beforeEach(async (to) => {
    const authStore = useAuthStore();
    const isAuthenticate = await authStore.isAuthenticate();

    if ((to.path === '/auth/login' || to.path === '/auth/register' || to.path === '/app') && isAuthenticate) return '/'
    else if (to.matched.some((record) => record.meta.requiresAuth) && !isAuthenticate) return '/auth/login'
});

export default router;