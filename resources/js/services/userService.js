// resources/js/services/api.js
import axios from "axios";

const api = axios.create({
    baseURL: import.meta.env.VITE_API_BACKEND,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

// ✅ Request interceptor → agrega el token a cada request
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("auth_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// ✅ Response interceptor → maneja errores globales
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Token inválido o expirado
            console.warn("Token expirado o inválido, redirigiendo a login...");
            localStorage.removeItem("auth_token");
            // Aquí podrías usar un router push:
            // router.push("/login");
        }

        return Promise.reject(error);
    }
);

export default api;
