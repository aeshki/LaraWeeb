<template>
    <div class='flex justify-between '>
        <NavButton
            to='/agenda'
            :icon='EventNoteIcon'
        />
        <NavButton
            to='/quests'
            :icon='LibraryBooksIcon'
        />
        <NavButton
            to='/catalog'
            :icon='MenuBookIcon'
        />
        <NavButton
            to='/users/@admin'
            :icon='SettingsIcon'
        />
    </div>
</template>
<script setup>
import {
    EventNoteIcon,
    LibraryBooksIcon,
    MenuBookIcon,
    SettingsIcon
} from '@/components/icons'
import NavButton from '@/components/common/buttons/NavButton.vue';
</script>