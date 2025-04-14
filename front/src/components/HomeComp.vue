<template>
    <div v-if="!sosActive" class="contain-sos w-full d-flex j-center align-center f-column">
        <h2 class="sos-heading">
            <span class="static-text">Ets </span>
            <span class="dynamic-text">{{ victimaTestimoni }}?</span><br>
            <span class="action">Prem el botó <span style="font-size: 35px;">SOS</span> i avisa'ns!</span>
        </h2>
        <input class="btn-sos" type="button" value="SOS" @click="sosAlert">
    </div>
    <div v-if="sosActive">
        <div v-if="!edificiActive" class="d-flex j-center align-center plantaSelector">
            <p class="container-planta no-margin" style="font-weight: bold; padding: 10px 20px;">Zona exterior</p>
        </div>
        <input class="sectorInput" type="text" name="sector" id="sec" v-model="sectorName"
            placeholder="Seleccioni un sector" readonly>
        <div v-if="!edificiActive" class="planoContainer">
            <div class="d-flex j-center align-center h-full">
                <svg width="60%" viewBox="0 0 613 396" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path v-for="(sector, index) in exteriorh" :key="index" :id="sector.id" :d="sector.d"
                        :stroke="'black'" :fill="sector.color" :stroke-width="3"
                        @click="toggleSectorColor(index, exteriorh)" class="sector" />
                    <g v-html="exterior"></g>
                </svg>
            </div>
        </div>
        <div v-if="edificiActive">
            <div class="d-flex j-center align-center plantaSelector">
                <select v-model="plantaInput" name="planta" id="planta" class="container-planta">
                    <option value="planta0">Planta baixa</option>
                    <option value="planta1">Planta 1</option>
                    <option value="planta2">Planta 2</option>
                    <option value="planta3">Planta 3</option>
                </select>
            </div>
            <div class="planoContainer mobile-view">
                <div v-if="plantaInput == 'planta0'">
                    <svg width="407" height="1865" viewBox="0 0 407 1865" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors0v" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors0v)" class="sector" />
                        <g v-html="planta0v"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta1'">
                    <svg width="407" height="1865" viewBox="0 0 407 1865" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors1v" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors1v)" class="sector" />
                        <g v-html="planta1v"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta2'">
                    <svg width="404" height="1866" viewBox="0 0 404 1866" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors2v" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors2v)" class="sector" />
                        <g v-html="planta2v"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta3'">
                    <svg width="414" height="1864" viewBox="0 0 414 1864" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors3v" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors3v)" class="sector" />
                        <g v-html="planta3v"></g>
                    </svg>
                </div>
            </div>
            <div class="planoContainer desktop-view">
                <div v-if="plantaInput == 'planta0'">
                    <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors0h" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors0h)" class="sector" />
                        <g v-html="planta0h"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta1'">
                    <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors1h" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors1h)" class="sector" />
                        <g v-html="planta1h"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta2'">
                    <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors2h" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors2h)" class="sector" />
                        <g v-html="planta2h"></g>
                    </svg>
                </div>
                <div v-if="plantaInput == 'planta3'">
                    <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path v-for="(sector, index) in sectors3h" :key="index" :id="sector.id" :d="sector.d"
                            :stroke="'black'" :fill="sector.color" :stroke-width="5"
                            @click="toggleSectorColor(index, sectors3h)" class="sector" />
                        <g v-html="planta3h"></g>
                    </svg>
                </div>
            </div>
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-cancel" type="button" value="Cancelar" @click="sosAlert">
            <input class="btn-confirm" type="button" value="Confirmar" @click="enviar">
        </div>
        <div v-if="alertaEnviada" class="popup-overlay">
            <div class="popup-content">
                <h2>L'alerta ha sigut enviada</h2>
                <p>Podries donar-nos més informació?</p>
                <textarea rows="5" placeholder="Escriu aquí qualsevol informació addicional sobre l'alerta..."
                    class="textarea-info" v-model="alertaDescripcio"></textarea>
                <button class="popup-button" @click="editarAlerta">Enviar</button>
            </div>
        </div>
        <div v-if="alertaEditada" class="popup-overlay">
            <div class="popup-content">
                <h2>Gràcies per avisar-nos</h2>
                <p>Estem de camí, mantén la calma.</p>
                <button class="popup-button" @click="tornarInici">Acceptar</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useCounterStore } from '@/stores/counter';
