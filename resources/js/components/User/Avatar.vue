<script setup>
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import { ref } from 'vue';

const props = defineProps({
    path: String,
    absolutePath: String,
    username: String,
    skeleton: {
        type: Boolean,
        default: false,
    },
    size: Number,
    gifStatic: {
        type: Boolean,
        default: true
    }
});

const hovered = ref(false);

const getImage = () => {
    if (props.absolutePath) {
        return props.absolutePath;
    } else if (props.path) {
        return `/storage/avatars/${props.path}`;
    } else {
        return `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${props.username}`;
    }
};
</script>

<template>
    <SkeletonLoader
        type='circle'
        :active='skeleton'
        :style='{ width: `${size}px`, height: `${size}px` }'
    >
        <img
            :src='!gifStatic || hovered ? getImage() : getImage().replace(".gif", ".png")'
            alt='User Avatar'
            class='max-h-fit max-w-fit w-12 h-12 aspect-square rounded-full select-none'
            :style='{ width: `${size}px`, height: `${size}px` }'
            :class='$attrs.class'
            @click='handleRedirect'
            @mouseenter='() => hovered = true'
            @mouseleave='() => hovered = false'
        />
    </SkeletonLoader>
</template>