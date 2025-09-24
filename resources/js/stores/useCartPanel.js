// /js/stores/useCartPanel.js
import { defineStore } from 'pinia';

export const useCartPanel = defineStore('cartPanel', {
    state: () => ({
        isOpen: false,
    }),
    actions: {
        open() {
            this.isOpen = true;

        },
        close() {
            this.isOpen = false;
        },
        toggle() {
            this.isOpen = !this.isOpen;
        },
    },
});