import { exterior, planta0h, planta0v, planta1h, planta1v, planta2h, planta2v, planta3v, planta3h } from '@/assets/planos/paths';

const store = useCounterStore();
const edificiActive = ref(false);
const sosActive = ref(false);
const alertaEnviada = ref(false);
const sectorInput = ref('');
const sectorName = ref('');
const plantaInput = ref('planta0');
const dataUser = store.userData;
const alumno_id = dataUser.user.id;
const alerta = ref(null);
const alertaDescripcio = ref("");
const alertaEditada = ref(false);
const words = ["víctima", "testimoni"];
const currentWordIndex = ref(0);
const victimaTestimoni = ref("testimoni");

function startWordRotation() {
    setInterval(() => {
        victimaTestimoni.value = words[currentWordIndex.value];
        currentWordIndex.value = (currentWordIndex.value + 1) % words.length;
    }, 2000); // Cambiar palabra cada 2 segundos
}

function resetSector() {
    arraySectores.forEach((sectores) => {
        sectores.value.forEach((sector, i) => {
            sector.color = "white";
        });
    });
    sectorInput.value = null;
}

function sosAlert() {
    sosActive.value = !sosActive.value;
    resetSector();
    edificiActive.value = false;
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

const exteriorh = ref([
    { id: "edifici", d: "M117 336V295.75M117 295.75V255.5L174 251L237.5 245.749L290 241.5L458 251V336L290 327L117 338.5V295.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "gimnas", d: "M355 180L237.5 179.5V245.5L290 241.5L355.5 245L355 180Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pati-eso-1", d: "M448 250.5V167.5H355L355.5 245L448 250.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "camp-futbol-sala", d: "M1 264.5V179.5H173L173.5 251L1 264.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "parquing", d: "M1 395.5V264.5L117 255.5V395.5H1Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "taules-ping-pong", d: "M117 338.5V395.5H242V330.5L117 338.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "entrada", d: "M339 395.5H242V330.5L291 327L339 329.5V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "entrada-cantina", d: "M339 329.5L458 336V395.5H339V329.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "entrada-cotxe", d: "M611.5 395.5H458V331H611.5V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "escales-pati", d: "M489.5 251V331H458V251H489.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "picnic", d: "M610 261L489.5 251V331H611.5L610 261Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "camp-futbol", d: "M448 161.5V250.5L458 251H489.5L610 261V161.5H448Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pista-basquet", d: "M610 36V161.5H448V167.5H434.5V71H506L558 1L610 36Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pati-eso-2", d: "M237.5 179.5H173V251L237.5 245.5V179.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors0v = ref([
    { id: "wc0", d: "M188.156 1783.5L179.5 1863.5L307.5 1864L313.5 1783.5H188.156Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias0", d: "M254 1082.5L268 932H53L50 1061.5L208.5 1075L254 1082.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias0", d: "M194 1729.5H146.5L208 1075L254 1082.5L194 1729.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca0", d: "M53 932L50 802.5L208.5 789L254 781.5L260 844L268 932H53Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca0", d: "M193.5 135H146.5L208 789L254 781.5L193.5 135Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-13", d: "M207.5 1582.5L194 1729.5L340 1733.5L352.5 1588L207.5 1582.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-11", d: "M353 1588L366.5 1454.5L220.5 1446.5L207.5 1582L353 1588Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-12", d: "M160.5 1579.5L173 1445L25 1435.5L13.5 1573.5L160.5 1579.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-14", d: "M146.541 1729.5L160.5 1579.5L13.5 1573.5L1.5 1727L146.541 1729.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-10", d: "M391 1169.5L403.5 1034.5L259.5 1022L247 1158L391 1169.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias0", d: "M9 1788L2 1861L179.5 1863.5L194 1729.5H146.5L140.5 1788H9Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-01", d: "M207.5 282.5L193.5 135L340 131L352.5 276.5L207.5 282.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-03", d: "M352.5 276.5L366.5 410L220 418L207.5 282.5L352.5 276.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-05", d: "M366.5 410L379 545.5L233 557.5L220 418L366.5 410Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-04", d: "M160.5 285L173 419.5L25 429L13.5 291L160.5 285Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-06", d: "M173 419.5L180.5 498.5L33.5 507L25 429L173 419.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-07", d: "M180.5 498.5L194 641L47 651L33.5 507L180.5 498.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-09", d: "M194 641L208 789L60.5 801.5L47 651L194 641Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-02", d: "M146.541 135L160.5 285L13.5 291L1.5 137.5L146.541 135Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-08", d: "M392 695.5L404.5 830.5L260 842.5L247 706.5L392 695.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca0", d: "M9 76.5L2 3.5L179.5 1L193.5 135H146.5L140.5 76.5L9 76.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors0h = ref([
    { id: "wc0", d: "M1783 217.344L1863 226L1863.5 98L1783 92V217.344Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias0", d: "M1082 151.5L931.5 137.5V352.5L1061 355.5L1074.5 197L1082 151.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias0", d: "M1729 211.5V259L1074.5 197.5L1082 151.5L1729 211.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca0", d: "M931.5 352.5L802 355.5L788.5 197L781 151.5L843.5 145.5L931.5 137.5V352.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca0", d: "M134.5 212V259L788.5 197.5L781 151.5L134.5 212Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-13", d: "M1582 198L1729 211.5L1733 65.5L1587.5 53L1582 198Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-11", d: "M1587.5 52.5L1454 39L1446 185L1581.5 198L1587.5 52.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-12", d: "M1579 245L1444.5 232.5L1435 380.5L1573 392L1579 245Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-14", d: "M1729 258.959L1579 245L1573 392L1726.5 404L1729 258.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-10", d: "M1169 14.5L1034 2L1021.5 146L1157.5 158.5L1169 14.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias0", d: "M1787.5 396.5L1860.5 403.5L1863 226L1729 211.5V259L1787.5 265V396.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-01", d: "M282 198L134.5 212L130.5 65.5L276 53L282 198Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-03", d: "M276 53L409.5 39L417.5 185.5L282 198L276 53Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-05", d: "M409.5 39L545 26.5L557 172.5L417.5 185.5L409.5 39Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-04", d: "M284.5 245L419 232.5L428.5 380.5L290.5 392L284.5 245Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-06", d: "M419 232.5L498 225L506.5 372L428.5 380.5L419 232.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-07", d: "M498 225L640.5 211.5L650.5 358.5L506.5 372L498 225Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-09", d: "M640.5 211.5L788.5 197.5L801 345L650.5 358.5L640.5 211.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-02", d: "M134.5 258.959L284.5 245L290.5 392L137 404L134.5 258.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-08", d: "M695 13.5L830 1L842 145.5L706 158.5L695 13.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca0", d: "M76 396.5L3 403.5L0.5 226L134.5 212V259L76 265V396.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors1v = ref([
    { id: "ala-ausias1", d: "M259.25 1022.25L267.75 932.25H52.75L49.75 1003.75L259.25 1022.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias1", d: "M193.75 1729.75H146.25L212.75 1018.75L259.25 1022.75L193.75 1729.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-ausias1", d: "M398.12 1109.75L252.25 1097.25L258.946 1022.75L406.25 1036.75L398.12 1109.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf5", d: "M207.25 1582.75L193.75 1729.75L339.75 1733.75L352.25 1588.25L207.25 1582.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-09", d: "M352.75 1588.25L366.25 1454.75L220.25 1446.75L207.25 1582.25L352.75 1588.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf3", d: "M159.75 1579.75L172.75 1445.25L24.75 1435.75L13.25 1573.75L159.75 1579.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf2", d: "M172.75 1445.25L185.25 1309.25L38.75 1300.75L24.75 1435.75L172.75 1445.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf1", d: "M185.25 1309.25L198.75 1166.75L52.25 1156.75L38.75 1300.75L185.25 1309.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-08", d: "M198.75 1166.75L212.75 1018.25L65.75 1005.25L52.25 1156.75L198.75 1166.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf4", d: "M146.291 1729.75L159.25 1579.75L13.25 1573.75L1.25 1727.25L146.291 1729.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sala-multifuncional-2", d: "M366.25 1454.75L385.25 1244.75L239.75 1233.25L220.25 1446.75L366.25 1454.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias1", d: "M8.75 1788.25L1.75 1861.25L179.25 1863.75L193.25 1729.75H146.25L140.25 1788.25H8.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca1", d: "M259.25 842.75L267.75 932.75H52.75L49.75 861.25L259.25 842.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca1", d: "M193.75 135.25H146.25L212.75 846.25L259.25 842.25L193.75 135.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-bosca1", d: "M398.12 755.25L252.25 767.75L258.946 842.25L406.25 828.25L398.12 755.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-01", d: "M207.25 282.25L193.75 135.25L339.75 131.25L352.25 276.75L207.25 282.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-03", d: "M352.75 276.75L366.25 410.25L220.25 418.25L207.25 282.75L352.75 276.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-04", d: "M159.75 285.25L172.75 419.75L24.75 429.25L13.25 291.25L159.75 285.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-06", d: "M185.25 555.75L198.75 698.25L52.25 708.25L38.75 564.25L185.25 555.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-07", d: "M198.75 698.25L212.75 846.75L65.75 859.75L52.25 708.25L198.75 698.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-02", d: "M146.291 135.25L159.25 285.25L13.25 291.25L1.25 137.75L146.291 135.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "biblioteca", d: "M366.25 410.25L385.25 620.25L239.75 631.75L220.25 418.25L366.25 410.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-05", d: "M385.25 620.25L397.75 755.25L252.75 767.25L239.75 631.25L385.25 620.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca1", d: "M8.75 76.75L1.75 3.75L179.25 1.25L193.25 135.25H146.25L140.25 76.75L8.75 76.75Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors1h = ref([
    { id: "ala-ausias1", d: "M1021.5 148L931.5 139.5V354.5L1003 357.5L1021.5 148Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias1", d: "M1729 213.5V261L1018 194.5L1022 148L1729 213.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-ausias1", d: "M1109 9.13043L1096.5 155L1022 148.304L1036 1L1109 9.13043Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf5", d: "M1582 200L1729 213.5L1733 67.5L1587.5 55L1582 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-09", d: "M1587.5 54.5L1454 41L1446 187L1581.5 200L1587.5 54.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf3", d: "M1579 247.5L1444.5 234.5L1435 382.5L1573 394L1579 247.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf2", d: "M1444.5 234.5L1308.5 222L1300 368.5L1435 382.5L1444.5 234.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf1", d: "M1308.5 222L1166 208.5L1156 355L1300 368.5L1308.5 222Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-08", d: "M1166 208.5L1017.5 194.5L1004.5 341.5L1156 355L1166 208.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf4", d: "M1729 260.959L1579 248L1573 394L1726.5 406L1729 260.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sala-multifuncional-2", d: "M1454 41L1244 22L1232.5 167.5L1446 187L1454 41Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias1", d: "M1787.5 398.5L1860.5 405.5L1863 228L1729 214V261L1787.5 267V398.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca1", d: "M842 148L932 139.5V354.5L860.5 357.5L842 148Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca1", d: "M134.5 213.5V261L845.5 194.5L841.5 148L134.5 213.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-bosca1", d: "M754.5 9.13043L767 155L841.5 148.304L827.5 1L754.5 9.13043Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-01", d: "M281.5 200L134.5 213.5L130.5 67.5L276 55L281.5 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-03", d: "M276 54.5L409.5 41L417.5 187L282 200L276 54.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-04", d: "M284.5 247.5L419 234.5L428.5 382.5L290.5 394L284.5 247.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-06", d: "M555 222L697.5 208.5L707.5 355L563.5 368.5L555 222Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-07", d: "M697.5 208.5L846 194.5L859 341.5L707.5 355L697.5 208.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-02", d: "M134.5 260.959L284.5 248L290.5 394L137 406L134.5 260.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "biblioteca", d: "M409.5 41L619.5 22L631 167.5L417.5 187L409.5 41Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-05", d: "M619.5 22L754.5 9.5L766.5 154.5L630.5 167.5L619.5 22Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca1", d: "M76 398.5L3 405.5L0.5 228L134.5 214V261L76 267V398.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors2v = ref([
    { id: "lavabo-homes2", d: "M187.25 1784.25L178.75 1864.25L306.75 1864.75L312.75 1784.25H187.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias2", d: "M258.75 1022.75L267.25 932.75L52.25 932.75L49.25 1004.25L258.75 1022.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-fisica-2", d: "M189.25 1264.25L38.75 1253.25L52.75 1079.25L205.25 1092.25L189.25 1264.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-quimica-2", d: "M172.25 1445.75L24.75 1436.25L38.75 1253.25L189.25 1264.25L172.25 1445.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias2", d: "M193.25 1730.25H145.75L212.25 1018.75L258.75 1022.75L193.25 1730.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-inf6", d: "M206.75 1582.75L193.25 1730.25L339.25 1734.25L351.75 1588.75L206.75 1582.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-09", d: "M351.75 1588.75L365.75 1455.25L219.25 1447.75L206.75 1582.75L351.75 1588.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-10", d: "M159.75 1580.25L172.25 1445.75L24.75 1436.25L12.75 1574.25L159.75 1580.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-11", d: "M145.791 1730.25L159.75 1580.25L12.75 1574.25L0.75 1727.75L145.791 1730.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-08", d: "M365.75 1455.25L378.75 1314.75L232.25 1307.25L219.25 1447.75L365.75 1455.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-07", d: "M390.75 1183.25L402.75 1032.92L258.811 1023.25L245.25 1170.25L390.75 1183.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias2", d: "M8.25 1788.75L1.25 1861.75L178.75 1864.25L192.75 1730.25H145.75L139.75 1788.75H8.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "wc2", d: "M187.25 81.7501L178.75 1.75006L306.75 1.25006L312.75 81.7501L187.25 81.7501Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca2", d: "M258.75 843.25L267.25 933.25L52.25 933.25L49.25 861.75L258.75 843.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-quimica-1", d: "M189.25 601.75L38.75 612.75L52.75 786.75L205.25 773.75L189.25 601.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-fisica-1", d: "M172.25 420.75L24.75 429.75L38.75 612.75L189.25 601.75L180.75 511.25L172.25 420.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca2", d: "M193.25 135.75H145.75L212.25 847.25L258.75 843.25L193.25 135.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-01", d: "M206.75 283.25L193.25 135.75L339.25 131.75L351.75 277.25L206.75 283.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-03", d: "M351.75 277.25L365.75 410.75L219.25 418.25L206.75 283.25L351.75 277.25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-04", d: "M159.75 285.75L172.25 420.25L24.75 429.75L12.75 291.75L159.75 285.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-02", d: "M145.791 135.75L159.75 285.75L12.75 291.75L0.75 138.25L145.791 135.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-05", d: "M365.75 410.75L378.25 545.75L232.25 558.75L219.25 418.25L365.75 410.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-06", d: "M390.75 682.75L402.75 833.081L258.811 842.75L245.25 695.75L390.75 682.75Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca2", d: "M8.25 77.2501L1.25 4.25006L178.75 1.75006L192.75 135.75L145.75 135.75L139.75 77.2501L8.25 77.2501Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors2h = ref([
    { id: "lavabo-homes2", d: "M1784 216.5L1864 225L1864.5 97L1784 91V216.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias2", d: "M1022.5 145L932.5 136.5V351.5L1004 354.5L1022.5 145Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratorio-fisica-2", d: "M1264 214.5L1253 365L1079 351L1092 198.5L1264 214.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratorio-quimica-2", d: "M1445.5 231.5L1436 379L1253 365L1264 214.5L1445.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias2", d: "M1730 210.5V258L1018.5 191.5L1022.5 145L1730 210.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-inf7", d: "M1582.5 197L1730 210.5L1734 64.5L1588.5 52L1582.5 197Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-09", d: "M1588.5 52L1455 38L1447.5 184.5L1582.5 197L1588.5 52Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-10", d: "M1580 244L1445.5 231.5L1436 379L1574 391L1580 244Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-11", d: "M1730 257.959L1580 244L1574 391L1727.5 403L1730 257.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-08", d: "M1455 38L1314.5 25L1307 171.5L1447.5 184.5L1455 38Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-07", d: "M1183 13L1032.67 1L1023 144.939L1170 158.5L1183 13Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias2", d: "M1788.5 395.5L1861.5 402.5L1864 225L1730 211V258L1788.5 264V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    // { id: "wc2", d: "M81.5 216.5L1.5 225L1 97L81.5 91V216.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca2", d: "M843 145L933 136.5V351.5L861.5 354.5L843 145Z", color: "white", hasAlerts: false, alerts: [] },
    // { id: "dept-socials", d: "M135.5 211L81.5 216.5V155.5L134 150.5L135.5 211Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-quimica-1", d: "M601.5 214.5L612.5 365L786.5 351L773.5 198.5L601.5 214.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-fisica-1", d: "M420.5 231.5L429.5 379L612.5 365L601.5 214.5L511 223L420.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca2", d: "M135.5 210.5V258L847 191.5L843 145L135.5 210.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-01", d: "M283 197L135.5 210.5L131.5 64.5L277 52L283 197Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-03", d: "M277 52L410.5 38L418 184.5L283 197L277 52Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-02", d: "M135.5 257.959L285.5 244L291.5 391L138 403L135.5 257.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-05", d: "M410.5 38L545.5 25.5L558.5 171.5L418 184.5L410.5 38Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-06", d: "M682.5 13L832.831 1L842.5 144.939L695.5 158.5L682.5 13Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca2", d: "M77 395.5L4 402.5L1.5 225L135.5 211V258L77 264V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-04", d: "M285.5 244L420 231.5L429.5 379L291.5 391L285.5 244Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors3v = ref([
    { id: "lavabo-alumnat", d: "M201.5 81L195 0.5H322.5L328.5 81H201.5Z", color: "white" },
    { id: "lavabo-dones", d: "M195.5 1783L187 1863L315 1863.5L321 1783H195.5Z", color: "white" },
    { id: "ala-ausias", d: "M267 1021.5L275.5 931.5H60.5L57.5 1003L267 1021.5Z", color: "white" },
    { id: "ala-bosca", d: "M267.5 844L275.5 931H60.5V859.5L267.5 844Z", color: "white" },
    { id: "dept-catala", d: "M154 1729L1 1724L12 1616L163.5 1621.5L154 1729Z", color: "white" },
    { id: "dept-matematiques", d: "M177.5 1479L27 1472.5L40.5 1328.5L191.5 1337L177.5 1479Z", color: "white" },
    { id: "p3-inf9", d: "M194.5 1300L44 1291L55 1148.5L208 1159L194.5 1300Z", color: "white" },
    { id: "pasillo-ausias", d: "M201.5 1729H154L220.5 1018L267 1022L201.5 1729Z", color: "white" },
    { id: "p3-inf7", d: "M208 1159L55 1148.5L66.5 1004L220.5 1018L208 1159Z", color: "white" },
    { id: "p3-08", d: "M209.5 704.5L60.5 715.5L68 858.5L222 847L209.5 704.5Z", color: "white" },
    { id: "p3-06", d: "M194.5 528.5L43 536L60.5 715.5L209.5 704.5L194.5 528.5Z", color: "white" },
    { id: "p3-04", d: "M182.5 385.5L31 391L43 536L194.5 528.5L182.5 385.5Z", color: "white" },
    { id: "lab-ciencies-naturals", d: "M170 242L19 247L31 391L182.5 385.5L170 242Z", color: "white" },
    { id: "dept-ciencies-naturals", d: "M161 139L9.5 143L19 247L170 242L161 139Z", color: "white" },
    { id: "pasillo-bosca", d: "M208 137.5L161 139L222 847.5L267.5 844L208 137.5Z", color: "white" },
    { id: "p3-01", d: "M354.5 133.5L208 137.5L220 277.5L368 268.5L354.5 133.5Z", color: "white" },
    { id: "p3-02", d: "M368 268.5L220 277.5L232 421L378.5 412.5L368 268.5Z", color: "white" },
    { id: "p3-03", d: "M378.5 412.5L232 421L244 562L390 554.5L378.5 412.5Z", color: "white" },
    { id: "p3-05", d: "M390 554.5L244 562L256 703.5L400 695L390 554.5Z", color: "white" },
    { id: "p3-07", d: "M400 695L256 703.5L267.5 843.5L412.5 832.5L400 695Z", color: "white" },
    { id: "lab-ciencies-naturals-2", d: "M163.5 1621.5L12 1616L27 1472.5L177.5 1479L163.5 1621.5Z", color: "white" },
    { id: "p3-inf11", d: "M214 1581.5L201.5 1729L347.5 1733L360 1587.5L214 1581.5Z", color: "white" },
    { id: "p3-inf10", d: "M360.5 1587.5L374 1454L227 1446.5L214 1581.5L360.5 1587.5Z", color: "white" },
    { id: "dept-ll-estrangeres", d: "M374.5 1453.5L387 1313.5L240 1306L227 1446L374.5 1453.5Z", color: "white" },
    { id: "dept-tecnologia", d: "M387.5 1313.5L393 1244L247 1233.5L240 1306L387.5 1313.5Z", color: "white" },
    { id: "p3-inf3", d: "M393 1244L410.5 1035.5L267 1022L247 1233.5L393 1244Z", color: "white" },
    { id: "fin-ala-bosca", d: "M24 76.5L17 3.5L194.5 1L208 137L161 139L155.5 76.5H24Z", color: "white" },
    { id: "fin-ala-ausias", d: "M16.5 1787.5L9.5 1860.5L187 1863L201 1729H154L148 1787.5H16.5Z", color: "white" },
]);
const sectors3h = ref([
    { id: "lavabo-alumnat", d: "M81 212.5L0.5 219V91.5L81 85.5V212.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lavabo-dones", d: "M1783 218.5L1863 227L1863.5 99L1783 93V218.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias", d: "M1021.5 147L931.5 138.5V353.5L1003 356.5L1021.5 147Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca", d: "M844 146.5L931 138.5V353.5H859.5L844 146.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-catala", d: "M1729 260L1724 413L1616 402L1621.5 250.5L1729 260Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-matematiques", d: "M1479 236.5L1472.5 387L1328.5 373.5L1337 222.5L1479 236.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf9", d: "M1300 219.5L1291 370L1148.5 359L1159 206L1300 219.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias", d: "M1729 212.5V260L1018 193.5L1022 147L1729 212.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf7", d: "M1159 206L1148.5 359L1004 347.5L1018 193.5L1159 206Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-08", d: "M704.5 204.5L715.5 353.5L858.5 346L847 192L704.5 204.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-06", d: "M528.5 219.5L536 371L715.5 353.5L704.5 204.5L528.5 219.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-04", d: "M385.5 231.5L391 383L536 371L528.5 219.5L385.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lab-ciencies-naturals", d: "M242 244L247 395L391 383L385.5 231.5L242 244Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-ciencies-naturals", d: "M139 253L143 404.5L247 395L242 244L139 253Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca", d: "M137.5 206L139 253L847.5 192L844 146.5L137.5 206Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-01", d: "M133.5 59.5L137.5 206L277.5 194L268.5 46L133.5 59.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-02", d: "M268.5 46L277.5 194L421 182L412.5 35.5L268.5 46Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-03", d: "M412.5 35.5L421 182L562 170L554.5 24L412.5 35.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-05", d: "M554.5 24L562 170L703.5 158L695 14L554.5 24Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-07", d: "M695 14L703.5 158L843.5 146.5L832.5 1.5L695 14Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lab-ciencies-naturals-2", d: "M1621.5 250.5L1616 402L1472.5 387L1479 236.5L1621.5 250.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf11", d: "M1581.5 200L1729 212.5L1733 66.5L1587.5 54L1581.5 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf10", d: "M1587.5 53.5L1454 40L1446.5 187L1581.5 200L1587.5 53.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-ll-estrangeres", d: "M1453.5 39.5L1313.5 27L1306 174L1446 187L1453.5 39.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-tecnologia", d: "M1313.5 26.5L1244 21L1233.5 167L1306 174L1313.5 26.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf3", d: "M1244 21L1035.5 3.5L1022 147L1233.5 167L1244 21Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca", d: "M76.5 390L3.5 397L1 219.5L137 206L139 253L76.5 258.5V390Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias", d: "M1787.5 397.5L1860.5 404.5L1863 227L1729 213V260L1787.5 266V397.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const arraySectores = [exteriorh, sectors0v, sectors0h, sectors1v, sectors1h, sectors2v, sectors2h, sectors3v, sectors3h];

function toggleSectorColor(index, sectores) {
    sectores.forEach((sector, i) => {
        if (sectores[index].id != "edifici") {
            sector.color = i === index ? "red" : "white";
            sectorInput.value = sectores[index].id;
        } else {
            edificiActive.value = true;
            sectorInput.value = null;
        }
        sectorName.value = formatText(sectorInput.value);
    });
}

import { enviarAlerta, updateAlert } from '../services/communictationManager';
async function enviar() {
    const cuerpo = {
        alumno_id: alumno_id,
        sectorName: sectorInput.value,
        descripcion: alertaDescripcio.value,
    }
    const response = await enviarAlerta(cuerpo);

    alerta.value = await response;
    console.log(alerta.value.id);
    alertaEnviada.value = !alertaEnviada.value;
}

async function editarAlerta() {
    try {
        const cuerpo = {
            alerta_id: alerta.value.id,
            alumne_id: alumno_id,
            descripcio: alertaDescripcio.value,
        }
        const response = await updateAlert(cuerpo);

        const result = await response;
        if (result.success) {
            alertaEnviada.value = !alertaEnviada.value;
            alertaEditada.value = true;
        } else {
            alert(`Ha ocorregut un error (${result.message || 'Error desconegut'})`)
        }
    } catch (error) {
        console.error(error);
    }
}

function tornarInici() {
    alertaEditada.value = !alertaEditada.value;
    sosAlert();
}

onMounted(() => {
    startWordRotation();
});
</script>

<style scoped>
.contain-sos {
    height: 90vh;
}

.sos-heading {
    text-align: center;
    font-size: 1.8rem;
    font-weight: normal;
    color: #333;
    line-height: 1.4;
    margin-bottom: 1rem;
}

.static-text {
    font-weight: bold;
    color: #000;
}

.dynamic-text {
    font-weight: bold;
    transition: all 0.5s ease-in-out;
    /* Animación para un cambio suave */
}

.action {
    color: #ff4b5c;
    font-weight: bold;
    opacity: 0.9;
}

.mobile-view {
    display: block;
}

.desktop-view {
    display: none;
}

@media (min-width: 1090px) {
    .mobile-view {
        display: none;
    }

    .desktop-view {
        display: block;
    }

    .planoContainer div {
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #containButtons {
        width: 30%;
    }
}

#containButtons {
    position: fixed;
    bottom: 80px;
    left: 0;
    right: 0;
    margin: auto;
    /* width: 50%; */
}

.btn-sos {
    height: 250px;
    width: 250px;
    border-radius: 250px;
    background: #ff4b45;
    box-shadow: -5px -5px 9px rgba(255, 114, 114, 0.45), 5px 5px 9px rgba(255, 25, 25, 0.438);

    border: none;
    /* position: absolute;
    top: 0;
    bottom: 70px;
    left: 0;
    right: 0;
    margin: auto; */
    font-family: "Outfit", serif;
    font-size: 60px;
    color: white;
}

.btn-sos:hover {
    background: linear-gradient(145deg, #e6443e, #ff504a);
}

select {
    border: 0;
    background: none;
    outline: none;
}

select:focus {
    outline: none;
}

.container-planta {
    border: 1px solid grey;
    background-color: white;
    border-radius: 10px;
    padding: 10px 5px;
    font-size: 16px;
}

.sectorInput {
    position: fixed;
    top: 55px;
    left: 0;
    right: 0;
    margin: auto;
    width: 200px;
    text-align: center;
    text-transform: uppercase;
    border: 1px solid grey;
    border-radius: 10px;
    padding: 10px 5px;
}

.planoContainer {
    padding-bottom: 70px;
    margin: 100px 0 60px 0;
    border: 1px solid black;
    height: 78vh;
    overflow-y: auto;
}

.planoContainer div {
    display: flex;
    justify-content: center;
    align-items: center;
}

.plantaSelector {
    position: fixed;
    top: 8px;
    left: 0;
    right: 0;
    margin: auto;
}

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
}

.textarea-info {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
    margin-bottom: 20px;
}

.popup-button {
    background: #ff4b45;
    box-shadow: -5px -5px 9px rgba(255, 114, 114, 0.45), 5px 5px 9px rgba(255, 25, 25, 0.438);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pop .popup-button:hover {
    background-color: #0056b3;
}
</style>