<template>
    <div v-if="alumne">
        <h1>Detalls de l'alumne</h1>
        <p>Nom: {{ alumne.nom }}</p>
        <p>Cognom: {{ alumne.cognoms }}</p>
        <p>Email: {{ alumne.email }}</p>
        <p>Curs: {{ alumne.curs?.name }}</p>
        <p>Torn: {{ alumne.torn?.torn }}</p>
        <p>Telefon: {{ alumne.telefon }}</p>

        <h2>Alertas de l'alumne</h2>
        <div v-if="alertas.length > 0">
            <ul>
                <li v-for="alerta in alertas" :key="alerta.id">
                    <strong>Sector:</strong> {{ alerta.sector }} <br>
                    <strong>Planta:</strong> {{ alerta.planta }} <br>
                    <strong>Descripció:</strong> {{ alerta.descripcion }} <br>
                    <strong>Estat:</strong> {{ alerta.estado }} <br>
                    <strong>Data:</strong> {{ alerta.created_at }}
                </li>
            </ul>
        </div>
        <p v-else>No hi han alertes registrades per aquest alumne</p>
    </div>
    <div v-else>
        <p>Cargant dades...</p>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';
    import { getAlumneById, alertasAlumne } from '../services/communictationManager';

    const route = useRoute();
    const alumne = ref(null);
    const alertas = ref([]);
    const errorMessage = ref('');

    onMounted(async () => {
        const id = route.params.id;
        try {
            const data = await getAlumneById(id);
            alumne.value = data.alumne;

            const alertasData = await alertasAlumne(id);
            alertas.value = alertasData;
        } catch (error) {
            errorMessage.value = 'No s\'han pogut carregar les dades';
        }
    });
</script>

<style scoped>
    * {
        transition: 0.2s;
    }

    body {
        color: #333;
        background-color: #fff;
        font-family: Arial, sans-serif;
    }

    h1, h2 {
        text-align: center;
        color: red;
    }

    div {
        padding: 20px;
        margin: 0 auto;
        max-width: 800px;
    }

    p {
        margin: 10px 0;
        font-size: 1.1em;
    }

    p strong {
        font-weight: bold;
    }

    ul {
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 10px;
        background-color: #f9f9f9;
        padding: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
        cursor: pointer;
        background-color: red;
        color: white;
        border: none;
        border-radius: 5px;
        transition: background-color 0.2s;
    }

    button:hover {
        background-color: darkred;
    }

    .loading {
        text-align: center;
        font-size: 1.2em;
        color: #999;
    }
</style>
