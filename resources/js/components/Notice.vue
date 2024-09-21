<script setup>
defineProps({
    type: String,
    message: String
});

const styles = {
  'default': 'text-red-400 border-2 border-red-400 bg-red-100',
  'warn': 'text-yellow-400 border-2 border-yellow-400 bg-yellow-100',
  'success': 'text-green-400 border-2 border-green-400 bg-green-100'
};
</script>

<template>
  <div
    class='p-1 rounded-md shadow-sm'
    :class='[styles[type] ?? styles.default]'
  >
    <span>{{ message }}</span>
  </div>
</template>