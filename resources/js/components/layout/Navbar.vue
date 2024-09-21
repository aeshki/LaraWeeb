<script setup>
import UserAvatar from '@/components/User/Avatar.vue';
import NavButton from '@/components/common/buttons/NavButton.vue';
import { Home, Search } from 'lucide-vue-next';

import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

const navItems = [
    { title: 'Accueil', icon: Home, to: '/' },
    { title: 'Recherche', icon: Search, to: '/search' },
];
</script>

<template>
    <aside class='p-4 bg-zinc-900 text-zinc-50 border-t border-neutral-600 sm:border-r sm:border-t-0'>
        <nav class='flex sm:flex-col gap-4 justify-around items-center md:items-start'>
            <div v-for="item in navItems" :key="item.to" class='md:w-full'>
                <NavButton
                    :title="item.title"
                    :icon="item.icon"
                    :to="item.to"
                />
            </div>
            <div>
                <RouterLink
                    class='border-neutral-500/70 flex gap-2 items-center text-white md:rounded-xl rounded-full max-md:[&.exact-active]:border-4 [&.exact-active]:bg-neutral-500/70 transition-all duration-200 md:py-2 md:px-3'
                    :to='`/@${authStore.user.username}`'
                >
                    <UserAvatar
                        :path="authStore.user?.avatar"
                        :username="authStore.user.username"
                        :class='["w-8 h-8"]'
                    />
                    <span class='hidden md:block text-nowrap'>Mon profil</span>
                </RouterLink>
            </div>
        </nav>
    </aside>
</template>
