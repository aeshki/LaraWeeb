<template setup>
    <form>
        <div v-if='$slots.header' class='flex flex-col gap-2'>
            <slot name='header' />
        </div>

        <div v-if='$slots.default' class='flex flex-col gap-6'>
            <slot />
        </div>

        <div v-if='$slots.footer' class='flex flex-col gap-3'>
            <slot name='footer' />
        </div>
    </form>
</template>