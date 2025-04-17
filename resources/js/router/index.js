// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/Pages/Home.vue';
import Checkout from '@/Pages/Checkout.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/checkout',
        name: 'checkout',
        component: Checkout
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
