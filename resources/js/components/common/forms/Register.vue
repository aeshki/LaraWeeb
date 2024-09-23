<script setup>
import { reactive } from 'vue';
import { useRouter } from  'vue-router';

import useAxios from '@/utils/useAxios';

import { DefaultButton } from '@/components/common/buttons';
import { TextInput } from '@/components/common/inputs';

import { useAuthStore } from '@/stores/auth';
import BaseForm from './BaseForm.vue';

const authStore = useAuthStore();
const router = useRouter();

const form = reactive({
    email: '',
    username: '',
    pseudo: '',
    password: ''
});

const { loading, errors, fetchRequest, onFulfilled } = useAxios('/auth/register', {
        method: 'POST',
        deferred: true,
        data: form
    });

onFulfilled((data) => {
    authStore.setUser(data.value.user);
    router.push('/');
});
</script>

<template>
    <BaseForm
        class='form-authenticate'
        @submit.prevent="() => fetchRequest()"
    >
        <template #header>
            <hgroup>
                <h1 class='text-3xl'>Bienvenue !</h1>
                <p>Nous sommes heureux que tu nous rejoignent sur LaraWeeb !</p>
            </hgroup>
        </template>
        
        <TextInput
            id='username'
            label="Nom d'utilisateur"
            required
            :disabled='loading'
            v-model='form.username'
        />

        <TextInput
            id='pseudo'
            label="Nom d'affichage"
            :disabled='loading'
            v-model='form.pseudo'
        />

        <TextInput
            id='email'
            type='email'
            label='E-Mail'
            required
            :disabled='loading'
            v-model='form.email'
        />

        <TextInput
            id='password'
            type='password'
            label='Mot de passe'
            required
            :disabled='loading'
            :error='errors.global'
            v-model='form.password'
        />

        <template #footer>
            <DefaultButton :loading='loading' text='Continuer' />
            <span class='font-medium'>Déjà un compte ?  <RouterLink to='/auth/login'>Se connecter</RouterLink></span>
        </template>
    </BaseForm>
</template>