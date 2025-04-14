<script setup>
import { ref } from 'vue';
import * as d3 from 'd3';
import { getAnalisisData, getCompanysClaseSociograma } from '../services/communictationManager';

const data = ref([]);
const clases = ref([]);
const selectedClass = ref('');
const nombresVictimes = ref([]);
const nombresNoMencionados = ref([]);
const nombresBullies = ref([]);

const fetchData = async () => {
    try {
        const json = await getAnalisisData();
        data.value = json;
        const uniqueClasses = [...new Set(json.map(item => item['Curs alumne emisor'].relacion))];
        clases.value = uniqueClasses;

        crearSociograma();
    } catch (error) {
        console.error('Error al obtener los datos de análisis:', error);
    }
};

const crearSociograma = () => {
    const nodos = [];
    const enlaces = [];
    const relacionesPositivas = {};
    let filteredData;

    if (selectedClass.value) {
        filteredData = data.value.filter(item => item['Curs alumne emisor'].relacion === selectedClass.value);
    } else {
        filteredData = data.value;
    }

    filteredData.forEach(item => {
        const alumnoEmisor = item['Alumne emisor'];
        const alumnos = [item['resposta 1'], item['resposta 2'], item['resposta 3']];
        const esPositiva = [1, 4, 7, 12].includes(item['pregunta'].id);
        const color = esPositiva ? 'green' : 'red';

        if (!nodos.find(nodo => nodo.id === alumnoEmisor.id)) {
            nodos.push({ id: alumnoEmisor.id, name: alumnoEmisor.relacion });
            relacionesPositivas[alumnoEmisor.id] = 0;
        }

        if (esPositiva) {
            relacionesPositivas[alumnoEmisor.id] += 1;
        }

        alumnos.forEach(alumno => {
            if (alumno.id !== alumnoEmisor.id) {
                if (!nodos.find(nodo => nodo.id === alumno.id)) {
                    nodos.push({ id: alumno.id, name: alumno.relacion });
                    relacionesPositivas[alumno.id] = 0;
                }

                if (esPositiva) {
                    relacionesPositivas[alumno.id] += 1;
                }

                enlaces.push({ source: alumnoEmisor.id, target: alumno.id, weight: 2, color });
            }
        });
    });

    const width = 600;
    const height = 400;

    const svg = d3.select("#sociograma")
        .attr("width", width)
        .attr("height", height);

    svg.selectAll("*").remove();

    const simulation = d3.forceSimulation(nodos)
        .force("link", d3.forceLink(enlaces).id(d => d.id).distance(100))
        .force("charge", d3.forceManyBody().strength(-100))
        .force("center", d3.forceCenter(width / 2, height / 2));

    const link = svg.append("g")
        .selectAll(".link")
        .data(enlaces)
        .enter().append("line")
        .attr("class", "link")
        .attr("stroke", d => d.color)
        .attr("stroke-width", d => d.weight)
        .attr("stroke-opacity", 0.6);

    const node = svg.append("g")
        .selectAll(".node")
        .data(nodos)
        .enter().append("circle")
        .attr("class", "node")
        .attr("r", d => 5 + relacionesPositivas[d.id])
        .attr("fill", "steelblue")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));

    const labels = svg.append("g")
        .selectAll(".label")
        .data(nodos)
        .enter().append("text")
        .attr("class", "label")
        .attr("dx", 12)
        .attr("dy", ".35em")
        .text(d => d.name);

    simulation.on("tick", () => {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);

        labels
            .attr("x", d => d.x)
            .attr("y", d => d.y);
    });

    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(event, d) {
        d.fx = event.x;
        d.fy = event.y;
    }

    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }
};

const obtenerBullies = () => {
    if (!selectedClass.value) {
        nombresBullies.value = [];
        return;
    }

    const filteredData = data.value.filter(item =>
        item['Curs alumne emisor'].relacion === selectedClass.value &&
        [3, 5, 6, 8].includes(item['pregunta'].id)
    );

    const nombres = new Set(
        filteredData.map(item => item['Alumne emisor'].relacion)
    );

    nombresBullies.value = Array.from(nombres);
};

