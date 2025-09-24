<template>
    <div class="bannerMain">
        <!-- {{ banners.data.banners }} -->
        <Splide v-if="banners && banners.data && banners.data.banners" :options="options" class="splide-custom">
            <SplideSlide v-for="(img, index) in banners.data.banners" :key="index">
                <div class="slideContainer">
                    
                    <router-link :to="img.link" v-if="!abrir_otra_ventana">
                      <img :src="img.poster" alt="Slide" class="imgBanner" />
                    </router-link>
                    <a 
                      :href="img.link"  
                      v-else
                    >
                        <img :src="img.poster" alt="Slide" class="imgBanner" />
                    </a>
                </div>
            </SplideSlide>
        </Splide>
    </div>
</template>

<script setup>
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/vue-splide/css'

const options = {
  type: 'loop',
  perPage: 1,
  autoplay: true,
  interval: 5000,
  pauseOnHover: true,
  arrows: false,
  pagination: true,
}

const images = [
  '/images/frontend/b1.png',
  '/images/frontend/b2.png',
  '/images/frontend/b3.png',
]

defineProps ({
  banners: {
    type: [],
    required: false,
    default: []
  }
})
</script>

