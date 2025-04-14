<script setup>
import { computed, onMounted } from "vue";
import { RouterView, useRouter } from 'vue-router';
import { useCounterStore } from "./stores/counter";
import AlumnoNavbar from "./components/AlumnoNavbar.vue";
import AdminNavbar from "./components/AdminNavbar.vue";
import socket from '@/services/socket.js';
import Swal from 'sweetalert2';

const store = useCounterStore();

const isLogged = computed(() => store.Iniciado);
const isAlumne = computed(() => store.userData?.user?.rol === 1);
const isAdmin = computed(() => store.userData?.user?.rol === 2);
const router = useRouter();

onMounted(() => {
  console.log('testeando');
  socket.on('test', () => {
    console.log('test');
  });

  socket.on('peticionChat', (data) => {
    Swal.fire({
        title: "Un alumno esta intentando iniciar un chat, quieres aceptarlo?",
        width: 600,
        showDenyButton: true,
        confirmButtonText: "Aceptar",
        denyButtonText: `Rechazar`
    }).then((result) => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        if (result.isConfirmed) {
            Toast.fire({
                icon: "success",
                title: "Chat aceptado"
            });
            socket.emit('chatAceptado', data);
            router.push('/chat');
        } else if (result.isDenied) {
            Toast.fire({
                icon: "error",
                title: "Chat rechazado"
            });
        }
    });
});

  socket.on('cargarChat', (mensajes) => {
    alert('cargarChat');
    router.push('/chat');
    chatEnEspera.value = false;
    chatConBot.value = false;
    messages.splice(0, messages.length, ...mensajes);
  });

  if (store.Iniciado) {
    socket.emit('connexion', { id: store.userData.user.id, rol: store.userData.user.rol });
  }
});

</script>

<template>
  <h1 v-if="isLogged && isAdmin" class="d-flex j-center">Panel de admin</h1>
  <AdminNavbar v-if="isLogged && isAdmin" />
  <RouterView />
  <AlumnoNavbar v-if="isLogged && isAlumne" />
</template>

<style>
body {
  margin: 0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
  background: #eff2f5;
}

/* ------------------------------------------ */
.no-style {
  list-style: none;
  text-decoration: none;
}

.no-margin {
  margin: 0;
  padding: 0;
}

.d-flex {
  display: flex;
}

.j-center {
  justify-content: center;
}

.j-right {
  justify-content: right;
}

.j-left {
  justify-content: left;
}

.j-between {
  justify-content: space-between;
}

.j-around {
  justify-content: space-around;
}

.align-center {
  align-items: center;
  align-content: center;
}

.f-column {
  flex-direction: column;
}

.mt-20 {
  margin-top: 20px;
}

.mt-40 {
  margin-top: 40px;
}

.mt-60 {
  margin-top: 60px;
}

.mx-10 {
  margin-left: 10px;
  margin-right: 10px;
}

.mx-20 {
  margin-left: 20px;
  margin-right: 20px;
}

.mt-60 {
  margin-top: 60px;
}

.p-15 {
  padding: 15px;
}

.py-10 {
  padding-top: 10px;
  padding-bottom: 10px;
}

.py-20 {
  padding-top: 20px;
  padding-bottom: 20px;
}

.py-30 {
  padding-top: 30px;
  padding-bottom: 30px;
}

.py-40 {
  padding-top: 40px;
  padding-bottom: 40px;
}

.w-full {
  width: 100%;
}

.h-full {
  height: 100%;
}

.btn-cancel {
  width: 180px;
  height: 45px;
  background-color: #a83d3a;
  border: 1px solid grey;
  background-color: white;
  padding: 10px 30px;
  font-size: 20px;
  font-weight: bold;
  color: grey;
  border-radius: 10px;
}

.btn-confirm {
  width: 180px;
  height: 45px;
  background-color: #a83d3a;
  outline: none;
  border: none;
  padding: 10px 30px;
  font-size: 20px;
  font-weight: bold;
  color: white;
  border-radius: 10px;
}

/* ------------------------------------------ */

.navbar {
  height: 70px;
  position: fixed;
  background-color: white;
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
  bottom: 0;
  right: 0;
  left: 0;
  overflow: hidden;
}

#items>li {
  height: 100%;
  display: flex;
  align-items: center;
}

.active {
  border-top: 3px solid red;

}

.icon-arrow {
  position: absolute;
  left: 10px;
  bottom: 0;
  top: 0;
  margin: auto;
}

.containCabezal {
  position: fixed;
  top: 0;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
  z-index: 10;
}

.cabezal {
  box-sizing: border-box;
  background-color: #ff4b45;
  box-shadow: -5px -5px 9px rgba(255, 39, 39, 0.45), 5px 5px 9px rgba(255, 0, 0, 0.374);
  height: 60px;
  width: 100%;
  border-radius: 20px;
  z-index: 10;
}

.cabezal p {
  color: white;
  font-weight: bold;
  font-size: 20px;
}

#containButtons {
  position: fixed;
  bottom: 65px;
  left: 0;
  right: 0;
  margin: auto;
}

.box {
  box-shadow: -5px -5px 9px rgba(255, 255, 255, 0.45), 5px 5px 9px rgba(94, 104, 121, 0.3);
  padding: 10px;
  border-radius: 10px
}
</style>