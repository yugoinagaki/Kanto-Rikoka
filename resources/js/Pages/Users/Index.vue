<script setup>
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import UserDetailModal from '@/Components/UserDetailModal.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    universities: {
        type: Array,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        default: false,
    },
    filters: {
        type: Object,
        required: true,
    },
});

const currentGender = ref(props.filters.gender || 'male');
const selectedUniversityId = ref(props.filters.university_id || '');
const selectedGrade = ref(props.filters.grade || '');
const selectedIsStem = ref(props.filters.is_stem || '');
const sortBy = ref(props.filters.sort_by || 'player_number');
const sortOrder = ref(props.filters.sort_order || 'asc');

// モーダル関連
const showUserModal = ref(false);
const selectedUser = ref(null);

const genderOptions = [
    { value: 'male', label: '男子' },
    { value: 'female', label: '女子' }
];

const sortOptions = [
    { value: 'player_number', label: '選手番号' },
    { value: 'name', label: '名前' },
    { value: 'singles_points', label: 'シングルスポイント' },
    { value: 'doubles_points', label: 'ダブルスポイント' }
];

const sortOrderOptions = [
    { value: 'asc', label: '昇順' },
    { value: 'desc', label: '降順' }
];

const gradeOptions = [
    { value: 1, label: '1年' },
    { value: 2, label: '2年' },
    { value: 3, label: '3年' },
    { value: 4, label: '4年' },
    { value: 5, label: '5年' },
    { value: 6, label: '6年' }
];

const stemOptions = [
    { value: '1', label: '理系' },
    { value: '0', label: '文系' }
];

const getMaleButtonClass = computed(() => {
    return currentGender.value === 'male'
        ? 'bg-blue-600 text-white'
        : 'bg-gray-200 text-gray-700 hover:bg-gray-300';
});

const getFemaleButtonClass = computed(() => {
    return currentGender.value === 'female'
        ? 'bg-pink-600 text-white'
        : 'bg-gray-200 text-gray-700 hover:bg-gray-300';
});

const getTableHeaderColorClass = computed(() => {
    return currentGender.value === 'male' ? 'blue' : 'pink';
});

const LayoutComponent = computed(() => {
    return props.isAdmin ? AdminAuthenticatedLayout : AuthenticatedLayout;
});

