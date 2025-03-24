<template>
    <Head title="Create Post" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <form @submit.prevent="createPost" class="space-y-4">
                <div>
                  <input
                    v-model="form.title"
                    placeholder="Post Title"
                    class="w-full p-2 border rounded"
                  />
                  <span v-if="store.errors.title" class="text-red-500 text-sm">
                    {{ store.errors.title[0] }}
                  </span>
                </div>
                <div>
                  <textarea
                    v-model="form.content"
                    placeholder="Post Content"
                    class="w-full p-2 border rounded h-32"
                  ></textarea>
                  <span v-if="store.errors.content" class="text-red-500 text-sm">
                    {{ store.errors.content[0] }}
                  </span>
                </div>
                <div>
                  <select
                    v-model="form.category_id"
                    class="w-full p-2 border rounded"
                  >
                    <option value="">Select Category</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <span v-if="store.errors.category_id" class="text-red-500 text-sm">
                    {{ store.errors.category_id[0] }}
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
  import { usePostStore } from '@/Stores/post';
  import { useCategoryStore } from '@/Stores/category';
  import { reactive } from 'vue';
  
  export default {
    components: { AuthenticatedLayout, Head },
    setup() {
      const postStore = usePostStore();
      const categoryStore = useCategoryStore();
      const form = reactive({ title: '', content: '', category_id: '' });
  
      const createPost = async () => {
        try {
          await postStore.createPost(form);
          window.location.href = '/blog/posts';
        } catch (error) {
          console.log('Validation errors:', postStore.errors);
        }
      };
  
      return {
        form,
        categories: categoryStore.categories,
        createPost,
        store: postStore,
      };
    },
  };
  </script>