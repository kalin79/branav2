import { defineStore } from 'pinia';
import { ref, computed } from 'vue'; // Si usas Composition API en el store

export const useProductsStore = defineStore('products', () => {
    // Estado
    const allProducts = ref([/* Tus productos iniciales, ej. fetched de una API */]);
    const filters = ref({ category: '' /* Ejemplos de filtros */ });

    // Getter para productos filtrados (computado, reactivo)
    const filteredProducts = computed(() => {
        let result = [...allProducts.value];

        if (filters.value.category) {
            result = result.filter(product => product.category === filters.value.category);
        }

        // Agrega más lógica de filtrado según necesites (ej. por nombre, etc.)
        return result;
    });

    // Acciones (métodos para mutar estado)
    const setFilter = (newFilters) => {
        filters.value = { ...filters.value, ...newFilters }; // Merge para no sobreescribir todo
    };

    const resetFilters = () => {
        filters.value = { category: '', priceMax: 0 };
    };

    const loadProducts = (products) => { // Si necesitas cargar productos dinámicamente
        allProducts.value = products;
    };

    return { allProducts, filters, filteredProducts, setFilter, resetFilters, loadProducts };
});