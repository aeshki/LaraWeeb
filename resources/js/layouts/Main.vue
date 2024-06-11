<script setup>
import Sidebar from '@/layouts/Sidebar.vue';
</script>

<template>
    <div class='flex flex-col-reverse h-full sm:flex-row'>
        <Sidebar />
        <router-view />
    </div>
</template>