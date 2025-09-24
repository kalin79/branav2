<template>
    <div>
        <div class="viewSeccionContainer">
            <div class="datosCheckOutContainer">
                <div class="innerContent">
                    <div class="headerTitleContainer">
                        <h1 class="titularMediano2 txtGrisOscuro2 fontWeight500">Finaliza tu compra</h1>
                        <h2 class="titularMediano txtGrisOscuro2 fontWeight500">Contacto</h2>
                    </div>
                    <form @submit.prevent="onSubmit">
                        
                        <div class="inputContainer big separar">
                            <Field name="email" class="inputText txtGrisOscuro2" type="text" placeholder=""  />
                            <label for="email" class="labelFlotante">Correo electrónico</label>
                            <ErrorMessage name="email" class="noviewError"/>
                        </div>
                        <!-- <div class="checkContainer separar">
                            <label class="custom-checkbox inputText textoGrisClaro3">
                                <input type="checkbox" v-model="ofertas"/>
                                <span class="checkmark"></span>
                                Envíame un correo electrónico con noticias y ofertas.
                            </label>
                        </div> -->
                        <div class="subtitularContainer">
                            <h2 class="titularMediano txtGrisOscuro2 fontWeight500">Entrega</h2>
                            <div class="tipoEntregaContainer">
                                <div :class="[ tipoRecojo === '1' ? 'active bottom' : '' ]">
                                    <label 
                                        class="radio-container DescripcionMediano2 fontWeight400"
                                    >
                                        <input type="radio" v-model="tipoRecojo" value="1" />
                                        <span class="custom-radio"></span>
                                        Envío delivery
                                    </label>
                                    <div class="iconContainer">
                                        <img :src="iconDelivery" alt="Delivery"/>
                                    </div>
                                </div>
                                <div :class="[ tipoRecojo === '2' ? 'active top' : '' ]">
                                    <label 
                                        class="radio-container DescripcionMediano2 fontWeight400"
                                    >
                                        <input type="radio" v-model="tipoRecojo" value="2" />
                                        <span class="custom-radio"></span>
                                        Retiro en tienda
                                    </label>
                                    <div class="iconContainer">
                                        <img :src="iconTienda" alt="Tienda"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="subtitularContainer" v-show="tipoRecojo === '2'">
                            <h2 class="titularMediano txtGrisOscuro2 fontWeight500">Sucursales en tienda</h2>
                            <p class="inputText textoGrisClaro3">Seleccione la tienda de su preferencia.</p>
                            <div class="listaTiendasContainer">
                                <div class="items" :class="{ active: idTienda === 1 }"  @click="() => { seleccionarTienda(1) }">
                                    <div>
                                        <h2 class="DescripcionMediano2 fontWeight500 textoGrisClaro3">Oficina</h2>
                                        <h3 class="DescripcionPequeno fontWeight400 textoGrisClaro3">Calle Huaura 126, San Isidro, PE-LMA</h3>
                                    </div>
                                    <div>
                                        <h4 class="DescripcionMediano2 fontWeight500 txtGrisOscuro2">GRATIS</h4>
                                        <h3 class="DescripcionPequeno fontWeight400 textoGrisClaro3">Normalmente listo en 2 a 4 días</h3>
                                    </div>
                                </div>
                                <div class="items" :class="{ active: idTienda === 2 }" @click="() => { seleccionarTienda(2) }">
                                    <div>
                                        <h2 class="DescripcionMediano2 fontWeight500 textoGrisClaro3">Oficina</h2>
                                        <h3 class="DescripcionPequeno fontWeight400 textoGrisClaro3">Calle Huaura 126, San Isidro, PE-LMA</h3>
                                    </div>
                                    <div>
                                        <h4 class="DescripcionMediano2 fontWeight500 txtGrisOscuro2">GRATIS</h4>
                                        <h3 class="DescripcionPequeno fontWeight400 textoGrisClaro3">Normalmente listo en 2 a 4 días</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-show="tipoRecojo === '1'">
                            <!-- <div class="selectContainer" :class="{ hasValue: hasSeleccionPais }">
                            
                                <v-select
                                    v-model="selectedPais"
                                    :options="optionsPais"
                                    class="inputText txtGrisOscuro2 big"
                                    label="label"
                                    :reduce="o => o.value"
                                    placeholder=""
                                >
                                    <template #no-options>
                                        <div class="no-options">
                                            🚫 No se encontraron resultados
                                        </div>
                                    </template>
                                </v-select>
                                <label for="selectedPais" class="labelFlotante">País/Región</label>
                                
                            </div> -->
                            <div class="inputFlexContainer">
                                <div class="inputContainer big">
                                    <Field name="nombres"  class="inputText txtGrisOscuro2" type="text" placeholder="Nombres"  />
                                    <ErrorMessage name="nombres" class="noviewError"/>
                                    <label for="nombres" class="labelFlotante">Nombres</label>
                                </div>
                                <div class="inputContainer big">
                                    <Field name="apellidos" class="inputText txtGrisOscuro2" type="text" placeholder="Apellidos"  />
                                    <ErrorMessage name="apellidos" class="noviewError"/>
                                    <label for="apellidos" class="labelFlotante">Apellidos</label>
                                </div>
                            </div>
                            <div class="inputContainer big">
                                <Field name="documento" v-slot="{ field }">
                                    <input
                                        v-bind="field"
                                        class="inputText textoGrisClaro3"
                                        type="text"
                                        inputmode="numeric"
                                        placeholder="DNI / CE / Pasaporte"
                                        maxlength="12"
                                        pattern="\d*"
                                        @keydown="onKeyDown($event, field)"
                                        @paste="onPaste($event, field)"
                                        @compositionstart="onCompositionStart()"
                                        @compositionend="onCompositionEnd($event, field)"
                                    />
                                    <ErrorMessage name="documento" class="noviewError"/>
                                </Field>
                                <label for="documento" class="labelFlotante">DNI / CE / RUC</label>

                            </div>
                            <div class="inputContainer big">
                                <Field name="direccion" class="inputText txtGrisOscuro2" type="text" placeholder=""  />
                                <ErrorMessage name="direccion" class="noviewError"/>
                                <label for="direccion" class="labelFlotante">Dirección</label>
                            </div>
                            <div class="inputContainer big">
                                <Field  name="referencia" class="inputText txtGrisOscuro2" type="text" placeholder=""  />
                                <ErrorMessage name="referencia" />
                                <label for="referencia" class="labelFlotante">Casa, apartamento, etc. (opcional)</label>
                            </div>
                            <div class="inputFlexContainer">
                                <div class="selectContainer big" :class="{ hasValue: hasSeleccionDepartamento }">
                                    <v-select
                                        v-model="selectedDepartamento"
                                        :options="optionsDepartamento"
                                        class="inputText txtGrisOscuro2 big"
                                        label="label"
                                        :reduce="o => o.value"
                                    >
                                    <!-- Slot para personalizar el mensaje -->
                                        <template #no-options>
                                            <div class="no-options">
                                                🚫 No se encontraron resultados
                                            </div>
                                        </template>
                                    </v-select>
                                    <label for="selectedDepartamento" class="labelFlotante">Dpto.</label>
                                </div>
                                <div class="selectContainer big" :class="{ hasValue: hasSeleccionProvincia }">
                                    <v-select
                                        v-model="selectedProvincia"
                                        :options="optionsProvincia"
                                        class="inputText txtGrisOscuro2 big"
                                        label="label"
                                        :reduce="o => o.value"
                                    >
                                    <!-- Slot para personalizar el mensaje -->
                                        <template #no-options>
                                            <div class="no-options">
                                                🚫 No se encontraron resultados
                                            </div>
                                        </template>
                                    </v-select>
                                    <label for="selectedProvincia" class="labelFlotante">Ciudad</label>

                                </div>
                                
                            </div>
                            <div class="selectContainer big" :class="{ hasValue: hasSeleccionDistrito }">
                                <v-select
                                    v-model="selectedDistrito"
                                    :options="optionsDistrito"
                                    class="inputText txtGrisOscuro2 big"
                                    label="label"
                                    :reduce="o => o.value"
                                    @update:modelValue="onDistritoChange"
                                >
                                <!-- Slot para personalizar el mensaje -->
                                    <template #no-options>
                                        <div class="no-options">
                                            🚫 No se encontraron resultados
                                        </div>
                                    </template>
                                </v-select>
                                <label for="selectedDistrito" class="labelFlotante">Distrito</label>
                            </div>
                            <div class="inputContainer big">
                                <Field name="celular" v-slot="{ field }">
                                    <input
                                        v-bind="field"
                                        class="inputText textoGrisClaro3"
                                        type="text"
                                        inputmode="numeric"
                                        placeholder="celular"
                                        maxlength="18"
                                        pattern="\d*"
                                        @keydown="onKeyDown($event, field)"
                                        @paste="onPaste($event, field)"
                                        @compositionstart="onCompositionStart()"
                                        @compositionend="onCompositionEnd($event, field)"
                                    />
                                    <ErrorMessage name="documento" class="noviewError"/>
                                </Field>
                                <label for="celular" class="labelFlotante">Celular</label>
                            </div>
                            <div class="checkContainer separate">
                                <label class="custom-checkbox inputTextCheck textoGrisClaro3">
                                    <input
                                        type="checkbox"
                                        v-model="recordarDatosCheck"
                                        :true-value="true"
                                        :false-value="false"
                                    />
                                    <span class="checkmark"></span>
                                    Guardar mi información y consultar más 
                                    rápidamente la próxima vez
                                </label>
                            </div>
                            <div class="subtitularContainer">
                                <h2 class="titularMediano txtGrisOscuro2 fontWeight500">Métodos de envío</h2>
                                <div class="listaTiendasContainer">
                                    <div class="items active">
                                        <div>
                                            <h2 class="DescripcionMediano2 fontWeight300 textoGrisClaro2">Delivery</h2>
                                            <h3 class="DescripcionPequeno fontWeight400 textoGrisClaro3">2 a 5 días hábiles</h3>
                                        </div>
                                        <div>
                                            <h4 class="DescripcionMediano2 fontWeight500 txtGrisOscuro2">{{ formatCurrency(costoDelivery) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="subtitularContainer separate">
                            <h2 class="titularMediano txtGrisOscuro2 fontWeight500">Pago</h2>
                            <p class="inputText textoGrisClaro3">Todas las transacciones son seguras y están encriptadas.</p>
                            <div class="tarjetaContainer">
                                <div class="items">
                                    <div>
                                        <h2 class="DescripcionMediano2 fontWeight300 textoGrisClaro2">Mercado Pago</h2>
                                    </div>
                                    <div>
                                        <img :src="tarjeta" alt="Pago con Mercado Pago Brana" />
                                    </div>
                                </div>
                                <div class="viewTarjeta">
                                    <div>
                                        <img :src="iconTarjeta" alt="tarjeta Brana"/>
                                        <p class="DescripcionMediano2 fontWeight300 textoGrisClaro10">
                                            Después de hacer clic en “Pagar ahora”, serás redirigido a Mercado Pago para completar tu compra de forma segura.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="mensajeError" class="txtErrorContainer">
                            <span class="DescripcionMediano2 txtRosado">{{ mensajeError }}</span>
                        </div>
                        <div class="btnFormContainer">
                            <button type="submit" class="btnGlobal bgGrisOscuro">COMPRAR</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="datosProductosContainer">
                <div class="alignContenido">
                    <div class="innerContent">
                        <div class="listaCartProductsContainer">
                            <div class="itemProduct" v-for="(item, index) in cart.items" :key="index">
                                <div>
                                    <img :src="item.poster" :alt="item.titulo"/>
                                    <div class="cantidadContainer DescripcionMediano fontWeight500  txtBlanco">{{ getQuantity(item.id) }}</div>
                                </div>
                                <div>
                                    <div>
                                        <h3 to="/" class="DescripcionPequeno txtVerde fontWeight600">
                                             {{ item.subcategoria }}
                                        </h3>
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
                            </div>
                           
                        </div>
                        <div class="inputFlexDescuentoContainer">
                            <div class="inputContainer big separar bgBlanco">
                                <input v-model="codigoDescuento" class="inputText txtGrisOscuro2" type="text" placeholder=""  />
                                <label for="descuento" class="labelFlotante">Código de descuento</label>
                            </div>
                            <button type="buttom" class="btnGlobal bgVerdeClaro" @click="aplicarDescuento">Aplicar</button>
                            <!-- <p v-if="mensajeDescuento">{{ mensajeDescuento }}</p> -->
                        </div>
                        <div class="priceContainerFinal">
                            <div class="flexLinePrice">
                                <p class="DescripcionRegular txtGrisOscuro2">Subtotal</p>
                                <p class="DescripcionRegular txtGrisOscuro2">{{ formatCurrency(cart.totalPrice) }}</p>
                            </div>
                            <div class="flexLinePrice " v-if="tipoRecojo === '1'">
                                <p class="DescripcionRegular txtGrisOscuro2">Envío</p>
                                <p class="DescripcionRegular txtGrisOscuro2">{{ formatCurrency(costoDelivery) }}</p>
                            </div>
                            <div class="flexLinePrice" v-if="boolCuponDescuento">
                                <p class="DescripcionRegular txtGrisOscuro2">Cupón de descuento</p>
                                <p class="DescripcionRegular txtGrisOscuro2">{{ formatCurrency(montoDescuento) }}</p>
                            </div>
                            <div class="flexLinePrice2 line">
                                <div>
                                    <h3 class="DescripcionRegular txtGrisOscuro2">Total</h3>
                                    <p class="DescripcionMediano2 fontWeight300 textoGrisClaro3">Incluye S/ 29.14 de impuestos</p>
                                </div>
                                <div class="flexLineContainer">
                                    <p class="DescripcionMediano2 fontWeight300 textoGrisClaro3">PEN</p>
                                    <!-- <h3 class="DescripcionRegular txtGrisOscuro2" >{{  formatCurrency(formatCostoTotal(cart.totalPrice )) }}</h3> -->
                                    <!-- <h3 class="DescripcionRegular txtGrisOscuro2" v-if="boolCuponDescuento">{{ formatCurrency(totalDescuentoFinal) }}</h3> -->
                                    <h3 class="DescripcionRegular txtGrisOscuro2">{{ formatCurrency(totalFinal) }}</h3>
                                    
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
    import { initMercadoPago, Wallet } from "@mercadopago/sdk-js";
    import { onMounted } from "vue";
    // import { useRouter } from 'vue-router';
    import { ref, onBeforeUnmount,computed } from "vue";
    import { useForm, useField, Field, ErrorMessage} from 'vee-validate';
    import { toFormValidator , toTypedSchema} from "@vee-validate/zod";
    import * as z from 'zod';
    
    import vSelect from "vue3-select";
    import { useCurrency } from '@/js/utils/useCurrency';

    // import {useCartPanel} from '@/js/stores/useCartPanel';
    import { useUserStore } from "@/js/stores/user";
    import { useCartStore } from '@/js/stores/cart';

    const cart = useCartStore();
    const userStore = useUserStore();

    // 👇 se lee la PUBLIC_KEY desde el .env
    const PUBLIC_KEY = import.meta.env.VITE_MERCADO_PAGO_PUBLIC_KEY;
    let mp = null;
    let checkout = null;
    const { formatCurrency } = useCurrency();
    const tarjeta = '/images/frontend/tarjeta2.svg';
    const iconTarjeta = '/images/frontend/icontarjeta.svg';
    const tipoRecojo = ref("1");
    const iconDelivery = '/images/frontend/delivery.svg';
    const iconTienda = '/images/frontend/tienda.svg';
    const idTienda = ref("");
    const codigoDescuento = ref(null);
    const mensajeDescuento = ref("");
    const recordarDatosCheck = ref(false); // true/false
    const costoDelivery = ref(0);
    const boolCuponDescuento = ref(false);
    

    const selectedDepartamento = ref(null);
    const hasSeleccionDepartamento = computed(() => !!selectedDepartamento.value)
    const optionsDepartamento = [
        { value: 1, label: "Junin" },
        { value: 2, label: "Arequipa" },
        { value: 3, label: "Lima" },
    ];

    const selectedProvincia = ref(null);
    const hasSeleccionProvincia = computed(() => !!selectedProvincia.value)

    const optionsProvincia = [
        { value: 1, label: "Lima" },
        { value: 2, label: "Callao" },
    ];

    const selectedDistrito = ref(null);
    const hasSeleccionDistrito = computed(() => !!selectedDistrito.value)

    const optionsDistrito = [
        { value: 1, label: "San Miguel" },
        { value: 2, label: "Miraflores" },
    ];

    const selectedRecibo = ref(null);
    const optionsRecibo = [
        { value: 1, label: "Boleta" },
        { value: 2, label: "Factura" },
    ];

    const ruc = ref("");
    const direccionRUC = ref("");
    const razonSocial = ref("");

    const totalConDescuento = ref(0);
    const montoDescuento = ref(0);
    async function aplicarDescuento() {
        try {
            // ESTO DEBO ENVIAR

            // {
            //     codigo: codigoDescuento.value,
            //     totalCompra: cart.totalPrice,
            // }


            // const res = await fetch("/api/descuento", {
            // method: "POST",
            // headers: { "Content-Type": "application/json" },
            // body: JSON.stringify({
            //     codigo: codigoDescuento.value,
            //     totalCompra: cart.totalPrice,
            // }),
            // })
            // const data = await res.json()
            let data = {};
            if (codigoDescuento.value === 'branacode'){
                cart.activarDescuento();
                data = {
                    "valido": true,
                    "tipo": "porcentaje",
                    "valor": 20,
                    "montoDescuento": (cart.totalPrice*20/100),
                    "totalConDescuento": (cart.totalPrice - (cart.totalPrice*20/100)),
                    "mensaje": "Se aplicó un 20% de descuento a tu compra."
                }
            }else{
                cart.desactivarDescuento()
                data = {
                    "valido": false,
                    "mensaje": "El código ha expirado o no es válido."
                }
            }

            if (data.valido) {
                totalConDescuento.value = data.totalConDescuento
                montoDescuento.value = data.montoDescuento
                mensajeDescuento.value = data.mensaje
                boolCuponDescuento.value = true
            } else {
                mensajeDescuento.value = data.mensaje
                boolCuponDescuento.value = false
            }
        } catch (err) {
            console.error(err)
            mensajeDescuento.value = "Error al validar el código."
        }
    }

    // const totalDescuentoFinal = computed(() => {
    //     return tipoRecojo.value === '1'
    //         ? totalConDescuento.value + costoDelivery.value
    //         : totalConDescuento.value;
    // });

    const totalFinal = computed(() => {
        if (boolCuponDescuento.value){
            return tipoRecojo.value === '1'
            ? totalConDescuento.value + costoDelivery.value
            : totalConDescuento.value;
        }else {
            return tipoRecojo.value === '1'
            ? cart.totalPrice + costoDelivery.value
            : cart.totalPrice;
        }
        
    });


    async function onDistritoChange(distritoId) {
        try {
            // llamada a tu API
            // const res = await fetch("http://localhost:8000/consultadelivery", {
            //     method: "POST",
            //     headers: { "Content-Type": "application/json" },
            //     body: JSON.stringify({ distrito: distritoId }),
            // })

            // if (!res.ok) {
            //     throw new Error("Error consultando costo de delivery")
            // }

            // const data = await res.json()
            // supongo que el backend devuelve algo como { costo: 12 }
            console.log(distritoId)
            costoDelivery.value = 15 ?? 0
        } catch (err) {
            console.error(err)
            costoDelivery.value = 20 // fallback
            mensajeError.value = "No se pudo calcular el costo del delivery, intentelo mas tarde.";
        }
    }
   
    function seleccionarTienda(valor) {
        idTienda.value = valor
    }

    function getQuantity(productId) {
        return cart.getQuantity(productId);
    }

    // const formatCostoTotal = (total) => {
    //     console.log(total)
    //     if (tipoRecojo.value === '1'){
    //         return total + costoDelivery.value;
    //     }else{
    //         return total;
    //     }
    // }

    

    const isComposing = ref(false);

    function onCompositionStart() {
        isComposing.value = true;
    }

    function onCompositionEnd(e, field) {
        // IME terminó: limpiar y truncar
        isComposing.value = false;
        field.value = (field.value || '').replace(/\D/g, '').slice(0, 12);
    }

    function onKeyDown(e, field) {
        // si está en composición IME, no interferir
        if (isComposing.value) return;

        // teclas permitidas para edición / navegación
        const controlKeys = [
            'Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown',
            'Tab','Home','End','Enter'
        ];
        if (controlKeys.includes(e.key)) return;

        // solo permitir una única cifra (0-9)
        if (!/^[0-9]$/.test(e.key)) {
            e.preventDefault();
            return;
        }

        // control de longitud considerando selección (para permitir reemplazar selección)
        const current = field.value || '';
        const target = e.target;
        const selStart = typeof target.selectionStart === 'number' ? target.selectionStart : current.length;
        const selEnd = typeof target.selectionEnd === 'number' ? target.selectionEnd : current.length;
        const resultingLength = current.length - (selEnd - selStart) + 1; // +1 por la nueva cifra

        if (resultingLength > 12) {
            e.preventDefault();
            return;
        }
    }

    function onPaste(e, field) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
        const digits = paste.replace(/\D/g, '');
        if (!digits) return;

        const current = field.value || '';
        const target = e.target;
        const selStart = typeof target.selectionStart === 'number' ? target.selectionStart : current.length;
        const selEnd = typeof target.selectionEnd === 'number' ? target.selectionEnd : current.length;

        const allowed = 12 - (current.length - (selEnd - selStart));
        if (allowed <= 0) return;

        const toInsert = digits.slice(0, allowed);
        const newValue = current.slice(0, selStart) + toInsert + current.slice(selEnd);
        field.value = newValue;
    }

    // Esquema con Zod
    const schema = z.object({
        nombres: z
            .string()
            .nonempty("El nombre es obligatorio")
            .min(2, "El nombre debe tener al menos 2 caracteres")
            .max(20, "El nombre no debe tener más de 20 caracteres")
            .regex(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/, "El nombre solo debe contener letras"),
        apellidos: z
            .string()
            .nonempty("El apellido es obligatorio")
            .min(2, "El apellido debe tener al menos 2 caracteres")
            .max(20, "El apellido no debe tener más de 20 caracteres")
            .regex(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/, "El apellido solo debe contener letras"),
        documento: z
            .string()
            .regex(/^[0-9]+$/, "El documento solo debe contener números")
            .min(8, "El documento debe tener al menos 8 dígitos")
            .max(12, "El documento no debe tener más de 12 dígitos")
            .nonempty("El documento es obligatorio"),
        direccion: z
            .string()
            .nonempty("La dirección es obligatorio")
            .min(2, "La dirección debe tener al menos 2 caracteres")
            .max(100, "La dirección no debe tener más de 20 caracteres"),
        celular: z
            .string()
            .regex(/^[0-9]+$/, "El celular solo debe contener números")
            .min(9, "El celular debe tener al menos 9 dígitos")
            .max(16, "El celular no debe tener más de 16 dígitos")
            .nonempty("El celular es obligatorio"),
        email: z.string().email("Ingrese un correo válido"),
        // 👇 Aquí los adicionales
        tipoRecibo: z.any().optional(),
        ruc: z.string().optional(),
        referencia: z.string().optional(),
        razonSocial: z.string().optional(),
        direccionRUC: z.string().optional(),
    });

    

    // Estado del mensaje global
    const mensajeError = ref("");

    const { handleSubmit, setValues, values } = useForm({
        validationSchema: toTypedSchema(schema),
        initialValues: {
            email: "",
            nombres: "",
            apellidos: "",
            documento: "",
            direccion: "",
            celular: "",
            referencia: "",
        },
    });
    const form = values;
    

    // 🚨 Aquí simulas la creación de la preferencia en tu backend
    async function crearPreferencia(values) {
        try {
            const res = await fetch("http://localhost:8000/create_preference", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(values),
            });
            const data = await res.json();
            return data.preference_id; // el preferenceId
        } catch (e) {
            console.error("Error creando preferencia", e);
            mensajeError.value = "No se pudo iniciar el pago: " + e.message;
            return null;
        }
    }

    const onSubmit = handleSubmit(
        async (validatedValues) => {
            
            const payload = {
                ...validatedValues, // valores que pasaron validación
                idTienda: idTienda.value,
                recordarDatosCheck: Boolean(recordarDatosCheck.value),
                tipoRecojo: tipoRecojo.value,
                productos: JSON.parse(JSON.stringify(cart.items)),
                totalPagar: totalFinal.value,
                montoDescuento: montoDescuento.value,
                codigoDescuento: codigoDescuento.value,
                costoDelivery: costoDelivery.value,
                boolCuponDescuento: Boolean(boolCuponDescuento.value)
            };
            console.log("payload checkout ->", payload);
            // console.log("payload cart ->", JSON.parse(JSON.stringify(cart.items)));
            return

            mensajeError.value = ""; // limpiar si todo ok
            try {
                // Simulación de login
                console.log("Enviando datos:", values);

                // Integracion con Mercado Pago
                const preferenceId = await crearPreferencia(values);

                if (!preferenceId) {
                    mensajeError.value = "No se pudo iniciar el pago.";
                    return;
                }

                // Abre el checkout en un modal dentro de tu página
                checkout = mp.checkout({
                    preference: {
                        id: preferenceId,
                    },
                    autoOpen: true, // ✅ abre el modal automáticamente
                    theme: {
                        elementsColor: "#3483fa",
                        headerColor: "#3483fa",
                    },
                });

                // Abrir el popup al hacer click
                checkout.open();

                // router.push('/checkouts');

            } catch (e) {
                mensajeError.value = "Hubo un problema al procesar el pago.";
                console.error(e);
            }
        },
        (errors) => {
            // Mostrar error específico según el campo
            console.log(errors);
            if (errors.errors.email) {
                mensajeError.value = errors.errors.email;
            } else if (errors.errors.nombres){
                mensajeError.value = errors.errors.nombres;
            } else if (errors.errors.apellidos){
                mensajeError.value = errors.errors.apellidos;
            } 
            else {
                mensajeError.value = "Por favor revisa los campos antes de continuar.";
            }
        }
    );

    onMounted(() => {
        // Configuracion MERCADO PAGO
        // Inicializar SDK solo 1 vez
        mp = new window.MercadoPago(PUBLIC_KEY, {
            locale: "es-PE", // cambia según tu país
        });
        cart.desactivarDescuento()
        // 🔹 lee usuario desde storage
        const storedUser = userStore.getUserFromStorage();
        console.log(storedUser)
        // 🔹 si ya está cargado en el store, úsalo para precargar el form
        if (storedUser) {
            setValues({
                email: storedUser.email || "",
                nombres: storedUser.nombres || "",
                apellidos: storedUser.apellidos || "",
                documento: storedUser.documento || "",
                direccion: storedUser.direccion || "",
                celular: storedUser.celular || "",
                referencia: storedUser.referencia || "",
            });
        }

        // 🔹 lee datos previos del checkout desde el cartStore
        console.log(Object.keys(cart.checkoutForm).length)
        console.log(JSON.parse(JSON.stringify(cart.checkoutForm)))
        if (cart.checkoutForm && Object.keys(cart.checkoutForm).length) {
            setValues({
                ...values, // mantiene los valores actuales del usuario
                ...JSON.parse(JSON.stringify(cart.checkoutForm)) // ⚡ convierte Proxy a objeto plano
            });

        

         
            selectedRecibo.value = optionsRecibo.find(
                option => option.value === Number(cart.checkoutForm.tipoRecibo)
            ) || null;

            selectedDepartamento.value = optionsDepartamento.find(
                option => option.value === Number(cart.checkoutForm.departamento)
            ) || null;

            selectedProvincia.value = optionsProvincia.find(
                option => option.value === Number(cart.checkoutForm.provincia)
            ) || null;

            selectedDistrito.value = optionsDistrito.find(
                option => option.value === Number(cart.checkoutForm.distrito)
            ) || null;

            ruc.value = cart.checkoutForm.ruc || "";
            razonSocial.value = cart.checkoutForm.razonSocial || "";
            direccionRUC.value = cart.checkoutForm.direccionRUC || "";
            costoDelivery.value = cart.checkoutForm.costoDelivery ?? "";
        }
    });


    
</script>