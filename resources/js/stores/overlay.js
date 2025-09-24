import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useOverlayStore = defineStore('overlay', () => {
    const color = ref('negro')      // valor por defecto
    const opacity = ref(0)          // inicia oculto
    const visible = ref(false)      // si se muestra o no

    function show(newColor = null, newOpacity = 1) {
        if (newColor) color.value = newColor
        opacity.value = newOpacity
        visible.value = true
    }

    function hide() {
        visible.value = false
    }

    return { color, opacity, visible, show, hide }
})
