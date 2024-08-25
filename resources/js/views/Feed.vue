<script setup>
import Post from '@/components/PostCard.vue';
import CreatePost from '@/components/forms/post/CreatePostForm.vue';
import useScrollBottom from '@/utils/useScrollBottom';

import { ref, watch } from 'vue';
import useAxiosPaginate from '@/utils/useAxiosPaginate';

const page = ref(0);
const posts = ref([]);

const scrollElement = ref(null);
const { bottomReached } = useScrollBottom(scrollElement);

const { onFulfilled, loading, per_page, to } = useAxiosPaginate(() => `/api/posts?page=${page.value}`);

onFulfilled((data) => {
    posts.value = [ ...posts.value, ...data.value ];
});

watch(bottomReached, (state) => {
    if ((state && !loading.value) && to.value % per_page.value === 0) {
        page.value = page.value + 1;
    }
});

const handleAddPost = (post) => {
    posts.value.unshift(post);
};
</script>

<template>
    <ul ref='scrollElement' class='flex flex-col items-center gap-4 p-4 overflow-y-scroll'>
        <CreatePost
            class='w-full'
            @submit='(post) => handleAddPost(post)'
        />
        <Post
            v-for='post of posts'
            :key='post.id'
            :avatar='post.author?.avatar'
            :pseudo='post.author.pseudo'
            :username='post.author.username'
            :createdAt='post.created_at'
            :lastestComment='post?.latest_comment'
            :isLiked='post.is_liked'
            :likesCount='post.likes_count'
            v-bind='post'
        />
        <template v-if='loading'>
            <Post :isLoading='loading' />
            <Post :isLoading='loading' />
            <Post :isLoading='loading' />
        </template>
        <p 
            v-if='to % per_page !== 0'
            class='my-4'
        >On dirait bien que tu as plus aucun poste à voir :o</p>
    </ul>
</template>