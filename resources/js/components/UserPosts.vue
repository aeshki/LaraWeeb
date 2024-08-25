<script setup>
const props = defineProps({
    path: String,
    to: String,
    username: String,
    isLoading: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <div>
        <p>POSTS</p> 
    </div>
</template>