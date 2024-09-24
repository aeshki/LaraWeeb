<script setup>
import { reactive } from 'vue';
import { useRouter } from  'vue-router';

import useAxios from '@/utils/useAxios';

import { DefaultButton } from '@/components/common/buttons';
import { TextInput } from '@/components/common/inputs';

import { useAuthStore } from '@/stores/auth';
import BaseForm from './BaseForm.vue';
import { useRoute } from 'vue-router';

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();

if (!route.query.email || !route.query.token) {
    router.push('/');
}

const form = reactive({
    token: route.query.token,
    email: route.query.email,
    password: '',
    password_confirmation: '',
});

const { loading, errors, fetchRequest, onFulfilled } = useAxios('/auth/password/reset', {
        method: 'POST',
        deferred: true,
        data: form
    });

onFulfilled(() => router.push('/'));
</script>

<template>
    <BaseForm
        class='form-authenticate'
        @submit.prevent="() => fetchRequest()"
    >
        <template #header>
            <hgroup>
                <h1 class='text-3xl'>Réinitialisation du mot de passe</h1>
            </hgroup>
        </template>

        <TextInput
            id='password'
            type='password'
            label='Mot de passe'
            required
            :disabled='loading'
            :error='errors.global'
            v-model='form.password'
        />

        <TextInput
            id='password'
            type='password'
            label='Confirmation du mot de passe'
            required
            :disabled='loading'
            :error='errors.global'
            v-model='form.password_confirmation'
        />

        <template #footer>
            <DefaultButton :loading='loading' text='Continuer' />
        </template>
    </BaseForm>
</template>