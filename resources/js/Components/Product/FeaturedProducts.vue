<template>
    <div class="sec-product bg0 p-t-10 p-b-10">
        <div class="swipe-container">
            <div class="container">
                <!-- Категориялар -->
                <div class="p-b-30">
                    <div ref="categoriesContainer" class="filter-scroll d-flex gap-2 overflow-auto pb-2" style="white-space: nowrap">
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            :ref="el => { if (category.id === activeCategory) activeCategoryRef = el }"
                            class="txt-m-104 cl-green hov2 trans-04 p-rl-10 p-b-10 border-0 bg-transparent"
                            :class="{ 'how-active1': activeCategory === category.id }"
                            @click="filterProducts(category.id)"
                        >
                            {{ category.title }}
                        </button>
                    </div>
                </div>

                <!-- Өнімдер -->
                <div class="row isotope-grid"
                     v-touch:swipe="onSwipe"
                     v-touch:options="{ swipeTolerance: 50 }"
                >
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
import { ref, computed, onMounted, nextTick } from "vue";
import axios from "axios";
import ProductCard from "./ProductCard.vue";

const activeCategory = ref("*");
const activeCategoryRef = ref(null);
const categoriesContainer = ref(null);
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

        let fetchedCategories = response.data.categories;
        fetchedCategories.sort((a, b) => {
            if (a.title === 'Рекомендуется') return -1;
            if (b.title === 'Рекомендуется') return 1;
            return 0;
        });

        categories.value = fetchedCategories;

        const recommendedCategory = categories.value.find(c => c.title === 'Рекомендуется');
        activeCategory.value = recommendedCategory ? recommendedCategory.id : categories.value[0]?.id;

    } catch (err) {
        error.value = "Failed to load products.";
    } finally {
        loading.value = false;
        nextTick(scrollToActiveCategory);
    }
};

// Өнімдерді фильтрациялау
const filteredProducts = computed(() => {
    if (activeCategory.value === "*") return products.value;
    return products.value.filter(product => product.category?.id === activeCategory.value);
});

// Категорияларды скроллдау
const scrollToActiveCategory = () => {
    if (activeCategoryRef.value && categoriesContainer.value) {
        const container = categoriesContainer.value;
        const button = activeCategoryRef.value;

        const containerWidth = container.offsetWidth;
        const buttonLeft = button.offsetLeft;
        const buttonWidth = button.offsetWidth;

        container.scrollTo({
            left: buttonLeft - (containerWidth / 2) + (buttonWidth / 2),
            behavior: 'smooth'
        });
    }
};

// Категорияларды ауыстыру
const changeCategory = (newCategoryId) => {
    activeCategory.value = newCategoryId;
    nextTick(scrollToActiveCategory);
};

// Свайп оқиғалары
const onSwipe = (direction) => {
    const currentIndex = categories.value.findIndex(c => c.id === activeCategory.value);

    if (direction === "left" && currentIndex < categories.value.length - 1) {
        changeCategory(categories.value[currentIndex + 1].id);
    } else if (direction === "right" && currentIndex > 0) {
        changeCategory(categories.value[currentIndex - 1].id);
    }
};

// Категорияны фильтрлеу
const filterProducts = (categoryId) => {
    changeCategory(categoryId);
};

onMounted(fetchData);
</script>

<style>
/* Алдыңғы стильдер сақталады */
.filter-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    padding-bottom: 8px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.filter-scroll::-webkit-scrollbar {
    display: none;
}

.cl-green {
    color: #2e7d32 !important;
}

.how-active1 {
    font-weight: bold;
    border-bottom: 2px solid #2e7d32;
}

.swipe-container {
    width: 100%;
    position: relative;
    touch-action: pan-y;
}

@media  screen and (max-width: 768px){
    .isotope-grid{
        flex-direction: column;
        margin-bottom: 10px !important;
        height: 80vh;
    }
}
</style>
