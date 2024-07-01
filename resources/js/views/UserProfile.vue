<script setup>
// BUILT-IN
import axios from 'axios';
import { ref, watch, computed } from 'vue';
import { useRoute } from 'vue-router';

// COMPONENTS

import BackNavigationBar from '@/components/BackNavigationBar.vue';
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import Post from '@/components/PostCard.vue';

import { UserAvatar } from '@/components/user';
import { RoundedButton } from '@/components/common';
import {
  Tv,
  Book,
  Smartphone,
  CalendarDays
} from 'lucide-vue-next';

// STORE
import { useAuthStore } from '@/stores/auth';

// VAR
const route = useRoute();
const authStore = useAuthStore();
const user = ref({});
const posts = ref([]);

// TEMP
const code = ref(null);
const isLoading = ref(true);

const isMyProfil = computed(() => {
  return !isLoading.value ? (user.value.username === authStore.user.username) : true;
});

// LOGIC
watch(() => route.params.username, (username) => {
  isLoading.value = true;

  axios.get(`/api/users/${username}`)
    .then((res) => {
      user.value = res.data.user;
      posts.value = res.data.user.posts.reverse();
      code.value = res.status;
    })
    .catch((err) => code.value = err.response.status)
    .finally(() => isLoading.value = false);
}, { immediate: true });

const removePost = (postId) => {
  posts.value = posts.value.filter((post) => post.id !== postId);
}
</script>

<template>
  <main>
    <BackNavigationBar
      v-if='!isMyProfil'
      :title='user.pseudo ?? user.username'
    />
    <div class='flex justify-between border-b border-neutral-600 p-4'>
      <div class='flex flex-col gap-4 w-full'>
        <div class='flex justify-between'>
          <div class='flex gap-4 items-end'>
            <UserAvatar
              :isLoading='isLoading'
            />

            <div class='flex flex-col h-full justify-center'>
              <template v-if='isLoading'>
                <SkeletonLoader class='w-32 h-4' />
                <SkeletonLoader class='w-24 h-3 mt-2' />
              </template>
              <template v-else>
                <p class='text-white font-semibold text-lg'>{{ user.pseudo ?? user.username }}</p>
                <p class='text-neutral-400 text-xs'>@{{ user.username }}</p>
              </template>

              <!-- <p v-else class='text-white font-semibold text-lg justify-self-center'>Utilisateur introuvable</p> -->
            </div>
          </div>

          <RoundedButton
            v-if='isMyProfil'
            to='/settings/profile'
            text='Edit profil'
          />
        </div>

        <p v-if='user.bio'>{{ user.bio }}</p>

        <template v-if='isLoading'>
          <SkeletonLoader class='w-48 h-3' />
          <SkeletonLoader class='w-32 h-4 mt-3' />
        </template>
        <template v-else >
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
            <p>{{ posts.length }} <span class='text-neutral-400'>publications</span></p>
          </div>
        </template>
      </div>
    </div>

    <ul v-if='posts.length > 0' class='flex flex-col gap-4 p-4 sm:items-center' >
      <Post v-for='post of posts'
            :key='post.id'
            :id='post.id'
            :username='user.username'
            :message='post.message'
            :createdAt='post.created_at'
            :displayUserInfo='false'
            :isLoading='isLoading'
            :withAvatar='false'
            :canEdit='isMyProfil'
            :canDelete='isMyProfil'
            @destroy="(postId) => removePost(postId)"
      />
    </ul>
    <p v-else-if='!isLoading' class='text-white w-full text-center p-4'>No publications :(</p>
  </main>
</template>