<template>
    <div id="filtre">
        <select v-model="selectedCurs">
            <option value="">Tots els cursos</option>
            <option v-for="curs in cursosUnicos" :key="curs" :value="curs">
                {{ curs }}
            </option>
        </select>

        <select v-model="selectedTorn">
            <option value="">Todos los turnos</option>
            <option v-for="torn in tornsUnics" :key="torn" :value="torn">
                {{ torn }}
            </option>
        </select>

        <input type="text" placeholder="Busca alumne o email" v-model="searchQuery" />
    </div>

    <div id="llistatAlumnes">
        <p v-for="alumne in alumnesFiltrats" :key="alumne.id">
            Nom:    {{ alumne.nom }}        <br>
            Cognom: {{ alumne.cognoms }}    <br>
            Email:  {{ alumne.email }}      <br><br>
            <button @click="verDetall(alumne.id)">Més informació</button>
            <br>
            <button @click="ModificarAlumne(alumne.id)">Modificar Alumne</button>
        </p>
    </div>
</template>

<script setup>
    import { ref, computed, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import ModificarAlumneComp from './ModificarAlumneComp.vue';
    import { getAlumnes } from '../services/communictationManager';

    const alumnes = ref([]);
    const router = useRouter();
    const searchQuery = ref('');
    const errorMessage = ref('');
    const selectedCurs = ref('');
    const selectedTorn = ref('');

    onMounted(async () => {
        try {
            const data = await getAlumnes();
            alumnes.value = data;
        } catch (error) {
            errorMessage.value = 'No se han podido cargar los alumnos.';
        }
    });

    const cursosUnicos = computed(() => {
        return [...new Set(alumnes.value.map(alumne => alumne.curs?.name))];
    });

    const tornsUnics = computed(() => {
        return [...new Set(alumnes.value.map(alumne => alumne.torn?.torn))];
    });

    const alumnesFiltrats = computed(() => {
        const query = searchQuery.value.toLowerCase();
        return alumnes.value.filter(alumne => {
            const cumpleCurs = selectedCurs.value === '' || alumne.curs?.name === selectedCurs.value;
            const cumpleTorn = selectedTorn.value === '' || alumne.torn?.torn === selectedTorn.value;
            const cumpleBusqueda = (
                alumne.nom.toLowerCase().includes(query) ||
                alumne.cognoms.toLowerCase().includes(query) ||
                alumne.email.toLowerCase().includes(query)
            );
            return cumpleCurs && cumpleTorn && cumpleBusqueda;
        });
    });

    const ModificarAlumne = (id) => {
        router.push(`/admin/modificar-alumne/${id}`);
    };

    const verDetall = (id) => {
        router.push(`/admin/alumnes/${id}`);
    };
</script>

<style scoped>
    *{
        transition: 0.2s;
    }
    body {
        color: #333;
        background-color: #fff;
        font-family: Arial, sans-serif;
    }

    #llistatAlumnes {
        gap: 20px;
        display: grid;
        padding: 20px;
        margin: 0 auto;
        max-width: 1200px;
        align-items: start;
        justify-items: center;
        grid-template-columns: repeat(3, 1fr);
    }

    #llistatAlumnes p {
        width: 95%;
        padding: 15px;
        text-align: left;
        background-color: #f9f9f9;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button {
        border: none;
        margin: 5px 0;
        padding: 10px;
        color: white;
        cursor: pointer;
        background-color: red;
    }

    button:hover {
        background-color: darkred;
    }

    #filtre select,
    #filtre input {
        padding: 10px;
        font-size: 1em;
        margin: 10px 5px;
        border: 1px solid red;
    }

    #filtre select {
        background-color: #fff;
    }

    #filtre {
        padding: 20px;
        color: white;
        text-align: center;
    }

    @media (max-width: 768px) {
        #llistatAlumnes {
            grid-template-columns: 1fr;
        }
    }
</style>