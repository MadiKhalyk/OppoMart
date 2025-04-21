import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [],
    }),

    getters: {
        total: (state) => state.items.reduce((sum, item) => sum + item.price * item.quantity, 0),
        count: (state) => state.items.length,
    },

    actions: {
        add(item) {
            console.log('Item added:', item);
            const existing = this.items.find(p => p.id === item.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                this.items.push({ ...item, quantity: 1 });
            }
        },

        remove(itemId) {
            this.items = this.items.filter(p => p.id !== itemId);
        },

        clear() {
            this.items = [];
        },

        increase(itemId) {
            const item = this.items.find(p => p.id === itemId);
            if (item) {
                item.quantity += 1;
            }
        },

        decrease(itemId) {
            const item = this.items.find(p => p.id === itemId);
            if (item) {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                } else {
                    this.remove(itemId);
                }
            }
        },
    },
    persist: {
        storage: sessionStorage,
    },
});
