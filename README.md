# ATURAPP - Lluita contra l'assetjament

**ATURAPP** és una aplicació dissenyada per combatre l'assetjament escolar en temps real dins de l'entorn educatiu. El seu objectiu principal és oferir una eina efectiva i discreta que permeti als alumnes informar d'incidents d'assetjament de manera immediata, així com proporcionar un espai per informar de casos recurrents o d'assetjament psicològic a través d'un xat en temps real.  

## 📋 Característiques principals  

- **Sistema d'alertes en temps real**:  
  Els usuaris poden reportar casos d'assetjament amb un parell de clics mitjançant un botó SOS.  

- **Xat en temps real**:  
  L'aplicació inclou un xat que permet als usuaris informar de casos freqüents o situacions d'assetjament psicològic, fomentant una comunicació constant amb els responsables.

- **Mapes interactius i personalitzats**:  
  Representació visual de l'institut amb zones identificables mitjançant un mapa SVG, acompanyat d'imatges representatives de cada àrea per facilitar la confirmació del lloc de l'incident.  

- **Mapa de calor**:  
  Visualització de les alertes en un mapa de calor que permet identificar les zones amb més incidència d'assetjament, utilitzant una escala de colors que va de vermell clar a vermell intens.  

- **Estadístiques rellevants**:  
  Dades i informes sobre els incidents reportats per ajudar les autoritats escolars a prendre decisions informades i desenvolupar estratègies preventives.  


## 🧑‍🤝‍🧑 Integrants

- Benjamín Romero Doren
- Arnau Barrero Sorribas
- Marc Ciurans Cartagena
- Agustín Enzo Noviello


## 🔗 Annexos

- [**Taiga**](https://tree.taiga.io/project/arnaubarrerosorribas-aturapp/timeline)
- [**Penpot**](https://design.penpot.app/#/view/a0a8e792-b2d2-818e-8005-5cd55650721d?page-id=a0a8e792-b2d2-818e-8005-5cd55650721e&section=interactions&index=0&share-id=a0a8e792-b2d2-818e-8005-5d01c5325112)
- [**Pàgina web**](http://aturapp.daw.inspedralbes.cat)


**Estat**: En procès 🕧


## 🚀 Pas a pas per integrar-se al projecte  

Si ets un nou membre de l'equip, segueix aquests passos per configurar l'entorn de desenvolupament amb Docker i començar a treballar en el projecte.  

### 1️⃣ Clona el repositori  
Primer, clona aquest repositori al teu ordinador:  

```bash
git clone https://github.com/inspedralbes/tr2-24-25-aturapp.git aturapp
cd aturapp
```

### 2️⃣ Instal·la Docker  
Assegura't de tenir Docker i Docker Compose instal·lats al teu ordinador. Si no els tens instal·lats, pots fer-ho des dels següents enllaços:  
- [Descarrega Docker](https://www.docker.com/products/docker-desktop)  
- [Guia per instal·lar Docker Compose](https://docs.docker.com/compose/install/)

### 3️⃣ Crea el fitxer `.env`  
Copia el fitxer d'exemple `.env.example` i crea el fitxer `.env`:  

```bash
cp .env.example .env
```
Edita el fitxer .env per personalitzar la configuració segons sigui necessari (per exemple, credencials de la base de dades).

### 4️⃣ Inicia els contenidors
```bash
docker compose up --build
```

### 5️⃣  Accedeix al projecte
El backend estarà accessible a: http://localhost:8000
El frontend (si està configurat) estarà accessible a: http://localhost
