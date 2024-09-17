<script setup>
// import Post from '@/components/PostCard.vue';

// import { UserAvatar, Badges } from '@/components/user';
// import { RoundedButton } from '@/components/common';
// import { Tv, Book, Smartphone, CalendarDays, ShieldBan } from 'lucide-vue-next';

// import { useAuthStore } from '@/stores/auth';

// const route = useRoute();
// const authStore = useAuthStore();
// const posts = ref([]);
// const user = ref({});
// const isPrivate = ref(false);

// const { error, loading, onFulfilled } = useAxios(() => `/api/users/${route.params.username}`);

// onFulfilled((data) => {
//   user.value = data.value.user;
//   isPrivate.value = user.value.is_private && authStore.user.id !== user.value.id;

//   if (!isPrivate.value) {
//     posts.value = user.value.posts.reverse();
//   }
// });

// const removePost = (postId) => {
//   posts.value = posts.value.filter((post) => post.id !== postId);
// };

// const handleLike = () => {
//   user.value.total_likes++;

//   if (!user.value.is_private && user.value.total_likes > 9 && !getBadges(user.value.flags).includes('STAR')) {
//     user.value.flags += 1 << 2;
//   }
// };

// const handleUnlike = () => {
//   user.value.total_likes--;
//   if (!user.value.is_private && user.value.total_likes < 10 && getBadges(user.value.flags).includes('STAR')) {
//     user.value.flags -= 1 << 2;
//   }
// };

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
  <!-- <main>
    <div class=''>
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
                <Badges v-if='user.flags' :flags='user.flags' />
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
            <p v-if='!user.is_private'>{{ user.total_likes }} <span class='text-neutral-400'>Likes</span></p>
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
            :lastestComment='post.latest_comment'
            :canEdit='isMyProfil'
            :canDelete='isMyProfil'
            :isLiked='post.is_liked'
            :likesCount='post.likes_count'
            @like='handleLike()'
            @unlike='handleUnlike()'
            @destroy="(postId) => removePost(postId)"
        />
    </ul>
    <p v-else-if='!loading && !error && isPrivate' class='text-white w-full text-center p-4'>Profil privé 🔒</p>
    <p v-else-if='!loading && !error' class='text-white w-full text-center p-4'>Aucune publications :(</p>
  </main> -->
</template>