import axios from 'axios';
window.axios = axios;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = '/';

import router from '@/router';
import { createPinia } from 'pinia';
import { createApp, markRaw } from 'vue';
import { createPersistedState } from 'pinia-plugin-persistedstate';

import Root from '@/Root.vue';

const pinia = createPinia()
  .use(createPersistedState({
    auto: true,
    key: (storeId) => `__persisted_${import.meta.env.VITE_APP_NAME}__${storeId}`
  }))
  .use(({ store }) => {
    store.router = markRaw(router)
  });

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
      navigator.serviceWorker.register('/service-worker.js')
          .then(registration => {
              console.log('Service worker registered with scope:', registration.scope);
          })
          .catch(error => {
              console.log('Service worker registration failed:', error);
          });
  });
}


createApp(Root)
  .use(router)
  .use(pinia)
  .mount('#app');