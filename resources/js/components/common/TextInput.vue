<script setup>
defineProps({
    id: String,
    type: String,
    label: String,
    placeholder: String,
    minlength: {
        type: [String, Number],
        default: 2
    },
    maxlength: {
        type: [String, Number],
        default: 2000
    },
    invalid: Boolean,
    required: Boolean,
    disabled: Boolean
});

const change = defineModel();

const styles = {
  default: 'outline-neutral-600 focus:outline-neutral-500 focus:outline-offset-2 hover:outline-neutral-400',
  invalid: 'outline-red-900 focus:outline-red-700 focus:outline-offset-2 hover:outline-red-600',
  disabled: 'bg-zinc-800 text-neutral-400 outline-neutral-600',
};
</script>

<template>
    <div class='flex flex-col gap-2 text-white'>
        <label
            class='font-semibold uppercase text-sm'
            :class="required ? `after:content-['*'] after:ml-1 after:text-red-600` : ''"
            :id='id'
        >{{ label }}</label>
        <input
            :id='id'
            :type='type ?? "text"'
            :class="styles[invalid ? 'invalid' : disabled ? 'disabled' : 'default']"
            :required='required'
            :disabled='disabled'
            :placeholder='placeholder'
            :maxlength='maxlength'
            :minlength='minlength'
            class='bg-transparent outline outline-1 p-2 text-sm rounded-sm transition-all duration-100'
            autocomplete='off'
            v-model='change' 
        />
    </div>
</template>