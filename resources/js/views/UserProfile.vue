<script setup>
// BUILT-IN
import axios from 'axios';
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';

// COMPONENTS
import SkeletonUserProfile from '@/views/SkeletonUserProfile.vue';
import Post from '@/components/Post.vue';
import RoundedButton from '@/components/inputs/RoundedButton.vue';
import { CalendarDays } from 'lucide-vue-next';

// STORE
import { useAuthStore } from '@/stores/auth';

// VAR
const route = useRoute();
const authStore = useAuthStore();
const user = ref({});

// TEMP
const code = ref(null);
const isLoading = ref(true);

// LOGIC
watch(() => route.params.username, (username) => {
  isLoading.value = true;

  axios.get(`/api/users/${username}`)
    .then((res) => {
      user.value = res.data.user
      code.value = res.status;
    })
    .catch((err) => code.value = err.response.status)
    .finally(() => isLoading.value = false);
}, { immediate: true });

</script>

<template>
  <SkeletonUserProfile v-if='isLoading' />
  <div v-else class='h-full overflow-y-scroll bg-zinc-900 text-slate-50 sm:w-full'>
    <div class='flex justify-between bg-zinc-900 border-b border-neutral-600 p-4'>
      <div class='flex flex-col gap-4'>
        <div class='flex gap-4 items-end'>
          <img
            class='bg-white w-12 h-12 rounded-full'
          />
          <div class='flex flex-col h-full justify-center'>
            <template v-if='code !== 404'>
              <p class='text-white font-semibold text-lg'>{{ user.pseudo ?? user.username }}</p>
              <p class='text-neutral-400 text-xs'>@{{ user.username }}</p>
            </template>

            <p v-else class='text-white font-semibold text-lg justify-self-center'>Utilisateur introuvable</p>
          </div>

        </div>

        <template v-if='code !== 404'>
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

          <div>
            <p>{{ user.posts?.length }} <span class='text-neutral-400'>publications</span></p>
          </div>
        </template>
      </div>

      <RoundedButton
        v-if='user.username === authStore.user.username'
        to='/settings/profile'
        text='Edit profil'
      />
    </div>

    <ul
      v-if='user.posts?.length > 0'
      class='flex flex-col divide-y divide-neutral-600 border-b border-neutral-600'
    >
      <Post
          v-for='post of user.posts.reverse()'
          :key='post.id'
          :message='post.message'
          :createdAt='post.created_at'
      />
    </ul>

    <p
      v-else-if='code !== 404'
      class='text-white w-full text-center p-4'
    >Aucune publication :(</p>
  </div>
</template>