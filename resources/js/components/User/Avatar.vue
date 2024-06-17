<script setup>
import { useRouter } from 'vue-router';

import SkeletonLoader from '@/components/SkeletonLoader.vue';

const props = defineProps({
    path: String,
    to: String,
    isLoading: {
        type: Boolean,
        default: false,
    }
});

const router = useRouter();

const defaultAvatar = 'https://i.pinimg.com/originals/51/bb/4f/51bb4fb4e0fcee875f6682e2a879900e.jpg'

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
        :src='path ?? defaultAvatar'
        alt='User Avatar'
        class='bg-white max-w-12 max-h-12 rounded-full select-none'
        :class="to ? 'cursor-pointer' : ''"
        @click='handleRedirect'
    />
</template>