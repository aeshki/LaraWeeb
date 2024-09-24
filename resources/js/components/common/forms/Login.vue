<script setup>
import useAxios from '@/utils/useAxios';
import { useRouter } from  'vue-router';

import { DefaultButton } from '@/components/common/buttons';
import { TextInput } from '@/components/common/inputs';

import { useAuthStore } from '@/stores/auth';
import { reactive } from 'vue';
import BaseForm from './BaseForm.vue';

const authStore = useAuthStore();
const router = useRouter();

const form = reactive({
    email: '',
    password: ''
});

const { loading, errors, fetchRequest, onFulfilled } = useAxios('/auth/login', {
        method: 'POST',
        deferred: true,
        data: form
    });

onFulfilled((data) => {
    authStore.setUser(data.value.user);
    router.push('/');
});

const handleForgotPassword = () => {
    const { onFulfilled } = useAxios('/auth/password/forgot', {
        method: 'POST',
        data: { email: form.email }
    });

    onFulfilled(() => {
        form.email = '';
        form.password = '';
    });
}
</script>

<template>
    <BaseForm
        class='form-authenticate'
        @submit.prevent="() => fetchRequest()"
    >
        <template #header>
            <hgroup>
                <h1 class='text-3xl'>Ha, te revoilà !</h1>
                <p>Nous sommes si heureux de te revoir parmis nous !</p>
            </hgroup>
        </template>
            
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

        <span
            v-if='form.email?.includes("@") && errors.global'
            class='text-indigo-600 text-shadow-indigo-300 cursor-pointer'
            @click='handleForgotPassword'
        >Mot de passe oublié ?</span>

        <template #footer>
            <DefaultButton :loading='loading' text='Connexion' />
            <span class='font-medium'>Besoin d'un compte ? <RouterLink to='/auth/register'>S'inscrire</RouterLink></span>
        </template>
    </BaseForm>
</template>