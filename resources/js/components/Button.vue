<script setup>
import { ref } from 'vue';

import ProgressIcon from '@/components/icons/ProgressIcon.vue';

const props = defineProps([
    'text',
    'loading'
]);

const defaultColor = ref('bg-indigo-500 hover:bg-indigo-600');
const loadingColor = ref('bg-indigo-400 cursor-progress');
</script>

<template>
    <button
        :disabled="loading"
        class='flex flex-center text-white p-2 rounded-xl uppercase font-semibold shadow-md min-h-10 transition-all duration-100'
        :class='props.loading ? loadingColor : defaultColor'
    >
        <ProgressIcon
            class='animation-rotate w-fit'
            v-if='loading'
        />
        <template v-else>
            {{ text }}
        </template>
    </button>
</template>