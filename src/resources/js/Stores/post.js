import { defineStore } from 'pinia';
import axios from 'axios';

export const usePostStore = defineStore('post', {
    state: () => ({
        posts: [],          // Array to hold all posts
        currentPost: null,  // Object to hold the currently selected post
        errors: {},         // Object to hold validation errors from API
    }),
    actions: {
        // Fetch all posts with their associated category
        async fetchPosts() {
            try {
                const response = await axios.get('/api/posts');
                this.posts = response.data;
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        // Create a new post
        async createPost(data) {
            try {
                const response = await axios.post('/api/posts', data);
                this.posts.push(response.data);
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        // Update an existing post
        async updatePost(id, data) {
            try {
                const response = await axios.put(`/api/posts/${id}`, data);
                const index = this.posts.findIndex(p => p.id === id);
                if (index !== -1) this.posts[index] = response.data;
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        // Delete a post
        async deletePost(id) {
            try {
                await axios.delete(`/api/posts/${id}`);
                this.posts = this.posts.filter(p => p.id !== id);
                this.errors = {};
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
        },
        // Fetch a single post by ID
        async fetchPost(id) {
            try {
              const response = await axios.get(`/api/posts/${id}`);
              this.currentPost = response.data;
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            }
          },
    },
});