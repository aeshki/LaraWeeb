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

    async function handleDeleteAccount() {
        return await axios.delete(`/api/users/${user.value.id}`).then(() => {
            $reset();
            this.router.push('/auth/login');
        });
    }

    async function updateUser(data) {
        let formData = new FormData();

        formData.set('_method', 'PATCH');

        Object.entries(data).forEach(data => {
            data[1] ??= '';

            if ((data[0] === 'avatar' || data[0] === 'banner') && !(data[1] instanceof File) && data[1]) {
                return
            } else if (typeof data[1] === 'boolean') {
                data[1] = +data[1]
            }

            formData.append(data[0], data[1]);
        })
        
        return await axios.post(`/api/users/${user.value.id}`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
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
        handleDeleteAccount,
        updateUser,
        $reset
    }
});