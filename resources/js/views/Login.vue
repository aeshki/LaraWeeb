<script setup>
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
        .then((err) => errors.value = err.errors ?? {})
        .finally(() => isLoaded.value = false);
};

const AllWallpapers = [
    'https://images3.alphacoders.com/132/thumb-1920-1322308.jpeg',
    'https://images7.alphacoders.com/736/thumb-1920-736462.png',
    'https://images4.alphacoders.com/133/thumb-1920-1336938.jpeg',
    'https://images7.alphacoders.com/133/thumb-1920-1330380.jpeg',
    'https://images3.alphacoders.com/131/thumb-1920-1319293.jpeg',
    'https://images7.alphacoders.com/325/thumb-1920-325547.jpg'
];

const wallpaper = reactive({
    backgroundImage: `url(${AllWallpapers[Math.floor(Math.random() * AllWallpapers.length)]})`,
    backgroundRepeat: 'no-repeat',
    backgroundSize: 'cover'
});
</script>

<template>
    <main class="relative bg-slate-50 h-full flex flex-center">
        <form
            class='flex flex-col gap-8 bg-zinc-100 px-10 py-9 rounded-2xl shadow-2xl z-10'
            @submit.prevent="submit"
        >
            <hgroup>
                <h1 class='text-3xl'>Ha, te revoilà !</h1>
                <p>Nous sommes si heureux de te revoir !</p>
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
                    <p
                        class='text-red-400 border-2 border-red-400 bg-red-100 p-1 rounded-md shadow-sm'
                        v-if="errors.email"
                    >
                        {{ errors.email[0] }}
                    </p>
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
                    <span
                        class='text-red-400 border-2 border-red-400 bg-red-100 p-1 rounded-md shadow-sm'
                        v-if="errors.password"
                    >
                        {{ errors.password[0] }}
                    </span>
                </div>
            </div>

            <div class='flex flex-col gap-3'>
                <Button :loading='isLoaded' text='Connexion' />
                <span class='font-medium text-zinc-800'>Besoin d'un compte ? <RouterLink to='/register'>S'inscrire</RouterLink></span>
            </div>
        </form>
        <div class='absolute top-0 left-0 h-full w-full brightness-[.8]' :style='wallpaper'></div>
    </main>
</template>