<script setup>
import { ref } from 'vue';

import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';

import { Trash2} from 'lucide-vue-next';
import UserAvatar from '@/components/User/Avatar.vue';

const props = defineProps({
    id: [Number, String],
    author: Object,
    initialMessage: String
});

const emit = defineEmits([ 'deleted' ]);

const authStore = useAuthStore();

const message = ref(props.initialMessage);

const canDelete = authStore.user.id === props.author.id || haveFlag(authStore.user.flags, 'STAFF');

const handleDelete = () => {
    const { onFulfilled } = useAxios(`/api/comments/${props.id}`, { method: 'DELETE' });

    onFulfilled(() => {
        emit('deleted', props.id);
    });
}
</script>

<template>
    <div class='flex gap-2 border bg-neutral-800 border-neutral-600 p-2 rounded-lg overflow-hidden sm:max-w-screen-sm sm:w-full'>
        <UserAvatar
            :username='author.username'
            :path='author.avatar'
        />

        <div class='flex flex-col w-full'>
            <div class='flex justify-between w-full'>
                <span>{{ author.pseudo ?? author.username }}</span>
                <div
                    v-if='canDelete'    
                    class='flex gap-2 *:text-neutral-400 hover:*:text-neutral-300 *:transition-all *:duration-100'
                >
                    <Trash2
                        v-if='canDelete'
                        size='18'
                        @click='handleDelete'
                    />
                </div>
            </div>
            <p class=''>{{ message }}</p>
        </div>
    </div>
</template>