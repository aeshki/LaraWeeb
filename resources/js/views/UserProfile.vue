<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';

import BackNavigationBar from '@/components/BackNavigationBar.vue';
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import Post from '@/components/PostCard.vue';
import useAxios from '@/utils/useAxios';

import { UserAvatar } from '@/components/user';
import { RoundedButton } from '@/components/common';
import { Tv, Book, Smartphone, CalendarDays } from 'lucide-vue-next';

import { useAuthStore } from '@/stores/auth';

const route = useRoute();
const authStore = useAuthStore();
const posts = ref([]);
const user = ref({});

const { error, loading, onFulfilled } = useAxios(() => `/api/users/${route.params.username}`);

onFulfilled((data) => {
  user.value = data.value.user;
  posts.value = user.value.posts.reverse();
});

const removePost = (postId) => {
  posts.value = posts.value.filter((post) => post.id !== postId);
}

const isMyProfil = computed(() => {
  return !loading.value ? (user.value.username === authStore.user.username) : true;
});
</script>

<template>
  <main>
    <BackNavigationBar v-if='!isMyProfil' title='Compte' />
    <div class='flex justify-between border-b border-neutral-600 p-4'>
      <div class='flex flex-col gap-4 w-full'>
        <div class='flex justify-between'>
          <div class='flex gap-4 w-full'>
            <UserAvatar
              :path='user?.avatar'
              :username='user?.username'
              :isLoading='loading'
            />

            <div class='flex flex-col h-full justify-center'>
              <template v-if='loading'>
                <SkeletonLoader class='w-32 h-4' />
                <SkeletonLoader class='w-24 h-3 mt-2' />
              </template>

              <p v-else-if='error' class='text-white font-semibold text-lg justify-self-center'>Utilisateur introuvable :/</p>
              
              <template v-else>
                <p class='text-white font-semibold text-lg'>{{ user.pseudo ?? user.username }}</p>
                <p class='text-neutral-400 text-xs'>@{{ user.username }}</p>
              </template>

            </div>
          </div>

          <RoundedButton
            v-if='isMyProfil'
            to='/settings/profile'
            text='Edit profil'
          />
        </div>

        <p v-if='user.bio'>{{ user.bio }}</p>

        <template v-if='loading'>
          <SkeletonLoader class='w-48 h-3' />
          <SkeletonLoader class='w-32 h-4 mt-3' />
        </template>
        <template v-else-if='!error' >
          <div class='flex gap-1 items-center text-neutral-400'>
            <CalendarDays class='w-5 h-5' />

            <p class='text-sm'>A rejoint LaraWeeb en
              {{
                  new Date(user.created_at).toLocaleDateString('default', {
                    month: 'long',
                    year: 'numeric'
                  })
              }}
            </p>
          </div>

          <div v-if='user.favorite_anime'
               class='flex gap-1 text-neutral-400'>
            <Tv class='h-5 w-5' />
            <p>Favorite anime <b>{{ user.favorite_anime }}</b></p>
          </div>

          <div v-if='user.favorite_manga'
               class='flex gap-1 text-neutral-400'>
            <Book class='h-5 w-5' />
            <p>Favorite manga <b>{{ user.favorite_manga }}</b></p>
          </div>

          <div v-if='user.favorite_webtoon'
               class='flex gap-1 text-neutral-400'>
            <Smartphone class='h-5 w-5' />
            <p>Favorite webtoon <b>{{ user.favorite_webtoon }}</b></p>
          </div>

          <div>
            <p>{{ posts.length }} <span class='text-neutral-400'>Publications</span></p>
          </div>
        </template>
      </div>
    </div>

    <ul v-if='posts.length > 0' class='flex flex-col gap-4 p-4 sm:items-center' >
      <Post v-for='post of posts'
            :key='post.id'
            :id='post.id'
            :image='post.image'
            :avatar='user?.avatar'
            :username='user.username'
            :message='post.message'
            :createdAt='post.created_at'
            :displayUserInfo='false'
            :isLoading='loading'
            :withAvatar='false'
            :canEdit='isMyProfil'
            :canDelete='isMyProfil'
            @destroy="(postId) => removePost(postId)"
      />
    </ul>
    <p v-else-if='!loading && !error' class='text-white w-full text-center p-4'>Aucune publications :(</p>
  </main>
</template>