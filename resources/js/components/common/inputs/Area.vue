<script setup>
import { onUpdated, ref } from 'vue';

const props = defineProps({
    id: String,
    type: String,
    label: String,
    placeholder: String,
    invalid: Boolean,
    required: Boolean,
    disabled: Boolean,
    rows: [String, Number],
    cols: [String, Number],
    autoSize: {
        type: Boolean,
        default: true
    },
    maxHeight: {
        type: String,
        default: '120px'
    }
});

const change = defineModel();

const input = ref(null);

const adjustHeight = () => {
    if (!props.autoSize) {
        return;
    }

    input.value.style.maxHeight = props.maxHeight;
    input.value.style.height = 'auto';
    input.value.style.height = `${input.value.scrollHeight}px`;
}

onUpdated(() => adjustHeight());

const styles = {
  default: 'outline-neutral-600 focus:outline-neutral-500 focus:outline-offset-2 hover:outline-neutral-400',
  invalid: 'outline-red-900 focus:outline-red-700 focus:outline-offset-2 hover:outline-red-600',
  disabled: 'bg-zinc-800 text-neutral-400 outline-neutral-600',
};
</script>

<template>
    <div class='flex flex-col gap-2 text-white'>
        <label
            v-if='label'
            class='font-semibold uppercase text-sm'
            :class="required && label ? `after:content-['*'] after:ml-1 after:text-red-600` : ''"
            :id='id'
        >{{ label }}</label>
        <textarea
            :id='id'
            :type='type ?? "text"'
            :class="styles[invalid ? 'invalid' : disabled ? 'disabled' : 'default']"
            :required='required'
            :disabled='disabled'
            :placeholder='placeholder'
            :rows='rows'
            :cols='cols'
            class='resize-none bg-transparent outline outline-1 p-2 text-sm rounded-sm transition-all duration-100'
            autocomplete='off'
            v-model='change' 
            @input='adjustHeight'
            ref='input'
        ></textarea>
    </div>
</template>