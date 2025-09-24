import { loadMercadoPago } from "@mercadopago/sdk-js";
import { createApp } from 'vue';
import { createPinia } from 'pinia';
// import FrontLayout from '@/js/layouts/FrontLayout.vue';
import App from '@/js/App.vue';
import router from '@/js/router';
import { useUserStore } from "@/js/stores/user";
import '@/scss/main.scss';
const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');


// validar sesión al iniciar
const userStore = useUserStore();
userStore.fetchUser();

// inicializar Mercado Pago
loadMercadoPago(import.meta.env.VITE_MERCADO_PAGO_PUBLIC_KEY) // guardas la clave en .env
    .then(() => {
        console.log("SDK Mercado Pago listo 🚀");
    });