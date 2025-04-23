import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import Vue3TouchEvents from 'vue3-touch-events';


const app = createApp(App);

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

app.use(router);
app.use(Vue3TouchEvents);
app.use(pinia);

app.mount('#app');
