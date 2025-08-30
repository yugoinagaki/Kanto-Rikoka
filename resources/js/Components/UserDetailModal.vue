<script setup>
import { computed } from 'vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    user: {
        type: Object,
        default: null,
    },
    isAdmin: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const genderLabel = computed(() => {
    return props.user?.gender === 'male' ? '男子' : '女子';
});

const stemLabel = computed(() => {
    return props.user?.is_stem ? '理系' : '文系';
});

const genderColor = computed(() => {
    return props.user?.gender === 'male' ? 'blue' : 'pink';
});
</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="4xl">
        <div v-if="user" class="p-6">
            <!-- ヘッダー -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ user.name }}
                    </h2>
                    <span
                        :class="[
                            'px-3 py-1 text-sm font-semibold rounded-full',
                            user.gender === 'male' 
                                ? 'bg-blue-100 text-blue-800' 
                                : 'bg-pink-100 text-pink-800'
                        ]"
                    >
                        {{ genderLabel }}
                    </span>
                </div>
                <button
                    @click="$emit('close')"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- 基本情報 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <!-- 基本データ -->
                <div class="space-y-3">
                    <h3 class="text-base font-semibold text-gray-900 border-b pb-1">
                        基本情報
                    </h3>
                    
                    <div class="space-y-2">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">選手番号</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ user.player_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">大学</dt>
                            <dd class="text-sm text-gray-900">{{ user.university?.name || '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">学年</dt>
                            <dd class="text-sm text-gray-900">{{ user.grade }}年（{{ user.years_enrolled }}年目）</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">文理</dt>
                            <dd class="text-sm text-gray-900">{{ stemLabel }}</dd>
                        </div>
                    </div>
                </div>

                <!-- ポイント -->
                <div class="lg:col-span-2 space-y-3">
                    <h3 class="text-base font-semibold text-gray-900 border-b pb-1">
                        現在のポイント
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div 
                            :class="[
                                'p-3 rounded-lg border',
                                user.gender === 'male' 
                                    ? 'border-blue-200 bg-blue-50' 
                                    : 'border-pink-200 bg-pink-50'
                            ]"
                        >
                            <dt class="text-xs font-medium text-gray-600">シングルス</dt>
                            <dd 
                                :class="[
                                    'mt-1 text-xl font-bold',
                                    user.gender === 'male' ? 'text-blue-600' : 'text-pink-600'
                                ]"
                            >
                                {{ user.singles_points }}pt
                            </dd>
                        </div>
                        <div 
                            :class="[
                                'p-3 rounded-lg border',
                                user.gender === 'male' 
                                    ? 'border-blue-200 bg-blue-50' 
                                    : 'border-pink-200 bg-pink-50'
                            ]"
                        >
                            <dt class="text-xs font-medium text-gray-600">ダブルス</dt>
                            <dd 
                                :class="[
                                    'mt-1 text-xl font-bold',
                                    user.gender === 'male' ? 'text-blue-600' : 'text-pink-600'
                                ]"
                            >
                                {{ user.doubles_points }}pt
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 戦績セクション -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- 個人戦成績 -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                        個人戦成績
                    </h3>
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p class="mt-2">個人戦成績データは準備中です</p>
                    </div>
                </div>

                <!-- リーグ戦成績 -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                        リーグ戦成績
                    </h3>
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-2">リーグ戦成績データは準備中です</p>
                    </div>
                </div>
            </div>

            <!-- フッター -->
            <div class="mt-8 flex justify-end">
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