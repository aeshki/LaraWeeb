<script setup>
defineProps([
    'pseudo',
    'username',
    'message',
    'createdAt',
]);
</script>

<template>
    <div class='flex flex-col gap-1 p-4 text-white'>
        <div class='flex gap-1 items-center'>
            <div class='flex gap-1 items-center' v-if='pseudo || username'>
                <RouterLink
                    class='text-white'
                    :to='"/@" + username'
                >
                    {{ pseudo ?? username }}
                </RouterLink>
                <span class='text-xs text-neutral-400'>@{{ username }} · </span>
            </div>
            <span class='text-xs text-neutral-400'>
                {{
                    new Date(createdAt).toLocaleDateString('default', {
                        month: 'long',
                        day: 'numeric',
                    })
                }}
            </span>
        </div>
        <p>{{ message }}</p>
    </div>
</template>