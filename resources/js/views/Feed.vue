<script setup>
import Post from '@/components/Post.vue';
import CreatePost from '@/components/forms/CreatePost.vue';

import { ref } from 'vue';

const posts = ref({});

axios.get('/api/posts')
    .then((rep) => posts.value = rep.data.posts.reverse())
</script>

<template>
    <ul class='flex w-full flex-col overflow-y-scroll divide-y divide-neutral-600'>
        <CreatePost />
        <Post
            v-for='post of posts'
            :key='post.id'
            :id='post.id'
            :pseudo='post.author.pseudo'
            :username='post.author.username'
            :message='post.message'
            :createdAt='post.created_at'
        />
    </ul>
</template>