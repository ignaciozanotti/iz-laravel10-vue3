<template>
    <Head title="Create Category" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Category</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <form @submit.prevent="createCategory" class="space-y-4">
                <div>
                  <input
                    v-model="form.name"
                    placeholder="Category Name"
                    class="w-full p-2 border rounded"
                  />
                  <span v-if="store.errors.name" class="text-red-500 text-sm">
                    {{ store.errors.name[0] }}
                  </span>
                </div>
                <button
                  type="submit"
                  class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                  Create
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { useCategoryStore } from '@/Stores/category';
  import { reactive } from 'vue';
  
  export default {
    components: { AuthenticatedLayout, Head },
    setup() {
      const categoryStore = useCategoryStore();
      const form = reactive({ name: '' });
  
      const createCategory = async () => {
        try {
          await categoryStore.createCategory(form);
          window.location.href = '/blog/categories';
        } catch (error) {
          console.log('Validation errors:', categoryStore.errors);
        }
      };
  
      return {
        form,
        createCategory,
        store: categoryStore,
      };
    },
  };
  </script>