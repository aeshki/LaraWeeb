<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';

import BackNavigationBar from '@/components/BackNavigationBar.vue';
import { CalendarDays, Smartphone, Book, Tv } from 'lucide-vue-next';
import { UserBadges, UserPosts, UserLikes } from '@/components/user';
import { RoundedButton } from '@/components/common';
import SkeletonLoader from '@/components/SkeletonLoader.vue';

const route = useRoute();
const authStore = useAuthStore();

const user = ref({});
const current_tab = ref(UserPosts);

const { error, loading, onFulfilled } = useAxios(() => `/api/users/${route.params.username}`)

onFulfilled((res) => user.value = res.value.user);

const canEditProfile = computed(() => {
  return loading.value ? true : (user.value.username === authStore.user.username);
});
</script>

<template>
  <main>
    <BackNavigationBar v-if='!canEditProfile' title='Compte' />
    <div class='sm:border sm:border-t-0 sm:border-zinc-700'>
      <!-- AVATAR | BANNER -->
      <div class='relative mb-11 sm:mb-16'>
        <template v-if='loading'>
          <SkeletonLoader class='aspect-3/1 border-b-2 border-zinc-900 sm:border-zinc-700' />
          <div class="absolute -bottom-9 left-8 sm:-bottom-16 sm:left-16 aspect-square w-full sm:max-w-32 max-w-20">
            <SkeletonLoader
              type='circle'
              class='w-full h-full border-b border-zinc-900 sm:border-zinc-700'
            />
          </div>
        </template>
        <template v-else>
          <div
            class='aspect-3/1 border-b border-zinc-900 sm:border-zinc-700'
            :style='{ backgroundColor: `#${user.banner_color}`, backgroundImage: `url(/storage/banners/${user.banner})`, backgroundSize: "cover" }'
          ></div>
          <div
            class='sm:max-w-36 sm:-bottom-16 border-2 border-zinc-900 absolute -bottom-11 left-8 aspect-square w-full max-w-24 rounded-full sm:border-zinc-700'
            :style='{ background: `url(${ user.avatar ? `/storage/avatars/${user.avatar}` : `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${user.username}`})`, backgroundSize: "cover" }'
          ></div>
        </template>
        <RoundedButton
            v-if='!loading && canEditProfile'
            class='absolute right-4 mt-3'
            to='/settings/profile'
            text='Éditer le profil'
          />
      </div>
      <!-- CONTENT -->
      <div class='flex flex-col px-4 py-2 gap-4 border-b border-b-zinc-700'>
        <!-- PSEUDO | USERNAME | BADGES | BIO -->
        <div class='flex flex-col'>
          <template v-if='loading'>
            <SkeletonLoader class='w-32 h-4' />
            <SkeletonLoader class='w-28 h-3 mt-2' />
          </template> 
          <template v-else>
            <span class='font-bold text-xl'>{{ user.pseudo ?? user.username }}</span>
            <span class='text-zinc-400 w-fit text-sm'>@{{ user.username }}</span>
          </template>
          <UserBadges
            v-if='user.flags'
            :bitwise='user.flags'
          />
          <p class='mt-2'>{{ user.bio }}</p>
        </div>
        <!-- INFO -->
        <div class='flex flex-col gap-2 *:flex *:gap-1.5 *:items-center *:text-neutral-400 *:text-sm'>
          <template v-if='loading'>
            <SkeletonLoader class='w-64 h-4' />
          </template>
          <template v-else>
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
            <!-- STATS -->
            <div class='mt-1'>
              <p v-if='!user.is_private'>
                <span class='text-neutral-200 font-bold text-base'>{{ user.total_likes }}</span> Likes
              </p>
            </div>
          </template>
        </div>
      </div>
      <!-- TABS -->
      <div
        class='flex *:w-full *:text-center *:py-3 *:border-b *:text-neutral-400 has-[:checked]:*:text-neutral-100 has-[:checked]:*:border-b-white *:border-b-zinc-700'
      >
        <label>
          <input
            type='radio'
            id='posts'
            name='tab'
            v-model='current_tab'
            :value='UserPosts'
            class='hidden'
          />Posts
        </label>

        <label>
          <input
            type='radio'
            id='likes'
            name='tab'
            v-model='current_tab'
            :value='UserLikes'
            class='hidden'
          />Likes
        </label>
      </div>
      <KeepAlive class='p-4 h-full'>
        <component :is='current_tab' />
      </KeepAlive>
    </div>
  </main>
</template>