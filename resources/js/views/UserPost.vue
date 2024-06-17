<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

import Post from '@/components/Post.vue';
import BackNavigationBar from '@/components/BackNavigationBar.vue';

const postData = ref({});

// TEMP
const code = ref(null);

watch(() => route.params.id, (id) => {
  axios.get(`/api/posts/${id}`)
    .then((res) => {
        postData.value = res.data.post;
        code.value = res.status;
    })
    .catch((err) => code.value = err.response.status)
}, { immediate: true });

</script>

<template>
    <div class='flex flex-col h-full w-full'>
        <BackNavigationBar title='Post' />
        <Post
            v-if='postData.message'
            class='border-b border-neutral-600'
            :id='route.params?.id'
            :username='postData.author?.username'
            :pseudo='postData.author?.pseudo'
            :createdAt='postData.created_at'
            :message='postData.message'
        />
        <p class='text-slate-50 self-center h-full flex items-center'>Aucun commentaire :(</p>
    </div>
</template>