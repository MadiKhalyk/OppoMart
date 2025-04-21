<template>
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-75 isotope-item" :class="product.categories">
        <div class="block1">
            <div class="block1-bg wrap-pic-w bo-all-1 bocl12 hov3 trans-04">
                <img :src="'/storage/' + product.poster" :alt="product.title" />

                <div class="block1-content flex-col-c-m p-b-46">
                    <a href="product-single.html" class="txt-m-103 cl3 txt-center hov-cl10 trans-04">
                        {{ product.title }}
                        <span v-if="product.unit">({{ product.unit }})</span>
                    </a>

                    <span class="block1-content-more txt-m-104 cl9 p-t-21 trans-04">
            {{ product.price }} тг
          </span>

                    <div class="block1-wrap-icon flex-c-m flex-w trans-05">
                        <template v-if="productInCart">
                            <button @click="decreaseQuantity" class="btn btn-sm btn-outline-dark">-</button>
                            <span class="mx-2">{{ productInCart.quantity }}</span>
                            <button @click="increaseQuantity" class="btn btn-sm btn-outline-dark">+</button>
                        </template>
                        <template v-else>
                            <a href="#" class="block1-icon flex-c-m wrap-pic-max-w" @click.prevent="addToCart">
                                <img src="/assets/images/icons/icon-cart.png" alt="Add to Cart" />
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from "vue";
import { useCartStore } from '@/stores/cart';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const cart = useCartStore();

const productInCart = computed(() =>
    cart.items.find(item => item.id === props.product.id)
);

const addToCart = () => {
    const item = {
        id: props.product.id,
        title: props.product.unit ? `${props.product.title} (${props.product.unit})` : props.product.title,
        price: props.product.price,
        poster: props.product.poster,
        quantity: 1
    };

    cart.add(item);
    console.log(`${item.title} себетке қосылды`);
};

const increaseQuantity = () => {
    cart.increase(props.product.id);
};

const decreaseQuantity = () => {
    cart.decrease(props.product.id);
};
</script>
