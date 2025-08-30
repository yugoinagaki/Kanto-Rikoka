<script setup>
import { computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    university: {
        type: Object,
        default: null,
    },
    isAdmin: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const navigateToUserList = (gender) => {
    const routeName = props.isAdmin ? 'admin.users.index' : 'users.index';
    const params = {
        gender: gender,
        university_id: props.university.id,
    };
    
    router.get(route(routeName), params);
    emit('close');
};
</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="3xl">
        <div v-if="university" class="p-6">
            <!-- ヘッダー -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ university.name }}
                </h2>
                <button
                    @click="$emit('close')"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- リーグ情報 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- 男子部門 -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-blue-600 border-b border-blue-200 pb-2">
                        男子部門
                    </h3>
                    
                    <div v-if="university.boys_division" class="bg-blue-50 rounded-lg p-4">
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">所属リーグ</dt>
                                <dd class="text-xl font-bold text-blue-600">{{ university.boys_division }}部</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">リーグ内順位</dt>
                                    <dd class="text-lg font-semibold text-blue-600">{{ university.boys_division_rank || '-' }}位</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">全体順位</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ university.boys_rank || '-' }}位</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="text-center py-6 text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8v2m0 0v2m0-2h2m-2 0h-2" />
                        </svg>
                        <p class="text-sm">男子部門なし</p>
                    </div>
                </div>

                <!-- 女子部門 -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-pink-600 border-b border-pink-200 pb-2">
                        女子部門
                    </h3>
                    
                    <div v-if="university.girls_division" class="bg-pink-50 rounded-lg p-4">
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">所属リーグ</dt>
                                <dd class="text-xl font-bold text-pink-600">{{ university.girls_division }}部</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">リーグ内順位</dt>
                                    <dd class="text-lg font-semibold text-pink-600">{{ university.girls_division_rank || '-' }}位</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">全体順位</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ university.girls_rank || '-' }}位</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="text-center py-6 text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8v2m0 0v2m0-2h2m-2 0h-2" />
                        </svg>
                        <p class="text-sm">女子部門なし</p>
                    </div>
                </div>
            </div>

            <!-- 選手一覧への遷移ボタン -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                    所属選手を確認
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button
                        v-if="university.boys_division"
                        @click="navigateToUserList('male')"
                        class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        男子所属選手一覧
                    </button>
                    
                    <div v-else class="flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                        </svg>
                        男子部門なし
                    </div>

                    <button
                        v-if="university.girls_division"
                        @click="navigateToUserList('female')"
                        class="flex items-center justify-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        女子所属選手一覧
                    </button>
                    
                    <div v-else class="flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                        </svg>
                        女子部門なし
                    </div>
                </div>
            </div>

            <!-- フッター -->
            <div class="mt-6 flex justify-end">
                <button
                    @click="$emit('close')"
                    class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                >
                    閉じる
                </button>
            </div>
        </div>
    </Modal>
</template>