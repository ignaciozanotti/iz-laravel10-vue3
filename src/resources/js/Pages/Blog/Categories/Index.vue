<template>
    <Head title="Categories" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <Link href="/blog/categories/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">Create New Category</Link>
              <ul class="space-y-2">
                <li v-for="category in categories" :key="category.id" class="flex items-center justify-between bg-gray-100 p-2 rounded">
                  <span class="text-gray-700">{{ category.name }}</span>
                  <div class="space-x-2">
                    <Link :href="'/blog/categories/' + category.id + '/edit'" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</Link>
                    <button @click="deleteCategory(category.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Link, Head } from '@inertiajs/vue3';
  import { useCategoryStore } from '@/Stores/category';
  import { onMounted, computed } from 'vue';
  
  export default {
    components: { AuthenticatedLayout, Link, Head },
    setup() {
      const categoryStore = useCategoryStore();
  
      onMounted(() => {
        categoryStore.fetchCategories();
      });
  
      const categories = computed(() => categoryStore.categories);
  
      return {
        categories,
        deleteCategory: categoryStore.deleteCategory,
      };
    },
  };
  </script>