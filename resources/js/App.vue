<!-- js/App.vue -->
<template>
  <component :is="layout">
    <router-view />
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

// Layouts
import FrontLayout from '@/js/layouts/FrontLayout.vue';
import AuthLayout from '@/js/layouts/AuthLayout.vue';

const route = useRoute()

const layout = computed(() => {
  return route.meta.layout === 'auth' ? AuthLayout : FrontLayout
})
</script>
