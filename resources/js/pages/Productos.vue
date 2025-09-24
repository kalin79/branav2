<template>
    <div>
        <div class="opcionesFiltrosMovilContainer" ref="PanelFilterMobil">
            <div class="headerFiltros">
                <h2 class="titularMediano fontWeight500 txtGrisOscuro9">Filtros</h2>
                <div class="closeContainer" @click="handleCloseMenu">
                    <img :src="imgClose" />
                </div>
            </div>
            <div class="bodyFiltros">
                <!-- Aquí filtros adicionales -->
                <div class="itemFilter" v-for="(filtro, index) in filtros" :key="index">
                    <div 
                        class="headerFilter"
                        :class="{ active: filtro.activo }"
                        @click="toggleFiltro(index)"
                    >
                        <p class="DescripcionMediano2 txtGrisOscuro9 sinBr" v-html="filtro.titulo"></p>
                        <img :src="imgArrow" alt=""/>
                    </div>
                    <div 
                        class="listFilter"
                        :class="{ active: filtro.activo }"
                    >
                        <ul>
                            <li 
                                class="DescripcionPequeno txtGrisOscuro9"
                                v-for="(item, i) in filtro.subcategorias"
                                :key="i"
                            >
                                {{ item.titulo }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="listadoProductosPagesContainer">
            <div class="bannerInterna">
                <img :src="imgBanner" alt="" class="imgBanner"/>
            </div>
            <div class="containerFluid">
                <section class="seccionListadoProductos">
                    <div class="gridContainer">
                        <!-- Filtros -->
                        <div class="filtrosContainer" ref="filtrosContainerRef">
                            <div class="contenidoFiltros">
                                <h2 class="titularMediano fontWeight500 txtGrisOscuro9">Filtros</h2>
                               
                                <!-- Aquí filtros adicionales -->
                                <div class="itemFilter" v-for="(filtro, index) in filtros" :key="index">
                                    <div 
                                        class="headerFilter"
                                        :class="{ active: filtro.activo }"
                                        @click="toggleFiltro(index)"
                                    >
                                        <p class="DescripcionMediano2 txtGrisOscuro9 sinBr" v-html="filtro.titulo"></p>
                                        <img :src="imgArrow" alt=""/>
                                    </div>
                                    <div 
                                        class="listFilter"
                                        :class="{ active: filtro.activo }"
                                    >
                                        <ul>
                                            <li 
                                                class="DescripcionPequeno txtGrisOscuro9"
                                                v-for="(item, i) in filtro.subcategorias"
                                                :key="i"
                                                @click="handleCategoryClick(item.id)"
                                            >
                                                {{ item.titulo }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filtrosMovilContainer">
                            <button @click="handleViewFilter" class="titularMediano2 txtGrisOscuro4">FILTROS</button>
                        </div>

                        <!-- Productos -->
                        <div class="productosScrollContainer" ref="productosContainerRef">
                            <div class="contenidoProductosCarrusel">
                                <ListadoProductosComponente
                                    v-for="(categoria, index) in productosApi"
                                    :key="index"
                                    :categoria="categoria"
                                    :bgColor = "categoria.color"
                                />
                            </div>
                        </div>
                    </div>
                </section> 
                
            </div>
        </section>   
    </div> 
</template>

<script setup>
    import { onMounted, onUnmounted, nextTick, ref } from 'vue';
    import ListadoProductosComponente  from  '@/js/components/producto/Listado.vue';
    import gsap from 'gsap';
    import ScrollTrigger from 'gsap/ScrollTrigger';
    import { getProducts } from "../services/productsService";
    import { useProductsStore } from '../stores/products';
    const store = useProductsStore();
    gsap.registerPlugin(ScrollTrigger);
    const imgBanner = '/images/frontend/productosbg.webp';
    const imgArrow = '/images/frontend/arrow.svg';
    const filtrosContainerRef = ref(null);
    const productosContainerRef = ref(null);
    const imgClose = '/images/frontend/close.svg';
    const PanelFilterMobil = ref(null);
    const productosApi = ref();
    const filtros = ref([]);
    const dataProductos = ref([]);

    const handleCategoryClick = (category) => {
        store.setFilter({ category });
    };

    function handleViewFilter () {
        const tlMenu = gsap.timeline();
        tlMenu.to(PanelFilterMobil.value, {
            x: 0,
            ease: "power2.out",
            duration: .5,
        })
    }

    function handleCloseMenu () {
        const tlMenu = gsap.timeline();
        tlMenu.to(PanelFilterMobil.value, {
            x: '-100%',
            ease: "power2.out",
            duration: .5,
        })
    }

    const toggleFiltro = (index) => {
        filtros.value[index].activo = !filtros.value[index].activo
    }

    let mediaQuery;

    const initScrollTrigger = () => {
        if (!filtrosContainerRef.value || !productosContainerRef.value) return;

        // Crear el ScrollTrigger solo si la pantalla es >= 992px
        if (window.matchMedia("(min-width: 992px)").matches) {
            ScrollTrigger.create({
            trigger: productosContainerRef.value,
            start: 'top+=200 center',
            end: 'bottom bottom-=80',
            pin: filtrosContainerRef.value,
            pinSpacing: false,
            markers: false,
            invalidateOnRefresh: true,
            });

            ScrollTrigger.refresh();
        }
    };

    const destroyScrollTrigger = () => {
      ScrollTrigger.getAll().forEach(trigger => trigger.kill());
    };

    const handleChange = (e) => {
        destroyScrollTrigger();
        if (e.matches) {
            initScrollTrigger();
        }
    };

    onMounted(async () => {
        await nextTick();

        mediaQuery = window.matchMedia("(min-width: 992px)");
        // Ejecutar al inicio
        if (mediaQuery.matches) {
            setTimeout( () => {
                initScrollTrigger();
            }, 2000);
            
        }

        // Escuchar cambios
        mediaQuery.addEventListener("change", handleChange);

        try {
            dataProductos.value = await getProducts();
            filtros.value = dataProductos.value.categorias;
            productosApi.value = dataProductos.value.categoriaProductos;
        } catch (error) {
            console.error("Error cargando:", error);
        }
    });

    onUnmounted(() => {
        destroyScrollTrigger();
        if (mediaQuery) {
            mediaQuery.removeEventListener("change", handleChange);
        }
    });
</script>