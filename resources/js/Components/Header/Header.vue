<script setup>
import Logo from './Logo.vue';
import CartDropdown from './CartDropdown.vue';
</script>

<template>
    <header class="header-v1">
        <div class="container-menu-desktop fix-menu-desktop">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop">
                    <div class="center-header">
                        <Logo />
                    </div>
                    <div class="right-header">
                        <div class="wrap-icon-header">
                            <CartDropdown />
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
</template>
