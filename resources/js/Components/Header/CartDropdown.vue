<script setup>
import { ref } from 'vue';

const cartOpen = ref(false);
const cartItems = [
    { name: 'Cheery', price: 18, quantity: 2, img: '/assets/images/item-cart-01.jpg' },
    { name: 'Asparagus', price: 12, quantity: 1, img: '/assets/images/item-cart-02.jpg' }
];

const toggleCart = () => {
    cartOpen.value = !cartOpen.value;
};
</script>

<template>
    <div class="wrap-cart-header">
        <div @click="toggleCart" class="icon-header-item">
            <img src="/assets/images/icons/icon-cart-2.png" alt="CART" />
        </div>

        <div v-if="cartOpen" class="cart-header">
            <div v-for="item in cartItems" :key="item.name" class="cart-item">
                <img :src="item.img" :alt="item.name" />
                <div>
                    <p>{{ item.name }}</p>
                    <p>{{ item.price }}$ x{{ item.quantity }}</p>
                </div>
            </div>
            <div class="cart-footer">
                <p>Total: {{ cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0) }}$</p>
                <a href="checkout.html">Check Out</a>
            </div>
        </div>
    </div>
</template>
