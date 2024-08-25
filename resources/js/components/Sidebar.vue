<script setup>
import { UserAvatar } from '@/components/user';
import { Home, Search } from 'lucide-vue-next';

import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
</script>

<template>
  <aside class='bg-zinc-900 text-zinc-50 p-4 border-t border-neutral-600 sm sm:border-r sm:border-t-0'>
    <nav class='flex sm:flex-col gap-4 justify-around items-center sm:items-start sm:gap-4 *:h-fit'>
        <ul>
            <li>
                <RouterLink
                    class='rounded-full p-2 sm:px-4 sm:py-2 group flex gap-2 text-white [&.exact-active]:bg-neutral-500/70 transition-all duration-200'
                    to='/'
                >
                    <Home />
                    <p class='hidden tablette:block'>Accueil</p>
                </RouterLink>
            </li>
        </ul>
        <ul>
            <li>
                <RouterLink
                    class='rounded-full p-2 sm:px-4 sm:py-2 group flex gap-2 text-white [&.exact-active]:bg-neutral-500/70 transition-all duration-200'
                    to='/search'
                >
                    <Search />
                    <p class='hidden tablette:block'>Recherche</p>
                </RouterLink>
            </li>
        </ul>
        <ul>
            <li>
                <UserAvatar
                    class='w-9 h-9 sm:h-full sm:w-full'
                    :path='authStore.user?.avatar'
                    :username='authStore.user.username'
                    :to='`/@${authStore.user.username}`'
                />
            </li>
        </ul>
    </nav>
  </aside>
</template>