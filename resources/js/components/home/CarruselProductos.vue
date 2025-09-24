<template>
    <div class="homeListaProductos" v-if="catalogoData && catalogoData.data && catalogoData.data.categorias">
        <div 
            v-for="(categoria, index) in catalogoData.data.categorias" 
            :key="index"
            :class="['carruselProductosHomeContainer', { posRight: index % 2 !== 0 }]"
        >
            <div class="imgBanner">
                <img 
                    :src="categoria.poster" 
                    :ref="el => { 
                        if (index === 0) categoriasRefs.value = []; 
                        if (el) categoriasRefs.value[index] = el
                    }" 
                />
            </div>
            <div class="gridContainer">
                <div :class="['headerTitleCategories', categoria.color]">
                    <div class="btnContainerProducts"  @click="goToProductos()" @mouseenter="startArrowAnim" @mouseleave="stopArrowAnim">
                        <img ref="arrow" :src="imgArrowProducts" alt=""/>
                    </div>
                    <div class="florContainer" >
                        <img :src="categoria.icono"  />
                    </div>
                    <h2 class="titularExtraGrande fontPoppins fontWeight300 txtNegro" v-html="categoria.titulo"></h2>
                </div>
               
                <div v-if="categoria.productos.length > 0">
                    {{catalogoData.data.categorias.productos }}
                    <Splide :options="options" class="splide-custom">
                        <SplideSlide v-for="(producto, index) in  categoria.productos" :key="index">
                            <div class="cardProduct" @click="goToProducto(producto.slug, categoria.color)">
                                <div :class="['imgContainerCard', categoria.color]">
                                    <img :src="producto.poster" :alt="producto.titulo" />
                                </div>
                                <div class="btnCar">
                                    <img :src="imgBolsa" alt="Slide" />
                                </div>
                                <div class="footerCar">
                                    <div>
                                        <h3 class="DescripcionPequeno fontWeight600 txtVerde txtUppercase" v-html="producto.subcategoria.titulo"></h3>
                                        <p class="DescripcionPequeno" v-html="producto.titulo"></p>
                                    </div>
                                    <div>
                                        <p class="DescripcionPequeno">{{ formatCurrency(producto.precio_actual) }}</p>
                                    </div>
                                </div>
                            </div>
                        </SplideSlide>
                    </Splide>
                </div>
                <div>
                    <p class="DescripcionGrande" v-html="categoria.descripcion"></p>
                </div>
            </div>  
        </div>
    </div>
</template>

<script setup>
import { useOverlayStore } from '@/js/stores/overlay';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { useRouter } from 'vue-router';
import { useCurrency } from '@/js/utils/useCurrency';

const props = defineProps({
  // Corrige el tipo y da estructura por defecto
  catalogoData: {
    type: Object,
    default: () => ({ data: { categorias: [] } }),
  },
});


const { formatCurrency } = useCurrency();
const router = useRouter();
gsap.registerPlugin(ScrollTrigger);
const overlayStore = useOverlayStore();

// refs dinámicos
const categoriasRefs = ref([]);


// (Opcional) ref al contenedor, útil para gsap.context
const rootCategoria = ref(null);

let ctxCategoria; // para limpiar animaciones previas

function buildAnimationsCategorias() {
    if (ctxCategoria) ctxCategoria.revert(); // limpia animaciones anteriores al reconstruir
  
    ctxCategoria = gsap.context(() => {
        categoriasRefs.value.value.forEach((el, index) => {
            
            if (!el) return;
            gsap.fromTo(el, 
                { yPercent: -30 }, // 👈 posición inicial
                {
                    yPercent: 30, // Mueve hacia arriba 100px mientras haces scroll
                    ease: 'none',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true, // hace que el movimiento sea proporcional al scroll
                        markers: false,
                    }
                }
            );
        });
        ScrollTrigger.refresh(); // re-calcula posiciones
    }, rootCategoria); // limita el scope al componente
}

onMounted(() => {
    // Reconstruye animaciones cuando llegue/ cambie la data
    watch(
        () => props.catalogoData?.data?.categorias,
        async (list) => {
            
            if (!list || !list.length) return;
            await nextTick();        // espera a que el DOM pinte el v-for
            
            buildAnimationsCategorias();       // ahora los refs existen
        },
        { immediate: true, deep: true }
    );
});

onBeforeUnmount(() => {
    if (ctxCategoria) ctxCategoria.revert();
    ScrollTrigger.getAll().forEach(t => t.kill());
});

