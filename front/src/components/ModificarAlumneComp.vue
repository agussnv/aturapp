<template>
    <div>
        <h1>Modificar Alumne</h1>
        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
        <div v-else-if="!alumne">Carregant dades dels estudiants ...</div>
        <div v-else>
            <form @submit.prevent="guardarCambios">
                <label for="nom">Nom:</label>
                <input id="nom" v-model="alumneEdit.nom" type="text" required />

                <label for="cognoms">Cognoms:</label>
                <input id="cognoms" v-model="alumneEdit.cognoms" type="text" required />

                <label for="email">Email:</label>
                <input id="email" v-model="alumneEdit.email" type="email" required />

                <label for="dni">DNI:</label>
                <input id="dni" v-model="alumneEdit.dni" type="text" required />

                <label for="telefon">Telèfon:</label>
                <input id="telefon" v-model="alumneEdit.telefon" type="text" />

                <label for="rol">Rol:</label>
                <select id="rol" v-model="selectedRol">
                    <option v-for="rol in roles" :key="rol.id" :value="rol.id">
                        {{ rol.name }}
                    </option>
                </select>

                <label for="curs">Curs:</label>
                <select id="curs" v-model="selectedCurs">
                    <option v-for="curs in cursos" :key="curs.id" :value="curs.id">
                        {{ curs.name }}
                    </option>
                </select>

                <label for="torn">Torn:</label>
                <select id="torn" v-model="selectedTorn">
                    <option v-for="torn in torns" :key="torn.id" :value="torn.id">
                        {{ torn.torn }}
                    </option>
                </select>

                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { getAlumneById, updateAlumne, getCursos, getTorns, getRoles } from '../services/communictationManager.js';

    const route = useRoute();
    const router = useRouter();

    const roles = ref([]);
    const torns = ref([]);
    const cursos = ref([]);
    const alumne = ref(null);
    const alumneEdit = ref({});
    const errorMessage = ref('');
    const selectedRol = ref(null);
    const selectedCurs = ref(null);
    const selectedTorn = ref(null);

    onMounted(async () => {
        try {
            roles.value = await getRoles();
            cursos.value = await getCursos();
            torns.value = await getTorns();

            const id = route.params.id;

            const response = await getAlumneById(id);
            if (response.success) {
                alumne.value = response.alumne;
                alumneEdit.value = { ...response.alumne };

                selectedRol.value = response.alumne.rol?.id || response.alumne.rol || null;
                selectedCurs.value = response.alumne.curs?.id || null;
                selectedTorn.value = response.alumne.torn?.id || null;
            } else {
                errorMessage.value = "Error cargando datos del alumno.";
            }
        } catch (error) {
            console.error('Error cargando datos del alumno:', error);
            errorMessage.value = "Error cargando datos del alumno.";
        }
    });

    const guardarCambios = async () => {
        try {
            const datosActualizados = {
                nom: alumneEdit.value.nom,
                cognoms: alumneEdit.value.cognoms,
                email: alumneEdit.value.email,
                dni: alumneEdit.value.dni,
                telefon: alumneEdit.value.telefon || "",

                rol: selectedRol.value,
                curs: selectedCurs.value,
                torn: selectedTorn.value,
            };

            console.log('Datos enviados al backend:', datosActualizados);

            await updateAlumne(alumneEdit.value.id, datosActualizados);

            alert('Datos guardados correctamente');
            router.push('/admin/alumnes');
        } catch (error) {
            alert('Error al guardar los cambios');
        }
    };
</script>

<style scoped>
    body {
        margin: 0;
        padding: 0;
        color: #333;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
    }

    div {
        padding: 20px;
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #c00;
        font-size: 1.8em;
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin: 10px 0 5px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        background-color: #fff;
    }

    select {
        cursor: pointer;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #c00;
        box-shadow: 0 0 5px rgba(204, 0, 0, 0.3);
    }

    button {
        border: none;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
        padding: 10px 15px;
        background-color: #c00;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #a00;
    }

    .error {
        color: #c00;
        padding: 10px;
        text-align: center;
        margin-bottom: 20px;
        background-color: #fdd;
        border: 1px solid #c00;
    }

    @media (max-width: 768px) {
        div {
            padding: 15px;
        }

        input, select {
            font-size: 0.9em;
        }

        button {
            font-size: 0.9em;
            padding: 8px 12px;
        }
    }
</style>