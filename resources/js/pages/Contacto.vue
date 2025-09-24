<template>
  <section>
    <h1>Contacto</h1>
    <p>Compra los mejores productos aquí.</p>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  document.title = 'Contacto | Mi Tienda';
  
  // Actualizar descripción
  let description = document.querySelector('meta[name="description"]');
  if (!description) {
    description = document.createElement('meta');
    description.name = 'description';
    document.head.appendChild(description);
  }
  description.content = 'Bienvenido a la tienda más confiable.';
});
</script>
