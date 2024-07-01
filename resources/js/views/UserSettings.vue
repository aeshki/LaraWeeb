<script setup>
import { RoundedButton, AreaInput, TextInput } from '@/components/common';

import { ref, reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

const isLoaded = ref(false);
const form = reactive({
  pseudo: authStore.user.pseudo,
  username: authStore.user.username,
  bio: authStore.user.bio,
  email: authStore.user.email,
  favorite_anime: authStore.user.favorite_anime,
  favorite_manga: authStore.user.favorite_manga,
  favorite_webtoon: authStore.user.favorite_webtoon
});

const handleSubmit = () => {
  isLoaded.value = true;

  authStore.updateUser(form)
    .finally(() => isLoaded.value = false);
};
</script>

<template>
  <div class='p-4'>
    <form @submit.prevent='handleSubmit' class='flex flex-col gap-4'>
      <TextInput
        id='pseudo'
        label='Pseudo'
        :disabled='isLoaded'
        v-model='form.pseudo'
      />

      <TextInput
        id='username'
        label='Username'
        :disabled='isLoaded'
        required
        v-model='form.username'
      />

      <AreaInput
        id='Bio'
        label='Bio'
        :disabled='isLoaded'
        v-model='form.bio'
      />

      <TextInput
        id='email'
        type='email'
        label='E-Mail'
        :disabled='isLoaded'
        required
        v-model='form.email'
      />

      <TextInput
        id='favorite_anime'
        label='Favorite anime'
        :disabled='isLoaded'
        v-model='form.favorite_anime'
      />

      <TextInput
        id='favorite_manga'
        label='Favorite manga'
        :disabled='isLoaded'
        v-model='form.favorite_manga'
      />

      <TextInput
        id='favorite_webtoon'
        label='Favorite webtoon'
        :disabled='isLoaded'
        v-model='form.favorite_webtoon'
      />
      
      <RoundedButton
        text='Sauvegarder'
        :loading='false'
      >Sauvegarder</RoundedButton>
    </form>
  </div>
</template>