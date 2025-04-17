<template>
    <div class="sec-product bg0 p-t-145 p-b-25">
        <div class="container">
            <div class="size-a-1 flex-col-c-m p-b-48">
                <div class="txt-center txt-m-201 cl10 how-pos1-parent m-b-14">
                    Featured Products
                    <div class="how-pos1">
                        <img src="/assets/images/icons/symbol-02.png" alt="IMG" />
                    </div>
                </div>
                <h3 class="txt-center txt-l-101 cl3 respon1">Our products</h3>
            </div>

            <div class="p-b-46">
                <div class="flex-w flex-c-m filter-tope-group">
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        class="txt-m-104 cl9 hov2 trans-04 p-rl-27 p-b-10"
                        :class="{ 'how-active1': activeCategory === category.id }"
                        @click="filterProducts(category.id)"
                    >
                        {{ category.title }}
                    </button>
                </div>
            </div>

            <div class="row isotope-grid">
                <ProductCard
                    v-for="product in filteredProducts"
                    :key="product.id"
                    :product="product"
                />
            </div>

            <div v-if="loading" class="text-center p-t-20">Loading...</div>
            <div v-if="error" class="text-center p-t-20 text-danger">{{ error }}</div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import ProductCard from "./ProductCard.vue";

const activeCategory = ref("*");
const products = ref([]);
const categories = ref([{ id: "*", title: "All Products" }]);
const loading = ref(false);
const error = ref(null);

const fetchData = async () => {
    loading.value = true;
    try {
        const response = await axios.get("http://opto-market.test//api/products");

        // Өнімдерді API-дан алу
        products.value = response.data.products.map(product => ({
            ...product,
            category: product.category || { id: null, title: "Unknown" } // Егер category жоқ болса, placeholder қосамыз
        }));

        // Категорияларды API-дан алу
        categories.value = [{ id: "*", title: "All Products" }, ...response.data.categories];

    } catch (err) {
        error.value = "Failed to load products.";
    } finally {
        loading.value = false;
    }
};

const filteredProducts = computed(() => {
    if (activeCategory.value === "*") {
        return products.value;
    }
    console.log(activeCategory.value)
    return products.value.filter(product => product.category && product.category.id === activeCategory.value);
});

const filterProducts = (categoryId) => {
    activeCategory.value = categoryId;
};

onMounted(fetchData);
</script>
