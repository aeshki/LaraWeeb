<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    id: String,
    label: String,
    accept: {
        type: String,
        default: 'image/png, image/jpeg, image/gif'
    },
    multiple: Boolean
});

const model = defineModel();
const fileInput = ref(null);

const handleChange = (e) => {
    model.value = props.multiple ? e.target.files : e.target.files[0];
};

watch(model, (newValue) => {
    if (!newValue || (Array.isArray(newValue) && newValue.length === 0)) {
        if (fileInput.value) {
            fileInput.value.value = '';
        }
    }
});

const styles = {
    default: 'text-white border-neutral-400 hover:bg-slate-50 hover:text-zinc-950',
    disabled: 'text-white bg-neutral-500 text-neutral-200 border-transparent cursor-not-allowed',
    fill: 'text-zinc-950 bg-slate-50 border-transparent hover:bg-indigo-500 hover:text-white',
    loading: 'border-neutral-600 cursor-progress'
}
</script>

<template>
    <div
        class='flex items-center w-fit h-fit border py-0.5 px-4 rounded-full text-sm text-nowrap font-semibold transition-all duration-200'
        :class="styles[disabled ? 'disabled' : loading ? 'loading' : variant ?? 'default'] ?? styles.default"
    >
        <label :for='id'>{{ label }}</label>
        <input
            ref='fileInput'
            class='text-transparent overflow-hidden w-0'
            type='file'
            :name='id'
            :id='id'
            :accept='accept'
            :multiple='multiple'
            @change="handleChange"
        />
    </div>
</template>
