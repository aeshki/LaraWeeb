<script setup>
import Sidebar from '@/components/Sidebar.vue';
</script>

<template>
    <div class='flex flex-col-reverse w-full h-full overflow-hidden text-slate-50 sm:flex-row'>
        <Sidebar />
        <div class='flex flex-col w-full h-full overflow-y-scroll'>
            <router-view
                class='w-full max-w-screen-md justify-self-center self-center'
            />
        </div>
    </div>
</template>