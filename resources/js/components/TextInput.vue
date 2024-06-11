<script setup>
import { ref } from 'vue';

const props = defineProps([
    'id',
    'required',
    'label',
    'type',
    'hasError',
    'disabled'
]);

const model = defineModel();

const defaultColor = ref('outline-zinc-300 focus:outline-zinc-500 focus:outline-offset-2 hover:outline-zinc-400');
const errorColor = ref('outline-red-300 focus:outline-red-500 focus:outline-offset-2 hover:outline-red-400');
const disabledColor = ref('outline-zinc-400 cursor-not-allowed');
</script>

<template>
    <div class='flex flex-col gap-2'>
        <label
            class='font-semibold uppercase text-zinc-800'
            :for='id'
        >
            {{ label }}
            <span
                v-if='required !== undefined'
                class='text-red-500 select-none'
            >*</span>
        </label>
        <input
            class='rounded-lg w-full p-2 outline outline-2 shadow-md transition-all duration-100'
            v-model='model' 
            autocomplete='off'
            :type='type ?? email'
            :id='id'
            :class='props.disabled ? disabledColor : props.hasError ? errorColor : defaultColor'
            :required='required'
            :disabled='disabled'
        />
    </div>
</template>