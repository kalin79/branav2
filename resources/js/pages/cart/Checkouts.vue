<template>
    <div>
        <HeaderAuth />
        <div class="checkoutPageContainer">
            <CheckoutComponent />
        </div>
    </div>
</template>
<script setup>
    import CheckoutComponent from '@/js/components/cart/Checkout.vue';
    import HeaderAuth from '@/js/components/cart/Header.vue';
</script>