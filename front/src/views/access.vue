<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

function goToLogin() {
  router.push("/login");
}

function goToRegister() {
  router.push("/register");
}
</script>

<template>
  <div class="initial-page">
    <h1>Benvingut a ATURAPP</h1>
    <p>Que desitges fer</p>
    <div class="link-container">
      <a @click.prevent="goToLogin" class="link">Iniciar Sesión</a>
      <a @click.prevent="goToRegister" class="link">Registrarse</a>
    </div>
  </div>
</template>

<style scoped>
.initial-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  font-family: 'Arial', sans-serif;
  background-color: #f7f7f7;
}

h1 {
  color: #ff4d4d;
  margin-bottom: 20px;
}

p {
  margin-bottom: 20px;
  font-size: 18px;
  color: #555;
}

.link-container {
  display: flex;
  gap: 20px;
}

.link {
  font-size: 18px;
  color: #007BFF;
  text-decoration: none;
  cursor: pointer;
  transition: color 0.3s ease;
}

.link:hover {
  color: #0056b3;
}
</style>
