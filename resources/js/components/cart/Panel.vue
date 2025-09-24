<template>
    <transition
        @enter="enterAnimation"
        @leave="leaveAnimation"
        appear
    >
        <div v-if="cartPanel.isOpen" ref="modalContent" class="panelCartContainer">
            <div class="overlayPanelContainer"></div>
            <div class="cartFormPanel">
                <div class="headerPanelCart">
                    <div>
                        <h3 class="titularMediano2 txtNegro">Carrito <span class="tituloMiga txtNegro fontWeight300">({{ cart.totalItems }})</span></h3>
                    </div>
                    <div>
                        <button type="button">
                            <svg class="icon-close" @click="closeCart" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg" data-v-327431ea=""><path d="M20 1L1 20" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M1 1L20 20" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="messageEmptyContainer" v-show="!boolProducto">
                    <h2 class="titularGrande2 txtNegro">Tu carrita est&aacute;</h2>
                    <h3 class="titularGrande2 fontEditorialItalic txtNegro">vacio</h3>
                    <router-link to="/" class="btnGlobalTransparente">Ver productos</router-link>
                </div>
                
                <div class="listProductsCartContainer" v-show="boolProducto">
                    <ul>
                    
                        <li v-for="item in cart.items" :key="item.id">
                            <div class="itemProduct">
                                <div>
                                    <img :src="item.poster" alt=""/>
                                </div>
                                <div>
                                    <div class="infoTopContainer">
                                        <div>
                                            <router-link to="/" class="DescripcionPequeno txtVerde fontWeight600">
                                                {{ item.subcategoria }}
                                            </router-link>
                                            <h2 class="DescripcionPequeno txtGrisOscuro2 fontWeight500">
                                                {{ item.titulo }}
                                            </h2>
                                            <p class="inputText fontWeight500 textoGrisClaro7">
                                                {{ item.presentacion }}
                                            </p>
                                        </div>
                                        <div class="priceContainer">
                                            <h3 class="DescripcionPequeno txtGrisOscuro2 fontWeight500">
                                                {{ formatCurrency(item.precio_actual) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="infoBottomContainer">
                                        <div class="quantityCartContainer">
                                            <button class="txtGrisOscuro6 DescripcionPequeno" @click="decrease(item.id)">
                                                -
                                            </button>
                                            <input 
                                                type="number" 
                                                class="DescripcionPequeno txtGrisOscuro2 fontWeight500" 
                                                :value="getQuantity(item.id)" 
                                                @input="updateManualQuantity($event, item.id)"
                                                name="quantity" 
                                                min="1"
                                                max="99"
                                            />
                                            <button class="txtGrisOscuro6 DescripcionPequeno" @click="increase(item.id)">
                                                +
                                            </button>
                                        </div>
                                        <button @click="deletedProduct(item.id)" class="circuloBtn">
                                            <svg data-v-327431ea="" class="icon-remove" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.33301 7.33301V10.6663M2.66634 3.99967H13.333L12.2797 13.4797C12.2436 13.8059 12.0884 14.1074 11.8438 14.3263C11.5993 14.5453 11.2826 14.6664 10.9543 14.6663H5.04501C4.71676 14.6664 4.40005 14.5453 4.15551 14.3263C3.91096 14.1074 3.75578 13.8059 3.71967 13.4797L2.66634 3.99967ZM4.89634 2.09767C5.00418 1.86899 5.17481 1.67567 5.38834 1.54028C5.60188 1.40489 5.8495 1.333 6.10234 1.33301H9.89701C10.15 1.33288 10.3977 1.40471 10.6114 1.5401C10.8251 1.6755 10.9958 1.86888 11.1037 2.09767L11.9997 3.99967H3.99967L4.89634 2.09767V2.09767ZM1.33301 3.99967H14.6663H1.33301ZM6.66634 7.33301V10.6663V7.33301Z" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="cartTotalToPayContainer">
                        <div>
                            <h4 class="DescripcionRegular txtGrisOscuro6 fontWeight500">SubTotal</h4>
                            <h3 class="DescripcionRegular txtGrisOscuro6 fontWeight500">
                                {{ formatCurrency(cart.totalPrice) }}
                            </h3>
                        </div>
                        <div>
                            <div>
                                <button class="btnGlobal bgGrisOscuro" @click="irCompra">
                                    <span class="DescripcionPequeno txtBlanco">FINALIZAR COMPRA</span>
                                    <!-- <svg ref="arrow" class="icon-arrow" width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg" data-v-327431ea=""><path d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464466C8.97631 0.269204 8.65973 0.269204 8.46447 0.464466C8.2692 0.659728 8.2692 0.976311 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4.5H12V3.5H0V4.5Z" fill="white"></path></svg> -->
                                </button>
                            </div>
                            <div>
                                <button class="btnGlobal bgVerdeClaro" @click="irCatalogo">
                                    <span class="DescripcionPequeno txtBlanco">IR AL CATÁLOGO</span>
                                    <!-- <svg ref="arrow" class="icon-arrow" width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg" data-v-327431ea=""><path d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464466C8.97631 0.269204 8.65973 0.269204 8.46447 0.464466C8.2692 0.659728 8.2692 0.976311 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4.5H12V3.5H0V4.5Z" fill="white"></path></svg> -->
                                </button>
                            </div>
                        </div>
                        <div>
                            <p class="DescripcionPequeno txtGrisOscuro6">El envío, los impuestos y los códigos de descuento se calculan al finalizar la compra</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </transition>
</template>

<script setup>
    import { useRouter } from 'vue-router';
    import { ref, onBeforeUnmount,computed } from 'vue';
    import { gsap } from 'gsap';
    import {useCartPanel} from '@/js/stores/useCartPanel';
    import { useCartStore } from '@/js/stores/cart';
    import { useCurrency } from '@/js/utils/useCurrency';
    const router = useRouter();
    const { formatCurrency } = useCurrency();
    const producto1 = '/images/frontend/producto1.png';
    const cartPanel = useCartPanel();
    const boolProducto = computed(() => cart.totalItems > 0);
    // const arrow = ref(null);
    const cart = useCartStore();
    let arrowTween = null;

    const emit = defineEmits(['close']);
    const modalContent = ref(null);

    function irCatalogo() {
        cartPanel.close();
        // Espera 300ms (o el tiempo que dure tu animación del panel)
        setTimeout(() => {
            router.push('/productos');
        }, 300);
    }

    function irCompra(){
        cartPanel.close();
        // Espera 300ms (o el tiempo que dure tu animación del panel)
        setTimeout(() => {
            router.push('/cart');
        }, 300);
    }

    function enterAnimation(el, done) {
        const overlay = el.querySelector('.overlayPanelContainer');
        const panel = el.querySelector('.cartFormPanel');
        const tl = gsap.timeline({ onComplete: done });

        tl.fromTo(
            overlay,
            { opacity: 0 },
            { opacity: 1, duration: 0.4 }
        );
        tl.fromTo(
            panel,
            { x: '100%', opacity: 0 },
            { x: '0%', opacity: 1, duration: 0.5 }
        );
    }

    function leaveAnimation(el, done) {
        const overlay = el.querySelector('.overlayPanelContainer');
        const panel = el.querySelector('.cartFormPanel');

        const tl = gsap.timeline({ onComplete: done });

        tl.to(
            panel,
            { x: '100%', opacity: 0, duration: 0.4 }
        );

        tl.to(
            overlay,
            { opacity: 0, duration: 0.3 }
        );
    }

    const closeCart = () => {
        cartPanel.close();
    };

    function deletedProduct(productId){
        cart.removeFromCart(productId);
    }

    function getQuantity(productId) {
        return cart.getQuantity(productId);
    }

    function updateManualQuantity(event, productId) {
        const value = parseInt(event.target.value)
        if (value >= 1 && value <= 99) {
            cart.updateQuantity(productId, value)
        }
    }

    function increase(productId) {
        cart.increaseQuantity(productId);
    }
    function decrease(productId) {
        cart.decreaseQuantity(productId);
    }
    // const startArrowAnim = () => {
    //     arrowTween = gsap.to(arrow.value, {
    //         x: 5, // mueve 5px a la derecha
    //         duration: 0.4,
    //         ease: 'power1.inOut',
    //         yoyo: true,
    //         repeat: -1, // loop infinito
    //     });
    // };
    // const stopArrowAnim = () => {
    //     if (arrowTween) {
    //         arrowTween.kill()
    //         gsap.set(arrow.value, { x: 0 }) // vuelve a su posición original
    //     }
    // }

    // Por si el componente se destruye antes de terminar
    onBeforeUnmount(() => {
        if (arrowTween) arrowTween.kill();
    })
</script>