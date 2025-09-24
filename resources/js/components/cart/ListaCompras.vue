<template>
    <div class="infoCartContainer">
        <div class="listaProductoCart">
            <div class="itemProduct" v-for="item in cart.items" :key="item.id">
                <div class="imgContainer">
                    <img :src="item.poster" :alt="item.titulo"/>
                </div>
                <div class="detailProductContainer">
                    <div>
                        <div class="detailTop">
                            <div>
                                <h2 class="DescripcionMediano2 textoVerdeClaro2 fontWeight600"> {{ item.subcategoria }}</h2>
                                <h3 class="DescripcionMediano2 txtGrisOscuro2 fontWeight500">{{ item.titulo }}</h3>
                                <p class="inputText fontWeight500 textoGrisClaro7"> {{ item.presentacion }}</p>
                            </div>
                            <div>
                                <h3>{{ formatCurrency(item.precio_actual) }}</h3>
                                <h4>{{ formatCurrency(aplicaDescuentoIndividualProducto(item.precio_actual, getQuantity(item.id), item.id)) }}</h4>
                            </div>
                        </div>
                        <div class="detailBottom">
                            <div class="quantityCartContainer">
                                <button class="txtGrisOscuro6 DescripcionPequeno" @click="decrease(item.id)">
                                    -
                                </button>
                                <input 
                                    type="number" 
                                    class="titularMediano txtGrisOscuro2 fontWeight500" 
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
            </div>
        </div>
        <div class="userCartContainer">
            <div class="formUserContainer">
                <div class="accessUserCartTitle">
                    <p class="DescripcionRegular txtGrisOscuro2">Por favor, coloca tus datos...</p>
                    <router-link class="DescripcionRegular txtGrisOscuro2" to="/auth/login" v-if="!userStore.isAuthenticate">Login</router-link>
                </div>
                <form @submit.prevent="onSubmit">
                    <div class="inputContainer">
                        <Field name="email" class="inputText textoGrisClaro3" type="text" placeholder="Correo electrónico"  />
                        <ErrorMessage name="email" class="noviewError"/>
                    </div>
                    <div class="inputContainer">
                        <Field name="nombres"  class="inputText textoGrisClaro3" type="text" placeholder="Nombres"  />
                        <ErrorMessage name="nombres" class="noviewError"/>
                    </div>
                    <div class="inputContainer">
                        <Field name="apellidos" class="inputText textoGrisClaro3" type="text" placeholder="Apellidos"  />
                        <ErrorMessage name="apellidos" class="noviewError"/>
                    </div>
                    <div class="inputContainer">
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
                    </div>
                    <div class="selectContainer">
                        <v-select
                            v-model="selectedDepartamento"
                            :options="optionsDepartamento"
                            class="inputText textoGrisClaro3"
                            label="label"
                            placeholder="Departamento..."
                        >
                        <!-- Slot para personalizar el mensaje -->
                            <template #no-options>
                                <div class="no-options">
                                    🚫 No se encontraron resultados
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="selectContainer">
                        <v-select
                            v-model="selectedProvincia"
                            :options="optionsProvincia"
                            class="inputText textoGrisClaro3"
                            label="label"
                            placeholder="Provincia..."
                        >
                        <!-- Slot para personalizar el mensaje -->
                            <template #no-options>
                                <div class="no-options">
                                    🚫 No se encontraron resultados
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="selectContainer">
                        <v-select
                            v-model="selectedDistrito"
                            :options="optionsDistrito"
                            class="inputText textoGrisClaro3"
                            label="label"
                            placeholder="Distrito..."
                            @update:modelValue="onDistritoChange"
                        >
                        <!-- Slot para personalizar el mensaje -->
                            <template #no-options>
                                <div class="no-options">
                                    🚫 No se encontraron resultados
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="inputContainer">
                        <Field name="direccion"  class="inputText textoGrisClaro3" type="text" placeholder="Dirección"  />
                        <ErrorMessage name="direccion" class="noviewError"/>
                    </div>
                    <div class="inputContainer">
                        <Field name="referencia"  class="inputText textoGrisClaro3" type="text" placeholder="Dpto. / Casa / Referencia"  />
                        <ErrorMessage name="referencia" />
                    </div>
                    <div class="inputContainer">
                        <!-- <Field name="celular" v-model="form.celular" class="inputText textoGrisClaro3" type="text" placeholder="Celular"  />
                        <ErrorMessage name="celular" /> -->
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
                    </div>
                    <div class="facturaContainer">
                        <p class="DescripcionRegular txtGrisOscuro2">Seleccione tipo de documento:</p>
                    </div>
                    <div class="selectContainer">
                        
                        <v-select
                            v-model="selectedRecibo"
                            :options="optionsRecibo"
                            class="inputText textoGrisClaro3"
                            label="label"
                            placeholder="Boleta / Factura..."
                        >
                        
                        <!-- Slot para personalizar el mensaje -->
                            <template #no-options>
                                <div class="no-options">
                                    🚫 No se encontraron resultados
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <!-- aaa {{ selectedRecibo.value }} -->
                    <div v-if="selectedRecibo && selectedRecibo.value === 2" class="datosFacturaContainer">
                        <div class="inputContainer">
                            <input name="ruc" v-model="ruc" class="inputText textoGrisClaro3" type="text" placeholder="RUC"  />
                            

                        </div>
                        <div class="inputContainer">
                            <input name="razonSocial" v-model="razonSocial" class="inputText textoGrisClaro3" type="text" placeholder="Razón Social"  />
                            
                        </div>
                        <div class="inputContainer">
                            <input name="direccionRUC" v-model="direccionRUC"  class="inputText textoGrisClaro3" type="text" placeholder="Dirección para facturación"  />
                        
                        </div>
                    </div>
                    <div class="checkContainer">
                        <label class="custom-checkbox inputTextCheck textoGrisClaro3">
                            <input
                            type="checkbox"
                            v-model="tycChecked"
                            :true-value="true"
                            :false-value="false"
                            />
                            <span class="checkmark"></span>
                            Acepto términos y condiciones
                        </label>
                    </div>
                    <div class="checkContainer">
                        <label class="custom-checkbox inputTextCheck textoGrisClaro3">
                            <input
                            type="checkbox"
                            v-model="politicaChecked"
                            :true-value="true"
                            :false-value="false"
                            />
                            <span class="checkmark"></span>
                            Acepto la política de privacidad
                        </label>
                    </div>
                    <div class="checkContainer">
                        <label class="custom-checkbox inputTextCheck textoGrisClaro3">
                            <input
                            type="checkbox"
                            v-model="ofertasChecked"
                            :true-value="true"
                            :false-value="false"
                            />
                            <span class="checkmark"></span>
                            Envíame un correo electrónico con noticias y ofertas.
                        </label>
                    </div>
                    <div class="priceCartContainer">
                        <div class="itemsFlex">
                            <p class="DescripcionMediano textoGrisClaro3">Total parcial</p>
                            <p class="DescripcionMediano textoGrisClaro3">{{ formatCurrency(cart.totalPrice)  }}</p>
                        </div>
                        <div class="itemsFlex">
                            <h3 class="titularMediano2 fontWeight500 txtGrisOscuro2">Total</h3>
                            <h3 class="titularMediano2 fontWeight500 txtGrisOscuro2">{{ formatCurrency(cart.totalPrice)  }}</h3>
                        </div>
                        <div v-if="mensajeError" class="txtErrorContainer">
                            <span class="DescripcionMediano2 txtRosado">{{ mensajeError }}</span>
                        </div>
                        <div class="itemsBtn">
                            <div class="btnContainer">
                                <button type="submit" class="btnGlobal bgGrisOscuro">COMPRAR</button>
                            </div>
                            <div class="tarjetasContainer">
                                <img :src="tarjeta" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</template>
