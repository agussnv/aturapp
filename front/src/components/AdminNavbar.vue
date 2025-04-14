<template>
    <button @click="cerrarSesion" class="btn-confirm"
        style="width: 200px; position: absolute; right: 10px; top: 10px; cursor: pointer;">Tancar sessió</button>
    <div class="d-flex j-center">
        <ul class="d-flex no-style j-around no-margin" style="color: red; width: 700px;">
            <li style="cursor: pointer;" @click="navigateTo('')">INICI</li>
            <li style="cursor: pointer;" @click="navigateTo('/alertes')">ALERTES</li>
            <li style="cursor: pointer;" @click="navigateTo('/heatmap')">HEATMAP</li>
            <li style="cursor: pointer;" @click="navigateTo('/alumnes')">ALUMNES</li>
            <li style="cursor: pointer;" @click="navigateTo('/estadisticas')">ESTADISTICAS</li>
            <li style="cursor: pointer;" @click="navigateTo('/sociograma')">SOCIOGRAMA</li>
            <li style="cursor: pointer;" @click="navigateTo('/denuncies')">DENUNCIES</li>
        </ul>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useCounterStore } from '../stores/counter';


const store = useCounterStore();
const router = useRouter();

function navigateTo(path) {
    router.push(`/admin${path}`);
}

function cerrarSesion(){
    store.clearUserData();
    location.href = "/login";
}
</script>

<style scoped></style>