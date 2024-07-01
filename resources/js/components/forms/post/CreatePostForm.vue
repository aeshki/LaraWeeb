<script setup>
// BUILT-IN
import axios from 'axios';
import { reactive } from 'vue';

// COMPONENTS
import { RoundedButton, AreaInput } from '@/components/common';
import { UserAvatar } from '@/components/user';

const form = reactive({
  message: ''
});

const handleSubmit = () => {
  axios.post('/api/posts', form);
}
</script>

<template>
  <div class='flex gap-4 p-4'>
    <UserAvatar />
    <form
      @submit.prevent='handleSubmit'
      class='flex flex-col gap-4 text-slate-50 w-full'
    >
      <AreaInput
        id='message'
        type='text'
        placeholder='Dite quelque chose..'
        required
        v-model='form.message'
        rows='4'
      />

      <RoundedButton
        class='self-end'
        text='Envoyer'
      />
    </form>
  </div>
</template>