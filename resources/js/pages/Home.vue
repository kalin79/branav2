<template>
  <section>
    
    <Carousel :banners="homeData"/>
    <CuidadoPersonal :cuidadoData="homeData"/>
    <Catalogo />
    <CarruselProductos :catalogoData="homeData"/>
    <UnicaComponent />
    <BlogComponent />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getHome } from "../services/homeService";
import Carousel from '@/js/components/Banner.vue'; // ✅ IMPORTA EL COMPONENTE
import CuidadoPersonal from '@/js/components/home/CuidadoPersonal.vue';
import Catalogo from '@/js/components/home/Catalogo.vue';
import CarruselProductos from '@/js/components/home/CarruselProductos.vue';
import UnicaComponent from '@/js/components/home/Unica.vue';
import BlogComponent from '@/js/components/home/Blog.vue';

const homeData = ref([]);

onMounted( async () => {
  document.title = 'Inicio | Mi Tienda';
  let description = document.querySelector('meta[name="description"]');
  if (!description) {
    description = document.createElement('meta')
    description.name = 'description'
    document.head.appendChild(description)
  }
  description.content = 'Bienvenido a la tienda más confiable.';

  try {
    homeData.value = await getHome();
  } catch (error) {
    console.error("Error cargando banner:", error);
  }


})
</script>
