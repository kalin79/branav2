<!-- js/pages/auth/Register.vue -->
<template>
    <div class="pageAuthContainer">
        <div class="bannerContainer">
            <img :src="banner" alt=""/>
        </div>
        <div class="formContainer">
            <div>
                <div class="florLogin">
                    <img :src="florLogin" alt=""/>
                </div>
                <div class="viewInfoContainer">
                    <HeaderAuth />
                    <div class="viewFormContainer">
                        <div>
                            <h1 class="titularGrande txtGrisOscuro4 fontWeight400">Regístra tu<br /><span class="fontEditorialItalic textoVerdeClaro2">cuenta</span></h1>
                            <p class="DescripcionMediano2 textoGrisClaro3">Al acceder a su cuenta Brana podrá rastrear y administrar sus pedidos y también guardar múltiples direcciones.</p>
                            <form @submit.prevent="onSubmit">

                                <div class="inputContainer">
                                    <input v-model="nombres" class="inputText textoGrisClaro3" type="text" placeholder="Nombres"  />
                                </div>

                                <div class="inputContainer">
                                    <input v-model="apellidos" class="inputText textoGrisClaro3" type="text" placeholder="Apellidos"  />
                                </div>

                                <div class="inputContainer">
                                    <input v-model="email" class="inputText textoGrisClaro3" type="text" placeholder="Ingresa tu correo electrónico"  />
                                </div>
                                <div class="inputContainer">
                                    <input v-model="password" type="password" class="inputText textoGrisClaro3" placeholder="Ingresa tu clave"  />
                                </div>
                                <div v-if="mensajeError" class="txtErrorContainer">
                                    <span class="DescripcionMediano2 txtRosado">{{ mensajeError }}</span>
                                </div>
                                <div class="btnFormContainer">
                                    <button type="submit" class="btnGlobal bgVerdeClaro">REGISTRARME</button>
                                </div>
                            </form>
                            <div class="rowForm">
                                <h3 class="DescripcionMediano textoGrisClaro3">Si tienes ya una cuenta</h3>
                                <router-link to="/auth/login" class="DescripcionMediano2 textoGrisClaro3">Inicia sesion aquí</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import { useForm, useField } from 'vee-validate';
    // import { toTypedSchema } from '@vee-validate/zod';
    import { toFormValidator } from "@vee-validate/zod";
    import * as z from 'zod'
    import HeaderAuth from '@/js/components/auth/Header.vue';
    import { useUserStore } from "@/js/stores/user"; 
    const router = useRouter();
    const userStore = useUserStore();
    const banner = '/images/frontend/bauth2.webp';
    const florLogin = '/images/frontend/florLogin.webp';

    // // 🔹 Esquema Zod
    // const loginSchema = z.object({
    //     email: z.string().email("Email inválido"),
    //     password: z.string().min(6, "Mínimo 6 caracteres")
    // });

    // mensajes por cada campo

    // 🔹 Inicializar form con el schema
    // const { handleSubmit } = useForm({
    //     validationSchema: toTypedSchema(loginSchema),
    // });

    // // 🔹 Campos individuales
    // const { value: email, errorMessage: emailError } = useField("email");
    // const { value: password, errorMessage: passwordError} = useField("password");

    // // 🔹 Submit
    // const onSubmit = handleSubmit((values) => {
    //     alert(1);
    //     console.log("✅ Login OK", values);
    // });

    // mensaje generico uno solo

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
        email: z.string().email("Ingrese un correo válido"),
        password: z.string().min(6, "La contraseña debe tener mínimo 6 caracteres"),
    });

    // Estado del mensaje global
    const mensajeError = ref("");

    // Configuración del form
    const { handleSubmit, isSubmitting } = useForm({
        validationSchema: toFormValidator(schema),
    });

    // Campos
    const { value: email } = useField("email");
    const { value: password } = useField("password");
    const { value: nombres } = useField("nombres");
    const { value: apellidos } = useField("apellidos");

    // Acción al enviar
const onSubmit = handleSubmit(
    async (values) => {
        mensajeError.value = ""; // limpiar si todo ok
        try {
        // Simulación de login
            console.log("Enviando datos:", values);
            await userStore.register(values); // 🔥 llamar a la API
            // Opcional: login automático después de registrar
            await userStore.login({ email: values.email, password: values.password });
            router.push("/user/profile"); // redirige al perfil
        
            // 🚨 Aquí podrías hacer tu request con axios/fetch
            // const res = await axios.post("/login", values);
        } catch (e) {
            mensajeError.value = "Hubo un problema con el login.";
        }
    },
    (errors) => {
        // Mostrar error específico según el campo
        console.log(errors);
        if (errors.errors.email) {
            mensajeError.value = errors.errors.email;
        } else if (errors.errors.password) {
            mensajeError.value = errors.errors.password;
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


</script>