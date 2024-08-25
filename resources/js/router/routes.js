export default [
    {
        path: '/app',
        redirect: '/auth/login'
    },
    {
        path: '/',
        component: () => import('@/layouts/MainLayout.vue'),
        children: [
            {
                path: '',
                name: 'Feed',
                component: () => import('@/views/Feed.vue')
            },
            {
                path: 'search',
                component: () => import('@/views/Search.vue')
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
                component: () => import('@/views/UserSettings.vue')
            }
        ],
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/auth',
        component: () => import('@/layouts/AuthenticateLayout.vue'),
        children: [
            {
                path: 'login',
                component: () => import('@/components/forms/authenticate/LoginForm.vue')
            },
            {
                path: 'register',
                component: () => import('@/components/forms/authenticate/RegisterForm.vue')
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