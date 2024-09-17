<script setup>
import { ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    title: String
});
</script>

<template>
    <div class='flex items-center gap-2 font-semibold text-white p-2 border-b border-neutral-600'>
        <ArrowLeft size='28'
                   class='cursor-pointer'
                   @click="$router.go(-1)" />
        <span v-if='title'
              class='text-xl'
        >{{ title }}</span>
    </div>
</template>