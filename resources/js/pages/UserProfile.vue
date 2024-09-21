<script setup>
import { ref, computed, shallowRef } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';

import HeaderNav from '@/components/layout/HeaderNavbar.vue';

import {
  UserAvatar,
  UserBanner,
  UserBadges,
  UserPosts,
  UserLikes
} from '@/components/User'

import { CalendarDays, Smartphone, Book, Tv } from 'lucide-vue-next';
import RoundedButton from '@/components/common/buttons/RoundedButton.vue';
import SkeletonLoader from '@/components/SkeletonLoader.vue';

const route = useRoute();
const authStore = useAuthStore();

const user = ref({});
const current_tab = shallowRef(UserPosts);

const { error, loading, onFulfilled } = useAxios(() => `/api/users/${route.params.username}`)

onFulfilled((res) => user.value = res.value.user);

const canEditProfile = computed(() => {
  return loading.value ? true : (user.value.username === authStore.user.username);
});
</script>

<template>
  <main>
    <HeaderNav title='Compte' class='sticky top-0 backdrop-blur-lg bg-zinc-900/80' />  
    <!-- AVATAR | BANNER -->
    <div class='sm:border sm:border-t-0 sm:broder-zinc-700'>
      <div class='relative mb-11 sm:mb-16'>
        <UserBanner
          :color='user.banner_color'
          :skeleton='loading'
          class='relative'
        />
        
        <UserAvatar
          :username='user.username'
          :skeleton='loading'
          class='absolute -bottom-9 left-8 w-20 h-20'
        />
        
        <RoundedButton
          v-if='!loading && canEditProfile'
          class='absolute right-4 mt-3'
          to='/settings'
          text='Éditer le profil'
        />
      </div>
    </div>
    <!-- CONTENT -->
    <div class='flex flex-col px-4 py-2 gap-4 border-b border-b-zinc-700'>
      <!-- PSEUDO | USERNAME | BADGES | BIO -->
      <div class='flex flex-col'>
        <template v-if='loading'>
          <SkeletonLoader class='relative w-32 h-4' />
          <SkeletonLoader class='relative w-28 h-3 mt-2' />
        </template> 
        <template v-else>
          <span class='font-bold text-xl'>{{ user.pseudo ?? user.username }}</span>
          <span class='text-zinc-400 w-fit text-sm'>@{{ user.username }}</span>
          <p class='mt-2'>{{ user.bio }}</p>
          <UserBadges
            v-if='user.flags'
            :flags='user.flags'
          />
        </template>
      </div>
      <!-- INFO -->
      <div class='flex flex-col gap-2 *:flex *:gap-1.5 *:items-center *:text-neutral-400 *:text-sm'>
        <template v-if='!loading'>
          <div>
            <CalendarDays size='20'/>
            <span>A rejoint <strong>LaraWeeb</strong> en
              {{new Date(user.created_at).toLocaleDateString('default', {
                  month: 'long',
                  year: 'numeric'
              })}}
            </span>
          </div>
          <div v-if='user.favorite_anime'>
            <Tv size='20'/>
            <span>Anime préféré <strong>{{ user.favorite_anime }}</strong></span>
          </div>
          <div v-if='user.favorite_manga'>
            <Book size='20'/>
            <span>Manga préféré <strong>{{ user.favorite_manga }}</strong></span>
          </div>
          <div v-if='user.favorite_webtoon'>
            <Smartphone size='20'/>
            <span>Webtoon préféré <strong>{{ user.favorite_webtoon }}</strong></span>
          </div>
        </template>
      </div>
      <!-- STATS -->
      <div class='mt-1'>
        <p v-if='!loading'>
          <span class='text-neutral-200 font-bold text-base'>{{ user.total_likes }}</span> Likes
        </p>
      </div>
    </div>
    <!-- TABS -->
    <template v-if='!loading && !user.is_private || canEditProfile'>
      <div class='flex *:w-full *:text-center *:py-3 *:border-b *:text-neutral-400 has-[:checked]:*:text-neutral-100 has-[:checked]:*:border-b-white *:border-b-zinc-700'>
        <label>
          <input
            type='radio'
            id='posts'
            name='tab'
            v-model='current_tab'
            :value='UserPosts'
            class='hidden'
          />
          Posts
        </label>

        <label>
          <input
            type='radio'
            id='likes'
            name='tab'
            v-model='current_tab'
            :value='UserLikes'
            class='hidden'
          />
          Likes
        </label>
      </div>

      <KeepAlive class='p-4 h-full'>
        <component :is='current_tab' />
      </KeepAlive>
    </template>
    <template v-else>
      <p>Ce profil est privé</p>
    </template>
  </main>
</template>