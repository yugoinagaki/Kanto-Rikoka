<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    auth: Object,
    grade: String,
    points: Array,
});

const isEditing = ref(false);
const editForm = reactive({
    grade: props.grade,
    points: props.points.map(point => ({
        id: point.id,
        round: point.round,
        points: point.points
    }))
});
const errors = ref({});
const processing = ref(false);

const startEdit = () => {
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    // フォームをリセット
    editForm.grade = props.grade;
    editForm.points = props.points.map(point => ({
        id: point.id,
        round: point.round,
        points: point.points
    }));
    errors.value = {};
};

const addRow = () => {
    editForm.points.push({
        id: null,
        round: '',
        points: 0
    });
};

const removeRow = (index) => {
    if (editForm.points.length > 1) {
        editForm.points.splice(index, 1);
    }
};

const saveChanges = () => {
    processing.value = true;
    errors.value = {};

    router.put(route('admin.tournament-points.update', { grade: props.grade }), {
        grade: editForm.grade,
        points: editForm.points
    }, {
        onSuccess: () => {
            isEditing.value = false;
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
    <Head :title="`${props.grade}のポイント表`" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ props.grade }}のポイント表
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <div v-if="!isEditing">
                                <h3 class="text-lg font-medium text-gray-900">{{ props.grade }}のポイント表</h3>
                            </div>
                            <div v-else>
                                <input
                                    v-model="editForm.grade"
                                    type="text"
                                    class="text-lg font-medium text-gray-900 bg-transparent border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none"
                                />
                                <div v-if="errors.grade" class="text-red-500 text-xs mt-1">
                                    {{ errors.grade }}
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    v-if="!isEditing"
                                    @click="startEdit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    編集
                                </button>
                                <template v-else>
                                    <button
                                        @click="saveChanges"
                                        :disabled="processing"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
                                    >
                                        {{ processing ? '保存中...' : '保存' }}
                                    </button>
                                    <button
                                        @click="cancelEdit"
                                        :disabled="processing"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        キャンセル
                                    </button>
                                </template>
                                <Link 
                                    :href="route('admin.rules.index')" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    戻る
                                </Link>
                            </div>
                        </div>

                        <div v-if="props.points.length === 0" class="text-center py-8">
                            <p class="text-gray-500 text-lg">このグレードのポイント表は登録されていません</p>
                        </div>
                        <div v-else>
                            <div v-if="isEditing" class="flex justify-end mb-4">
                                <button
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
                                            <th v-if="isEditing" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                操作
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="(point, index) in (isEditing ? editForm.points : props.points)" :key="point.id || index" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <input
                                                    v-if="isEditing"
                                                    v-model="point.round"
                                                    type="text"
                                                    :class="[
                                                        'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                                        errors[`points.${index}.round`] ? 'border-red-300' : 'border-gray-300'
                                                    ]"
                                                />
                                                <span v-else>{{ point.round }}</span>
                                                <div v-if="isEditing && errors[`points.${index}.round`]" class="text-red-500 text-xs mt-1">
                                                    {{ errors[`points.${index}.round`] }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <input
                                                    v-if="isEditing"
                                                    v-model.number="point.points"
                                                    type="number"
                                                    min="0"
                                                    max="100000"
                                                    :class="[
                                                        'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                                        errors[`points.${index}.points`] ? 'border-red-300' : 'border-gray-300'
                                                    ]"
                                                />
                                                <span v-else>{{ point.points }}ポイント</span>
                                                <div v-if="isEditing && errors[`points.${index}.points`]" class="text-red-500 text-xs mt-1">
                                                    {{ errors[`points.${index}.points`] }}
                                                </div>
                                            </td>
                                            <td v-if="isEditing" class="px-6 py-4 whitespace-nowrap">
                                                <button
                                                    @click="removeRow(index)"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                    :disabled="editForm.points.length <= 1"
                                                >
                                                    削除
                                                </button>
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