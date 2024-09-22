<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';

import useAxios from '@/utils/useAxios';

import HeaderNavbar from '@/components/layout/HeaderNavbar.vue';
import PostCard from '@/components/PostCard.vue';
import PostListComments from '@/components/PostListComments.vue';

import { useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const post = ref({});

const { onFulfilled, error, loading, isNotFound } = useAxios(() => `/api/posts/${route.params.id}`);

onFulfilled((data) => {
    post.value = data.value.post;
});

const handlePostDeleted = () => {
    router.push('/');
};
</script>

<template>
    <main class='max-w-screen-sm'>
        <HeaderNavbar :title='isNotFound ? "Poste introuvable" : "Poste"' />
        <div
            v-if='!loading && !error'
            class='flex flex-col items-center gap-2 p-3 *:w-full'
        >
            <PostCard
                :created-at='post.created_at'
                :latest_comment='post.latest_comment'
                :initial-message='post.message'
                :initial-likes-count='post.likes_count'
                :initial-liked-state='post.is_liked'
                @deleted='handlePostDeleted'
                v-bind='post'
            />
            <PostListComments />
        </div>
    </main>
</template>