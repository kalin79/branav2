<!-- js/pages/auth/Login.vue -->
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
                            <h1 class="titularGrande txtGrisOscuro4 fontWeight400">Accede a tu <br /><span class="fontEditorialItalic textoVerdeClaro2">cuenta</span></h1>
                            <p class="DescripcionMediano2 textoGrisClaro3">Al acceder a su cuenta Brana podrá rastrear y administrar sus pedidos y también guardar múltiples direcciones.</p>
                            <LoginComponent />
                            <div class="rowForm">
                                <h3 class="DescripcionMediano textoGrisClaro3">¿Aún no tienes una cuenta?</h3>
                                <router-link to="/auth/registro" class="DescripcionMediano2 textoGrisClaro3">Registrate aquí</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script setup>
    import HeaderAuth from '@/js/components/auth/Header.vue';
    import LoginComponent from '@/js/components/auth/Login.vue';
    const banner = '/images/frontend/bauth.webp';
    const florLogin = '/images/frontend/florLogin.webp';
    
</script>