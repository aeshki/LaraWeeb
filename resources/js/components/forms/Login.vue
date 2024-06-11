<script setup>
import NoticeForm from '@/components/NoticeForm.vue';
import TextInput from '@/components/TextInput.vue';
import Button from '@/components/Button.vue';

import { useAuthStore } from '@/stores/auth';
import { reactive, ref } from 'vue';

const authStore = useAuthStore();

const isLoaded = ref(false);
const errors = ref({});
const form = reactive({
    email: '',
    password: ''
});

const submit = () => {
    errors.value = {};

    isLoaded.value = true;

    authStore.handleLogin(form)
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
            <h1 class='text-3xl'>Ha, te revoilà !</h1>
            <p>Nous sommes si heureux de te revoir parmis nous !</p>
        </hgroup>
            
        <div class='flex flex-col gap-6'>
            <div class='flex flex-col gap-3'>
                <TextInput
                    id='email'
                    type='email'
                    label='E-Mail'
                    required
                    :disabled='isLoaded'
                    :hasError='errors.email || errors.global'
                    v-model='form.email'
                />
                <NoticeForm
                    v-if='errors.email'
                    :message='errors.email[0]'
                />
            </div>

            <div>
                <TextInput
                    id='password'
                    type='password'
                    label='Mot de passe'
                    required
                    :disabled='isLoaded'
                    :hasError='errors.password || errors.global'
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
            <Button :loading='isLoaded' text='Connexion' />
            <span class='font-medium text-zinc-800'>Besoin d'un compte ? <RouterLink to='/auth/register'>S'inscrire</RouterLink></span>
        </div>
    </form>
</template>