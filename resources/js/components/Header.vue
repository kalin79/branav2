<template>
    <div>
        <header class="headerContainerMain" ref="navbar">
            <div class="containerFluid">
                <div class="gridContainer">
                    <div class="menuMovilNav" @click="handleViewMenu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="logoContainer">
                        <router-link to="/">
                            <img :src="logo" alt="Logo de BRANA" width="120" height="33" loading="eager"/>
                        </router-link>
                    </div>
                    <nav>
                        <div class="opcionesContainer">
                            <router-link to="/">Acerca de BRANA</router-link>
                            <router-link to="/productos">Catálogo de Productos</router-link>
                            <router-link to="/contacto">Pack Mayorista</router-link>
                            <router-link to="/contacto">BLOG</router-link>
                            <router-link to="/contacto">Contáctenos</router-link>
                        </div>
                    </nav>
                    <div class="loginCartContainer">
                        <div class="btnAccessUser">
                            <div>
                                <button class="btnTransparente" @click="openCart">
                                    <div class="countProductContainer DescripcionPequeno fontWeight300 txtBlanco" v-show="cart.totalItems > 0">
                                        ({{ cart.totalItems }})
                                    </div>
                                    <img src="../assets/images/bolsa.svg" class="bolsaComprasImg" alt="Bolsa de Compras"/>
                                </button>
                            </div>
                            <div>
                                <div class="lineContainer"></div>
                            </div>
                            <div>
                                <router-link to="/auth/login">
                                    <img src="../assets/images/user.svg"  class="userLoginImg" alt="Login Brana"  />
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="PanelMenuMobil" ref="PanelMenuMobil">
            <div class="contentBox">
                <div class="headerContainer">
                    <div class="logoContainer">
                        <img :src="logo" alt="Logo de BRANA" width="120" height="33" loading="eager"/>
                    </div>
                    <div class="closeContainer" @click="handleCloseMenu">
                        <img :src="imgClose" />
                    </div>
                </div>
                <div class="BodyContainer">
                    <router-link to="/" class="titularMediano2 txtGrisOscuro4" @click="handleGoPage">Acerca de BRANA</router-link>
                    <router-link to="/productos" class="titularMediano2 txtGrisOscuro4" @click="handleGoPage">Catálogo de Productos</router-link>
                    <router-link to="/contacto" class="titularMediano2 txtGrisOscuro4" @click="handleGoPage">Pack Mayorista</router-link>
                    <router-link to="/contacto" class="titularMediano2 txtGrisOscuro4" @click="handleGoPage">BLOG</router-link>
                    <router-link to="/contacto" class="titularMediano2 txtGrisOscuro4" @click="handleGoPage">Contáctenos</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { useCartStore } from '@/js/stores/cart';
    import { useCartPanel } from '../stores/useCartPanel';
    import { gsap } from "gsap";
    import ScrollTrigger from "gsap/ScrollTrigger";
    const cart = useCartStore();
    const cartPanel = useCartPanel();
    const logo = '/images/frontend/logo.svg';
    const imgClose = '/images/frontend/close.svg';
    const navbar = ref(null);
    const PanelMenuMobil = ref(null);
    gsap.registerPlugin(ScrollTrigger);
    const openCart = () => {
        cartPanel.open();
    }

    function handleViewMenu () {
        const tlMenu = gsap.timeline();
        tlMenu.to(PanelMenuMobil.value, {
            x: 0,
            ease: "power2.out",
            duration: .5,
        })
    }
    function handleGoPage () {
        const tlMenu = gsap.timeline();
        tlMenu.to(PanelMenuMobil.value, {
            x: '-100%',
            ease: "power2.out",
            duration: .5,
        }, .85)
    }

    function handleCloseMenu () {
        const tlMenu = gsap.timeline();
        tlMenu.to(PanelMenuMobil.value, {
            x: '-100%',
            ease: "power2.out",
            duration: .5,
        })
    }

    onMounted(() => {
        ScrollTrigger.create({
            trigger: document.body,
            start: "100 top", // cuando pasas 100px
            onEnter: () => {
                gsap.to(navbar.value, {
                    backgroundColor: "rgba(255, 255, 255, 0.85)",
                    borderBottom: "1px solid #DDDDDD", 
                    duration: 0.4,
                    ease: "power2.out"
                });
            },
            onLeaveBack: () => {
                gsap.to(navbar.value, {
                    backgroundColor: "transparent",
                    borderBottom: "none",
                    duration: 0.4,
                    ease: "power2.out"
                });
            }
        });
    });
    
</script>