const productosApi = ref([
    {
        categoria: 'Línea <span>Terapeútica</span>',
        idCategoria: 1,
        bgColor: '',
        imgBig: './images/frontend/bp1.png',
        productos: [
            {
                idProducto: 1,
                titulo: 'Aceite esencial de eucalipto',
                precio: 40,
                slug: 'aceites-esenciales',
                img: './images/frontend/p1.png',
                subcategoria: 'Aceites Esenciales',
                idSubcategoria: 1,
            },
            {
                idProducto: 2,
                titulo: 'Perfume Natural de Naranja',
                precio: 20,
                slug: 'perfume-natural-de-naranja',
                img: './images/frontend/p2.png',
                subcategoria: 'Perfumes Naturales',
                idSubcategoria: 2,
            },
            {
                idProducto: 3,
                titulo: 'Blend natural sueño',
                precio: 30,
                slug: 'blend-natural-sueno',
                img: './images/frontend/p1.png',
                subcategoria: 'Roll-On de aromaterapia',
                idSubcategoria: 3,
            }
        ]
    },
    {
        categoria: 'Cosmética <span>Natural</span>',
        idCategoria: 2,
        bgColor: 'bgRosado',
        imgBig: './images/frontend/bp2.png',
        productos: [
            {
                idProducto: 4,
                titulo: 'Mascarilla de carbón activado',
                precio: 40,
                slug: 'mascarilla-de-carbon-activado',
                img: './images/frontend/p3.png',
                subcategoria: 'Mascarillas & arcillas',
                idSubcategoria: 4,
            },
            {
                idProducto: 5,
                titulo: 'Aceite vegetal de coco',
                precio: 20,
                slug: 'aceite-vegetal-de-coco',
                img: './images/frontend/p4.png',
                subcategoria: 'Aceites vegetales',
                idSubcategoria: 5,
            },
        ]
    }
]);


const options = {
    type: 'loop',
    perPage: 3,
    focus: 'center',
    gap: '0rem',
    pagination: true,
    arrows: false,
    breakpoints: {
        768: {
            perPage: 1,
            focus: 0,
            gap: '1rem',
        },
        992: {
            perPage: 2,
            focus: 0,
            gap: '2rem',
        },
        1600: {
            perPage: 2,
        },
    }
}
const imgBolsa = '/images/frontend/bolsa.svg';

const imgArrowProducts = '/images/frontend/arrow4.svg';
const imagenBg = ref(null);
const imgContainerBg = ref(null);

const imagenBg2 = ref(null);
const imgContainerBg2 = ref(null);


const arrow = ref(null);
let arrowTween = null;


const startArrowAnim = () => {
    arrowTween = gsap.to(arrow.value, {
        x: 5, // mueve 5px a la derecha
        duration: 0.4,
        ease: 'power1.inOut',
        yoyo: true,
        repeat: -1, // loop infinito
    });
};
const stopArrowAnim = () => {
    if (arrowTween) {
        arrowTween.kill()
        gsap.set(arrow.value, { x: 0 }) // vuelve a su posición original
    }
}

onMounted(() => {
    gsap.fromTo(imagenBg.value, 
        { yPercent: '-30' }, // 👈 posición inicial
        {
            yPercent: '30', // Mueve hacia arriba 100px mientras haces scroll
            ease: 'none',
            scrollTrigger: {
                trigger: imgContainerBg.value,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true, // hace que el movimiento sea proporcional al scroll
                markers: false,
            }
       }
    );

    gsap.fromTo(imagenBg2.value, 
        { yPercent: '-30' }, // 👈 posición inicial
        {
            yPercent: '30', // Mueve hacia arriba 100px mientras haces scroll
            ease: 'none',
            scrollTrigger: {
                trigger: imgContainerBg2.value,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true, // hace que el movimiento sea proporcional al scroll
                markers: false,
            }
       }
    );
})

function goToProducto(id, color) {
    if (color === ''){
        overlayStore.show('bgVerde', 1); // color + opacidad
    }else{
        overlayStore.show(color, 1) // color + opacidad
    }
    // // Mostrar overlay
    // if (typeof window.showTransition === 'function') {
    //     window.showTransition()
    // } else {
    //     console.warn('showTransition no está disponible aún');
    // }

    // Esperar animación y luego navegar
    setTimeout(() => {
        router.push(`/producto/${id}`)
    }, 500) // misma duración que la animación GSAP
}

function goToProductos() {
    setTimeout(() => {
        router.push(`/productos`)
    }, 500) // misma duración que la animación GSAP
}

</script>

