<script setup>
const props = defineProps({
    postId: [String, Number],
});

const emit = defineEmits([
    'submit'
]);

import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';
import { ref } from 'vue';

import UserAvatar from '@/components/User/Avatar.vue';
import { RoundedButton, AreaInput } from '@/components/common';

const authStore = useAuthStore();
const message = ref('');

const handleClick = () => {
    const { onFulfilled } = useAxios(`/api/comments`, {
        method: 'POST',
        data: {
            message: message.value,
            post_id: props.postId
        }
    });

    onFulfilled(data => {
        emit('submit', data.value.comment);
        message.value = '';
    });
}
</script>

<template>
    <div class='flex gap-2 border bg-neutral-800 border-neutral-600 p-2 rounded-lg overflow-hidden'>
        <UserAvatar
            :username='authStore.user.username'
            :path='authStore.user?.avatar'
        />

        <div class='flex flex-col gap-2 w-full'>
            <AreaInput
                placeholder='Dite quelques choses..'
                v-model='message'
            />
            <RoundedButton
                class='self-end'
                text='publier'
                @click='handleClick'
            />
        </div>
    </div>
</template>