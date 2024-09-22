<script setup>
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

import useAxiosPaginate from '@/utils/useAxiosPaginate';
import useScrollBottom from '@/utils/useScrollBottom';

import CommentCard from '@/components/CommentCard.vue';
import CreateCommentForm from '@/components/common/forms/CreateCommentForm.vue';

const scrollElement = ref(null);
const { bottomReached } = useScrollBottom(scrollElement);

const route = useRoute();
const router = useRouter();

const page = ref(1);
const comments = ref([]);

const { onFulfilled, loading, per_page, to } = useAxiosPaginate(() => `/api/posts/${route.params.id}/comments?page=${page.value}`);

onFulfilled((data) => {
    comments.value = [ ...comments.value, ...data.value ];
});

watch(bottomReached, (state) => {
    if ((state && !loading.value) && to.value % per_page.value === 0) {
        page.value = page.value + 1;
    }
});

const handleAddComment = (comment) => {
    comments.value.unshift(comment);
};

const handleCommentDeleted = (commentId) => {
    comments.value = comments.value.filter((comment) => comment.id !== commentId);
};
</script>

<template>
    <div ref='scrollElement'>
        <h3 class='text-lg font-semibold mb-3 mt-2'>
            Commentaires <span v-if='comments?.length > 0'>( {{ comments?.length }} )</span>
        </h3>
        
        <div class='flex flex-col gap-3'>
            <CreateCommentForm
                :post-id='route.params.id'
                @submit='handleAddComment'
            />
    
            <template v-if='comments.length > 0'>
                <CommentCard
                    v-for='comment of comments'
                    :key='comment.id'
                    :initialMessage='comment.message'
                    @deleted='handleCommentDeleted'
                    v-bind='comment'
                />
            </template>
            <p v-else class='text-slate-50 w-full text-center'>Aucun commentaire :(</p>
        </div>
    </div>
</template>