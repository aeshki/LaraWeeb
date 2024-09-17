<script setup>
defineProps({
    'id': String,
    'label': String,
    'invalid': Boolean,
    'required': Boolean,
    'disabled': Boolean
});

const checked = defineModel();

const styles = {
    default: 'outline-neutral-600 focus:outline-neutral-500 focus:outline-offset-2 hover:outline-neutral-400',
    invalid: 'outline-red-900 focus:outline-red-700 focus:outline-offset-2 hover:outline-red-600',
    disabled: 'bg-zinc-800 text-neutral-400 outline-neutral-600',
//   default: 'outline-neutral-600 focus:outline-neutral-500 focus:outline-offset-2 hover:outline-neutral-400',
//   invalid: 'outline-red-900 focus:outline-red-700 focus:outline-offset-2 hover:outline-red-600',
//   disabled: 'bg-zinc-800 text-neutral-400 outline-neutral-600',
};
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
                :class="styles[invalid ? 'invalid' : disabled ? 'disabled' : 'default']"
                :required='required'
                :disabled='disabled'
                :checked='checked'
                v-model='checked'
                class='sr-only peer'
                autocomplete='off'
            />
            <div class="w-9 h-5 bg-gray-200 hover:bg-gray-300 peer-focus:outline-0 peer-focus:ring-transparent rounded-full peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600 hover:peer-checked:bg-indigo-700"></div>
        </label>
    </div>
</template>