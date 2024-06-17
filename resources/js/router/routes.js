import Main from '@/layouts/Main.vue';

export default [
    {
        path: '/app',
        redirect: '/auth/login'
    },
    {
        path: '/',
        component: Main,
        children: [
            {
                path: '',
                name: 'Feed',
                component: () => import('@/views/Feed.vue')
            },
            {
                path: 'search',
                name: 'Search',
                component: () => import('@/views/Feed.vue')
            },
            {
                path: '@:username',
                component: () => import('@/views/UserProfile.vue')
            },
            {
                path: 'posts/:id',
                component: () => import('@/views/UserPost.vue')
            },
            {
                path: 'settings/profile',
                component: () => import('@/views/UserProfileEdit.vue')
            }
        ],
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/auth',
        component: () => import('@/layouts/Authenticate.vue'),
        children: [
            {
                path: 'login',
                component: () => import('@/components/forms/Login.vue')
            },
            {
                path: 'register',
                component: () => import('@/components/forms/Register.vue')
            },
            {
                path: ':any(.*)',
                redirect: '/auth/login'
            }, 
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/views/NotFound.vue'),
    }
];