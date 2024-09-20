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
        <p>Bientôt disponible ⚙</p> 
    </div>
</template>