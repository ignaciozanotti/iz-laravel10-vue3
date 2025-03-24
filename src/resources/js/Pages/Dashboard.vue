<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps(['message']);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <p v-if="message" class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ message }}
            </p>
            
            <p v-if="$page.props.flash.error" class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ $page.props.flash.error }}
            </p>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="$page.props.auth.user">
                            <p>Welcome, {{ $page.props.auth.user.name }}!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
