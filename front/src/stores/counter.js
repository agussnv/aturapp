import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    userData: null,
    Iniciado: false,
  }),
  actions: {
    setUserData(data) {
      this.userData = data;
      this.Iniciado = true;
    },
    clearUserData() {
      this.userData = null;
      this.Iniciado = false;
    },
  },
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'counter',
        storage: localStorage,
      },
    ],
  },
});