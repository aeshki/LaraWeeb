<script setup>
// BUILT-IN
import axios from 'axios';
import { reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

// COMPONENTS
import { RoundedButton, AreaInput, FileInput } from '@/components/common';
import { UserAvatar } from '@/components/user';

const form = reactive({
  message: '',
  image: null
});

const handleSubmit = () => {
  let formData = new FormData();

  // formData.set('_method', 'PATCH');

  Object.entries(form).forEach((data) => {
    data[1] ??= '';

    if (data[0] === 'image' && !(data[1] instanceof File) && data[1]) {
        return
    }

    formData.append(data[0], data[1]);
  });

  axios.post('/api/posts', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  });
}
</script>

<template>
  <div class='flex gap-4 p-4'>
    <UserAvatar :username='authStore.user.username' :path='authStore.user?.avatar' />
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

      <div class='w-full flex justify-end gap-2'>
        <FileInput
          id='image'
          @change='(file) => form.image = file'
        />

        <RoundedButton
          class='self-end'
          text='Envoyer'
        />
      </div>
    </form>
  </div>
</template>