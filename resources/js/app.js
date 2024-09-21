import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate  from 'pinia-plugin-persistedstate';
import router from './router';

import Root from '@/Root.vue';

const pinia = createPinia().use(piniaPluginPersistedstate);

createApp(Root)
  .use(router)
  .use(pinia)
  .mount('#app');