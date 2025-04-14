<template>
    <div class="container">
        <h1>Alertas Admin</h1>
        <div v-if="cargando">Carregant alertas...</div>
        <div v-else-if="error" class="error">Error al cargar alertas: {{ error }}</div>
        <ul v-else>
            <li v-for="alerta in alertas" :key="alerta.id">
                <div class="alerta-header">
                    <strong>{{ alerta.titulo || 'Sin título' }}</strong>
                </div>
                <div class="alerta-content">
                    Descripció: {{ alerta.descripcion || 'Sin descripción' }}<br />
                    Sector: {{ alerta.sector || 'Sin sector' }}<br />
                    Planta: {{ alerta.planta || 'Sin planta' }}<br />
                    Estat:
                    <select v-model="alerta.estado" @change="actualizarEstado(alerta)">
                        <option :value="alerta.estado" disabled>{{ alerta.estado }}</option>
                        <option value="pendent">Pendent</option>
                        <option value="en progres">En progrés</option>
                        <option value="resolt">Resolt</option>
                    </select>
                    <br /><br>
                    Data: {{ formatearFecha(alerta.created_at) }}
                </div>
            </li>
        </ul>
    </div>
</template>


<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { AdminAlertes_getAllAlertsAdmin, AdminAlertes_updateAlert } from '../services/communictationManager';

    const alertas = ref([]);
    const cargando = ref(true);
    const error = ref(null);
    const pollingInterval = ref(null);

    const fetchAlertas = async (showNotification = false) => {
        try {
            const datos = await AdminAlertes_getAllAlertsAdmin();

            if (showNotification && datos.length > alertas.value.length) {
                const nuevasAlertas = datos.slice(alertas.value.length);
                nuevasAlertas.forEach(alerta => {
                    mostrarNotificacion('Nueva alerta', alerta.titulo || 'Sin título');
                });
            }

            alertas.value = datos;
        } catch (err) {
            console.error('Error al cargar alertas:', err);
            error.value = `Error al cargar alertas: ${err.message}`;
        } finally {
            cargando.value = false;
        }
    };

    const bucleFetch = () => {
        pollingInterval.value = setInterval(() => fetchAlertas(true), 5000); 
    };

    const detenerFetch = () => {
        if (pollingInterval.value) {
            clearInterval(pollingInterval.value);
        }
    };

    const mostrarNotificacion = (titulo, mensaje) => {
        if (Notification.permission === 'granted') {
            new Notification(titulo, { body: mensaje });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    new Notification(titulo, { body: mensaje });
                }
            });
        }
    };

    const actualizarEstado = async (alerta) => {
        try {
            await AdminAlertes_updateAlert(alerta.id, alerta.estado);
            alert("Estat modificat correctament");
            mostrarNotificacion('Éxito', `El estado de la alerta "${alerta.titulo}" ha sido actualizado.`);
        } catch (err) {
            error.value = `Error al actualizar la alerta: ${err.message}`;
            mostrarNotificacion('Error', `No se pudo actualizar la alerta "${alerta.titulo}".`);
        }
    };

    const formatearFecha = (fechaISO) => {
        if (!fechaISO) return 'Sin fecha';

        const fecha = new Date(fechaISO);

        const opciones = { 
            timeZone: 'UTC', 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit', 
            hour: '2-digit', 
            minute: '2-digit' 
        };

        return fecha.toLocaleDateString('es-ES', opciones);
    };

    onMounted(() => {
        fetchAlertas();
        bucleFetch();
    });

    onUnmounted(() => {
        detenerFetch(); 
    });
</script>

<style scoped>
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: white; 
    color: #333;
}

.container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    text-align: left;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

h1 {
    color: black; 
    text-align: center;
    margin-bottom: 20px;
    font-size: 2rem;
    font-weight: bold;
}

.error {
    color: #b71c1c;
    background-color: #ffebee; 
    padding: 15px;
    border-radius: 8px;
    margin-top: 10px;
    border: 1px solid #f44336;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: #ffebee; 
    margin: 10px 0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-left: 5px solid #d32f2f; 
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: relative;
}

li strong {
    font-size: 1.2rem;
    color: #b71c1c; 
}

li select {
    padding: 5px 10px;
    border: 1px solid #d32f2f;
    border-radius: 5px;
    background: #ffcdd2;
    font-size: 1rem;
    color: #b71c1c;
}

li select:focus {
    outline: none;
    border-color: #d32f2f;
    box-shadow: 0 0 5px rgba(211, 47, 47, 0.5);
}

li span {
    color: #c62828; 
    font-size: 0.9rem;
}

li .estado {
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

li .estado select {
    flex: 1;
}

li .fecha {
    font-style: italic;
    color: #d32f2f; 
}

.alerta-header {
    display: flex;
    justify-content: space-between; 
    align-items: center;
}

.alerta-btn {
    background-color: #d32f2f;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.alerta-btn:hover {
    background-color: #b71c1c;
}

.alerta-content {
    margin-top: 10px;
}

</style>
