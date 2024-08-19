<script setup>
const props = defineProps({
    flags: Number
});

import { Shield, MessageCircleCode, HandHeart, Lock } from 'lucide-vue-next';

const Badges = {
    STAFF: 1 << 0,
    DEVELOPER: 1 << 1,
    STAR: 1 << 2,
    PRIVATE: 1 << 3
};

const badgesToIcons = {
    STAFF: Shield,
    DEVELOPER: MessageCircleCode,
    STAR: HandHeart,
    PRIVATE: Lock
};

const badgesToStyles = {
    STAFF: {
        fill: '#2b378c',
        stroke: '#4654c2'
    },
    DEVELOPER: {
        stroke: '#b8a1ff'
    },
    STAR: {
        stroke: '#fa7dce'
    },
    PRIVATE: {
        stroke: '#fffa9c'
    }
};

const badgesLabels = {
    STAFF: 'Staff LaraWeeb',
    DEVELOPER: 'Développeur LaraWeeb',
    STAR: 'Une Star !',
    PRIVATE: 'Secret.. Is secret !'
};

const getBadges = (flags) => {
    return Object.entries(Badges)
        .filter(([key, value]) => (flags & value) === value)
        .map(([key]) => key);
}
</script>

<template>
    <div class='flex gap-2 rounded-lg bg-neutral-700 border border-neutral-500 px-2 py-1 mt-2 w-fit'>
        <div
            v-for="(flag, idx) in getBadges(flags)"
            :key="idx"
        >
            <div :title='badgesLabels[flag]'>
                <component
                    :is='badgesToIcons[flag]'
                    size='20'
                    v-bind='badgesToStyles[flag]'
                />
            </div>
        </div>
    </div>
</template>