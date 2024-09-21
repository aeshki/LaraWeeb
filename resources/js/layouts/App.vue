<script setup>
import Navbar from '@/components/layout/Navbar.vue';
</script>

<template>
    <div class='flex flex-col-reverse w-full h-full overflow-hidden text-slate-50 sm:flex-row'>
        <Navbar />
        <div class='flex flex-col w-full h-full overflow-y-scroll'>
            <router-view class='w-full max-w-screen-md justify-self-center self-center'/>
        </div>
    </div>
</template>