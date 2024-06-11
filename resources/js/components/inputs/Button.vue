<script setup>
import ProgressIcon from '@/components/icons/ProgressIcon.vue';

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
    <component
        :is="to ? 'RouterLink' : 'Button'"
        :class="styles[loading ? 'loading' : 'default']"
        :disabled="loading"
        :to='to'
        class='flex justify-center w-fit h-fit border py-1 px-4 rounded-full text-sm text-nowrap font-semibold transition-all duration-200'
    >
        <ProgressIcon
            class='animation-rotate w-fit'
            v-if='loading'
        />
        <slot v-else />
    </component>
</template>