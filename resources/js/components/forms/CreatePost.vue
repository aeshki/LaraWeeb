<script setup>
// BUILT-IN
import axios from 'axios';
import { reactive } from 'vue';

// COMPONENTS
import AreaInput from '@/components/inputs/AreaInput.vue';
import RoundedButton from '@/components/inputs/RoundedButton.vue';

const form = reactive({
  message: ''
});

const handleSubmit = () => {
  axios.post('/api/posts', form);
}
</script>

<template>
  <div class='p-4'>
    <form
      @submit.prevent='handleSubmit'
      class='flex flex-col gap-4 text-slate-50'
    >
      <AreaInput
        id='message'
        type='text'
        label='Message'
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