<script setup>
const props = defineProps({
    id: String,
    label: String,
    multiple: Boolean,
    disabled: Boolean,
    loading: Boolean,
});

const model = defineModel();
</script>

<template>
    <div class='flex flex-col gap-2 text-white'>
        <label
            class='font-semibold uppercase text-sm'
            :class="required ? `after:content-['*'] after:ml-1 after:text-red-600` : ''"
            :id='id'
        >{{ label }}</label>
        <input
            class='appearance-none p-0 w-16 h-10'
            type='color'
            :id='id'
            v-model='model'
        />
    </div>
</template>
