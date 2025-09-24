<template>
    <div class="headerAuthContainer">
        <img :src="logo" alt="Brana"/>
        <router-link to="/" class="btnGlobalTransparente textoGrisClaro3">VOLVER AL INICIO</router-link>
    </div>
</template>

<script setup>
    const logo = '/images/frontend/logo.svg';
</script>