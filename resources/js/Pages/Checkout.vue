<script setup>
import {ref, computed} from 'vue';
import axios from 'axios';
import {useCartStore} from '@/stores/cart';
import TheHeader from "@/Components/Header/Header.vue";

const cart = useCartStore();
const subtotal = computed(() => cart.total);
const products = computed(() => cart.items);


const firstName = ref('');
const lastName = ref('');
const note = ref('');
const phone = localStorage.getItem('phone') || '77001112233';

const makeOrder = async () => {
    try {
        const productData = products.value.map(p => ({
            product_id: p.id,
            quantity: p.quantity
        }));
        const total_price = subtotal.value;

        await axios.post('/api/purchases', {
            phone,
            first_name: firstName.value,
            last_name: lastName.value,
            note: note.value,
            products: productData,
            total_price: total_price,
        });

        alert('Заказ сәтті жіберілді!');
        cart.clear();
    } catch (error) {
        console.error('Validation error:', error.response?.data);
        alert('Қате: деректер дұрыс толтырылмаған. Консольді тексеріңіз.');
    }
};

</script>


<template>
    <TheHeader/>
    <div class="bg0 p-t-95 p-b-50">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-8 p-b-50">
                    <h4 class="txt-m-124 cl3 p-b-28">Платежные данные</h4>
                    <div class="row p-b-50">
                        <div class="col-sm-6 p-b-23">
                            <div>
                                <label class="txt-s-101 cl6 p-b-10">Имя<span class="cl12">*</span></label>
                                <input
                                    v-model="firstName"
                                    class="txt-s-120 cl3 size-a-21 bo-all-1 bocl15 p-rl-20 focus1"
                                    type="text"
                                    name="first-name"
                                />
                            </div>
                        </div>
                        <div class="col-sm-6 p-b-23">
                            <div>
                                <label class="txt-s-101 cl6 p-b-10">Фамилия<span class="cl12">*</span></label>
                                <input
                                    v-model="lastName"
                                    class="txt-s-120 cl3 size-a-21 bo-all-1 bocl15 p-rl-20 focus1"
                                    type="text"
                                    name="last-name"
                                />
                            </div>
                        </div>
                        <!-- Add more billing fields as needed -->
                    </div>

                    <h4 class="txt-m-124 cl3 p-b-19">Дополнительная информация</h4>
                    <div>
                        <label class="txt-s-101 cl6 p-b-10">Примечания к заказу</label>
                        <textarea
                            v-model="note"
                            class="plh2 txt-s-120 cl3 size-a-38 bo-all-1 bocl15 p-rl-20 p-tb-10 focus1"
                            name="note"
                        ></textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-md-5 col-lg-4 p-b-50">
                    <div class="how-bor4 p-t-35 p-b-40 p-rl-30 m-t-5">
                        <h4 class="txt-m-124 cl3 p-b-11">Ваш заказ</h4>
                        <div class="flex-w flex-sb-m txt-m-103 cl6 bo-b-1 bocl15 p-b-21 p-t-18">
                            <span>Товар</span>
                            <span>Итого</span>
                        </div>

                        <div v-for="item in products" :key="item.id"
                             class="flex-w flex-sb-m txt-s-101 cl6 bo-b-1 bocl15 p-b-21 p-t-18">
                            <span>
                              {{ item.title }}
                              <img class="m-rl-3" :src="'/storage/' + item.poster" :alt="item.title">
                              {{ item.quantity }} {{ item.unit ? 'кг' : 'шт' }}
                            </span>
                            <span>{{ item.price * item.quantity }}тг</span>
                        </div>

                        <div class="flex-w flex-m txt-m-103 bo-b-1 bocl15 p-tb-23">
                            <span class="size-w-61 cl6">Промежуточный итог</span>
                            <span class="size-w-62 cl9">{{ subtotal }}тг</span>
                        </div>

                        <div class="flex-w flex-m txt-m-103 p-tb-23">
                            <span class="size-w-61 cl6">Итого</span>
                            <span class="size-w-62 cl10">{{ subtotal }}$</span>
                        </div>

                        <button
                            @click="makeOrder"
                            class="flex-c-m txt-s-105 cl0 bg10 size-a-21 hov-btn2 trans-04 p-rl-10">
                            Сделать заказ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
