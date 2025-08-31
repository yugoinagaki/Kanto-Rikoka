<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    auth: Object,
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-5">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">基本情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <Link :href="route('admin.universities.index')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <h4 class="font-medium text-gray-900">大学一覧</h4>
                                <p class="text-sm text-gray-600 mt-1">所属大学の管理</p>
                            </Link>
                            <Link :href="route('admin.users.index')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <h4 class="font-medium text-gray-900">選手一覧</h4>
                                <p class="text-sm text-gray-600 mt-1">所属選手の管理</p>
                            </Link>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">管理者管理</h4>
                                <p class="text-sm text-gray-600 mt-1">管理者情報を管理</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-5">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">個人戦情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <Link :href="route('admin.tournaments.index')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <h4 class="font-medium text-gray-900">大会</h4>
                                <p class="text-sm text-gray-600 mt-1">個人戦の大会管理</p>
                            </Link>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">試合</h4>
                                <p class="text-sm text-gray-600 mt-1">個人戦の試合管理</p>
                            </div>
                            <Link :href="route('admin.rules.index')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <h4 class="font-medium text-gray-900">ルール</h4>
                                <p class="text-sm text-gray-600 mt-1">個人戦のルール・要項管理</p>
                            </Link>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-5">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">団体戦情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">大会</h4>
                                <p class="text-sm text-gray-600 mt-1">団体戦の大会管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">試合</h4>
                                <p class="text-sm text-gray-600 mt-1">団体戦の試合管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">ルール</h4>
                                <p class="text-sm text-gray-600 mt-1">団体戦のルール・要項管理</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
