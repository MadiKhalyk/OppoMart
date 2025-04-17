<script setup>
import { cart } from '@/stores/cart';

const removeItem = (id) => {
    cart.remove(id);
};

const submitOrder = () => {
    console.log('Тапсырыс жасалды:', cart.items);
    cart.clear();
};
</script>

<template>
    <div class="container p-t-100">
        <h2 class="txt-center">Себет</h2>
        <div v-if="cart.items.length === 0" class="txt-center p-t-20">
            Себет бос
        </div>

        <div v-else>
            <div v-for="item in cart.items" :key="item.id" class="p-b-20">
                <div>{{ item.title }} ({{ item.quantity }}) - {{ item.price * item.quantity }} ₸</div>
                <button @click="removeItem(item.id)">Жою</button>
            </div>

            <div class="p-t-20">
                <strong>Жалпы: {{ cart.total() }} ₸</strong>
            </div>

            <button @click="submitOrder" class="btn btn-success m-t-20">Тапсырыс беру</button>
        </div>
    </div>
</template>
