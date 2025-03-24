import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: null,
    }),
    actions: {
        setToken(token) {
            this.token = token;
            localStorage.setItem('auth_token', token); // Persist token
        },
        loadToken() {
            this.token = localStorage.getItem('auth_token');
        },
        clearToken() {
            this.token = null;
            localStorage.removeItem('auth_token');
        },
    },
});