const obtenerVictimes = () => {
    if (!selectedClass.value) {
        nombresVictimes.value = [];
        return;
    }

    const filteredData = data.value.filter(item =>
        item['Curs alumne emisor'].relacion === selectedClass.value &&
        [9, 10].includes(item['pregunta'].id)
    );

    const nombres = new Set(
        filteredData.flatMap(item => [
            item['resposta 1'].relacion,
            item['resposta 2'].relacion,
            item['resposta 3'].relacion
        ])
    );

    nombresVictimes.value = Array.from(nombres);
};

const obtenerNombresNoMencionados = async () => {
    if (!selectedClass.value) {
        nombresNoMencionados.value = [];
        return;
    }

    try {
        const json = await getCompanysClaseSociograma(selectedClass.value);
        const todosNombres = json.companys.map(company => `${company.nom} ${company.cognoms}`);

        const mencionados = new Set(
            data.value
                .filter(item => item['Curs alumne emisor'].relacion === selectedClass.value)
                .flatMap(item => [
                    item['Alumne emisor'].relacion,
                    item['resposta 1'].relacion,
                    item['resposta 2'].relacion,
                    item['resposta 3'].relacion,
                ])
        );

        nombresNoMencionados.value = todosNombres.filter(nombre => !mencionados.has(nombre));
    } catch (error) {
        console.error('Error al obtener los nombres no mencionados:', error);
    }
};

const actualizarSociograma = async () => {
    crearSociograma();
    await obtenerNombresNoMencionados();
    obtenerVictimes();
    obtenerBullies();
};

fetchData();
</script>

<template>
    <div>
        <div>
            <p>Per veure més informació de la clase selecciona la teva</p>
            <label for="clase">Selecciona una clase:</label>
            <select id="clase" v-model="selectedClass" @change="actualizarSociograma">
                <option value="">Todas les clases</option>
                <option v-for="clase in clases" :key="clase" :value="clase">{{ clase }}</option>
            </select>
        </div>

        <p v-if="!data || !data.length">Carregant dades...</p>

        <div class="container">
            <svg id="sociograma"></svg>

            <div id="infoAdicional">
                <div v-if="nombresNoMencionados.length" class="nombres-no-mencionados">
                    <h3>Noms no mencionats</h3>
                    <ul>
                        <li v-for="nombre in nombresNoMencionados" :key="nombre">{{ nombre }}</li>
                    </ul>
                </div>

                <div v-if="nombresVictimes.length" class="nombres-victimes">
                    <h3>Víctimes</h3>
                    <ul>
                        <li v-for="nombre in nombresVictimes" :key="nombre">{{ nombre }}</li>
                    </ul>
                </div>

                <div v-if="nombresBullies.length" class="nombres-bullies">
                    <h3>Responsables de Bullying</h3>
                    <ul>
                        <li v-for="nombre in nombresBullies" :key="nombre">{{ nombre }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

.container {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 20px;
    max-width: 1200px;
    margin: auto;
    margin-top: 50px;
    background-color: #fff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

svg {
    border: 1px solid red;
    background-color: #fff;
    flex-shrink: 0;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

#infoAdicional {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 15px;
    background-color: #ffe5e5;
    border: 2px solid red;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.nombres-no-mencionados,
.nombres-victimes,
.nombres-bullies {
    border: 1px solid red;
    padding: 15px;
    background-color: #ffcccc;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

h3 {
    color: red;
    margin-bottom: 10px;
    font-size: 1.2em;
    border-bottom: 1px solid red;
    padding-bottom: 5px;
}

ul {
    margin: 0;
    padding: 0;
    list-style-type: none;
}

li {
    color: #000;
    margin-bottom: 8px;
    font-size: 0.9em;
}

label {
    font-weight: bold;
    margin-right: 10px;
}

select {
    padding: 5px 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
    font-size: 0.9em;
}

select:focus {
    border-color: red;
    outline: none;
    box-shadow: 0px 0px 5px rgba(255, 0, 0, 0.5);
}

p {
    font-style: italic;
    color: #666;
}

button {
    padding: 10px 15px;
    border: none;
    background-color: red;
    color: white;
    font-size: 0.9em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: darkred;
}

.node {
    stroke: #fff;
    stroke-width: 1.5px;
}

.link {
    stroke-opacity: 0.6;
}

.label {
    font-size: 0.8em;
    fill: #333;
}
</style>