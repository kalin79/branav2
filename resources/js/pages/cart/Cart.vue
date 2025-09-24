<template>
    <div class="pageCartContainer">
        <div class="seccionCompraContainer">
            <div class="containerFluid">
                <div class="headerCartContainer">
                    <div>
                        <img :src="iconCart"/>
                        <div class="itemsCart DescripcionPequeno txtBlanco fontWeight300">{{ cart.totalItems }}</div>
                    </div>
                    <h1 class="">Tus compras</h1>
                </div>
                <ListaComprasComponent />
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useCartStore } from '@/js/stores/cart';
    import ListaComprasComponent from '@/js/components/cart/ListaCompras.vue';
    const iconCart ='/images/frontend/bolsa2.svg';
    const cart = useCartStore();
    
</script>