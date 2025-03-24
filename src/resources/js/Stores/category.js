import { defineStore } from 'pinia';
import axios from 'axios';

export const useCategoryStore = defineStore('category', {
    state: () => ({
        categories: [],
        currentCategory: null,
        errors: {},
    }),
    actions: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        async createCategory(data) {
            try {
                const response = await axios.post('/api/categories', data);
                this.categories.push(response.data);
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        async updateCategory(id, data) {
            try {
                const response = await axios.put(`/api/categories/${id}`, data);
                const index = this.categories.findIndex(c => c.id === id);
                if (index !== -1) this.categories[index] = response.data;
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        async deleteCategory(id) {
            try {
                await axios.delete(`/api/categories/${id}`);
                this.categories = this.categories.filter(c => c.id !== id);
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        async fetchCategory(id) {
            try {
                const response = await axios.get(`/api/categories/${id}`);
                this.currentCategory = response.data;
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
    },
});