<template>
    <div class="cuidadoPersonalHomeContainer">
        <div class="containerFluid">
            <div class="gridContainer">
                <div>
                    <h2 class="tituloMiga txtNegro">NATURAL, SENSORIAL, REAL.</h2>
                    <h1 class="titularGrande txtVerde">BRANA: Cuidado <br />personal con<br /> propósito</h1>
                </div>
                <div>
                    <img :src="imgFlor" class="florContainer"/>
                    <p class="DescripcionMediano">
                        Creamos experiencias auténticas que nutren tu piel y elevan tus sentidos, con ingredientes de origen natural, fórmulas honestas y un compromiso profundo con el bienestar y la sostenibilidad.
                    </p>
                </div>
                <div v-if="cuidadoData && cuidadoData.data && cuidadoData.data.cuidado_personal">
                    <div class="centerImgContainer">
                        <div class="imagenCentral"  :style="{ backgroundImage: `url(${imgIso})` }"></div>
                        <div 
                            :class="`noteContainer pos${index + 1}`" 
                            v-for="(item, index) in cuidadoData.data.cuidado_personal" 
                            :key="index"
                            :ref="el => { 
                                    if (index === 0) elementRefs.value = []; 
                                    if (el) elementRefs.value[index] = el
                                }" 
                            
                           
                        >
                            <div class="headerContainer">
                                <img :src="item.icono" />
                            </div>
                            <div class="bodyContainer">
                                <h3 class="titularMediano">{{ item.titulo }}</h3>
                                <p class="DescripcionMediano2">
                                    {{ item.descripcion }}
                                </p>
                            </div>
                        </div>
                       
                    </div>
                    <div class="centerImgContainer movil">
                        <div class="imagenCentral"  :style="{ backgroundImage: `url(${imgIso})` }"></div>
                        <div class="elementosGridContainer">
                            <div 
                                :class="`noteContainer pos${index + 1}`" 
                                v-for="(item, index) in cuidadoData.data.cuidado_personal" 
                                :key="index"
                            >
                                <div class="headerContainer">
                                    <img :src="item.icono" />
                                </div>
                                <div class="bodyContainer">
                                    <h3 class="titularMediano">{{ item.titulo }}</h3>
                                    <p class="DescripcionMediano2">
                                        {{ item.descripcion }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount, watch, nextTick  } from 'vue';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

const imgFlor = '/images/frontend/flor.svg';
const imgIso = '/images/frontend/iso1.png';


const props = defineProps({
  // Corrige el tipo y da estructura por defecto
  cuidadoData: {
    type: Object,
    default: () => ({ data: { cuidado_personal: [] } }),
  },
});

// refs dinámicos
const elementRefs = ref([]);

// (Opcional) ref al contenedor, útil para gsap.context
const root = ref(null);

let ctx; // para limpiar animaciones previas

function buildAnimations() {
  if (ctx) ctx.revert(); // limpia animaciones anteriores al reconstruir
  
  ctx = gsap.context(() => {
    elementRefs.value.value.forEach((el, index) => {
        if (!el) return;
        gsap.to(el, {
            y: -100 - index * 50,
            ease: "none",
            scrollTrigger: {
                trigger: el,
                start: "top bottom",
                scrub: true,
                markers: false,
                // ⚠️ Si scrolleas un DIV y no el body, descomenta y pon tu contenedor:
                // scroller: ".containerFluid",
            },
        });
    });
    ScrollTrigger.refresh(); // re-calcula posiciones
  }, root); // limita el scope al componente
}


onMounted(() => {
    // Reconstruye animaciones cuando llegue/ cambie la data
    watch(
        () => props.cuidadoData?.data?.cuidado_personal,
        async (list) => {
            
            if (!list || !list.length) return;
            await nextTick();        // espera a que el DOM pinte el v-for
            
            buildAnimations();       // ahora los refs existen
        },
        { immediate: true, deep: true }
    );
});

onBeforeUnmount(() => {
    if (ctx) ctx.revert();
    ScrollTrigger.getAll().forEach(t => t.kill());
});

</script>

