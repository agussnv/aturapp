<template>
    <div>
        <h2>Restablir la contrasenya</h2>
        <form @submit.prevent="resetPassword">
            <input v-model="password" type="password" placeholder="Nueva Contraseña" />
            <input v-model="password_confirmation" type="password" placeholder="Confirmar Contraseña" />
            <button type="submit">Restablir contrasenya</button>
            <p v-if="error">{{ error }}</p>
        </form>
    </div>
</template>

<script>
import { resetPassword } from '../services/communictationManager';

export default {
    data() {
        return {
            password: '',
            password_confirmation: '',
            error: null,
            token: this.$route.params.token,
        };
    },
    mounted() {
        console.log('Token desde la URL:', this.token);
    },
    methods: {
        async resetPassword() {
            if (!this.token) {
                this.error = 'No se ha encontrado un token válido.';
                return;
            }

            if (this.password !== this.password_confirmation) {
                this.error = 'Las contraseñas no coinciden.';
                return;
            }

            try {
                await resetPassword(this.token, this.password, this.password_confirmation);
                this.error = null;
                this.$router.push('/login');
            } catch (error) {
                this.error = error.message || 'Hubo un error al restablecer la contraseña.';
            }
        },
    },
};
</script>

<style scoped>
form {
    display: flex;
    flex-direction: column;
}

button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

input {
    margin-bottom: 10px;
}
</style>
