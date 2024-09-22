<script setup>
defineProps({
    id: String,
    label: String,
    invalid: Boolean,
    required: Boolean,
    disabled: Boolean
});

const checked = defineModel();
</script>

<template>
    <div class='flex flex-col gap-2 text-white'>
        <label
            class='font-semibold uppercase text-sm'
            :class="required ? `after:content-['*'] after:ml-1 after:text-red-600` : ''"
            :id='id'
        >{{ label }}</label>
        <label class="relative inline-flex items-center cursor-pointer w-fit">
            <input
                :id='id'
                type='checkbox'
                :required='required'
                :disabled='disabled'
                :checked='checked'
                v-model='checked'
                class='sr-only peer'
                autocomplete='off'
            />
            <div class="w-12 h-6 bg-red-700 hover:bg-red-600 peer-focus:outline-0 after:rounded-md peer-focus:ring-transparent rounded-lg peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0 after:left-0 after:bg-white after:border-gray-300 after:border after:h-6 after:w-2/4 after:transition-all peer-checked:bg-green-600 hover:peer-checked:bg-green-700"></div>
        </label>
    </div>
</template>