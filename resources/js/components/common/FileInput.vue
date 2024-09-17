<script setup>
defineProps({
    id: String,
    accept: {
        type: String,
        default: 'image/png, image/jpeg'
    },
    multiple: Boolean
});

const emit = defineEmits([ 'change' ]);

const styles = {
  default: '',
  invalid: '',
  disabled: '',
};
</script>

<template>
    <div class='flex items-center text-white px-4 py-1 rounded-full w-fit bg-neutral-700'>
        <label :for='id'>Ajouter une image</label>
            <input
                class='text-transparent overflow-hidden w-0'
                type='file'
                :name='id'
                :id='id'
                :accept='accept'
                :multiple='multiple'
                @change="(e) => emit('change', multiple ? e.target.files : e.target.files[0])"
            />
    </div>
</template>