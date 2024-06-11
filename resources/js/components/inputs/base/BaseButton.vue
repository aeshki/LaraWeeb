<script setup>
import { LoaderCircle } from 'lucide-vue-next';

defineProps({
    'to': String,
    'text': String,
    'disabled': Boolean,
    'loading': Boolean
});
</script>

<template>
    <component
        :is="to ? 'RouterLink' : 'Button'"
        :disabled="loading"
        :to='to'
    >
        <LoaderCircle
            class='animation-rotate w-fit'
            v-if='loading'
        />
        <span v-else>{{ text }}</span>
    </component>
</template>