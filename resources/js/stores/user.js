// js/stores/user.js
import { defineStore } from 'pinia';
import api from "@/js/services/api";
export const useUserStore = defineStore('user', {
    state: () => ({
        token: localStorage.getItem('token') || null,
        // refreshToken: localStorage.getItem("refreshToken") || null,
        user: JSON.parse(localStorage.getItem('user')) || null,
    }),

    getters: {
        isAuthenticate: (state) => !!state.token,
    },

    actions: {
        async register(data) {
            try {
                // console.log(data);
                const res = await api.post("/cliente/store", data); // tu endpoint real de registro
                return res.data; // puede devolver mensaje de éxito
            } catch (error) {
                console.log(error);
                throw error.response?.data?.message || "Error al registrar usuario";
            }
        },
        async login(credentials) {
            try {
                console.log(credentials)
                const { data } = await api.post("/cliente/authenticate", credentials);
                // this.setSession(data.access_token, data.refresh_token, data.user);
                this.setSession(data.access_token, data.user);
                console.log(data);
                return true; // ✅ login correcto
            } catch (error) {
                throw error.response?.data?.message || "Credenciales inválidas";
            }
        },
        // setSession(token, refreshToken, user) {
        //     this.token = token;
        //     this.refreshToken = refreshToken;
        //     this.user = user;
        //     localStorage.setItem("token", token);
        //     localStorage.setItem("refreshToken", refreshToken);
        //     localStorage.setItem("user", JSON.stringify(user));
        // },

        setSession(token, user) {
            this.token = token;
            this.user = user;
            localStorage.setItem("token", token);
            localStorage.setItem("user", JSON.stringify(user));
        },

        getUserFromStorage() {
            return JSON.parse(localStorage.getItem('user')) || null;
        },

        async fetchUser() {
            try {
                const { data } = await api.get("/user", {
                    headers: { Authorization: `Bearer ${this.token}` },
                });
                this.user = data;
                localStorage.setItem("user", JSON.stringify(data));
            } catch (error) {
                // await this.refreshTokenFn();
                // this.logout();
            }
        },

        // async refreshTokenFn() {
        //     try {
        //         const { data } = await api.post("https://externo.com/refresh", {
        //             refresh_token: this.refreshToken,
        //         });

        //         this.token = data.access_token;
        //         localStorage.setItem("token", data.access_token);

        //         // Si backend manda refresh nuevo
        //         if (data.refresh_token) {
        //             this.refreshToken = data.refresh_token;
        //             localStorage.setItem("refreshToken", data.refresh_token);
        //         }
        //     } catch (error) {
        //         this.logout();
        //     }
        // },

        logout() {
            this.token = null;
            // this.refreshToken = null;
            this.user = null;
            localStorage.removeItem("token");
            // localStorage.removeItem("refreshToken");
            localStorage.removeItem("user");
        },
    },
});
