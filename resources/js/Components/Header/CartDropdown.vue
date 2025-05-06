<script setup>
import {useCartStore} from '@/stores/cart';
import {ref} from 'vue';
import {onMounted, onBeforeUnmount} from 'vue';

const cartRef = ref(null);

const handleClickOutside = (event) => {
    if (cartRef.value && !cartRef.value.contains(event.target)) {
        cartOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

const cart = useCartStore();
const cartOpen = ref(false);

const toggleCart = () => {
    cartOpen.value = !cartOpen.value;
};
</script>

<template>
    <div class="wrap-cart-header" ref="cartRef">
        <div @click="toggleCart" class="icon-header-item">
            <img src="/assets/images/icons/icon-cart-2.png" alt="CART"/>
            <span v-if="cart.count > 0" class="badge">{{ cart.count }}</span>
        </div>

        <div v-if="cartOpen" class="cart-header">
            <div v-for="item in cart.items" :key="item.id" class="cart-item">
                <img class="product-img" :src="'/storage/' + item.poster" :alt="item.title"/>
                <div class="product-text">
                    <p>{{ item.title }}</p>
                    <p>{{ item.price }}тг x {{ item.quantity }} {{ item.unit || 'шт' }}</p>
                    <div class="quantity-controls">
                        <button @click="cart.decrease(item.id)">−</button>
                        <span>{{ item.quantity }}</span>
                        <button @click="cart.increase(item.id)">+</button>
                    </div>
                </div>
            </div>
            <div class="cart-footer">
                <p>Итого: {{ cart.total }}тг</p>
                <router-link
                    to="/checkout"
                    class="btn-main flex-c-m size-a-8 bg10 txt-s-105 cl13 hov-btn2 trans-04 btn-checkout"
                >
                    Оформить заказ
                </router-link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.cart-header {
    transform: scale(1);
}

.product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.btn-main {
    background-color: #eb7514;
}

.product-text {
    font-size: 12px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
}

.quantity-controls button {
    width: 24px;
    height: 24px;
    border: none;
    background-color: #ccc;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}
</style>
