<template>
    <div class="sec-product bg0 p-t-10 p-b-10">
        <!-- swipe-контейнерге overflow және position қосылды -->
        <div class="swipe-container"
             v-touch:swipe="onSwipe"
        >
            <div class="container">
                <!-- Категориялар -->
                <div class="p-b-46">
                    <div class="filter-scroll d-flex gap-2 overflow-auto pb-2" style="white-space: nowrap">
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            class="txt-m-104 cl-green hov2 trans-04 p-rl-10 p-b-10 border-0 bg-transparent"
                            :class="{ 'how-active1': activeCategory === category.id }"
                            @click="filterProducts(category.id)"
                        >
                            {{ category.title }}
                        </button>
                    </div>
                </div>

                <!-- Өнімдер -->
                <div class="row isotope-grid">
                    <ProductCard
                        v-for="product in filteredProducts"
                        :key="product.id"
                        :product="product"
                    />
                </div>

                <!-- Жүктелуде -->
                <div v-if="loading" class="text-center p-t-20">Загрузка...</div>
                <div v-if="error" class="text-center p-t-20 text-danger">{{ error }}</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import ProductCard from "./ProductCard.vue";
import Vue3TouchEvents from 'vue3-touch-events';

const activeCategory = ref("*");
const products = ref([]);
const categories = ref([{ id: "*", title: "Все" }]);
const loading = ref(false);
const error = ref(null);

// Деректерді жүктеу
const fetchData = async () => {
    loading.value = true;
    try {
        const response = await axios.get("/api/products");

        products.value = response.data.products.map(product => ({
            ...product,
            category: product.category || { id: null, title: "Unknown" }
        }));

        // Категорияларды аламыз
        let fetchedCategories = response.data.categories;
        fetchedCategories.sort((a, b) => {
            if (a.title === 'Рекомендуется') return -1;
            if (b.title === 'Рекомендуется') return 1;
            return 0;
        });

        categories.value = fetchedCategories;

        // Әдепкі категорияны таңдау
        const recommendedCategory = categories.value.find(c => c.title === 'Рекомендуется');
        if (recommendedCategory) {
            activeCategory.value = recommendedCategory.id;
        } else {
            activeCategory.value = categories.value[0]?.id;
        }

    } catch (err) {
        error.value = "Failed to load products.";
    } finally {
        loading.value = false;
    }
};

// Өнімдерді фильтрациялау
const filteredProducts = computed(() => {
    if (activeCategory.value === "*") {
        return products.value;
    }
    return products.value.filter(product => product.category && product.category.id === activeCategory.value);
});

// Келесі категорияға өту
const nextCategory = () => {
    const index = categories.value.findIndex(c => c.id === activeCategory.value);
    if (index < categories.value.length - 1) {
        activeCategory.value = categories.value[index + 1].id;
    }
};

// Алдыңғы категорияға өту
const prevCategory = () => {
    const index = categories.value.findIndex(c => c.id === activeCategory.value);
    if (index > 0) {
        activeCategory.value = categories.value[index - 1].id;
    }
};

// Свайп оқиғаларын өңдеу
const onSwipe = (direction) => {
    if (direction === "left") {
        nextCategory();
    } else if (direction === "right") {
        prevCategory();
    }
};

const filterProducts = (categoryId) => {
    activeCategory.value = categoryId;
};

onMounted(fetchData);
</script>

<style>
.swipe-container {
    width: 100%;
    position: relative;
    touch-action: pan-y; /* вертикальды swipe үшін міндетті */
}

.filter-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    padding-bottom: 8px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox үшін */
}

.filter-scroll::-webkit-scrollbar {
    display: none; /* Chrome/Safari үшін */
}
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
