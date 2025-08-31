<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    boysUniversities: {
        type: Object,
        required: true,
    },
    girlsUniversities: {
        type: Object,
        required: true,
    },
});

// フォームデータを準備
const form = useForm({
    boysUniversities: JSON.parse(JSON.stringify(props.boysUniversities)),
    girlsUniversities: JSON.parse(JSON.stringify(props.girlsUniversities)),
});

// 同じ部内で隣り合う大学を入れ替える
const swapUniversities = (gender, division, index) => {
    const array = form[`${gender}Universities`][division];
    if (index < array.length - 1) {
        const temp = array[index];
        array[index] = array[index + 1];
        array[index + 1] = temp;
    }
};

// ソート済みのリーグキーを取得する関数
const getSortedDivisions = (gender) => {
    return Object.keys(form[`${gender}Universities`]).sort((a, b) => parseInt(a) - parseInt(b));
};

// 異なるリーグ間で入れ替える（現在のリーグの最下位と次のリーグの最上位）
const swapBetweenDivisions = (gender, currentDivision, nextDivision) => {
    const currentArray = form[`${gender}Universities`][currentDivision];
    const nextArray = form[`${gender}Universities`][nextDivision];
    
    if (currentArray.length > 0 && nextArray.length > 0) {
        const temp = currentArray[currentArray.length - 1];
        currentArray[currentArray.length - 1] = nextArray[0];
        nextArray[0] = temp;
    }
};

// 保存処理
const save = () => {
    form.put(route('admin.universities.update'), {
        onSuccess: () => {
            // 成功時の処理
        }
    });
};
</script>

<template>
    <Head title="大学順位編集" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    大学順位編集
                </h2>
                <div class="space-x-4">
                    <button
                        @click="$inertia.visit(route('admin.universities.index'))"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                    >
                        キャンセル
                    </button>
                    <button
                        @click="save"
                        :disabled="form.processing"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out disabled:opacity-50"
                    >
                        <span v-if="form.processing">保存中...</span>
                        <span v-else>保存</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>操作方法：</strong>
                                隣り合う大学の間の入れ替えボタンで順位を変更できます。
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                            <!-- 男子の部 -->
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold text-blue-600">
                                    男子
                                </h3>
                                <div class="space-y-4">
                                    <template v-for="(universities, division, divisionIndex) in form.boysUniversities" :key="`boys-${division}`">
                                        <div class="rounded-lg border border-gray-200 p-4">
                                        <h4 class="mb-3 text-lg font-semibold text-gray-700">
                                            {{ division }}部
                                        </h4>
                                        <div>
                                            <template v-for="(university, index) in universities" :key="`boys-${university.id}`">
                                                <!-- 大学表示 -->
                                                <div class="bg-blue-50 px-3 py-2 rounded hover:bg-blue-100 transition-colors">
                                                    <div class="flex items-center space-x-3">
                                                        <span class="font-medium text-blue-600 w-6">{{ index + 1 }}.</span>
                                                        <span class="text-sm text-gray-800">{{ university.name }}</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- 入れ替えボタン（最後の大学以外） -->
                                                <div v-if="index < universities.length - 1" class="flex justify-center py-1">
                                                    <button
                                                        @click="swapUniversities('boys', division, index)"
                                                        class="p-1 text-gray-400 hover:text-blue-600 transition-colors"
                                                        title="入れ替え"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        </div>
                                        
                                        <!-- リーグ間入れ替えボタン（最後のリーグ以外） -->
                                        <div v-if="getSortedDivisions('boys').indexOf(division) < getSortedDivisions('boys').length - 1" class="flex justify-center py-2">
                                            <button
                                                @click="swapBetweenDivisions('boys', division, getSortedDivisions('boys')[getSortedDivisions('boys').indexOf(division) + 1])"
                                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 rounded transition-colors border border-dashed border-gray-300 hover:border-blue-300"
                                                title="リーグ間入れ替え"
                                            >
                                                {{ division }}部 ⇅ {{ getSortedDivisions('boys')[getSortedDivisions('boys').indexOf(division) + 1] }}部
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- 女子の部 -->
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold text-pink-600">
                                    女子
                                </h3>
                                <div class="space-y-4">
                                    <template v-for="(universities, division, divisionIndex) in form.girlsUniversities" :key="`girls-${division}`">
                                        <div class="rounded-lg border border-gray-200 p-4">
                                        <h4 class="mb-3 text-lg font-semibold text-gray-700">
                                            {{ division }}部
                                        </h4>
                                        <div>
                                            <template v-for="(university, index) in universities" :key="`girls-${university.id}`">
                                                <!-- 大学表示 -->
                                                <div class="bg-pink-50 px-3 py-2 rounded hover:bg-pink-100 transition-colors">
                                                    <div class="flex items-center space-x-3">
                                                        <span class="font-medium text-pink-600 w-6">{{ index + 1 }}.</span>
                                                        <span class="text-sm text-gray-800">{{ university.name }}</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- 入れ替えボタン（最後の大学以外） -->
                                                <div v-if="index < universities.length - 1" class="flex justify-center py-1">
                                                    <button
                                                        @click="swapUniversities('girls', division, index)"
                                                        class="p-1 text-gray-400 hover:text-pink-600 transition-colors"
                                                        title="入れ替え"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        </div>
                                        
                                        <!-- リーグ間入れ替えボタン（最後のリーグ以外） -->
                                        <div v-if="getSortedDivisions('girls').indexOf(division) < getSortedDivisions('girls').length - 1" class="flex justify-center py-2">
                                            <button
                                                @click="swapBetweenDivisions('girls', division, getSortedDivisions('girls')[getSortedDivisions('girls').indexOf(division) + 1])"
                                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-pink-100 text-gray-600 hover:text-pink-600 rounded transition-colors border border-dashed border-gray-300 hover:border-pink-300"
                                                title="リーグ間入れ替え"
                                            >
                                                {{ division }}部 ⇅ {{ getSortedDivisions('girls')[getSortedDivisions('girls').indexOf(division) + 1] }}部
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
