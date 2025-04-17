<script setup>
import { useCartStore } from '@/stores/cart';
import { ref } from 'vue';

const cart = useCartStore(); // Pinia store-ды қолданамыз
const cartOpen = ref(false);

const toggleCart = () => {
    cartOpen.value = !cartOpen.value;
};
</script>

<template>
    <div class="wrap-cart-header">
        <div @click="toggleCart" class="icon-header-item">
            <img src="/assets/images/icons/icon-cart-2.png" alt="CART" />
            <span v-if="cart.count > 0" class="badge">{{ cart.count }}</span>
        </div>

        <div v-if="cartOpen" class="cart-header">
            <div v-for="item in cart.items" :key="item.id" class="cart-item">
                <img :src="'/storage/' + item.poster" :alt="item.title" />
                <div>
                    <p>{{ item.title }}</p>
                    <p>{{ item.price }}$ x{{ item.quantity }}</p>
                </div>
            </div>
            <div class="cart-footer">
                <p>Total: {{ cart.total }}$</p>
                <router-link сlass="flex-c-m size-a-8 bg10 txt-s-105 cl13 hov-btn2 trans-04" to="/checkout" class="btn-checkout">Check Out</router-link>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .cart-header{
        transform: scale(1);
    }
</style>
