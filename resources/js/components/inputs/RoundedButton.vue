<script setup>
import BaseButton from './base/BaseButton.vue';

defineProps({
    'to': String,
    'text': String,
    'disabled': Boolean,
    'loading': Boolean
});

const styles = {
    default: 'text-white border-neutral-400 hover:bg-slate-50 hover:text-zinc-950',
    loading: 'border-neutral-600 cursor-progress'
}
</script>

<template>
    <BaseButton
        v-bind='$props'
        class='flex justify-center w-fit h-fit border py-1 px-4 rounded-full text-sm text-nowrap font-semibold transition-all duration-200'
        :class="styles[loading ? 'loading' : 'default']"
    />
</template>