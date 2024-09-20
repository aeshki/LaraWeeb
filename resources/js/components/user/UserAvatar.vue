<script setup>
import { useRouter } from 'vue-router';

import SkeletonLoader from '@/components/SkeletonLoader.vue';

const props = defineProps({
    path: String,
    absolutePath: String,
    to: String,
    username: String,
    isLoading: {
        type: Boolean,
        default: false,
    },
    size: Number
});

const router = useRouter();

const handleRedirect = () => {
    if (props.to) {
        router.push(props.to);
    }
}
</script>

<template>
    <SkeletonLoader
        v-if='isLoading'
        type='circle'
        class='w-12 h-12'
    />
    <img
        v-else
        :src='absolutePath ? absolutePath : path ? `/storage/avatars/${path}` : `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${username}`'
        alt='User Avatar'
        class='bg-white max-h-fit max-w-fit w-12 h-12 aspect-square rounded-full select-none'
        :class="to ? 'cursor-pointer' : ''"
        :style='{ width: `${size}px`, height: `${size}px` }'
        @click='handleRedirect'
    />
</template>