const updateFilters = () => {
    const params = {
        gender: currentGender.value,
        ...(selectedUniversityId.value && { university_id: selectedUniversityId.value }),
        ...(selectedGrade.value && { grade: selectedGrade.value }),
        ...(selectedIsStem.value !== '' && { is_stem: selectedIsStem.value }),
        sort_by: sortBy.value,
        sort_order: sortOrder.value,
    };

    const routeName = props.isAdmin ? 'admin.users.index' : 'users.index';
    router.get(route(routeName), params, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    selectedUniversityId.value = '';
    selectedGrade.value = '';
    selectedIsStem.value = '';
    updateFilters();
};

const switchGender = (gender) => {
    currentGender.value = gender;
    updateFilters();
};

const openUserModal = (user) => {
    selectedUser.value = user;
    showUserModal.value = true;
};

const closeUserModal = () => {
    showUserModal.value = false;
    selectedUser.value = null;
};
</script>

<template>
    <Head title="選手一覧" />

    <component :is="LayoutComponent">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                選手一覧
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- 男女切り替えタブ -->
                        <div class="mb-6">
                            <div class="flex space-x-4">
                                <button
                                    @click="switchGender('male')"
                                    :class="[
                                        'px-6 py-2 rounded-lg font-medium transition duration-150 ease-in-out',
                                        getMaleButtonClass
                                    ]"
                                >
                                    男子
                                </button>
                                <button
                                    @click="switchGender('female')"
                                    :class="[
                                        'px-6 py-2 rounded-lg font-medium transition duration-150 ease-in-out',
                                        getFemaleButtonClass
                                    ]"
                                >
                                    女子
                                </button>
                            </div>
                        </div>

                        <!-- フィルター・並び替えコントロール -->
                        <div class="mb-6 space-y-4 rounded-lg border border-gray-200 p-4">
                            <h3 class="text-lg font-semibold text-gray-700">フィルター・並び替え</h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <!-- 大学選択 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">大学</label>
                                    <select
                                        v-model="selectedUniversityId"
                                        @change="updateFilters"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="">すべて</option>
                                        <option
                                            v-for="university in universities"
                                            :key="university.id"
                                            :value="university.id"
                                        >
                                            {{ university.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- 学年選択 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">学年</label>
                                    <select
                                        v-model="selectedGrade"
                                        @change="updateFilters"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="">すべて</option>
                                        <option
                                            v-for="grade in gradeOptions"
                                            :key="grade.value"
                                            :value="grade.value"
                                        >
                                            {{ grade.label }}
                                        </option>
                                    </select>
                                </div>

                                <!-- 文理選択 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">文理</label>
                                    <select
                                        v-model="selectedIsStem"
                                        @change="updateFilters"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="">すべて</option>
                                        <option
                                            v-for="stem in stemOptions"
                                            :key="stem.value"
                                            :value="stem.value"
                                        >
                                            {{ stem.label }}
                                        </option>
                                    </select>
                                </div>

                                <!-- 並び替え項目 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">並び替え</label>
                                    <select
                                        v-model="sortBy"
                                        @change="updateFilters"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option
                                            v-for="sort in sortOptions"
                                            :key="sort.value"
                                            :value="sort.value"
                                        >
                                            {{ sort.label }}
                                        </option>
                                    </select>
                                </div>

                                <!-- 並び順 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">順序</label>
                                    <select
                                        v-model="sortOrder"
                                        @change="updateFilters"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option
                                            v-for="order in sortOrderOptions"
                                            :key="order.value"
                                            :value="order.value"
                                        >
                                            {{ order.label }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- フィルタークリアボタン -->
                            <div class="flex justify-end">
                                <button
                                    @click="clearFilters"
                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out"
                                >
                                    フィルターをクリア
                                </button>
                            </div>
                        </div>

                        <!-- 選手一覧テーブル -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            選手番号
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            名前
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            大学
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            学年
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            文理
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            シングルス
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            ダブルス
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr
                                        v-for="user in users.data"
                                        :key="user.id"
                                        @click="openUserModal(user)"
                                        :class="[
                                            'cursor-pointer hover:bg-gray-50 transition-colors duration-150',
                                            user.id === $page.props.auth.user.id
                                                ? (currentGender === 'male' ? 'bg-blue-50 border-l-4 border-blue-500' : 'bg-pink-50 border-l-4 border-pink-500')
                                                : ''
                                        ]"
                                    >
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ user.player_number }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                {{ user.name }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ user.university?.name || '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ user.grade }}年
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ user.is_stem ? '理系' : '文系' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ user.singles_points }}pt
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ user.doubles_points }}pt
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- ページネーション -->
                        <div v-if="users.links && users.links.length > 3" class="mt-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    {{ users.from }} - {{ users.to }} / {{ users.total }} 件
                                </div>
                                <div class="flex space-x-1">
                                    <template v-for="link in users.links" :key="link.label">
                                        <button
                                            v-if="link.url"
                                            @click="router.get(link.url)"
                                            :class="[
                                                'px-3 py-2 text-sm rounded',
                                                link.active
                                                    ? (currentGender === 'male' ? 'bg-blue-600 text-white' : 'bg-pink-600 text-white')
                                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                            ]"
                                            v-html="link.label"
                                        ></button>
                                        <span
                                            v-else
                                            class="px-3 py-2 text-sm text-gray-400"
                                            v-html="link.label"
                                        ></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 選手詳細モーダル -->
        <UserDetailModal 
            :show="showUserModal"
            :user="selectedUser"
            :is-admin="isAdmin"
            @close="closeUserModal"
        />
    </component>
</template>
