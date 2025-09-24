<template>
    <form @submit.prevent="onSubmit">
        <div class="inputContainer">
            <img :src="iconEmail" alt="email" />
            <input v-model="email" class="inputText textoGrisClaro3" type="text" placeholder="Correo electrónico"  />
        </div>
        <!-- <span class="errorMsg">{{ emailError }}</span> -->
        <div class="inputContainer">
            <img :src="iconPass" alt="email" />
            <input v-model="password" type="password" class="inputText textoGrisClaro3" placeholder="Contraseña"  />
        </div>
        <!-- <span class="errorMsg">{{ passwordError }}</span> -->
        <div class="linkContainer">
            <router-link to="/auth/recuperar-contrasena" class="textoGrisClaro3">¿Olvidaste tu contraseña?</router-link>
        </div>
        <div v-if="mensajeError" class="txtErrorContainer">
            <span class="DescripcionMediano2 txtRosado">{{ mensajeError }}</span>
        </div>
        <div class="btnFormContainer">
            <button type="submit" class="btnGlobal bgVerdeClaro">INGRESAR</button>
        </div>
    </form>
</template>

<script setup>
    import { useRouter } from "vue-router";
    import { ref } from "vue";
    import { useUserStore } from "@/js/stores/user";
    import { useForm, useField } from 'vee-validate';
    import { toFormValidator } from "@vee-validate/zod";
    import * as z from 'zod';
    const router = useRouter();
    const userStore = useUserStore();
    const iconEmail = '/images/frontend/email.svg';
    const iconPass = '/images/frontend/pass.svg';

    // mensaje generico uno solo

    // Esquema con Zod
    const schema = z.object({
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

    // Acción al enviar
    const onSubmit = handleSubmit(
        async (values) => {
            mensajeError.value = ""; // limpiar si todo ok
            try {
                const ok = await userStore.login({
                    email: values.email,
                    password: values.password,
                });
                // console.log(ok);
                if (ok) {
                    console.log('exito');
                    router.push("/user/profile"); 
                }
            } catch (error) {
                mensajeError.value = error;
            }
        },
        (errors) => {
            // Mostrar error específico según el campo
            console.log(errors);
            if (errors.errors.email) {
                mensajeError.value = errors.errors.email;
            } else if (errors.errors.password) {
                mensajeError.value = errors.errors.password;
            } else {
                mensajeError.value = "Por favor revisa los campos antes de continuar.";
            }
        }
    );

</script>