<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
      </template>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <Link v-if="isAdmin" href="/blog/posts/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">Create New Post</Link>
              <ul class="space-y-2">
                <li v-for="post in posts" :key="post.id" class="flex items-center justify-between bg-gray-100 p-2 rounded">
                  <span class="text-gray-700">{{ post.title }} - {{ post.category.name }}</span>
                  <div class="space-x-2">
                    <Link :href="'/blog/posts/' + post.id + '/show'" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Read</Link>
                    <Link v-if="isAdmin" :href="'/blog/posts/' + post.id + '/edit'" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</Link>
                    <button v-if="isAdmin" @click="deletePost(post.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
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
  import { Link } from '@inertiajs/vue3';
  import { Head } from '@inertiajs/vue3';
  import { usePostStore } from '@/Stores/post';
  import { useCategoryStore } from '@/Stores/category';
  import { onMounted, computed } from 'vue';
  
  export default {
    components: { AuthenticatedLayout, Link, Head },
    props: {
      isAdmin: {
        type: Boolean,
        default: false,
      },
    },
    setup(props) {
      const postStore = usePostStore();
      const categoryStore = useCategoryStore();
  
      onMounted(() => {
        postStore.fetchPosts();
        categoryStore.fetchCategories();
      });
  
      const posts = computed(() => postStore.posts);
  
      return {
        posts,
        deletePost: postStore.deletePost,
      };
    },
  };
  </script>