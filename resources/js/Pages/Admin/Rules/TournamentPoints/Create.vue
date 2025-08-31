<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    auth: Object,
});

const form = reactive({
    grade: '',
    points: [
        { round: '優勝', points: 0 },
        { round: '準優勝', points: 0 },
        { round: '3位', points: 0 },
        { round: '4位', points: 0 },
        { round: 'ベスト8', points: 0 },
        { round: 'ベスト16', points: 0 },
    ]
});

const errors = ref({});
const processing = ref(false);

const addRow = () => {
    form.points.push({
        round: '',
        points: 0
    });
};

const removeRow = (index) => {
    if (form.points.length > 1) {
        form.points.splice(index, 1);
    }
};

const submit = () => {
    processing.value = true;
    errors.value = {};

    if (!form.grade.trim()) {
        errors.value.grade = 'ポイント区分を入力してください';
        processing.value = false;
        return;
    }

    // 空のラウンド名をチェック
    const emptyRounds = form.points.filter(point => !point.round.trim());
    if (emptyRounds.length > 0) {
        errors.value.points = '成績・ラウンドが未入力の行があります';
        processing.value = false;
        return;
    }

    router.post(route('admin.tournament-points.store'), {
        grade: form.grade,
        points: form.points
    }, {
        onSuccess: () => {
            // 成功時はポイント管理画面にリダイレクト
        },
        onError: (error) => {
            errors.value = error;
        },
        onFinish: () => {
            processing.value = false;
        }
    });
};
</script>

<template>
    <Head title="ポイント表新規作成" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ポイント表新規作成
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- ポイント区分入力 -->
                            <div class="mb-6">
                                <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">
                                    ポイント区分（登録名）
                                </label>
                                <input
                                    v-model="form.grade"
                                    type="text"
                                    id="grade"
                                    placeholder="例：グレード１、新人戦など"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                        errors.grade ? 'border-red-300' : 'border-gray-300'
                                    ]"
                                />
                                <div v-if="errors.grade" class="text-red-500 text-sm mt-1">
                                    {{ errors.grade }}
                                </div>
                            </div>

                            <!-- ポイント設定 -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">ポイント設定</h3>
                                    <button
                                        type="button"
                                        @click="addRow"
                                        class="px-3 py-1 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    >
                                        + 行を追加
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    成績・ラウンド
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ポイント
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    操作
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="(item, index) in form.points" :key="index">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input
                                                        v-model="item.round"
                                                        type="text"
                                                        placeholder="例：優勝、準優勝、ベスト8..."
                                                        :class="[
                                                            'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                                            errors[`points.${index}.round`] ? 'border-red-300' : 'border-gray-300'
                                                        ]"
                                                    />
                                                    <div v-if="errors[`points.${index}.round`]" class="text-red-500 text-xs mt-1">
                                                        {{ errors[`points.${index}.round`] }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input
                                                        v-model.number="item.points"
                                                        type="number"
                                                        min="0"
                                                        max="100000"
                                                        :class="[
                                                            'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                                            errors[`points.${index}.points`] ? 'border-red-300' : 'border-gray-300'
                                                        ]"
                                                    />
                                                    <div v-if="errors[`points.${index}.points`]" class="text-red-500 text-xs mt-1">
                                                        {{ errors[`points.${index}.points`] }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <button
                                                        type="button"
                                                        @click="removeRow(index)"
                                                        class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                        :disabled="form.points.length <= 1"
                                                    >
                                                        削除
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="errors.points" class="text-red-500 text-sm mt-2">
                                    {{ errors.points }}
                                </div>
                            </div>

                            <!-- ボタン -->
                            <div class="flex justify-end space-x-3">
                                <button
                                    type="button"
                                    @click="router.visit(route('admin.rules.index'))"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    キャンセル
                                </button>
                                <button
                                    type="submit"
                                    :disabled="processing"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                                >
                                    {{ processing ? '登録中...' : '新規登録' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
