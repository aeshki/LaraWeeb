<script setup>
import NoticeForm from '@/components/common/NoticeForm.vue';
import { DefaultButton, TextInput } from '@/components/common';

import { useAuthStore } from '@/stores/auth';
import { reactive, ref } from 'vue';

const authStore = useAuthStore();

const isLoaded = ref(false);
const errors = ref({});
const form = reactive({
    email: '',
    username: '',
    pseudo: '',
    password: ''
});

const submit = () => {
    errors.value = {};

    isLoaded.value = true;

    authStore.handleRegister(form)
        .then((err) => errors.value = err?.errors ?? {})
        .finally(() => isLoaded.value = false);
};
</script>

<template>
    <form
        class='form-authenticate'
        @submit.prevent="submit"
    >
        <hgroup class='flex flex-col gap-2'>
            <h1 class='text-3xl'>Bienvenue !</h1>
            <p>Nous sommes heureux que tu nous rejoignent sur LaraWeeb !</p>
        </hgroup>
            
        <div class='flex flex-col gap-6'>
            <div class='flex flex-col gap-3'>
                <TextInput
                    id='email'
                    type='email'
                    label='E-Mail'
                    required
                    :disabled='isLoaded'
                    :hasError='errors.email'
                    v-model='form.email'
                />
                <NoticeForm
                    v-if='errors.email'
                    :message='errors.email[0]'
                />
            </div>

            <div class='flex flex-col gap-3'>
                <TextInput
                    id='username'
                    type='text'
                    label="Nom d'utilisateur"
                    required
                    :disabled='isLoaded'
                    :hasError='errors.username'
                    v-model='form.username'
                />
                <NoticeForm
                    v-if='errors.username'
                    :message='errors.username[0]'
                />
            </div>

            <div class='flex flex-col gap-3'>
                <TextInput
                    id='pseudo'
                    type='text'
                    label="Nom d'affichage"
                    :disabled='isLoaded'
                    :hasError='errors.pseudo'
                    v-model='form.pseudo'
                />
                <NoticeForm
                    v-if='errors.pseudo'
                    :message='errors.pseudo[0]'
                />
            </div>

            <div>
                <TextInput
                    id='password'
                    type='password'
                    label='Mot de passe'
                    required
                    :disabled='isLoaded'
                    :hasError='errors.password'
                    v-model='form.password'
                />
                <NoticeForm
                    v-if='errors.password'
                    :message='errors.password[0]'
                />
            </div>
            <NoticeForm
                v-if='errors.global'
                :message='errors.global'
            />
        </div>

        <div class='flex flex-col gap-3'>
            <DefaultButton :loading='isLoaded' text='Continuer' />
            <span class='font-medium'>Déjà un compte ? <RouterLink to='/auth/login'>Se connecter</RouterLink></span>
        </div>
    </form>
</template>