<template>
    <Head title="Read Post" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Read Post</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900" v-if="post">
              <h1 class="text-2xl font-bold mb-4">{{ post.title }}</h1>
              <p class="text-gray-700 mb-4">{{ post.content }}</p>
              <p class="text-sm text-gray-500">Category: {{ post.category.name }}</p>
              <Link href="/blog/posts" class="text-blue-500 mt-4 inline-block">Back to Posts</Link>
            </div>
            <div class="p-6 text-gray-900" v-else>Loading...</div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Link, Head } from '@inertiajs/vue3';
  import { usePostStore } from '@/Stores/post';
  import { onMounted, computed } from 'vue';
  
  export default {
    components: { AuthenticatedLayout, Link, Head },
    props: ['id'],
    setup(props) {
      const postStore = usePostStore();
  
      onMounted(async () => {
        await postStore.fetchPost(props.id);
      });
  
      const post = computed(() => postStore.currentPost);
  
      return {
        post,
      };
    },
  };
  </script>