<script setup>
import { reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';

const emit = defineEmits([ 'submit' ]);

const authStore = useAuthStore();

import {
  RoundedButton,
  AreaInput,
  FileInput
} from '@/components/common';

import { UserAvatar } from '@/components/User';

const form = reactive({
  message: '',
  image: null
});


const handleSubmit = () => {
  let formData = new FormData();
  
  Object.entries(form).forEach((data) => {
    data[1] ??= '';

    if (data[0] === 'image' && !(data[1] instanceof File) && data[1]) {
        return
    }

    formData.append(data[0], data[1]);
  });

  const { onFulfilled } = useAxios(`/api/posts`, {
    method: 'POST',
    data: formData
  });

  onFulfilled((data) => {
    emit('submit', data.value.post);
    
    form.message = '';
    form.image = '';
  });
}
</script>

<template>
  <div class='flex gap-4'>
    <UserAvatar
      :username='authStore.user.username'  
      :path='authStore.user?.avatar'
    />
    <form
      class='flex flex-col gap-4 text-slate-50 w-full'
      @submit.prevent='handleSubmit'
    >
      <AreaInput
        id='message'
        type='text'
        placeholder='Dite quelque chose..'
        :required='!form.image'
        v-model='form.message'
        rows='4'
      />

      <div class='flex flex-col items-end justify-end gap-2'>
        <FileInput
          id='image'
          label='Attacher une image'
          v-model='form.image'
        />

        <RoundedButton text='Envoyer' />
      </div>
    </form>
  </div>
</template>