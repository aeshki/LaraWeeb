<script setup>
import BaseInput from  './BaseButton.vue';

const props = defineProps({
    text: String,
    loading: Boolean,
    disabled: Boolean,
    variant: String,
});

const variants = {
    primary: {
        default: 'bg-indigo-500 hover:bg-indigo-600',
        loading: 'bg-indigo-400 cursor-progress'
    },
    danger: {
        default: 'bg-red-500 hover:bg-red-600',
        loading: 'bg-red-400 cursor-progress'
    }
}

const variant = variants[props.variant] ?? variants.primary;
</script>

<template>
    <BaseInput
        v-bind='$props'
        class='flex flex-center text-white p-2 rounded-lg uppercase font-semibold shadow-md min-h-10 select-none transition-all duration-100'
        :class="variant[loading ? 'loading' : 'default']"
        :disabled='disabled'
    />
</template>