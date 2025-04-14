<template>
    <div class="d-flex j-center">
        <div class="container">
            <div id="chats-container">
                <h2>Denuncies fetes</h2>
                <div id="alert-list">
                    <div class="alert-card" v-for="chat in chats" @click="verChat(chat)">
                        <h3 class="alert-title">Denuncia #{{ chat.id }}</h3>
                        <div class="alert-footer">
                            <span class="alert-user">Reportado por: {{ chat.alumne_nom }} {{ chat.alumne_cognom
                                }}</span>
                            <span class="alert-date">{{ formatFecha(chat.fecha) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="show-container">
                <div class="d-flex align-center j-center" v-if="!chatAbierto">
                    <p>Seleccioni un chat</p>
                </div>
                <div class="alert-info" v-if="chatAbierto">
                    <div id="contenedor-mensajes">
                        <ul id="missatges">
                            <li v-for="(msg, index) in chatMessages" :key="msg.id" :id="msg.id"
                                :class="{ propio: msg.emisor != chatAlumneID }">
                                    {{ msg.texto }}
                                <template v-if="msg.editado && !msg.editando">
                                    <div class="msjEditado">editado</div>
                                </template>
                                <button class="botonEditar" @click="editarMensaje(msg)"><img :src="botonEditar"
                                        alt="editar"></button>
                            </li>
                            <li id="escribiendo" :style="{ display: escribiendo.value ? 'block' : 'none' }">
                                <img :src="escribiendoSvg" alt="Escribiendo">
                            </li>
                        </ul>
                    </div>
                    <a :href="'mailto:' + chatInfo.alumne_email">
                        <button class="btn-email">
                            Enviar correo
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCounterStore } from '../stores/counter';
import { getChatsBBDD, getChatMessagesBBDD } from '@/services/communictationManager.js';
import escribiendoSvg from '@/assets/svg/escribiendo.svg';
import botonEditar from '@/assets/svg/botonEditar.svg';
import socket from '@/services/socket.js';

const store = useCounterStore();
let user = store.userData.user;
let msjEditado = ref('');
let pausaMensaje = ref(false);
let escribiendo = reactive({ value: false});
let chatEnEspera = ref(false);
const router = useRouter();
const route = useRoute();
const chatAbierto = ref(false);
const chats = ref();
const chatInfo = ref();
const chatMessages = ref();
const chatAlumneID = ref();

function navigateTo(path) {
    router.push(`/admin/${path}`)
}

function formatFecha(isoDate) {
    const date = new Date(isoDate);
    return new Intl.DateTimeFormat('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date);
}

async function verChat(chat) {
    chatInfo.value = chat;
    chatAbierto.value = true;
    chatAlumneID.value = chatInfo.value.alumne_id;
    console.log(user)
    console.log(chatInfo.value);
    chatMessages.value = await getChatMessagesBBDD(chatInfo.value.id, user.rol);
    console.log(chatMessages.value)
}

onMounted(async () => {
    chats.value = await getChatsBBDD();
    console.log(chats.value);
    // alertes.value = await getAlertsSector();
    // sector.value = formatText(alertes.value[0].sector_name);
});

</script>

<style scoped>

.btn-email{
    background-color: rgb(255, 199, 199);
    border: none;
    border-radius: 10px;
    padding: 10px 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    color: rgb(0, 0, 70);
    font-size: 20px;
    position: absolute;
    bottom: 0;
    left: 30px;
    right: 30px;
    margin: auto;
    cursor: pointer;
}

/* CHAT Y MENSAJES */
#contenedor-mensajes {
  max-height:100%;
  overflow-y: auto
}

#missatges {
  list-style-type: none;
  margin: 0;
  padding: 0 10px 0 0;
  display: flex;
  flex-direction: column;
}

#missatges .propio {
  position: relative;
  align-self: flex-end;
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border-radius: 5px;
  max-width: 70%;
}

#missatges li.servidor {
  background-color: #f0f0f0; /* Gris claro */
  color: #333; /* Texto oscuro para contraste */
  width: 100%; /* Ocupa todo el ancho disponible */
  padding: 10px; /* Espaciado interior */
  border-radius: 8px; /* Bordes redondeados */
  margin: 5px 0; /* Margen entre los mensajes */
  box-sizing: border-box; /* Asegura que el padding y el border no afecten al ancho */
  text-align: center; /* Alinea el texto horizontalmente en el centro */
  display: flex; /* Utiliza flexbox para alinear el contenido */
  justify-content: center; /* Centra el contenido horizontalmente */
  align-items: center; /* Centra el contenido verticalmente (si hay más de una línea de texto) */
  align-self: center; /* Centra el mensaje en el contenedor */
}

#missatges .propio .botonEditar {
  padding: 5px;
  background-color: white;
  max-width: 70%;
}

#missatges .propio:hover .botonEditar {
  display: block;
}

#missatges .botonEditar {
  display: none;
  position: absolute;
  top: 50%;
  left: -35px;
  transform: translateY(-50%);
  background-color: #f5f5f5;
  border: 0;
  cursor: pointer;
}

#missatges li {
  align-self: flex-start;
  background-color: #e0e0e0;
  color: #333;
  padding: 10px;
  border-radius: 5px;
  max-width: 70%;
  margin: 5px 0;
}

.editorMsj {
  all: unset;
  background: transparent;
  border: none;
  font-family: inherit;
  font-size: inherit;
  line-height: inherit;
  padding: 0;
  margin: 0;
  width: 100%;
}

.operacionesMsj {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.operacionesMsj button {
  padding: 5px 15px;
  border: none;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
  border-radius: 10px;
  transition: background-color 0.3s ease;
}

.operacionesMsj button:hover {
  opacity: 0.8;
}

.operacionesMsj button:active {
  transform: scale(0.98);
}

.operacionesMsj button:nth-child(1) {
  background-color: white;
  color: black;
}

.operacionesMsj button:nth-child(1):hover {
  background-color: #e0e0e0;
}

.operacionesMsj button:nth-child(2) {
  background-color: black;
  color: white;
}

.operacionesMsj button:nth-child(2):hover {
  background-color: #333;
}

.msjEditado {
  font-size: 12px;
  color: black;
  font-style: italic;
  margin-top: 4px;
}

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
#chats-container {
    flex: 1;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    overflow-y: auto;
    max-height: 80vh;
}

/* Título */
#chats-container h2 {
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
    height: 80vh;
    border-radius: 8px;
    position: relative;
}

.show-container>div:first-child {
    width: 100%;
}

.show-container>div:first-child>p:first-child {
    font-size: 30px;
    color: #b7b7b7;
    font-weight: bold;
}

/* Información de la alerta */
.alert-info {
    height: 100%;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
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