<script setup>
    import { useRouter } from 'vue-router';
    import { ref, onBeforeUnmount,computed, onMounted } from 'vue';
    import { useForm, useField, Field, ErrorMessage } from 'vee-validate';
    import { toFormValidator, toTypedSchema } from "@vee-validate/zod";
    import * as z from 'zod';
    import { gsap } from 'gsap';
    import {useCartPanel} from '@/js/stores/useCartPanel';
    import { useCartStore } from '@/js/stores/cart';
    import { useCurrency } from '@/js/utils/useCurrency';
    import { useUserStore } from "@/js/stores/user";
    import vSelect from "vue3-select";
    // import "vue3-select/dist/vue3-select.css";
    const router = useRouter();
    const tyc = ref(false); // true/false
    const politica = ref(false); // true/false
    const ofertas = ref(false); // true/false
    const selectedDepartamento = ref(null);
    const optionsDepartamento = [
        { value: 1, label: "Junin" },
        { value: 2, label: "Arequipa" },
        { value: 3, label: "Lima" },
    ];

    const selectedProvincia = ref(null);
    const optionsProvincia = [
        { value: 1, label: "Lima" },
        { value: 2, label: "Callao" },
    ];

    const selectedDistrito = ref(null);
    const optionsDistrito = [
        { value: 1, label: "San Miguel" },
        { value: 2, label: "Miraflores" },
    ];

    const selectedRecibo = ref(null);
    const optionsRecibo = [
        { value: 1, label: "Boleta" },
        { value: 2, label: "Factura" },
    ];


    const tarjeta = '/images/frontend/tarjeta.svg';

    const { formatCurrency } = useCurrency();
    const cartPanel = useCartPanel();
    const boolProducto = computed(() => cart.totalItems > 0);
    const imgProduct = '/images/frontend/p3.png';
    const cart = useCartStore();
    const userStore = useUserStore();
    const costoDelivery = ref(0);

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

    function increase(productId) {
        cart.increaseQuantity(productId);
    }
    function decrease(productId) {
        cart.decreaseQuantity(productId);
    }
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

    const aplicaDescuentoIndividualProducto = (precio, cantidad, boolDescuentoProducto) => {
        console.log(boolDescuentoProducto);  // ej. id: 1
        let _total = precio * cantidad
        let _descuento = 10
        if (boolDescuentoProducto === 1){
            return (_total - ((_total*_descuento)/100))
        }
        return precio * cantidad
    }

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

        const politicaChecked = ref(false);
        const tycChecked = ref(false);
        const ofertasChecked = ref(false);
        const ruc = ref("");
        const direccionRUC = ref("");
        const razonSocial = ref("");

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


    const procesarCompra = (payload) => {
        console.log("payload final2 ->", payload);
        try {
            router.push('/cart/checkouts');
        } catch (e) {
            mensajeError.value = "No se ha podido procesar su pedido, vuelva intentar mas tarde!, gracias.";
        }
    }

    const onSubmit = handleSubmit(
        async (validatedValues) => {
            mensajeError.value = ""; // limpiar si todo ok
            if (tycChecked.value){
                if (politicaChecked.value){
                    const payload = {
                        ...validatedValues, // valores que pasaron validación
                        tyc: Boolean(tycChecked.value),
                        politica: Boolean(politicaChecked.value),
                        ofertas: Boolean(ofertasChecked.value),
                        tipoRecibo: selectedRecibo.value?.value ?? "",
                        departamento: selectedDepartamento.value?.value ?? "",
                        provincia: selectedProvincia.value?.value ?? "",
                        distrito: selectedDistrito.value?.value ?? "",
                        ruc: ruc.value ?? "",
                        razonSocial: razonSocial.value ?? "",
                        direccionRUC: direccionRUC.value ?? "",
                        costoDelivery: costoDelivery.value ?? "",
                    };

                    cart.setCheckoutForm(payload);

                    if (selectedRecibo.value?.value === 2){
                        if (ruc.value && ruc.value.trim() !== "") {
                            if (razonSocial.value && razonSocial.value.trim() !== "") {
                                if (direccionRUC.value && direccionRUC.value.trim() !== "") {
                                    procesarCompra(payload);
                                }else{
                                    mensajeError.value = "El Dirección RUC es obligatorio";
                                    return; // detener el submit
                                }

                            }else{
                                mensajeError.value = "El Razón Social es obligatorio";
                                return; // detener el submit
                            }
                            
                        }else{
                            mensajeError.value = "El RUC es obligatorio";
                            return; // detener el submit
                        }
                        
                    } else {
                        procesarCompra(payload);
                    }

                } else {
                    mensajeError.value = "Debe aceptar los Póliticias de Privacidad.";
                    return;
                }
            }else{
                mensajeError.value = "Debe aceptar los Términos y Condiciones.";
                return;
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
            } else if (errors.errors.documento){
                mensajeError.value = errors.errors.documento;
            } else if (errors.errors.direccion){
                mensajeError.value = errors.errors.direccion;
            } else if (errors.errors.celular){
                mensajeError.value = errors.errors.celular;
            } 
            else {
                mensajeError.value = "Por favor revisa los campos antes de continuar.";
            }
        }
    );
    onMounted(() => {
        // 🔹 lee usuario desde storage
        const storedUser = userStore.getUserFromStorage();
        console.log(storedUser)
        cart.desactivarDescuento()
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

            // actualizar los checkboxes y selects que no están en values directamente
            tycChecked.value = cart.checkoutForm.tyc || false;
            politicaChecked.value = cart.checkoutForm.politica || false;
            ofertasChecked.value = cart.checkoutForm.ofertas || false;

         
            selectedRecibo.value = optionsRecibo.find(
                option => option.value === cart.checkoutForm.tipoRecibo
            ) || null;

            selectedDepartamento.value = optionsDepartamento.find(
                option => option.value === cart.checkoutForm.departamento
            ) || null;

            selectedProvincia.value = optionsProvincia.find(
                option => option.value === cart.checkoutForm.provincia
            ) || null;

            selectedDistrito.value = optionsDistrito.find(
                option => option.value === cart.checkoutForm.distrito
            ) || null;

            ruc.value = cart.checkoutForm.ruc || "";
            razonSocial.value = cart.checkoutForm.razonSocial || "";
            direccionRUC.value = cart.checkoutForm.direccionRUC || "";
            costoDelivery.value = costoDelivery.value ?? "";
        }
    });
</script>