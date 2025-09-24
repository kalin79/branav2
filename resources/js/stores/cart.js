import { defineStore } from 'pinia'

const STORAGE_KEY = 'cart_data'

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: JSON.parse(localStorage.getItem(STORAGE_KEY)) || [],
        checkoutForm: JSON.parse(localStorage.getItem('checkout_data')) || {},
        boolCodigoDescuento: false, // 👈 bandera para saber si aplica descuento
    }),

    getters: {
        getQuantity: (state) => (productId) => {
            const item = state.items.find(i => i.id === productId)
            return item ? item.quantity : 0
        },
        totalItems(state) {
            return state.items.reduce((total, item) => total + item.quantity, 0)
        },
        totalPrice(state) {
            if (!state.boolCodigoDescuento) {
                return state.items.reduce((total, item) => {
                    let precio = Number(item.precio_actual) || 0
                    let cantidad = Number(item.quantity) || 0
                    let _total = precio * cantidad
                    let _descuento = 10
                    if (item.id === 1) {
                        // aplica descuento del 10%
                        _total = _total - ((_total * _descuento) / 100)
                    }
                    return total + _total
                }, 0)
            }
            else {
                // ✅ lógica normal (sin descuento)
                return state.items.reduce((total, item) => {
                    return total + (Number(item.precio_actual) || 0) * (Number(item.quantity) || 0)
                }, 0)
            }
        }
    },

    actions: {
        saveToStorage() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(this.items))
        },

        addToCart(product) {
            // console.log(product)
            const existing = this.items.find(i => i.id === product.id)
            if (existing) {
                existing.quantity += 1
            } else {
                this.items.push({ ...product, quantity: 1 })
            }
            this.saveToStorage()
        },

        removeFromCart(productId) {
            this.items = this.items.filter(i => i.id !== productId)
            this.saveToStorage()
        },

        updateQuantity(productId, quantity) {
            const item = this.items.find(i => i.id === productId)
            if (item) {
                item.quantity = quantity
                this.saveToStorage()
            }
        },

        clearCart() {
            this.items = []
            this.saveToStorage()
        },

        increaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId)
            if (item) {
                item.quantity += 1
                this.saveToStorage?.()  // Si manejas localStorage manualmente
            }
        },

        // ✅ Acciones para manejar el código de descuento
        activarDescuento() {
            this.boolCodigoDescuento = true
        },

        desactivarDescuento() {
            this.boolCodigoDescuento = false
        },


        // Disminuir cantidad
        decreaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId)
            if (item && item.quantity > 1) {
                item.quantity -= 1
            } else if (item && item.quantity === 1) {
                this.removeFromCart(productId)
            }
        },

        // Nuevo método: actualizar datos del checkout
        setCheckoutForm(payload) {
            this.checkoutForm = payload;
            localStorage.setItem('checkout_data', JSON.stringify(payload));
        },
        clearCheckoutForm() {
            this.checkoutForm = {};
            localStorage.removeItem('checkout_data');
        }
    }
})
