<script setup>
import { ref } from 'vue';
import { X } from 'lucide-vue-next';

const emit = defineEmits([ 'click-outside' ]);
</script>

<template>
  <div
    class='fixed top-0 left-0 w-full h-full bg-black/50 text-white z-50'
    @click.stop="emit('click-outside')"
  >
    <div @click.stop>
      <div class='flex flex-col absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-zinc-800 mobileLarge:max-w-96 w-full h-full mobileLarge:h-fit mobileLarge:rounded-xl mobileLarge:shadow-xl *:p-4'>
        <div class='flex justify-between rounded-t-xl border-b border-b-zinc-500 font-semibold text-xl'>
          <slot name='header'></slot>
          <X
            class='cursor-pointer'
            @click.stop="emit('click-outside')"
          />
        </div>
        <div class='h-full'>
          <slot name='content'></slot>
        </div>
        <div class='bg-zinc-700 mobileLarge:rounded-b-xl'>
          <slot name='footer'></slot>
        </div>
      </div>
    </div>
  </div>
</template>