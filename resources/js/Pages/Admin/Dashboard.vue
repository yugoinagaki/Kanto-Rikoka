<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

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
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">管理者メニュー</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">ユーザー管理</h4>
                                <p class="text-sm text-gray-600 mt-1">登録ユーザーの管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">システム設定</h4>
                                <p class="text-sm text-gray-600 mt-1">システム全体の設定管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">レポート</h4>
                                <p class="text-sm text-gray-600 mt-1">各種統計・レポート確認</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>