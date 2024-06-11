<script setup>
import TextInput from '@/components/inputs/TextInput.vue';
import RoundedButton from '@/components/inputs/RoundedButton.vue';

import { ref, reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

const isLoaded = ref(false);
const form = reactive({
  pseudo: authStore.user.pseudo,
  username: authStore.user.username,
  email: authStore.user.email
});

const handleSubmit = () => {
  isLoaded.value = true;

  authStore.updateUser(form)
    .finally(() => isLoaded.value = false);
};
</script>

<template>
  <div class='h-full p-4'>
    <form @submit.prevent='handleSubmit' class='flex flex-col gap-4'>
      <TextInput
        id='pseudo'
        type='text'
        label='Pseudo'
        :disabled='isLoaded'
        v-model='form.pseudo'
      />
      <TextInput
        id='username'
        type='text'
        label='Username'
        :disabled='isLoaded'
        required
        v-model='form.username'
      />
      <TextInput
        id='email'
        type='email'
        label='E-Mail'
        :disabled='isLoaded'
        required
        v-model='form.email'
      />
      <RoundedButton
        text='Sauvegarder'
        :loading='false'
      >Sauvegarder</RoundedButton>
    </form>
  </div>
</template>