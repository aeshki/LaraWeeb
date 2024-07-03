<script setup>
import { UserAvatar } from '@/components/user';
import { Home, Search } from 'lucide-vue-next';

import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
</script>

<template>
  <aside class='bg-zinc-900 text-zinc-50 p-4 border-t border-neutral-600 sm sm:border-r sm:border-t-0'>
    <nav class='flex sm:flex-col gap-4 justify-around sm:gap-4 items-center'>
        <ul>
            <li>
                <RouterLink
                    class='rounded-full p-2 group flex gap-1 text-white [&.exact-active]:bg-neutral-500/70 transition-all duration-200'
                    to='/'
                >
                    <Home />
                </RouterLink>
            </li>
        </ul>
        <ul>
            <li>
                <RouterLink
                    class='rounded-full p-2 group flex gap-1 text-white [&.exact-active]:bg-neutral-500/70 transition-all duration-200'
                    to='/search'
                >
                    <Search />
                </RouterLink>
            </li>
        </ul>
        <ul>
            <li>
                <UserAvatar
                    class='h-7'
                    :path='authStore.user?.avatar'
                    :username='authStore.user.username'
                    :to='`/@${authStore.user.username}`'
                />
            </li>
        </ul>
    </nav>
  </aside>
</template>