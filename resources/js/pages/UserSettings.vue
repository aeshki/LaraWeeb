<!-- <script setup>
import { RoundedButton, AreaInput, TextInput, FileInput, SwitchInput } from '@/components/common';
import { ref, reactive, watch } from 'vue';
import { useAuthStore } from '@/stores/auth';
import UserAvatar from '../components/user/UserAvatar.vue';
import UserBanner from '../components/user/UserBanner.vue';

const authStore = useAuthStore();

const isLoaded = ref(false);
const form = reactive({
  avatar: authStore.user.avatar,
  banner: authStore.user.banner,
  banner_color: authStore.user.banner_color,
  pseudo: authStore.user.pseudo,
  username: authStore.user.username,
  bio: authStore.user.bio,
  email: authStore.user.email,
  favorite_anime: authStore.user.favorite_anime,
  favorite_manga: authStore.user.favorite_manga,
  favorite_webtoon: authStore.user.favorite_webtoon,
  is_private: authStore.user.is_private,
});

const avatarPreview = ref(null);
const bannerPreview = ref(null);

watch(() => form.avatar, (avatar) => {
  if (avatar instanceof File) {
    previewImage(avatar, avatarPreview);
  }
});

watch(() => form.banner, (banner) => {
  if (banner instanceof File) {
    previewImage(banner, bannerPreview);
  }
});

const handleSubmit = () => {
  isLoaded.value = true;
  authStore.updateUser(form)
    .finally(() => isLoaded.value = false);
};

const previewImage = (file, ref) => {
  const reader = new FileReader();

  reader.onload = (e) => {
    ref.value = e.target.result;
  };

  reader.readAsDataURL(file);
};

const handleRemoveAvatar = () => {
  if (avatarPreview.value) {
    avatarPreview.value = null;
    form.avatar = authStore.user.avatar;
  } else {
    form.avatar = form.avatar ? null : authStore.user.avatar;
  }
};

const handleRemoveBanner = () => {
  if (bannerPreview.value) {
    bannerPreview.value = null;
    form.banner = authStore.user.banner;
  } else {
    form.banner = form.banner ? null : authStore.user.banner;
  }
};
</script>

<template>
  <div class='flex flex-col gap-4 p-4'>
    <form @submit.prevent='handleSubmit' class='flex flex-col gap-4'>
      <div class='flex flex-col gap-3'>
        <label class='font-semibold uppercase text-sm'>Bannière</label>

        <UserBanner
          :banner='form.banner === authStore.user.banner ? form.banner : null'
          :absoluteBannerPath='bannerPreview'
          :bannerColor='form.banner_color'
        />

        <div class='flex flex-col mobileLarge:flex-row mobileLarge:items-center gap-2'>
          <FileInput
            id='banner'
            :label='form.banner ? "Changer de bannière" : "Ajouter une bannière"'
            v-model='form.banner'
          />

          <RoundedButton
            :text="bannerPreview ? `Revenir à la bannière de base` : form.banner === authStore.user.banner ? `Supprimer la bannière` : 'Remettre la bannière'"
            @click.prevent='handleRemoveBanner'
          />
        </div>
      </div>

      <div class='flex flex-col gap-3'>
        <label class='font-semibold uppercase text-sm'>Avatar</label>

        <div class='flex gap-3'>
          <UserAvatar
            :size='64'
            :path='form.avatar === authStore.user.avatar ? form.avatar : null'
            :absolutePath='avatarPreview'
            :username='form.username'
          />

          <div class='flex flex-col mobileLarge:flex-row mobileLarge:items-center gap-2'>
            <FileInput
              id='avatar'
              :label="form.avatar ? `Changer d'avatar` : 'Ajouter un avatar'"
              v-model='form.avatar'
            />

            <RoundedButton
              :text="avatarPreview ? `Revenir à l'avatar de base` : form.avatar === authStore.user.avatar ? `Supprimer l'avatar` : `Remettre l'avatar`"
              @click.prevent='handleRemoveAvatar'
            />
          </div>
        </div>
      </div>

      <TextInput id='pseudo' label='Pseudo' :disabled='isLoaded' v-model='form.pseudo' />
      <TextInput id='username' label='Username' :disabled='isLoaded' required v-model='form.username' />
      <AreaInput id='Bio' label='Bio' :disabled='isLoaded' v-model='form.bio' />
      <TextInput id='email' type='email' label='E-Mail' :disabled='isLoaded' required v-model='form.email' />
      <TextInput id='favorite_anime' label='Favorite anime' :disabled='isLoaded' v-model='form.favorite_anime' />
      <TextInput id='favorite_manga' label='Favorite manga' :disabled='isLoaded' v-model='form.favorite_manga' />
      <TextInput id='favorite_webtoon' label='Favorite webtoon' :disabled='isLoaded' v-model='form.favorite_webtoon' />
      <SwitchInput id='is_private' label='Profil Private' :disabled='isLoaded' v-model='form.is_private' />
      
      <RoundedButton text='Sauvegarder' :loading='isLoaded' />
    </form>
    <div class='flex gap-2'>
      <RoundedButton text='Logout' @click='() => authStore.handleLogout()' />
      <RoundedButton text='Delete account' @click='() => authStore.handleDeleteAccount()' />
    </div>
  </div>
</template> -->
