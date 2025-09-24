<template>
    <div class="profileBody">
        <div class="containerFluid">
            <div class="gridContainer">
                <div>
                    <div class="topItem">
                        <h2 class="titularMediano fontWeight400 txtGrisOscuro4">Mis Pedidos</h2>
                        <img :src="iconItem1" alt="Mis Pedidos"/>
                    </div>
                    <div class="bottomItem">
                        <button>
                            <img :src="iconflecha" alt="Mis Pedidos"/>
                        </button>
                    </div>
                </div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</template>
<script setup>
    const iconItem1 = '/images/frontend/profile1.svg';
    const iconflecha = '/images/frontend/flechaverde.svg';
</script>