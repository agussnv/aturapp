<template>
    <div id="containAll">
        <ul class="no-style d-flex j-center button-group">
            <li><button @click="getAlerts('dia', 0)">Avui</button></li>
            <li><button @click="getAlerts('semana', 0)">Setmana</button></li>
            <li><button @click="getAlerts('mes', 0)">Mes</button></li>
            <li><button @click="getAlerts('total', 0)">Tot</button></li>
        </ul>
        <div id="statsContain">
            <div id="item-a" class="box">
                <p class="no-margin">Alertes rebudes</p><span class="resultado">{{ count(alertas_recibidas) }}</span>
            </div>
            <div id="item-b" class="box">
                <p class="no-margin">Percentatge d'èxit (prova)</p><span class="resultado">87%</span>
                <!-- {{ porcentajeExito() }} -->
            </div>
            <div id="item-c" class="box">
                <p class="no-margin">Ranking sectors</p>
                <ul>
                    <li v-for="index in 3" class="ranking-item">
                        <p class="ranking-text">{{ index }} - {{ formatText(rankingSectores[index - 1]?.nombre) }} ({{
                            rankingSectores[index - 1]?.planta }})</p>
                    </li>
                </ul>
            </div>
            <div id="item-d" class="box">
                <button @click="choiseChart('horario')">Horario</button>
                <button @click="choiseChart('dia')" :class="{ 'isUnclickable': time === 'dia' }">Dia</button>
                <button @click="choiseChart('total')" :class="{ 'isUnclickable': time != 'total' }">Total</button>
                <div class="d-flex j-center">
                    <div>
                        <canvas width="600px" height="400px" ref="chartCanvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Chart, registerables } from "chart.js";
import { getAlertsFilter, getAllAlerts } from '../services/communictationManager';
import { ref, onMounted } from 'vue';
const time = ref('total');
const quant = ref('0');
const alertas_recibidas = ref();
const rankingSectores = ref([]);

const tipo = ref('pie');
const etiquetas = ref();
const datos = ref([12, 19, 3, 5, 2]);

const chartCanvas = ref();
Chart.register(...registerables);
let grafico = null;

async function getAlerts(tiempo, cantidad) {
    time.value = tiempo;
    quant.value = cantidad;
    try {
        alertas_recibidas.value = await getAlertsFilter(tiempo, cantidad);
    } catch (error) {
        console.error(error);
    }
}

async function getAllAlertes() {
    try {
        rankingSectores.value = await getAllAlerts();
    } catch (error) {
        console.error(error);
    }
}

function getQuantitat(caso, alertas) {
    const datos = ref();
    switch (caso) {
        case 'horario':
            datos.value = [0, 0, 0, 0, 0, 0, 0, 0];
            etiquetas.value = ['8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', "Fora d'horari"];
            tipo.value = 'pie';
            const horaris = [];
            for (let index = 8; index <= 15; index++) {
                const horario = new Date();
                horario.setHours(index, 0, 0, 0);
                horaris.push(horario);
            }
            alertas.forEach(alerta => {
                const alertaHora = new Date(alerta.created_at);
                const alertaTotalMinutos = alertaHora.getHours() * 60 + alertaHora.getMinutes();

                for (let i = 0; i < horaris.length - 1; i++) {
                    const inicioRango = horaris[i].getHours() * 60;
                    const finRango = horaris[i + 1].getHours() * 60;

                    if (alertaTotalMinutos >= inicioRango && alertaTotalMinutos < finRango) {
                        datos.value[i] += 1;
                        return;
                    }
                }

                datos.value[7] += 1;
            });
            break;
        case 'dia':
            datos.value = [0, 0, 0, 0, 0];
            etiquetas.value = ['Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres'];
            tipo.value = 'bar';
            alertas.forEach((alerta) => {
                const dia = new Date(alerta.created_at).getDay();
                if (dia >= 1 && dia <= etiquetas.value.length) {
                    datos.value[dia] += 1;
                }
            })
            break;
        case 'total':
            datos.value = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            etiquetas.value = ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'];
            tipo.value = 'line';
            alertas.forEach((alerta) => {
                const mes = new Date(alerta.created_at).getMonth();
                datos.value[mes] += 1;
            })
            break;
        // default:
        //     break;
    }

    return datos.value;
}

function formatHora(isoDate) {
    const date = new Date(isoDate);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
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

function count(array) {
    return array ? array.length : 0; // Verifica que el array no sea null o undefined
}

function createChart(tipo, etiquetas, datos) {
    if (grafico) {
        grafico.destroy();
    }
    grafico = new Chart(chartCanvas.value, {
        type: tipo,
        data: {
            labels: etiquetas,
            datasets: [{
                label: "# of alerts",
                data: datos,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function choiseChart(type) {
    datos.value = getQuantitat(type, alertas_recibidas.value);
    createChart(tipo.value, etiquetas.value, datos.value);
}

onMounted(async () => {
    await getAlerts(time.value, quant.value);
    rankingSectores.value = await getAllAlertes();
    datos.value = getQuantitat('total', alertas_recibidas.value);
    createChart(tipo.value, etiquetas.value, datos.value);
});
</script>

<style scoped>
#containAll {
    box-sizing: border-box;
    padding: 20px;
    /* Márgenes laterales */
}

.button-group {
    gap: 10px;
    margin-bottom: 20px;
}

#statsContain {
    display: grid;
    grid-template-areas:
        "a a b b c"
        "a a b b c"
        "d d d d c"
        "d d d d e"
        "d d d d e";
    grid-template-columns: repeat(4, 1fr) 1fr;
    /* 4 columnas iguales y una más pequeña */
    gap: 20px;
    max-width: 1200px;
    /* Máximo ancho para grandes pantallas */
    margin: auto;
    /* Centrado horizontal */
}

.resultado {
    font-weight: bolder;
    font-size: 40px
}

#item-a {
    grid-area: a;
    /* width: 20rem; */
    font-size: 30px;
}

#item-b {
    grid-area: b;
    /* width: 20rem; */
    font-size: 30px;
}

#item-c {
    grid-area: c;
    width: 15rem;
    font-size: 30px;
}

#item-c>ul {
    list-style-type: none;
    padding: 0;
}

#item-d {
    grid-area: d;
    /* width: 60rem; */
    padding: 20px;
}

.activo {
    font-weight: bold;
    margin-bottom: 100px;
}

button {
    cursor: pointer;
}

.isUnclickable {
    cursor: not-allowed;
    /* Cambia el cursor para indicar que no se puede hacer clic */
    pointer-events: none;
    background-color: #e0e0e0fd;
    border: 2px solid #c4c4c4;
}

.ranking-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
    width: 100%;
    max-width: 400px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

/* Estilo de cada ítem de la lista */
.ranking-item {
    background-color: #f4f4f4;
    margin: 8px 0;
    padding: 5px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.ranking-item>p {
    margin: 0;
    font-size: 20px;
}

@media (max-width: 768px) {
    #statsContain {
        grid-template-areas:
            "a"
            "b"
            "c"
            "d";
        grid-template-columns: 1fr;
        grid-template-rows: auto;
    }

    .button-group {
        flex-wrap: wrap;
        justify-content: center;
    }

    button {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>