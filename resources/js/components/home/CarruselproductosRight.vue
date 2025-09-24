<template>
    <div>
        <Overlay :color="colorOverlay" :opacity="1" />
        <div class="carruselProductosHomeContainer posRight">
            <div class="imgBanner" ref="imgContainerBg">
                <img :src="imgBanner" ref="imagenBg"/>
            </div>
            <div class="gridContainer">
                <div>
                    <div class="btnContainerProducts pos2" @click="goToProducto('mi-producto', 'bgRosado')"  @mouseenter="startArrowAnim" @mouseleave="stopArrowAnim">
                        <img ref="arrow" :src="imgArrowProducts" alt=""/>
                    </div>
                    <div class="florContainer">
                        <img :src="imgFlor"/>
                    </div>
                    <h2 class="titularExtraGrande fontPoppins fontWeight300 txtNegro txtLineHeight">
                        Cosmética <br />
                        <span class="fontEditorialItalic txtRosado">Natural</span>
                    </h2>
                </div>
                <div>
                    <Splide :options="options" class="splide-custom">
                        <SplideSlide v-for="(img, index) in images" :key="index">
                            <div class="cardProduct" @click="goToProducto(index, 'bgRosado')">
                                <div class="imgContainerCard bgRosadoSuave">
                                    <img :src="img" alt="Slide" />
                                </div>
                                <div class="btnCar">
                                    <img :src="imgBolsa" alt="Slide" />
                                </div>
                                <div class="footerCar">
                                    <div>
                                        <h3 class="DescripcionPequeno fontWeight600 txtVerde">ACEITES ESENCIALES</h3>
                                        <p class="DescripcionPequeno">Aceite escencial de eucalipto</p>
                                    </div>
                                    <div>
                                        <p class="DescripcionPequeno">S/. 40.00</p>
                                    </div>
                                </div>
                            </div>
                        </SplideSlide>
                    </Splide>
                </div>
                <div>
                    <p class="DescripcionGrande">
                        Cosmética consciente, con ingredientes vegetales que purifican, hidratan y renuevan tu piel de forma gentil y efectiva.
                    </p>
                </div>
            </div>  
        </div>
    </div>
</template>

<script setup>
import Overlay from '@/js/components/Overlay.vue';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import { ref, onMounted } from 'vue';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { useRouter } from 'vue-router';

gsap.registerPlugin(ScrollTrigger);

const router = useRouter();

const options = {
    type: 'loop',
    perPage: 3,
    focus: 'center',
    gap: '0rem',
    pagination: true,
    arrows: false,
    breakpoints: {
        1600: {
        perPage: 2,
        }
    }
}
const imgBolsa = '/images/frontend/bolsa.svg';
const imgFlor = '/images/frontend/flor4.svg';
const imgBanner = '/images/frontend/bp2.png';
const imgArrowProducts = '/images/frontend/arrow4.svg';
const imagenBg = ref(null);
const imgContainerBg = ref(null);
const colorOverlay = ref('bgRosado');
const arrow = ref(null);
let arrowTween = null;
const images = [
  '/images/frontend/p3.png',
  '/images/frontend/p4.png',
  '/images/frontend/p3.png',
]


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
    })
})
function goToProducto(id, color) {
    if (color === ''){
        colorOverlay.value = 'bgVerde';
    }else{
        colorOverlay.value = color;
    }
  // Mostrar overlay
    if (typeof window.showTransition === 'function') {
        window.showTransition()
    } else {
        console.warn('showTransition no está disponible aún');
    }

  // Esperar animación y luego navegar
  setTimeout(() => {
    router.push(`/producto/${id}`)
  }, 500) // misma duración que la animación GSAP
}
</script>

