<!-- js/layouts/AuthLayout.vue -->
<template>
  <div>
    <main>
      <router-view />
    </main>
    <Footer />
    <CookieBanner />
  </div>
</template>

<script setup>
import Footer from '../components/Footer.vue';
import CookieBanner from '../components/CookieConsent.vue';

</script>