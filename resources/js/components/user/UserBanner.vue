<script setup>
import { useRouter } from 'vue-router';

const props = defineProps({
    banner: String,
    absoluteBannerPath: String,
    bannerColor: String
});

const router = useRouter();
</script>

<template>
    <div
        class='aspect-3/1 border-b border-zinc-900 sm:border-zinc-700'
        :style='{ backgroundColor: `#${bannerColor}`, backgroundImage: `url(${absoluteBannerPath ?? `/storage/banners/${banner}`})`, backgroundSize: "cover" }'
    ></div>
</template>