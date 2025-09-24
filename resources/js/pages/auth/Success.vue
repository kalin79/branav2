<template>
  <AuthLayout>
    <h2>¡Felicidades!</h2>
    <p>Tu cuenta ha sido creada con éxito.</p>
    <router-link to="/login">Iniciar sesión</router-link>
  </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/js/layouts/AuthLayout.vue'
</script>
