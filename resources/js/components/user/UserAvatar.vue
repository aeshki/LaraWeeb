<script setup>
import { useRouter } from 'vue-router';

import SkeletonLoader from '@/components/SkeletonLoader.vue';

const props = defineProps({
    path: String,
    to: String,
    username: String,
    isLoading: {
        type: Boolean,
        default: false,
    }
});

const router = useRouter();

const handleRedirect = () => {
    if (props.to) {
        router.push(props.to);
    }
}

const getBaseURL = () => {
    return window.location.origin;
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
        :src='path ? `${getBaseURL()}/storage/avatars/${path}` : `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${username}`'
        alt='User Avatar'
        class='bg-white max-w-12 max-h-12 aspect-square	 rounded-full select-none'
        :class="to ? 'cursor-pointer' : ''"
        @click='handleRedirect'
    />
</template>