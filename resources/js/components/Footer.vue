<template>
    <footer class="footerContainer">
        <div class="bgFooter">
            <img :src="imgFooterBg"  alt=""/>
        </div>
        <div class="bgImg">
            <img :src="imgFooter"  alt=""/>
        </div>
        <div class="containerFluid">
            <div class="gridContainer">
                <div>
                    <router-link to="/" class="logoLinkContainer">
                        <img :src="logo" alt="Brana :: Mente & Cuerpo en equilibrio natural"/>
                    </router-link>
                    <h3 class="DescripcionMediano textVerdeClaro">Mente & Cuerpo <br />en equilibrio natural</h3>
                    <div class="redesSocialesContainer">
                        <a to="#">
                            <img :src="facebook" alt="Brana :: Facebook"/>
                        </a>
                        <a href="#">
                            <img :src="instagram" alt="Brana :: Instagram"/>
                        </a>
                        <a href="#">
                            <img :src="tiktok" alt="Brana :: Tik Tok"/>
                        </a>
                    </div>
                </div>
                <div>
                    <h2 class="textVerdeClaro DescripcionRegular fontWeight600">MAPA DE SITIO</h2>
                    <ul>
                        <li>
                            <router-link to="/">Principal</router-link>
                        </li>
                        <li>
                            <router-link to="/">Acerca de BRANA</router-link>
                        </li>
                        <li>
                            <router-link to="/">Catálogo de productos</router-link>
                        </li>
                        <li>
                            <router-link to="/">Pack Mayorista</router-link>
                        </li>
                        <li>
                            <router-link to="/">BLOG</router-link>
                        </li>
                        <li>
                            <router-link to="/">Contáctenos</router-link>
                        </li>
                        <li>
                            <router-link to="/">Login</router-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="textVerdeClaro DescripcionRegular fontWeight600">NUESTRA POLÍTICAS</h2>
                    <ul>
                        <li>
                            <router-link to="/">Términos y condiciones</router-link>
                        </li>
                        <li>
                            <router-link to="/">Políticas de empaques</router-link>
                        </li>
                        <li>
                            <router-link to="/">Políticas de privacidad</router-link>
                        </li>
                        <li>
                            <router-link to="/">Campañas y términos legales</router-link>
                        </li>
                        <li>
                            <router-link to="/">Política de cambio</router-link>
                        </li>
                        <li>
                            <router-link to="/">Delivery</router-link>
                        </li>
                        <li>
                            <a to="/">Libro de reclamaciones</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="textVerdeClaro DescripcionRegular fontWeight600">CONTÁCTANOS</h2>
                    <ul>
                        <li>
                            <a href="mailto:branasac@brana.pe">branasac@brana.pe</a>
                        </li>
                        <li>
                            <p>+51 996 357 889</p>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
        <div class="legalContainer">
            <div class="containerFluid">
                <p>© 2025 Brana Todos los derechos reservados</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
const imgFooterBg = '/images/frontend/bgfooter.webp';
const imgFooter = '/images/frontend/florFooter.png';
const logo= '/images/frontend/logofooter.svg';
const facebook= '/images/frontend/facebook.svg';
const instagram= '/images/frontend/instagram.svg';
const tiktok= '/images/frontend/tiktok.svg';
</script>
