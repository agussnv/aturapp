<script setup>
    import { ref, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import { useCounterStore } from '@/stores/counter';
    import { fetchAlertes } from '../services/communictationManager';

    const store = useCounterStore();
    const data = store.userData;
    const usuari_id = data.user.id;
    const router = useRouter();
    const alertes = ref([]);

async function getAlertas() {
    try {
        const response = await fetchAlertes();

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        alertes.value = await response.json();
        
    } catch (error) {
        console.error(error);
    }
}
    async function loadAlertes() {
        try {
            alertes.value = await fetchAlertes(usuari_id);
        } catch (error) {
            console.error("Error al cargar las alertas:", error);
        }
    }

    function formatFecha(isoDate) {
        const date = new Date(isoDate);
        return new Intl.DateTimeFormat('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date);
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

    function navigateTo(nameIcon) {
        router.push(`/${nameIcon}`);
    }

    onMounted(() => {
        if (usuari_id !== undefined) {
            loadAlertes();
        }
    });
</script>


<template>
    <div class="containCabezal">
        <div class="d-flex align-center j-center cabezal">
            <div class="d-flex align-center f-column" style="z-index: 20;">
                <img class="icon-arrow" src="../../public/assets/svg/arrow.svg" alt="back" width="40px" @click="navigateTo('perfil')">
                <p class="no-margin">Les meves alertes</p>
            </div>
        </div>
    </div>
    <ul id="containAlertes" class="no-margin d-flex j-center f-column align-center">
        <li v-for="alert in alertes" :key="alert.id" class="itemAlert">
            <div class="contentItem">
                <p>{{ formatText(alert.sector) }} ({{ alert.planta }})</p>
                <p>{{ formatFecha(alert.created_at) }}</p>
                <p>Estat: {{ alert.estado }}</p>
                <button class="btn-editar" @click="navigateTo(`perfil/alertes/editar?id=${alert.id}`)">Editar</button>
            </div>
        </li>
    </ul>
</template>

<style scoped>
#containAlertes{
    margin-top: 60px;
    margin-bottom: 80px;
}

#containAlertes>.itemAlert:first-child{
    margin-top: 30px;
}

.itemAlert {
    background-color: white;
    height: 80px;
    width: 350px;
    box-shadow: -5px -5px 9px rgba(198, 198, 198, 0.45), 5px 5px 9px rgba(94, 104, 121, 0.263);
    margin-top: 15px;
    border-radius: 10px;
    position: relative;
    list-style: none;
}

.contentItem {
    margin-top: 10px;
    margin-left: 20px;
    height: 50px;
    display: flex;
    flex-direction: column;
}

.contentItem p {
    margin: 0;
    color: #313131;
    font-size: 15px;
}

.contentItem p:nth-child(2) {
    margin-top: 3px;
    font-size: 13px;
}

.contentItem p:nth-child(3) {
    margin-top: 8px;
    font-size: 13px;
}

.contentItem .btn-editar {
    position: absolute;
    background-color: #ff4b45;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    top: 25px;
    right: 30px;
    border: none;
}
</style>