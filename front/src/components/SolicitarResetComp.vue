<template>
    <div class="container">
        <div class="d-flex f-column align-center j-center">
            <h2 class="no-margin">Sol·liciteu restabliment de contrasenya</h2>
            <input v-model="email" type="email" placeholder="Introduce tu correo" />
            <button @click="sendRequest">Enviar sol·licitud</button>
            <p v-if="message">{{ message }}</p>
        </div>
    </div>
</template>

<script>
    import { sendPasswordResetEmail } from '../services/communictationManager';

    export default {
        data() {
            return {
                email: '',
                message: null,
            };
        },
        methods: {
            async sendRequest() {
                try {
                    const data = await sendPasswordResetEmail(this.email);
                    this.message = data.message;
                } catch (error) {
                    this.message = error.message || 'Hubo un error al enviar el correo.';
                }
            },
        },
    };
</script>

<style scoped>
* {
    transition: 0.3s;
    font-family: Arial, Helvetica, sans-serif;
}

.container {
    width: 100%;
    height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container div {
    width: 300px;
    padding: 20px 30px;
    text-align: center;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.container div h2{
    margin-bottom: 15px;
}

input {
    outline: 0;
    width: 100%;
    padding: 10px;
    display: block;
    margin-bottom: 10px;
    border: 1px solid #ccc;
}

input:focus {
    border: 1px solid red;
}

button {
    background-color: #ff0000;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #b30000;
}

p {
    color: green;
    margin-top: 10px;
}
</style>