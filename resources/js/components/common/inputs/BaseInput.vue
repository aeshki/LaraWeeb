<script setup>
import Notice from '@/components/Notice.vue';

defineProps({
    error: String
});
</script>

<template>
    <slot />
    <Notice
        v-if='error'
        :message='error'
    />
</template>