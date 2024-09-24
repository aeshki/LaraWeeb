<script setup>
import { ref, watch } from 'vue';
import useAxiosPaginate from '@/utils/useAxiosPaginate';
import useScrollBottom from '@/utils/useScrollBottom';

import CreatePostForm from '@/components/common/forms/CreatePostForm.vue';
import PostCard from '@/components/PostCard.vue';

const scrollElement = ref(null);
const { bottomReached } = useScrollBottom(scrollElement);

const page = ref(1);
const posts = ref([]);

const { onFulfilled, loading, per_page, to } = useAxiosPaginate(() => `/api/posts?page=${page.value}`);

onFulfilled((data) => {
    posts.value = [ ...posts.value, ...data.value ];
});

watch(bottomReached, (state) => {
    if ((state && !loading.value) && to.value % per_page.value === 0) {
        page.value = page.value + 1;
    }
});

const handlePostCreated = (post) => {
    posts.value.unshift(post);
};

const handlePostDeleted = (postId) => {
    posts.value = posts.value.filter((post) => post.id !== postId);
};
</script>

<template>
    <ul ref='scrollElement' class='flex flex-col p-4 gap-4 max-w-screen-sm'>
        <CreatePostForm @submit='handlePostCreated' />
        <PostCard
            v-for='post of posts'
            :key='post.id'
            :created-at='post.created_at'
            :latest_comment='post.latest_comment'
            :initial-message='post.message'
            :initial-likes-count='post.likes_count'
            :initial-liked-state='post.is_liked'
            @deleted='handlePostDeleted'
            v-bind='post'
        />
        <p 
            v-if='!loading && (to % per_page !== 0)'
            class='my-4 text-center'
        >On dirait bien que tu as plus aucun poste à voir :O</p>
    </ul>
</template>