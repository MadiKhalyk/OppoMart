<script setup>
import Logo from './Logo.vue';
import CartDropdown from './CartDropdown.vue';
import {useCartStore} from '@/stores/cart';

const cartStore = useCartStore();
</script>

<template>
    <header class="header-v1">
        <div class="container-menu-desktop fix-menu-desktop">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop">
                    <div class="center-header">
                        <Logo/>
                    </div>
                    <div class="right-header">

                        <div class="wrap-icon-header">
                            <div class="wrap-cart-header h-full flex-m m-l-10 menu-click">
                                <div class="main-color icon-header-item flex-c-m trans-04 icon-header-noti" :data-notify="cartStore.items.length">
                                    <CartDropdown/>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="wrap-header-mobile">
            <div class="logo-mobile">
                <Logo/>
            </div>
            <div class="wrap-icon-header flex-w flex-r-m h-full wrap-menu-click m-r-15">
                <div class="wrap-cart-header h-full flex-m m-l-5 menu-click">
                    <div class="icon-header-item flex-c-m trans-04 icon-header-noti"
                         :data-notify="cartStore.items.length">
                        <CartDropdown/>
                    </div>
                </div>
            </div>

        </div>
    </header>
</template>

<style>
.icon-header-noti::after,
.wrap-header-mobile .icon-header-noti::after{
    background-color: #EB7514;
}
</style>
