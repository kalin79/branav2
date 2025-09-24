<template>
    <section class="productoPageContainer">
        <HeaderComponent :dataDetalle="dataProducto" />
        <DetailComponent :dataDetalle="dataProducto" />
    </section>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { useRoute } from 'vue-router'   // 👈 IMPORTANTE
    import HeaderComponent from '@/js/components/producto/Header.vue'; // ✅ IMPORTA EL COMPONENTE
    import DetailComponent from '@/js/components/producto/Detail.vue';
    import { getProductDetail } from "../services/productsService";
    // refs para los datos
    const dataProducto = ref([]);
    const route = useRoute()              // 👈 accedemos a la ruta
    const slug = route.params.slug        // 👉 aquí tienes "aceite-esencial-de-eucalipto"

    onMounted(async () => {
        try {
            dataProducto.value = await getProductDetail(slug);
        } catch (error) {
            console.error("Error cargando:", error);
        }
    });
</script>
