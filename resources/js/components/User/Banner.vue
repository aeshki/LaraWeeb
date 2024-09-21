<script setup>
import SkeletonLoader from '@/components/SkeletonLoader.vue';

const props = defineProps({
    path: String,
    absolutePath: String,
    color: {
        type: String,
        default: '#FFF'
    },
    skeleton: {
        type: Boolean,
        default: false,
    },
    size: Number
});
</script>

<template>
    <SkeletonLoader
        class='aspect-3/1 border-b-2 rounded-none border-zinc-900 sm:border-zinc-700'
        :active='skeleton'
    >
        <div
            class='aspect-3/1 border-b border-zinc-900 sm:border-zinc-700'
            :class='$attrs.class'
            :style='{ backgroundColor: color, backgroundImage: `url(${absolutePath ?? `/storage/banners/${path}`})`, backgroundSize: "cover" }'
        ></div>
    </SkeletonLoader>
</template>