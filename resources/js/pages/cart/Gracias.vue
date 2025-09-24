<template>
    <div>
        <HeaderAuth />
        <div class="gracias">
            <h1>🎉 ¡Gracias por tu compra!</h1>

            <div v-if="payment">
                <p><strong>ID de pago:</strong> {{ payment.id }}</p>
                <p><strong>Estado:</strong> {{ payment.status }}</p>
                <p><strong>Monto:</strong> {{ payment.transaction_amount }}</p>
                <p><strong>Comprador:</strong> {{ payment.payer.email }}</p>
            </div>

            <div v-else>
                <p>Cargando información del pago...</p>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref, onMounted } from "vue";
    import { useRoute } from "vue-router";
    import axios from "axios";
    import HeaderAuth from '@/js/components/cart/Header.vue';
    const route = useRoute();
    const payment = ref(null);
    onMounted(async () => {
        const paymentId = route.query.payment_id;

        if (!paymentId) return;

        try {
            // Llamada al backend para obtener info verificada
            const response = await axios.get(
                `https://tu-backend.com/api/pagos/${paymentId}`
            );

            payment.value = response.data;
        } catch (error) {
            console.error("Error obteniendo el pago verificado:", error);
        }
    });
</script>