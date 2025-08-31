<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    auth: Object,
    grades: Array,
});
</script>

<template>
    <Head title="個人戦ルール・要項管理" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ポイント管理
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">ルール・要項管理メニュー</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <Link :href="route('admin.tournament-points.create')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <h4 class="font-medium text-gray-900">新規作成</h4>
                                <p class="text-sm text-gray-600 mt-1">新たなポイント表を作成</p>
                            </Link>
                            <Link 
                                v-for="grade in grades" 
                                :key="grade"
                                :href="route('admin.tournament-points.show', { grade: grade })"
                                class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                            >
                                <h4 class="font-medium text-gray-900">{{ grade }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ grade }}のポイント表</p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
