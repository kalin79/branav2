<template>
    <div class="profileHeader">
        <div class="containerFluid">
            <div class="gridContainer">
                <div>
                    <h1 class="titularGrande fontWeight500 txtGrisOscuro4">
                        Tu cuidado <span class="fontEditorialItalic txtVerde">natural</span> <br />
                        empieza aquí.
                    </h1>
                </div>
                <div>
                    <button class="btnGlobal bgVerdeOscuro2" @click="handleLogout">CERRAR SESIÓN</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useUserStore } from "@/js/stores/user";
const router = useRouter();
const userStore = useUserStore();

function handleLogout() {
  userStore.logout(); // 🔥 cierra sesión
  // Opcional: redirigir al login
  router.push("/auth/login");
}
</script>
