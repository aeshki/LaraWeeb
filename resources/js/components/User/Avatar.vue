<script setup>
import SkeletonLoader from '@/components/SkeletonLoader.vue';

const props = defineProps({
    path: String,
    absolutePath: String,
    username: String,
    skeleton: {
        type: Boolean,
        default: false,
    },
    size: Number,
    class: String
});
</script>

<template>
    <SkeletonLoader
        type='circle'
        :active='skeleton'
        :size='size ?? 48'
    >
        <img
            :src='absolutePath ? absolutePath : path ? `/storage/avatars/${path}` : `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${username}`'
            alt='User Avatar'
            class='bg-white max-h-fit max-w-fit w-12 h-12 aspect-square rounded-full select-none'
            :class='class'
            :style='{ width: `${size}px`, height: `${size}px` }'
            @click='handleRedirect'
        />
    </SkeletonLoader>
</template>