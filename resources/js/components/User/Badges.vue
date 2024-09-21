<script setup>
const props = defineProps({
    flags: {
        type: Number,
        required: true
    }
});

import { bitwiseToBadges } from '@/utils/badge';
</script>

<template>
    <div class='flex gap-1 rounded-lg bg-neutral-800 border border-neutral-500 px-2 py-1 mt-2 w-fit'>
        <div
            v-for='badge in bitwiseToBadges(flags)'
            :key='badge.key'
        >
            <div :title='badge.label'>
                <component
                    :is='badge.icon'
                    size='20'
                />
            </div>
        </div>
    </div>
</template>