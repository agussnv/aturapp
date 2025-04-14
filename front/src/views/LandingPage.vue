<script setup>
    import { ref } from 'vue';

    const isMenuVisible = ref(false);

    const showMenu = () => { isMenuVisible.value = true; };
    const hideMenu = () => { isMenuVisible.value = false; };
</script>

<template>
    <div>
    <nav class="desktop-menu">
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Acerca de</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </nav>

    <div 
        id="botonMenu" 
        @click="showMenu" 
        :class="{ hidden: isMenuVisible }" 
        class="menu-button">
        <div id="lineaMenu"></div>
        <div id="lineaMenu"></div>
        <div id="lineaMenu"></div>
    </div>


    <div 
        id="menuLateral" 
        :class="{ 'visible': isMenuVisible }" 
        class="menu">
        <div id="cerrarMenu" @click="hideMenu" class="close-button">X</div>
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Acerca de</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
        </div>
    </div>
</template>

<style scoped>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .hidden {
        display: none;
    }

    .desktop-menu { 
        display: none; 
    }

    .desktop-menu ul {
    gap: 30px;
    display: flex;
    background-color: #ffffff;
    }

    .desktop-menu a {
    color: rgb(0, 0, 0);
    font-size: 25px;
    }

    .desktop-menu a:hover {
        color: rgb(137, 0, 0);
    }

    .menu-button {
        position: absolute;
        cursor: pointer;
        margin: 20px;
        z-index: 1;
        right: 0;
    }
    #lineaMenu{
        height: 5px;
        width: 40px;
        margin-top: 3px;
        background: black;
    }

    .menu {
        top: 0;
        right: -100%;
        height: 100%;
        width: 250px;
        display: flex;
        padding: 20px;
        position: fixed;
        flex-direction: column;
        transition: right 0.3s ease-in-out;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
    }

    .menu.visible { right: 0; }

    .close-button {
        margin: 20px;
        color: red;
        cursor: pointer;
        font-size: 20px;
        text-align: right;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    li { margin-bottom: 15px; }

    a {
        font-size: 20px;
        color: rgb(0, 0, 0);
        text-decoration: none;
    }

    a:hover {}

    @media (min-width: 768px) {
        .menu-button {
            display: none;
        }

        .menu {
            display: none;
        }

        .desktop-menu {
            display: block;
        }
    }
</style>