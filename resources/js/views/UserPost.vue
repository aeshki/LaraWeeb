<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import useAxios from '@/utils/useAxios';
import { useAuthStore } from '@/stores/auth';

const route = useRoute();
const authStore = useAuthStore();

import Post from '@/components/PostCard.vue';
import BackNavigationBar from '@/components/BackNavigationBar.vue';
import CommentCard from '@/components/CommentCard.vue';
import PostComment from '@/components/forms/PostComment.vue';

const post = ref({});
const comments = ref([]);

const { onFulfilled } = useAxios(() => `/api/posts/${route.params.id}`);

onFulfilled((data) => {
    post.value = data.value.post;
    comments.value = post.value.comments.reverse();
});

const handleAddComment = (comment) => {
    comments.value.unshift(comment);
}

const handleDeletedComment = (commentId) => {
    comments.value = comments.value.filter((comment) => comment.id !== commentId);
}
</script>

<template>
    <main>
        <BackNavigationBar title='Post' />
        <div class='flex flex-col p-3 items-center'>
            <Post
                v-if='post.message'
                class='border-b border-neutral-600'
                v-bind='post'
                :image='post.image'
                :avatar='post.author?.avatar'
                :pseudo='post.author?.pseudo'
                :username='post.author.username'
                :createdAt='post.created_at'
            />
            
            <div class='flex flex-col sm:max-w-screen-sm sm:w-full'>
                <h3 class='text-lg font-semibold mb-3 mt-2'>
                    Commentaires <span v-if='comments?.length > 0'>( {{ comments?.length }} )</span>
                </h3>
                <PostComment
                    :postId='route.params.id'
                    :avatar='authStore.user?.avatar'
                    class='mb-3'
                    @submit='(comment) => handleAddComment(comment)'
                />
                <div v-if='comments?.length > 0' class='flex flex-col gap-3'>
                    <CommentCard
                        v-for='comment of comments'
                        :key='comment.id'
                        :id='comment.id'
                        :avatar='comment.author?.avatar'
                        :pseudo='comment.author.pseudo'
                        :username='comment.author.username'
                        :message='post.message'
                        :canEdit='comment.author.username === authStore.user.username'
                        :canDelete='(comment.author.username === authStore.user.username) || (post.author.username === authStore.user.username)'
                        @deleted='handleDeletedComment(comment.id)'
                    />
                </div>
                <p v-else class='text-slate-50 self-center h-full flex items-center'>Aucun commentaire :(</p>
            </div>
        </div>
    </main>
</template>