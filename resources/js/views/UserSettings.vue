<script setup>
import { RoundedButton, AreaInput, TextInput, FileInput, SwitchInput } from '@/components/common';

import { ref, reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';
import useAxios from '@/utils/useAxios';

const authStore = useAuthStore();

const isLoaded = ref(false);
const form = reactive({
  avatar: authStore.user.avatar,
  pseudo: authStore.user.pseudo,
  username: authStore.user.username,
  bio: authStore.user.bio,
  email: authStore.user.email,
  favorite_anime: authStore.user.favorite_anime,
  favorite_manga: authStore.user.favorite_manga,
  favorite_webtoon: authStore.user.favorite_webtoon,
  is_private: authStore.user.is_private
});

const handleSubmit = () => {
  isLoaded.value = true;

  authStore.updateUser(form)
    .finally(() => isLoaded.value = false);
};

const handleFileChanged = (file) => {
  if (file) {
    form.avatar = file;
  }
}
</script>

<template>
  <div class='flex flex-col gap-4 p-4'>
    <form @submit.prevent='handleSubmit' class='flex flex-col gap-4'>
      <FileInput
        id='avatar'
        @change='handleFileChanged'
      />

      <RoundedButton
        v-if='form.avatar'
        text='Supprimer'
        @click.prevent='() => form.avatar = null'
      />

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

      <SwitchInput
        id='is_private'
        label='Profil Private'
        :disabled='isLoaded'
        v-model='form.is_private'
      />
      
      <RoundedButton
        text='Sauvegarder'
        :loading='false'
      />
    </form>
    <div class='flex gap-2'>
      <RoundedButton text='Logout' @click='() => authStore.handleLogout()' />
      <RoundedButton text='Delete account' @click='() => authStore.handleDeleteAccount()' />
    </div>
  </div>
</template>