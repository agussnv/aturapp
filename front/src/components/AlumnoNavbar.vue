<template>
    <nav class="navbar d-flex j-center">
        <div>
            <ul id="items" class="no-style d-flex align-center h-full no-margin j-around">
                <li v-for="icon in icons" :key="icon.alt" :class="{ active: route.path.includes(icon.alt) }"
                    @click="navigateTo(icon.alt)">
                    <img :src="icon.src" :width="icon.width" />
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';

// Navegación y Rutas
const router = useRouter();
const route = useRoute();

// Íconos para el navbar de alumno
const icons = [
    { src: "/assets/svg/home.svg", alt: "home", width: "40px" },
    { src: "/assets/svg/chat.svg", alt: "chat", width: "35px" },
    { src: "/assets/svg/user.svg", alt: "perfil", width: "35px" },
];

function navigateTo(nameIcon) {
    router.push(`/${nameIcon}`);
}
</script>

<style scoped>
.navbar div {
  height: 70px;
  width: 100%;
}

@media (min-width: 1090px) {
    .navbar div{
        width: 40%;
    }
}
</style>