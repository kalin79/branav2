<!-- components/CookieBanner.vue -->
<template>
    <div v-if="showBanner" class="cookie-banner">
        <div class="cookieContainer">
            <div>
                <h2 class="titularMediano fontWeight500 txtBlanco">Brana.com.pe</h2>
                <p class="DescripcionMediano2 txtBlanco">
                    Para brindarle un mejor servicio, BRANA utiliza cookies. Si continúa, 
                    asumimos que acepta recibir cookies de seguimiento y de terceros en 
                    todos los sitios web de BRANA. <router-link to='/terminos-y-condiciones'>Haga clic aquí para más información</router-link>
                </p>
            </div>
            <div>
                 <button @click="acceptCookies" class="DescripcionMediano2 fontWeight500">ESTOY DE ACUERDO</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref } from 'vue';
    import Cookies from 'js-cookie';

    export default {
        setup() {
            const showBanner = ref(!Cookies.get('cookies_accepted'));
            const gtmId = 'GTM-W75QMXBQ'; // Google Tag Manager
            const loadGTM = () => {
                if (!document.getElementById("gtm-script")) {
                    const script = document.createElement("script");
                    script.id = "gtm-script";
                    script.src = `https://www.googletagmanager.com/gtm.js?id=${gtmId}`;
                    script.async = true;
                    document.head.appendChild(script);

                    window.dataLayer = window.dataLayer || [];
                }
            };
            // const loadGTM = () => {
            //     if (!window.dataLayer) {
            //         const script = document.createElement('script');
            //         script.src = `https://www.googletagmanager.com/gtm.js?id=${gtmId}`;
            //         script.async = true;
            //         document.head.appendChild(script);

            //         window.dataLayer = window.dataLayer || [];
            //     }
            // };

            const acceptCookies = () => {
                Cookies.set("cookies_accepted", "true", { expires: 365 });
                showBanner.value = false;
                loadGTM();

                // Disparar un evento a GTM
                if (window.dataLayer) {
                    window.dataLayer.push({
                    event: "cookies_accepted",
                    category: "Cookies",
                    label: "User accepted cookies",
                    });
                }
            };

            const loadGAScript = () => {
                if (!window.gtag) {
                    const script = document.createElement('script');
                    script.src = `https://www.googletagmanager.com/gtag/js?id=${gtmId}`; // reemplaza con tu ID
                    script.async = true;
                    document.head.appendChild(script);

                    window.dataLayer = window.dataLayer || [];
                    function gtag(){window.dataLayer.push(arguments);}
                    window.gtag = gtag;

                    gtag('js', new Date());
                    gtag('config', gtmId); // reemplaza con tu ID
                }
            };

            // const acceptCookies = () => {
            //     Cookies.set('cookies_accepted', 'true', { expires: 365 });
            //     showBanner.value = false;
            //     loadGTM();
            //     loadGAScript();
            //     if (window.gtag) {
            //         window.gtag('event', 'cookies_accepted', {
            //         event_category: 'Cookies',
            //         event_label: 'User accepted cookies',
            //         });
            //     }
            // };

            // Si ya aceptó cookies antes → cargar GTM de inmediato
            if (!showBanner.value) {
                loadGTM();
            }

            return {
                showBanner,
                acceptCookies,
            };

            // // Cargar GTM y GA si ya aceptaron cookies
            // if (!showBanner.value) {
            //     loadGTM();
            //     loadGAScript();
            // }

            // return {
            //     showBanner,
            //     acceptCookies,
            // };
        },
    };
</script>
