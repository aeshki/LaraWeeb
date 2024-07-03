<script setup>
import Post from '@/components/PostCard.vue';
import CreatePost from '@/components/forms/post/CreatePostForm.vue';

import { ref } from 'vue';

const posts = ref({});

axios.get('/api/posts')
    .then((rep) => posts.value = rep.data.posts.reverse())
</script>

<template>
    <ul class='flex flex-col items-center gap-4 p-4'>
        <CreatePost class='w-full' />
        <Post v-for='post of posts'
              :key='post.id'
              :id='post.id'
              :image='post.image'
              :avatar='post.author?.avatar'
              :pseudo='post.author.pseudo'
              :username='post.author.username'
              :message='post.message'
              :createdAt='post.created_at' />
    </ul>
</template>