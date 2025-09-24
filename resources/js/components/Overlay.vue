<template>
    <div
        ref="overlay"
        class="overlay"
        v-show="overlayStore.visible"
        :style="{
            backgroundColor: backgroundColor,
            opacity: overlayStore.opacity
        }"
    ></div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import gsap from 'gsap'
import { useOverlayStore } from '@/js/stores/overlay'

const overlayStore = useOverlayStore()
const overlay = ref(null)
const defaultDuration = 2500;
// Diccionario de colores
const colorMap = {
    bgRosado: '#FFF1F2',
    bgVerde: '#BDDDCA',
    bgMorado: '#DDCEE5',
    bgAmarrillo: '#FFFDE9',
}

// Computed para el color dinámico
const backgroundColor = computed(() => {
    console.log(overlayStore.color)
    console.log(colorMap[overlayStore.color]);
    return colorMap[overlayStore.color] || overlayStore.color
})

watch(
    () => overlayStore.visible,
    (isVisible) => {
        if (isVisible) {
            gsap.to(overlay.value, {
                duration: 0.5,
                opacity: overlayStore.opacity ?? 1,
                y: 0,
                ease: "power2.out",
            })

            setTimeout(() => {
                overlayStore.visible = false
            }, overlayStore.duration ?? defaultDuration)
            } else {
            gsap.to(overlay.value, {
                duration: 0.5,
                opacity: 0,
                y: "-100%",
                ease: "power2.in",
            })
        }
    }
)
</script>
