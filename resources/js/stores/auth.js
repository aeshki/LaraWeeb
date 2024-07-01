import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);

    async function getCSRFToken() {
        return await axios.get('/sanctum/csrf-cookie');
    };

    async function isAuthenticate() {
        if (!user.value) {
            return false;
        }

        const rep = await axios.get('/api/user')
            .catch((err) => err.response);
        
        const isOK = rep.status === 200;

        if (isOK) {
            user.value = rep.data;
        } else {
            $reset();
        }

        return isOK;
    }

    async function handleLogin(formData) {
        await getCSRFToken();

        return await axios.post('/auth/login', formData)
            .then((rep) => {
                user.value = rep.data.user;
                this.router.push('/');
            })
            .catch((err) => err.response?.data);
    }

    async function handleRegister(formData) {
        await getCSRFToken();

        return await axios.post('/auth/register', formData)
            .then((rep) => {
                user.value = rep.data.user;
                this.router.push('/');
            })
            .catch((err) => err.response?.data);
    }

    async function handleLogout() {
        return await axios.get('/auth/logout').then(() => {
            $reset();
            this.router.push('/auth/login');
        });
    }

    async function updateUser(formData) {
        console.log(formData)
        return await axios.patch(`/api/users/${user.value.id}`, formData)
            .then(() => {
                user.value = { ...user.value, ...formData };
                this.router.push(`/@${user.value.username}`)
            });
    }

    function $reset() {
        user.value = null;
    }

    return {
        user,
        getCSRFToken,
        isAuthenticate,
        handleLogin,
        handleRegister,
        handleLogout,
        updateUser,
        $reset
    }
});