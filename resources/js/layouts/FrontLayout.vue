<template>
  <div>
    <Overlay />
    <Header />
    <main>
      <router-view />
    </main>
    <Footer />
    <CookieBanner />
    <CartPanel />
  </div>
</template>

<script setup>
import Overlay from '@/js/components/Overlay.vue';

import Header from '@/js/components/Header.vue';
import Footer from '@/js/components/Footer.vue';
import CookieBanner from '@/js/components/CookieConsent.vue';
import CartPanel from '@/js/components/cart/Panel.vue';
</script>
