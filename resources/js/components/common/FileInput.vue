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
    <div class='flex flex-col gap-2 text-white'>
        <input
            type='file'
            :id='id'
            :accept='accept'
            :multiple='multiple'
            @change="(e) => emit('change', multiple ? e.target.files : e.target.files[0])" />
    </div>
</template>