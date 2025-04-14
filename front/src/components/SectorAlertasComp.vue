<template>
    <div class="d-flex j-center">
        <div class="container">
            <div id="alert-container">
                <h2>Alertas del sector: {{ sector }}</h2>
                <div id="alert-list">
                    <div class="alert-card" v-for="alerta in alertes" @click="verAlerta(alerta.id)">
                        <h3 class="alert-title">Alerta #{{ alerta.id }}</h3>
                        <div class="alert-footer">
                            <span class="alert-user">Informat per: {{ alerta.alumne_name }}</span>
                            <span class="alert-date">{{ alerta.fecha }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="show-container">
                <div class="d-flex align-center j-center" v-if="!alertVisible">
                    <p>Seleccioni una alerta</p>
                </div>
                <div class="alert-info" v-if="alertVisible">
                    <!-- ID de la alerta -->
                    <h1 class="alert-id">Alerta #{{ infoAlerta.id }}</h1>

                    <!-- Fecha y hora -->
                    <p class="alert-datetime">{{ infoAlerta.fecha }}</p>

                    <!-- Autor de la alerta -->
                    <h3 class="alert-author">Reportat per: <span @click="navigateTo(`alumnes/${infoAlerta.alumne_id}`)" style="color: blue; cursor: pointer;">{{ infoAlerta.alumne_name }}</span></h3>

                    <!-- Descripción -->
                    <p class="alert-description">
                        Descripció: {{ infoAlerta.descripcion }}
                    </p>

                    <!-- Turno -->
                    <span class="alert-shift">Torn: {{ infoAlumne?.torn?.torn || 'Cargando...' }}</span>

                    <!-- Curso -->
                    <span class="alert-course">Curso: {{ infoAlumne?.curs?.name || 'Cargando...' }}</span>

                    <!-- Sector -->
                    <span class="alert-sector">Sector: {{ formatText(infoAlerta.sector_name) }}</span>

                    <!-- Planta -->
                    <span class="alert-floor">{{ infoAlerta.planta }}</span>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { GetUserSectorAlertas, GetAlertasSectorAlertas } from '../services/communictationManager';

const router = useRouter();
const route = useRoute();
const id_sector = route.query.id;
const alertes = ref();
const sector = ref();
const alertVisible = ref(false);
const infoAlerta = ref();
const infoAlumne = ref();

function navigateTo(path) {
    router.push(`/admin/${path}`)
}

async function getUser() {
    try {
        // Llamamos a la función del communicationManager
        const result = await GetUserSectorAlertas(infoAlerta.value.alumne_id);
        console.log(result);
        return result;
    } catch (error) {
        console.error(error);
    }
}

async function getAlertsSector() {
    try {
        // Llamamos a la función del communicationManager
        const result = await GetAlertasSectorAlertas(id_sector);
        return result;
    } catch (error) {
        console.error(error);
    }
}

function formatText(text) {
    text = text || "";

    if (text.includes("-inf") || text.includes("pb") || text.includes("p1") || text.includes("p2") || text.includes("p3")) {
        return text.toUpperCase();
    }

    // Verifica si el texto termina con una palabra y un número junto (ej. bosca0)
    const match = text.match(/([a-zA-Z]+)(\d+)$/);
    if (match) {
        text = text.replace(/\d+$/, ""); // Elimina el número al final
    }

    return text
        .split('-') // Divide el texto en palabras separadas por "-"
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitaliza la primera letra de cada palabra
        .join(' '); // Une las palabras con un espacio
}

async function verAlerta(id) {
    alertVisible.value = true;
    infoAlerta.value = alertes.value.find((alerta) => alerta.id === id);
    infoAlumne.value = await getUser(); // Llamamos a la función getUser para obtener la información del usuario
}

onMounted(async () => {
    alertes.value = await getAlertsSector();
    // sector.value = formatText(alertes.value[0].sector_name);
});
</script>


<style scoped>
/* Contenedor principal */
.container {
    display: flex;
    width: 100%;
    height: 100vh;
    /* Ocupa toda la altura de la pantalla */
    padding: 20px;
    gap: 20px;
}

/* Contenedor de alertas */
#alert-container {
    flex: 1;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    overflow-y: auto;
    max-height: 420px;
}

/* Título */
#alert-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
    font-weight: bold;
}

/* Lista de alertas */
#alert-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Tarjetas de alerta */
.alert-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
    cursor: pointer;
    border: 1px solid #ddd;
    transition: box-shadow 0.3s, transform 0.2s;
}

/* Hover sobre la tarjeta */
.alert-card:hover {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Títulos de las alertas */
.alert-title {
    margin: 0;
    font-size: 18px;
    color: #333;
    font-weight: bold;
}

/* Pie de la tarjeta */
.alert-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #555;
    margin-top: 10px;
}

/* Usuario que reportó */
.alert-user {
    font-style: italic;
}

/* Hora de la alerta */
.alert-time {
    font-weight: bold;
    color: #555;
}

/* Fecha de la alerta */
.alert-date {
    font-size: 12px;
    color: #777;
}

/* Contenedor de estadísticas (lado derecho) */
.show-container {
    display: flex;
    flex: 1.5;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    height: max-content;
}

.show-container>div:first-child{
    width: 100%;
}

.show-container>div:first-child>p:first-child {
    font-size: 30px;
    color: #b7b7b7;
    font-weight: bold;
}

/* Información de la alerta */
.alert-info {
    width: 100%;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
    height: max-content;
}

/* Título (ID de la alerta) */
.alert-id {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

/* Fecha y hora */
.alert-datetime {
    font-size: 0.9rem;
    color: rgba(0, 0, 0, 0.5);
    margin-bottom: 15px;
}

/* Autor de la alerta */
.alert-author {
    font-size: 1.2rem;
    font-weight: 500;
    color: #555;
    margin-bottom: 15px;
}

/* Descripción */
.alert-description {
    font-size: 1rem;
    line-height: 1.5;
    color: #444;
    margin-bottom: 20px;
}

/* Turno, curso, sector y planta */
.alert-shift,
.alert-course,
.alert-sector,
.alert-floor {
    display: block;
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 8px;
    font-weight: 500;
}
</style>