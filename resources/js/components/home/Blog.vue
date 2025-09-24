<template>
    <div class="blogHomeContainer">
        <div class="florContainer pos1">
            <img :src="imgflor1" alt="" />
        </div>
        <div class="florContainer pos2">
            <img :src="imgflor2" alt="" />
        </div>
        <div class="containerFluid">
            <div class="titleHeaderContainer">
                <h3 class="DescripcionRegular">BLOG</h3>
                <h2 class="titularExtraGrande fontPoppins fontWeight300 txtBlanco txtLineHeight">Respira y <span class="fontEditorialItalic txtVerde">Conecta</span></h2>
                <p class="DescripcionGrande fontWeight400 txtBlanco">Historias, rituales y consejos para tu bienestar natural.</p>
            </div>
            <div class="gridContainer">
                <div>
                    <img :src="imgBlog1" alt="" />
                    <div class="textoSuperpuesto">
                        <div class="contenidoCurvo">
                            <div class="infoContent">
                                <h3 class="titularMediano2">Aromaterapia en casa:</h3>
                                <p class="DescripcionRegular fontWeight400">Transforma tu espacio en un <br/>santuario de paz</p>
                            </div>
                            <img :src="imgCurva" class="curvaSvg"/>
                        </div>
                    </div>
                    <div class="arrowContainer">
                        <img :src="imgArrow" alt="" />
                    </div>
                    <div class="fechaContainer">
                        <p class="DescripcionRegular fontWeight400">31 julio, 2025</p>
                    </div>
                </div>
                <div>
                    <img :src="imgBlog2" alt="" />
                    <div class="textoSuperpuesto small">
                        <div class="contenidoCurvo">
                            <div class="infoContent">
                                <!-- <h3 class="titularMediano2">Aromaterapia en casa:</h3> -->
                                <p class="DescripcionRegular fontWeight400">Lavanda: el secreto natural para tu piel y tus emociones</p>
                            </div>
                            <img :src="imgCurvaSmall" class="curvaSvg"/>
                        </div>
                    </div>
                    <div class="arrowContainer">
                        <img :src="imgArrow" alt="" />
                    </div>
                    <div class="fechaContainer">
                        <p class="DescripcionRegular fontWeight400">31 julio, 2025</p>
                    </div>
                </div>
                <div>
                    <img :src="imgBlog3" alt="" />
                    <div class="textoSuperpuesto small">
                        <div class="contenidoCurvo">
                            <div class="infoContent">
                                <!-- <h3 class="titularMediano2">Aromaterapia en casa:</h3> -->
                                <p class="DescripcionRegular fontWeight400">Rituales de autocuidado: 3 pasos para renovar tu energía</p>
                            </div>
                            <img :src="imgCurvaSmall" class="curvaSvg"/>
                        </div>
                    </div>
                    <div class="arrowContainer">
                        <img :src="imgArrow" alt="" />
                    </div>
                    <div class="fechaContainer">
                        <p class="DescripcionRegular fontWeight400">31 julio, 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const imgBlog1 = './images/frontend/blog1.webp';
    const imgBlog2 = './images/frontend/blog2.webp';
    const imgBlog3 = './images/frontend/blog3.webp';
    const imgflor1 = './images/frontend/florBlog1.webp';
    const imgflor2 = './images/frontend/florBlog2.webp';
    const imgArrow = './images/frontend/arrow2.svg';
    const imgCurvaSmall = './images/frontend/arrow3.svg';
    const imgCurva = './images/frontend/curva.svg';
</script>