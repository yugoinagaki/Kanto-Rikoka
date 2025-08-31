<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    auth: Object,
    league: Object,
});
</script>

<template>
    <Head :title="`${league.name} - 団体戦大会管理`" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ league.name }} - 団体戦大会管理
                </h2>
                <SecondaryButton 
                    type="button"
                    @click="$inertia.get(route('admin.leagues.index'))"
                >
                    一覧に戻る
                </SecondaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- リーグ基本情報 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">リーグ情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">リーグ名</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ league.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">開催年</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ league.year }}年</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">開始日</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ league.start_date ? new Date(league.start_date).toLocaleDateString('ja-JP') : '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">終了日</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ league.end_date ? new Date(league.end_date).toLocaleDateString('ja-JP') : '-' }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 管理機能 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">リーグ管理</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">対戦管理</h4>
                                <p class="text-sm text-gray-600 mt-1">対戦の作成・編集・結果入力</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">大学管理</h4>
                                <p class="text-sm text-gray-600 mt-1">参加大学の管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">順位表</h4>
                                <p class="text-sm text-gray-600 mt-1">リーグ戦順位表の表示</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">試合管理</h4>
                                <p class="text-sm text-gray-600 mt-1">個別試合の詳細管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">選手管理</h4>
                                <p class="text-sm text-gray-600 mt-1">各大学の選手管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">設定</h4>
                                <p class="text-sm text-gray-600 mt-1">リーグ設定の変更</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>