<script setup>
import { ref, onMounted } from 'vue';
import { useCounterStore } from '../stores/counter';
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router';

const store = useCounterStore();
const user = store.userData.user;
const fotoPerfil = ref(user.foto);
const token = store.userData.token;
let id_user = store.userData.user.id;
const mostrarBotonEncuesta = ref(true);

const router = useRouter();
function navigateTo(nameRoute) {
    router.push(`/${nameRoute}`)
};

const data = store.userData;

const UserInfo = {
    'nom': data.user.nom,
    'cognom': data.user.cognom,
    'email': data.user.email,
    'dni': data.user.dni,
    'telefon': data.user.telefon,
}

function cerrarSesion() {
    store.clearUserData();
    location.href = "/login";
}

import { obtenerFotoPerfil, verificar_usuario_enquesta } from '../services/communictationManager';

const obtenerFotoPerfilAsync = async () => {
    try {
        const response = await obtenerFotoPerfil(user.id, token);
        
        const data = await response;
        
        fotoPerfil.value = data.foto || '';
        console.log(fotoPerfil.value);
    } catch (error) {
        console.error('Error al obtener la foto de perfil:', error);
    }
};

const verificarUsuarioEnquestaAsync = async (id_user) => {
    try {
        const respuesta = await verificar_usuario_enquesta(id_user);

        if (respuesta.Enquesta_resposta) {
            mostrarBotonEncuesta.value = false;
        } else {
            mostrarBotonEncuesta.value = true; 
        }
    } catch (error) {
        console.error("Error al verificar el usuario para la encuesta:", error);
    }
};



onMounted(() => {
    //if (!user.foto) {
        obtenerFotoPerfilAsync();
    //}

    verificarUsuarioEnquestaAsync(id_user);
});

</script>



<template>
    <div class="containHeader">
        <div id="headerProfile" class="d-flex f-column bg-red">
            <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20">
                <p class="no-margin">Perfil</p>
                <div id="profileImage">
                    <img :src="fotoPerfil || '../../public/assets/svg/noimage.svg'" alt="photo">
                </div>
                <p>{{ UserInfo.nom }} {{ UserInfo.cognom }}</p>
            </div>
        </div>
    </div>
    <div id="containItems" class="d-flex align-center f-column">
        <button @click="navigateTo('perfil/dades')">
            <p>Informació general</p>
        </button>
        <button @click="navigateTo('perfil/alertes')">
            <p>Les meves alertes</p>
        </button>
        
        <button v-if="mostrarBotonEncuesta" @click="navigateTo('enquesta')">
            <p>Respondre enquesta</p>
        </button>

        <button @click="cerrarSesion">
            <p>Tancar sessió</p>
        </button>
    </div>
</template>


<style scoped>
.bg-red {
    background-color: #ff4b45;
}

#contentHeaderProfile p:first-child {
    color: white;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
}

#contentHeaderProfile p:last-child {
    color: white;
    margin-top: 20px;
    text-align: center;
    font-size: 20px;
}

#contentHeaderProfile img {
    height: 70px
}

#contentHeaderProfile #profileImage {
    width: 90px;
    height: 90px;
    background-color: white;
    border-radius: 90px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    margin-top: 20px;
}

#profileImage img{
    width: 100%;
    height: 100%;
}

.containHeader{
    padding: 10px;
}

#headerProfile {
    border-radius: 10px;
    width: 100%;
    overflow: hidden;
    box-shadow: -5px -5px 9px rgba(255, 39, 39, 0.45), 5px 5px 9px rgba(255, 0, 0, 0.374);

}

#containItems {
    overflow-y: scroll;
    padding-bottom: 10px;
    margin-bottom: 70px;
}

#containItems button {
    height: 60px;
    width: 350px;
    box-shadow: -5px -5px 9px rgba(198, 198, 198, 0.45), 5px 5px 9px rgba(94, 104, 121, 0.263);
    margin-top: 15px;
    border-radius: 10px;
    display: flex;
    align-items: center;

    border: none;
    background-color: white;
}

#containItems button:last-child p {
    color: rgb(145, 27, 27);
}

#containItems button p {
    margin: 0px 20px;
    color: #474747;
    font-size: 15px;
}
</style>