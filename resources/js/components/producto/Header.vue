<template>
    <div class="bannerContainer bgMorado">
        <div class="containerFluid" v-show="!loading">
            <div class="gridContainer" v-if="dataDetalle && dataDetalle.data">
                <div>
                    <!-- Carrusel principal -->
                    <Splide
                        :options="mainOptions"
                        ref="mainSplide"
                        class="spileMain"
                        >
                        <SplideSlide v-for="(image, index) in images" :key="index">
                            <div class="imgContainer">
                                <img :src="image"  alt="Imagen grande" />
                            </div>
                        </SplideSlide>
                    </Splide>
                    <!-- Carrusel de thumbnails -->
                        <div class="thumbContainer">
                        <Splide
                            :options="thumbOptions"
                            ref="thumbSplide"
                            class="spliThumbContainer"
                            >
                            <SplideSlide
                                v-for="(image, index) in images"
                                :key="'thumb-' + index"
                                @click="goToSlide(index)"
                            >
                                <img :src="image" alt="Miniatura" />
                            </SplideSlide>
                        </Splide>
                    </div>
                </div>
                <div>
                    <div class="infoMainContainer">
                        <div class="tagContainer DescripcionRegular txtVerde" v-html="dataDetalle.data?.subcategoria?.titulo"></div>
                        <h1 class="titularGrande fontWeight200 txtGrisOscuro4" v-html="dataDetalle.data?.titulo"></h1>
                        <p class="subtitleContainer DescripcionRegular" v-html="dataDetalle.data?.subtitulo"></p>
                        <div class="priceContainer">
                            <div class="viewContent DescripcionRegular txtBlanco">{{ dataDetalle.data?.presentacion }}</div>
                            <p class="DescripcionGrande txtGrisOscuro2">{{ formatCurrency(dataDetalle.data?.precio_actual) }}</p>
                        </div>
                        <div class="descripcionCortaContainer DescripcionRegular" v-html="dataDetalle.data?.description"></div>
                        <div class="addtoCartContainer">
                            <div class="quantityCartContainer">
                                <button class="quantityBtn circuloRegular txtVerde DescripcionMediano" @click="decrease(dataDetalle.data?.id)">
                                    -
                                </button>
                                <input 
                                    type="number" 
                                    class="DescripcionRegular txtGrisOscuro4" 
                                    :value="getQuantity(dataDetalle.data?.id)" 
                                    @input="updateManualQuantity($event, dataDetalle.data?.id)"
                                    name="quantity" 
                                    min="1"
                                    max="99"
                                />
                                <button class="quantityBtn circuloRegular txtVerde DescripcionMediano" @click="increase(dataDetalle.data?.id, { id: dataDetalle.data?.id, titulo: dataDetalle.data?.titulo, subtitulo: dataDetalle.data?.subtitulo, presentacion: dataDetalle.data?.presentacion, precio_actual: parseFloat(dataDetalle.data?.precio_actual), poster: dataDetalle.data?.poster})">
                                    +
                                </button>
                            </div>
                            <div class="btnAddToCart">
                                <button name="add" class="btnGlobal btnAddCart" @click="agregarAlCarrito({ id: dataDetalle.data?.id, titulo: dataDetalle.data?.titulo, subcategoria: dataDetalle.data?.subcategoria?.titulo, presentacion: dataDetalle.data?.presentacion, precio_actual: parseFloat(dataDetalle.data?.precio_actual), poster: dataDetalle.data?.poster})">
                                    <div>
                                        <img :src="iconCart" />
                                    </div>
                                    <p class="DescripcionRegular txtBlanco">
                                        AÑADIR AL CARRITO
                                    </p>
                                </button>
                            </div>
                        </div>
                        <div class="productoRelacionadosContainer1">
                            <div class="headerContainer">
                                <h2 class="DescripcionRegular fontWeight500 grisOscuro4">Va bien con:</h2>
                            </div>
                            <div class="listItemsProducts">
                                <!-- Carrusel principal -->
                                <Splide
                                    :options="mainOptions2"
                                    ref="mainSplide2"
                                    class="spileMiniCarrusel"
                                    >
                                    <SplideSlide v-for="(relacionado, indexj) in dataDetalle?.data?.relacionados" :key="indexj">
                                        <div class="itemContainer">
                                            <div class="detailProduct">
                                                <div class="pictureContainer">
                                                    <img :src="relacionado.poster" :alt="relacionado.titulo"/>
                                                </div>
                                                <div class="detailContainer">
                                                    <h2 class="DescripcionRegular txtVerde" v-html="relacionado.titulo"></h2>
                                                    <p class="DescripcionRegular grisOscuro2 fontWeight400" v-html="relacionado.subtitulo"></p>
                                                    <h3 class="mt2 DescripcionRegular grisOscuro2 fontWeight400">{{formatCurrency(relacionado.precio_actual) }}</h3>
                                                </div>
                                            </div>
                                            <div class="addItemProduct">
                                                <button class="circuloRegular txtVerde DescripcionMediano" @click="agregarAlCarrito({ id: relacionado?.id, titulo: relacionado?.titulo, subcategoria: relacionado?.subcategoria?.titulo, presentacion: relacionado?.presentacion, precio_actual: parseFloat(relacionado?.precio_actual), poster: relacionado?.poster})">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </SplideSlide>
                                </Splide>
                                
                            </div>
                        </div>
                        <div class="deliveryContainer">
                            <div class="itemDelivery">
                                <div class="circuloContainer2">
                                    <img :src="imgDelivery1" alt="HASTA 30 DÍAS DE  RETORNO" />
                                </div>
                                <p class="DescripcionMediano2 txtGrisOscuro2 fontWeight500">
                                    HASTA 30 <br />
                                    DÍAS DE <br />
                                    RETORNO
                                </p>
                            </div>
                            <div class="itemDelivery">
                                <div class="circuloContainer2">
                                    <img :src="imgDelivery2" alt="HASTA 30 DÍAS DE  RETORNO" />
                                </div>
                                <p class="DescripcionMediano2 txtGrisOscuro2 fontWeight500">
                                    ENVIO <br />
                                    GRATIS*
                                </p>
                            </div>
                            <div class="itemDelivery">
                                <div class="circuloContainer2">
                                    <img :src="imgDelivery3" alt="HASTA 30 DÍAS DE  RETORNO" />
                                </div>
                                <p class="DescripcionMediano2 txtGrisOscuro2 fontWeight500">
                                    SIN CRUELDAD <br />
                                    ANIMAL
                                </p>
                            </div>
                            <div class="itemDelivery">
                                <div class="circuloContainer2">
                                    <img :src="imgDelivery4" alt="HASTA 30 DÍAS DE  RETORNO" />
                                </div>
                                <p class="DescripcionMediano2 txtGrisOscuro2 fontWeight500">
                                    EMBALAJE <br />
                                    ECOLÓGICO
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useCartStore } from '@/js/stores/cart';
    import { useCartPanel } from '@/js/stores/useCartPanel';
     import { useCurrency } from '@/js/utils/useCurrency';
    import { useRoute } from 'vue-router';
    import { Splide, SplideSlide } from '@splidejs/vue-splide';
    import '@splidejs/splide/dist/css/splide.min.css';

    const route = useRoute();
    const slug = route.params.slug;
    const loading = ref(true);
    const iconCart = '/images/frontend/cart.svg';
    const imgDelivery1 = '/images/frontend/dia.svg';
    const imgDelivery2 = '/images/frontend/carro.svg';
    const imgDelivery3 = '/images/frontend/animal.svg';
    const imgDelivery4 = '/images/frontend/ecologico.svg';
    const { formatCurrency } = useCurrency();
    const images = [
        '/images/frontend/producto1.png',
        '/images/frontend/producto2.png',
        '/images/frontend/producto1.png',
        // Puedes cargar dinámicamente con una API de Laravel
    ];

    defineProps ({
        dataDetalle: Object,
        required: false,
        default: () => null
    });

    const mainSplide = ref(null);
    const mainSplide2 = ref(null);
    const thumbSplide = ref(null);

    const cart = useCartStore();
    const cartPanel = useCartPanel();
    const mainOptions = {
        type: 'slide',        // Desliza en lugar de hacer fade
        perPage: 1,           // Una imagen por slide (esto es importante)
        heightRatio: 0.5,     // Ajusta la altura respecto al ancho del contenedor
        pagination: false,    // Oculta los dots
        arrows: false,         // Si quieres flechas (puedes dejarlo en false si no)
        drag: true,           // Habilita arrastrar con mouse/touch
        cover: true,          // Hace que la imagen cubra el contenedor (útil si usas <img>)
        lazyLoad: 'nearby',   // (opcional) mejora carga si hay muchas imágenes
        rewind: true,         // (opcional) vuelve al inicio al llegar al final
    };

    const mainOptions2 = {
        type: 'slide',        // Desliza en lugar de hacer fade
        perPage: 1,           // Una imagen por slide (esto es importante)
        heightRatio: 0.5,     // Ajusta la altura respecto al ancho del contenedor
        pagination: true,    // Oculta los dots
        arrows: false,         // Si quieres flechas (puedes dejarlo en false si no)
        drag: true,           // Habilita arrastrar con mouse/touch
        cover: true,          // Hace que la imagen cubra el contenedor (útil si usas <img>)
        lazyLoad: 'nearby',   // (opcional) mejora carga si hay muchas imágenes
        rewind: true,         // (opcional) vuelve al inicio al llegar al final
    };

    const thumbOptions = {
        fixedWidth: 100,
        fixedHeight: 64,
        isNavigation: true,
        gap: 10,
        pagination: false,
        arrows: false,
        drag: true,
        focus: 'center',
        cover: true,
    };

    function getQuantity(productId) {
        return cart.getQuantity(productId);
    }

    function updateManualQuantity(event, productId) {
        const value = parseInt(event.target.value)
        if (value >= 1 && value <= 99) {
            cart.updateQuantity(productId, value)
        }
    }

    function increase(productId, producto) {
        if (cart.getQuantity(productId) === 0) cart.addToCart(producto);
        else{
            cart.increaseQuantity(productId);
        }
    }
    function decrease(productId) {
        cart.decreaseQuantity(productId);
    }
    function agregarAlCarrito(producto) {
        if (cart.getQuantity(producto.id) === 0) cart.addToCart(producto);
        // cart.addToCart(producto);
        cartPanel.open();
    }

    function goToSlide(index) {
        mainSplide.value?.go(index);
    }

    // function syncThumbnails(splide) {
    //     const newIndex = splide.index;
    //     console.log('Main moved to:', newIndex);
    //     thumbSplide.value?.go(newIndex);
    // }

    onMounted(async () => {
        if (typeof window.showTransition === 'function') {
            window.showTransition()
        };
        // Simula carga del producto
        await new Promise(resolve => setTimeout(resolve, 1500))

        loading.value = false;
        // Refresca Splide para asegurar que se renderiza correctamente
        // Forzar refresco para que Splide re-calibre los slides
        setTimeout(() => {
            if (mainSplide.value?.splide) {
                mainSplide.value.splide.refresh(); // ← Usa `.splide.refresh()`
            }

            if (mainSplide2.value?.splide) {
                mainSplide2.value.splide.refresh(); // ← Usa `.splide.refresh()`
            }
        }, 100); // espera un poco por si el DOM aún no está listo

        if (typeof window.hideTransition === 'function') {
            window.hideTransition();
        };

        const mainImageProduct = mainSplide.value?.splide;
        if (mainImageProduct) {
            mainImageProduct.on('moved', (newIndex) => {
                if (thumbSplide.value?.splide) {
                    thumbSplide.value.splide.go(newIndex);
                };
            });
        };
    })
</script>
