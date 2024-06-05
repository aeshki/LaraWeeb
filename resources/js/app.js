import '@/axios';

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

createApp(Root)
  .use(router)
  .use(pinia)
  .mount('#app');