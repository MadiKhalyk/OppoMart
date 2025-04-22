<template>
    <div class="sec-product bg0 p-t-10 p-b-10">
        <div class="container">
<!--            <div class="size-a-1 flex-col-c-m p-b-48">-->
<!--                <div class="txt-center txt-m-201 cl10 how-pos1-parent m-b-14">-->
<!--                    Популярные товары-->
<!--                    <div class="how-pos1">-->
<!--                        <img src="/assets/images/icons/symbol-02.png" alt="IMG" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h3 class="txt-center txt-l-101 cl3 respon1">Наши продукты</h3>-->
<!--            </div>-->

            <div class="p-b-46">
                <div
                    class="filter-scroll d-flex gap-2 overflow-auto pb-2"
                    style="white-space: nowrap"
                >
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        class="txt-m-104 cl-green hov2 trans-04 p-rl-27 p-b-10 border-0 bg-transparent"
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

            <div v-if="loading" class="text-center p-t-20">Загрузка...</div>
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
const categories = ref([{ id: "*", title: "Все" }]);
const loading = ref(false);
const error = ref(null);

const fetchData = async () => {
    loading.value = true;
    try {
        const response = await axios.get("/api/products");

        products.value = response.data.products.map(product => ({
            ...product,
            category: product.category || { id: null, title: "Unknown" }
        }));


        categories.value = [{ id: "*", title: "Все" }, ...response.data.categories];

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

<style>
.filter-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    padding-bottom: 8px;
    -webkit-overflow-scrolling: touch;
}

.filter-scroll::-webkit-scrollbar {
    height: 6px;
}

.filter-scroll::-webkit-scrollbar-thumb {
    background: #2e7d32;
    border-radius: 10px;
}

.cl-green {
    color: #2e7d32 !important;
}

.how-active1 {
    font-weight: bold;
    border-bottom: 2px solid #2e7d32;
}
</style>
