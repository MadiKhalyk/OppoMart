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
                    <p>
                        {{ item.price }}тг x{{ item.quantity }}
                        {{ item.unit ? item.unit : 'шт' }}
                    </p>
                </div>
            </div>
            <div class="cart-footer">
                <p>Итого: {{ cart.total }}тг</p>
                <router-link
                    to="/checkout"
                    class="flex-c-m size-a-8 bg10 txt-s-105 cl13 hov-btn2 trans-04 btn-checkout"
                >
                    Оформить заказ
                </router-link>
            </div>
        </div>
    </div>
</template>


<style scoped>
    .cart-header{
        transform: scale(1);
    }
</style>
