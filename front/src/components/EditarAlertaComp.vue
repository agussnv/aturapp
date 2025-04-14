<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCounterStore } from '@/stores/counter';
import { getAlertById, updateAlert } from '../services/communictationManager';

const store = useCounterStore();
const route = useRoute();
const router = useRouter();
const alerta = ref('');
const id = route.query.id;
const data = store.userData;
const user_id = data.user.id
const alertaDescripcio = ref('');
const alertaEditada = ref(false);

function navigateTo(nameIcon) {
    router.push(`/${nameIcon}`)
};

async function getAlert() {
    try {
        const result = await getAlertById(id);
        alerta.value = result;
        alertaDescripcio.value = alerta.value.descripcion;
    } catch (error) {
        console.error(error);
    }
}

async function editarAlerta() {
    try {
        const cuerpo = {
            alerta_id: id,
            alumne_id: user_id,
            descripcio: alertaDescripcio.value,
        }
        const result = await updateAlert(cuerpo); 

        if (result.success) {
            alertaEditada.value = !alertaEditada.value;
        } else {
            alert(`Ha ocorregut un error (${result.message || 'Error desconegut'})`);
        }
    } catch (error) {
        console.error(error);
    }
}


function tornarInici() {
    alertaEditada.value = !alertaEditada.value;
    navigateTo('perfil/alertes');
}

function formatFecha(isoDate) {
    const date = new Date(isoDate);
    return new Intl.DateTimeFormat('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date);
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



onMounted(() => {
    getAlert();
})
</script>

<template>
    <div class="containCabezal">
        <div class="d-flex align-center j-center cabezal">
            <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
                <p class="no-margin">Editar alerta</p>
            </div>
        </div>
    </div>
    <div id="containAlerta" class="d-flex j-center align-center f-column mt-60" v-if="alerta != ''">
        <p class="no-margin"> {{ formatText(alerta.sector) }} ({{ alerta.planta }})</p>
        <p> {{ formatFecha(alerta.created_at) }} - {{ formatHora(alerta.created_at) }}h | Estat: {{ alerta.estado }}
        </p>
        <div id="containDesc">
            <p class="no-margin">Descripció:</p>
            <textarea v-model="alertaDescripcio" id="textDesc" name="descripcion"
                placeholder="Dona'ns més informació"></textarea>
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-cancel" type="button" value="Cancelar" @click="navigateTo('perfil/alertes')">
            <input class="btn-confirm" type="button" value="Guardar" @click="editarAlerta">
        </div>
    </div>
    <div v-if="alertaEditada" class="popup-overlay">
        <div class="popup-content">
            <h2>Gràcies per donar-nos major informació</h2>
            <!-- <p>Estem de camí, mantén la calma.</p> -->
            <button class="popup-button" @click="tornarInici">Acceptar</button>
        </div>
    </div>
</template>

<style scoped>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
}

.popup-button {
    background: #ff4b45;
    box-shadow: -5px -5px 9px rgba(255, 114, 114, 0.45), 5px 5px 9px rgba(255, 25, 25, 0.438);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pop .popup-button:hover {
    background-color: #0056b3;
}

#textDesc {
    width: 300px;
    height: 200px;
    border: 1px solid #a83d3a;
    border-radius: 10px;
    font-family: sans-serif;
    font-size: 18px;
    box-sizing: border-box;
    padding: 10px;
}

textarea:focus {
    outline: none;
}

#containAlerta {
    margin-top: 70px;
}

#containDesc p:first-child {
    font-size: 18px;
    margin: 10px 0 5px 0;
}

#containAlerta>p:first-child {
    font-size: 19px;
    margin-top: 15px;
}

#containButtons {
    margin-bottom: 15px;
}
</style>