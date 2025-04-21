<template>
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-30 isotope-item" :class="product.categories">
        <div class="product-card border rounded p-2">
            <!-- Сурет -->
            <div class="product-image">
                <img
                    :src="'/storage/' + product.poster"
                    :alt="product.title"
                    class="img-fluid"
                    style="width: 100px; height: 100px; object-fit: cover;"
                />
            </div>

            <!-- Ақпарат -->
            <div class="product-info">
                <div>
                    <a href="#" class="txt-m-103 cl3 d-block text-truncate mt-2">
                        {{ product.title }}
                        <span v-if="product.unit">({{ product.unit }})</span>
                    </a>
                    <div class="text-muted small mb-2">{{ product.price }} тг</div>
                    <span>{{product.description}}</span>
                </div>
                <!-- Себет -->
                <div>
                    <template v-if="productInCart">
                        <button @click="decreaseQuantity" class="btn btn-sm btn-outline-dark">-</button>
                        <span class="mx-2">{{ productInCart.quantity }}</span>
                        <button @click="increaseQuantity" class="btn btn-sm btn-outline-dark">+</button>
                    </template>
                    <template v-else>
                        <button @click.prevent="addToCart" class="btn btn-sm btn-main cl13">
                            В корзину
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from "vue";
import { useCartStore } from "@/stores/cart";

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
};

const increaseQuantity = () => {
    cart.increase(props.product.id);
};

const decreaseQuantity = () => {
    cart.decrease(props.product.id);
};
</script>

<style scoped>
.btn-main{
    background-color: #EB7514;
}

.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}


@media (max-width: 768px) {
    .product-info{
        display: flex;
        gap: 20px;
        justify-content: end;
        align-items: center;
    }
    .product-card {
        flex-direction: row;
        text-align: left;
    }

    .product-image {
        margin-right: 12px;
    }

    .product-info {
        text-align: center;
        flex: 1;
        margin-right: 15px
    }

    .product-info a {
        font-size: 14px;
    }

    .product-info .btn {
        padding: 2px 6px;
        font-size: 12px;
    }
}
</style>
