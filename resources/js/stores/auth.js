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

        return await axios.post('auth/login', formData)
            .then((rep) => {
                user.value = rep.data.user;
                this.router.push('/');
            })
            .catch((err) => err.response?.data)
    }

    function $reset() {
        user.value = null;
    }

    return {
        user,
        getCSRFToken,
        isAuthenticate,
        handleLogin,
        $reset
    }
});

// state: () => ({
//     authUser: null,
// }),
// getters: {
//     user: (state) => state.authUser,
//     isLoggin: (state) => !!state.authUser
// },
// actions:  {
//     async getToken() {
//         await axios.get('/sanctum/csrf-cookie');
//     },
//     async getUser() {
//         return await axios.get('api/users/@me')
//             .then((rep) => this.authUser = rep.data.data)
//             .catch(() => {
//                 this.authUser = null
//                 this.router.push('/login');
//             });
//     },
//     async handleLogin(data) {
//         await this.getToken().then(async () => {
//             const rep = await axios.post('/auth/login', data);
            
//             this.authUser = rep.data;

//             this.router.push('/');
//         });
//     },
//     async handleRegister(data) {
//         await this.getToken().then(async () => {
//             const rep = await axios.post('/auth/register', data);
            
//             this.authUser = rep.data;

//             this.router.push('/');
//         });
//     },
//     async handleLogout() {
//         await axios.post('/auth/logout');
//         this.authUser = null;
//         this.router.push('/login');
//         this.$reset();
//     },
//     async handleSendVerificationEmail() {
//         return await axios.post('/auth/email/verification');
//     },
//     async getDevices() {
//         return (await axios.get('/api/devices')).data.devices;
//     },
//     async revokeSession(sessionId) {
//         return await axios.post('/auth/logout', {
//             session_token: sessionId
//         });
//     }
// },