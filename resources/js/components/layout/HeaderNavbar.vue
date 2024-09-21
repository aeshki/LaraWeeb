<script setup>
import { ArrowLeft } from 'lucide-vue-next';

defineProps({
    title: String
});
</script>

<template>
    <div class='z-10 flex items-center gap-2 font-semibold text-white px-2 py-3 border-b border-neutral-600'>
        <ArrowLeft
            size='28'
            class='cursor-pointer'
            @click='$router.go(-1)'
        />
        <span
            v-if='title'
            class='text-xl'
        >{{ title }}</span>
    </div>
</template>