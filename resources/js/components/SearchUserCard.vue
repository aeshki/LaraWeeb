<script setup>
const props = defineProps({
    avatar: String,
    pseudo: String,
    username: {
        type: String,
        required: true
    },
    isPrivate: Boolean
});

import UserAvatar from '@/components/User/Avatar.vue';
import { Lock } from 'lucide-vue-next';
import { useRouter } from 'vue-router';

const router = useRouter();

const handleClick = () => {
    router.push(`/@${props.username}`);
}
</script>

<template>
    <div @click='handleClick' class='cursor-pointer flex gap-4 p-3 bg-zinc-800 border border-zinc-500 max-w-sm w-full rounded-2xl'>
        <UserAvatar
            :path='avatar'
            :username='username'
        />
        <div>
            <div class='flex gap-1 items-center'>
                <Lock v-if='isPrivate' size='18' />
                <p>{{ pseudo ?? username }}</p>
            </div>
            <p class='text-sm text-neutral-400'>@{{ username }}</p>
        </div>
    </div>
</template>