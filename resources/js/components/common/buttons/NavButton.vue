<script setup>
defineProps({
    icon: [Object, Function],
    title: String, 
    to: String
});
</script>

<template>
    <RouterLink
        class='group flex gap-2 p-2 text-white rounded-xl [&.exact-active]:bg-neutral-500/70 transition-all duration-200 md:px-3'
        :to='to'
    >
        <component :is='icon' />
        <p class='hidden md:block'>{{ title }}</p>
    </RouterLink>
</template>