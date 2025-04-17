<script setup>
import { onMounted } from 'vue';
import TheHeader from './Components/Header/Header.vue';
import Product from './Components/Product/FeaturedProducts.vue';

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const phone = urlParams.get('p');

    if (phone) {
        localStorage.setItem('client_phone', phone);
        console.log('Сақталған номер:', phone);
    }
});
</script>

<template>
    <div>
        <router-view></router-view>
    </div>
</template>
