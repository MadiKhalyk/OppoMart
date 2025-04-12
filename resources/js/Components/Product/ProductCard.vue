<template>
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-75 isotope-item" :class="product.categories">
        <div class="block1">
            <div class="block1-bg wrap-pic-w bo-all-1 bocl12 hov3 trans-04">
                <img :src="'/storage/' + product.poster" :alt="product.title" />

                <div class="block1-content flex-col-c-m p-b-46">
                    <a href="product-single.html" class="txt-m-103 cl3 txt-center hov-cl10 trans-04">
                        {{ product.title }}
                    </a>

                    <span class="block1-content-more txt-m-104 cl9 p-t-21 trans-04">
            {{ product.price }}$
          </span>

                    <div class="block1-wrap-icon flex-c-m flex-w trans-05">
                        <a href="product-single.html" class="block1-icon flex-c-m wrap-pic-max-w">
                            <img :src="product.poster" alt="View" />
                        </a>

                        <a href="#" class="block1-icon flex-c-m wrap-pic-max-w" @click.prevent="addToCart">
                            <img src="/assets/images/icons/icon-cart.png" alt="Add to Cart" />
                        </a>

                        <a href="wishlist.html" class="block1-icon flex-c-m wrap-pic-max-w" @click.prevent="addToWishlist">
                            <img class="icon-addwish-b1" src="/assets/images/icons/icon-heart.png" alt="Add to Wishlist" />
                            <img class="icon-addedwish-b1" src="/assets/images/icons/icon-heart2.png" alt="Added to Wishlist" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const addToCart = () => {
    console.log(`${props.product.name} себетке қосылды`);
};

const addToWishlist = () => {
    console.log(`${props.product.name} тілектер тізіміне қосылды`);
};
</script>
