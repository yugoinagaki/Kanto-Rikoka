<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    auth: Object,
    tournament: Object,
});
</script>

<template>
    <Head :title="`${tournament.name} - 個人戦大会管理`" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ tournament.name }} - 個人戦大会管理
                </h2>
                <SecondaryButton 
                    type="button"
                    @click="$inertia.get(route('admin.tournaments.index'))"
                >
                    一覧に戻る
                </SecondaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- 大会基本情報 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">大会情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">大会名</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ tournament.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">開催年</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ tournament.year }}年</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">開始日</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ tournament.starts_on ? new Date(tournament.starts_on).toLocaleDateString('ja-JP') : '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">終了日</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ tournament.ends_on ? new Date(tournament.ends_on).toLocaleDateString('ja-JP') : '-' }}
                                </dd>
                            </div>
                            <div v-if="tournament.categories && tournament.categories.length > 0" class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">カテゴリ</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <div class="flex flex-wrap gap-2">
                                        <span 
                                            v-for="category in tournament.categories" 
                                            :key="category"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                        >
                                            {{ category }}
                                        </span>
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 管理機能 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">大会管理</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">試合管理</h4>
                                <p class="text-sm text-gray-600 mt-1">試合の作成・編集・結果入力</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">選手管理</h4>
                                <p class="text-sm text-gray-600 mt-1">参加選手の管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">ポイント管理</h4>
                                <p class="text-sm text-gray-600 mt-1">ポイント計算・表示</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">ドロー管理</h4>
                                <p class="text-sm text-gray-600 mt-1">トーナメントドローの管理</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">結果表示</h4>
                                <p class="text-sm text-gray-600 mt-1">試合結果・順位表の表示</p>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium text-gray-900">設定</h4>
                                <p class="text-sm text-gray-600 mt-1">大会設定の変更</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>