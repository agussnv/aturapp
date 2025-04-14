<template>
    <div class="containCabezal">
        <div class="d-flex align-center j-center cabezal">
            <div class="d-flex align-center f-column" style="z-index: 20;">
                <img class="icon-arrow" src="../../public/assets/svg/arrow.svg" alt="back" width="40px"
                    @click="navigateTo('perfil')">
                <p class="no-margin">informació general</p>
            </div>
        </div>
    </div>
    <div class="d-flex align-center f-column contentProfile" style="z-index: 20;">
        <div id="profileImage">
            <img :src="fotoPerfil.foto || '../../public/assets/svg/noimage.svg'" alt="photo">
            <div id="contain-edit-btn">
                <button @click="abrirSelector" id="edit-btn" class="d-flex j-center align-center">
                    <img src="../../public/assets/svg/pencil.svg" alt="edit">
                </button>
            </div>
            <input type="file" ref="fileInput" accept="image/*" @change="procesarImagen" style="display: none;">
        </div>
        <div id="infoProfile" class="mt-20">
            <p class="no-margin">Nom: </p>
            <input type="text" v-model="nom" name="nom" id="nom">
            <p class="no-margin">Cognom: </p>
            <input type="text" v-model="cognom" name="cognom" id="cognom">
            <p class="no-margin">Telèfon: </p>
            <input type="number" v-model="telefon" name="telefon" id="telefon">
            <p class="no-margin">DNI / NIE: </p>
            <input type="text" v-model="dni" name="nom" id="nom" value="">
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-confirm" type="button" value="Guardar" @click="editarPerfil">
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCounterStore } from '../stores/counter';
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router';

const router = useRouter();
const store = useCounterStore();
let user = store.userData.user;
let token = store.userData.token;
const nom = ref(user.nom);
const cognom = ref(user.cognom);
const telefon = ref(user.telefon);
const dni = ref(user.dni);
const fotoPerfil = ref(user.foto);
const fileInput = ref(null);
import { updateFoto,editarPerfilUser,obtenerFotoPerfil } from '../services/communictationManager';

function navigateTo(nameRoute) {
    router.push(`/${nameRoute}`)
};

function abrirSelector() {
    fileInput.value.click();
}

const procesarImagen = async (event) => {
    const archivo = event.target.files[0];
    if (!archivo) return;

    const formData = new FormData();
    formData.append('id', user.id);
    formData.append('imagen', archivo);
    
    try {
        const data = await updateFoto(formData, token);

        if (data.success){
            fotoPerfil.value = await obtenerFotoPerfil(user.id, token);
        }else{
            alert('Ha ocurrido un error al subir la imagen');
        }
    } catch (error) {
        console.error('Error al subir la imagen: ', error);
    }
};

async function getFotoPerfil() {
        try {
            fotoPerfil.value = await obtenerFotoPerfil(user.id, token);
            console.log(fotoPerfil.value);
        } catch (error) {
            console.error('Error al obtener la foto de perfil:', error);
        }
    }

onMounted(() => {
    if(!user.foto){
        getFotoPerfil();
    }
})

async function editarPerfil() {
    try {
        const payload = {
            alumne_id: user.id,
            nom: nom.value,
            cognom: cognom.value,
            telefon: telefon.value,
            dni: dni.value,
            foto: fotoPerfil.value
        };

        const result = await editarPerfilUser(payload);

        if (result.success) {
            alert('Usuari editat amb èxit');
            store.userData.user.nom = result.user.nom ?? store.userData.user.nom;
            store.userData.user.cognom = result.user.cognom ?? store.userData.user.cognom;
            store.userData.user.dni = result.user.dni ?? store.userData.user.dni;
            store.userData.user.telefon = result.user.telefon ?? store.userData.user.telefon;
            store.userData.user.foto = result.user.foto;
            console.log(result.user);
            user = JSON.stringify(result.user);
        } else {
            alert(`Ha ocorregut un error (${result.message || 'Error desconegut'})`);
        }

    } catch (error) {
        console.error('Error en la edición del perfil:', error);
    }
}

</script>

<style>
button {
    cursor: pointer;
}

#contain-edit-btn {
    position: absolute;
    bottom: 0px;
    right: -10px;
}

#edit-btn {
    background-color: white;
    height: 40px;
    width: 40px;
    padding: 0;
    margin: 0;
    border-radius: 40px;
    border: 1px solid grey;
}

#edit-btn img {
    padding: 0;
    margin: 0;
    height: 35px;
    width: 35px;
}

.contentProfile {
    margin-top: 60px;
}

.contentProfile img {
    height: 120px;
    width: 120px;
    object-fit: cover;
    border-radius: 50%;
}

.contentProfile #profileImage {
    position: relative;
    width: 120px;
    height: 120px;
    background-color: white;
    border: 1px solid grey;
    border-radius: 90px;
    display: flex;
    justify-content: center;
    align-items: center;
    /* overflow: hidden; */
    margin-top: 20px;
}

#infoProfile {
    width: 300px;
}

#infoProfile p {
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 16px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus {
    outline: none;
    border-color: #ff4d4d;
    background-color: #fff;
}

input::placeholder {
    color: #aaa;
}
</style>