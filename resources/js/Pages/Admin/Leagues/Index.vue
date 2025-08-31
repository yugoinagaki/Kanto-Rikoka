<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    auth: Object,
    leagues: Array,
});
</script>

<template>
    <Head title="リーグ管理" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                団体戦管理
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6 flex justify-between items-center">
                            <h3 class="text-lg font-medium">団体戦一覧</h3>
                            <Link
                                :href="route('admin.leagues.create')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150"
                            >
                                団体戦を新規作成
                            </Link>
                        </div>

                        <div v-if="props.leagues.length === 0" class="text-center py-8">
                            <p class="text-gray-500 text-lg">登録されている団体戦はありません</p>
                        </div>
                        <div v-else>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                リーグ名
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                開催年
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                期間
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="league in props.leagues" :key="league.id" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ league.name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ league.year }}年
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span v-if="league.start_date && league.end_date">
                                                    {{ new Date(league.start_date).toLocaleDateString('ja-JP') }}〜{{ new Date(league.end_date).toLocaleDateString('ja-JP') }}
                                                </span>
                                                <span v-else-if="league.start_date">
                                                    {{ new Date(league.start_date).toLocaleDateString('ja-JP') }}〜
                                                </span>
                                                <span v-else-if="league.end_date">
                                                    〜{{ new Date(league.end_date).toLocaleDateString('ja-JP') }}
                                                </span>
                                                <span v-else>-</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
