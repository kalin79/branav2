<template>
    <div class="unicaContainerSection">
        <div class="hojacontainer pos1">
            <img :src="iconHoja1" alt=""/>
        </div>
        <div class="hojacontainer pos2">
            <img :src="iconHoja2" alt=""/>
        </div>
        <div class="hojacontainer pos3">
            <img :src="iconHoja3" alt=""/>
        </div>
        <div class="containerFluid">
            <div class="gridContainer">
                <div>
                    <h2 class="titularExtraGrande fontPoppins fontWeight300 txtNegro">
                        Lo que hace <span class="fontEditorialItalic txtVerde">Única</span> <br />
                        a Brana
                    </h2>
                </div>
                <div>
                    <div class="itemUnicaBox" v-for="(item, index) in unicaApi" :key="index">
                        <div class="imgContainer">
                            <img :src="item.img" alt=""/>
                        </div>
                        <h3 class="DescripcionMediano fontWeight600" v-html="item.titulo"></h3>
                        <p class="DescripcionRegular fontWeight300" v-html="item.descripcion"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script setup>
    import { ref } from 'vue';

    const iconHoja1 = './images/frontend/hoja1.svg';
    const iconHoja2 = './images/frontend/hoja2.svg';
    const iconHoja3 = './images/frontend/hoja3.svg';
    const unicaApi = ref ([
        {
            titulo: 'Ingredientes <br />Naturales',
            descripcion: 'Formulaciones basadas en extractos botánicos puros para cuidar tu piel y bienestar.',
            img: './images/frontend/unica1.svg'
        },
        {
            titulo: 'Aromaterapia <br />Efectiva',
            descripcion: 'Aceites esenciales de alta calidad que transforman el ambiente y mejoran tu estado de ánimo.',
            img: './images/frontend/unica2.svg'
        },
        {
            titulo: 'Belleza y Bienestar',
            descripcion: 'Sin parabenos, siliconas ni químicos agresivos, respetando tu cuerpo y la naturaleza.',
            img: './images/frontend/unica3.svg'
        },
        {
            titulo: '100% Transparentes',
            descripcion: 'Información clara sobre cada ingrediente y sus beneficios.',
            img: './images/frontend/unica4.svg'
        },
        {
            titulo: 'Compromiso con el planeta',
            descripcion: 'Packaging eco-friendly y materiales reciclables.',
            img: './images/frontend/unica5.svg'
        },
        {
            titulo: 'Productos Veganos y Cruelty-Free',
            descripcion: 'Respetuosos con los animales y certificados en procesos sostenibles.',
            img: './images/frontend/unica6.svg'
        },
        {
            titulo: 'Hecho en Perú con Amor',
            descripcion: 'Inspirado en la biodiversidad peruana, con estándares de calidad internacional.',
            img: './images/frontend/unica7.svg'
        }
    ])
</script>