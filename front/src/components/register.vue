<template>
    <h1>REGISTRA'T</h1>

    <div id="containForm" class="d-flex f-column align-center j-center">
        <form @submit.prevent="handleSubmit">
            <input type="text" v-model="name" placeholder="Nom" />
            <input type="text" v-model="surname" placeholder="Cognom" />
            <input type="text" v-model="email" placeholder="Correu electrònic" />
            <p>Selecciona el teu curs</p>
            <select v-model="grade">
                <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
                    {{ curso.name }}
                </option>
            </select>
            <input type="text" v-model="dni" placeholder="DNI" />
            <div class="password-container">
                <input :type="passwordType" v-model="password" placeholder="Contrasenya" />
                <i :class="passwordIcon" @click="togglePassword"></i>
            </div>
            <div class="password-container">
                <input :type="confirmPasswordType" v-model="confirmPassword" placeholder="Confirmar contrasenya" />
                <i :class="confirmPasswordIcon" @click="toggleConfirmPassword"></i>
            </div>
            <button class="btn-register" type="submit">Registrar-se</button>
        </form>
        <div class="d-flex j-center align-center no-margin">
            <button class="btn-login" @click="navigateTo('login')">Iniciar sessió</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { fetchCursos, registerUser } from '../services/communictationManager';

const router = useRouter();

const name = ref('');
const surname = ref('');
const email = ref('');
const grade = ref('');
const dni = ref('');
const password = ref('');
const confirmPassword = ref('');
const cursos = ref([]);
const passwordType = ref("password");
const confirmPasswordType = ref("password");
const passwordIcon = ref("fa fa-eye");
const confirmPasswordIcon = ref("fa fa-eye");

async function loadCursos() {
    try {
        cursos.value = await fetchCursos();
    } catch (error) {
        console.error("Error al cargar los cursos:", error);
        alert("No se pudieron cargar los cursos.");
    }
}

async function handleSubmit() {
    const DominisValids = ["@inspedralbes.cat", "@xtec.cat"];

    if (!DominisValids.some(domain => email.value.endsWith(domain))) {
        alert("Correu Invalid");
        return;
    }

    if (password.value !== confirmPassword.value) {
        alert("Les contrasenyes no coincideixen");
        return;
    }

    if (!dni.value.trim()){ dni.value = "00000000Z" }

    const userData = {
        name: name.value,
        surname: surname.value,
        email: email.value,
        grade: grade.value,
        dni: dni.value,
        password: password.value,
        password_confirmation: confirmPassword.value,
    };

    try {
        const result = await registerUser(userData);
        alert("Usuari registrat amb èxit: " + result.message);
    } catch (error) {
        console.error("Error al registrar l'usuari:", error);
        alert("Error al registrar l'usuari");
    }
}

function togglePassword() {
    passwordType.value = passwordType.value === "password" ? "text" : "password";
    passwordIcon.value = passwordType.value === "password" ? "fa fa-eye" : "fa fa-eye-slash";
}

function toggleConfirmPassword() {
    confirmPasswordType.value = confirmPasswordType.value === "password" ? "text" : "password";
    confirmPasswordIcon.value = confirmPasswordType.value === "password" ? "fa fa-eye" : "fa fa-eye-slash";
}

function navigateTo(namePath) {
    router.push(`/${namePath}`);
}

onMounted(() => {
    loadCursos();
});
</script>


<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
}

h1 {
    margin-top: 30px;
    color: #ff4d4d;
    text-align: center;
}

p {
    font-size: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    width: 100%;
}

input,
select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

input:focus,
select:focus {
    outline: none;
    border-color: #ff4d4d;
    background-color: #fff;
}

input::placeholder,
select::placeholder {
    color: #aaa;
}

button {
    padding: 14px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #ff4d4d;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-register:hover {
    background-color: #e60000;
}

.password-container {
    display: flex;
    align-items: center;
    background: #f9f9f9;
    border: 1px solid #ddd;
}

.password-container input {
    border: 0;
    width: 90%;
    border: 1px solid white;
    background: #f9f9f9;
    padding: 12px;
}

.password-container input:focus {
    border: 1px solid red;
}

.password-container i {
    width: 10%;
    text-align: center;
    padding: 12px 0;
    cursor: pointer;
    background-color: #f9f9f9;
}

@media (max-width: 600px) {
    form {
        width: 90%;
        margin: 20px auto;
    }

    input,
    select {
        padding: 10px;
        font-size: 14px;
    }

    button {
        font-size: 14px;
        padding: 12px;
    }
}

#containForm {
    margin-top: 20px;
}

#containForm form {
    margin: 0;
    padding: 0;
    width: 320px;
}

.btn-login {
    margin-top: 10px;
    width: 320px;
    background-color: white;
    border: 1px solid #ff4d4d;
    color: #ff4d4d;
    transition: all 0.3s ease;
}

.btn-login:hover {
    border: 1px solid #e60000;
    color: #e60000;
}
</style>