<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    boysUniversities: {
        type: Object,
        required: true,
    },
    girlsUniversities: {
        type: Object,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        required: true,
    },
});

const LayoutComponent = computed(() => {
    return props.isAdmin ? AdminAuthenticatedLayout : AuthenticatedLayout;
});
</script>

<template>
    <Head title="大学一覧" />

    <component :is="LayoutComponent">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                大学一覧
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                            <!-- 男子の部 -->
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold text-blue-600">
                                    男子
                                </h3>
                                <div class="space-y-4">
                                    <div 
                                        v-for="(universities, league) in boysUniversities" 
                                        :key="`boys-${league}`"
                                        class="rounded-lg border border-gray-200 p-4"
                                    >
                                        <h4 class="mb-3 text-lg font-semibold text-gray-700">
                                            {{ league }}部
                                        </h4>
                                        <ul class="space-y-2">
                                            <li 
                                                v-for="university in universities" 
                                                :key="`boys-${university.id}`"
                                                class="rounded bg-blue-50 px-3 py-2 text-sm text-gray-800"
                                            >
                                                {{ university.name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- 女子の部 -->
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold text-pink-600">
                                    女子
                                </h3>
                                <div class="space-y-4">
                                    <div 
                                        v-for="(universities, league) in girlsUniversities" 
                                        :key="`girls-${league}`"
                                        class="rounded-lg border border-gray-200 p-4"
                                    >
                                        <h4 class="mb-3 text-lg font-semibold text-gray-700">
                                            {{ league }}部
                                        </h4>
                                        <ul class="space-y-2">
                                            <li 
                                                v-for="university in universities" 
                                                :key="`girls-${university.id}`"
                                                class="rounded bg-pink-50 px-3 py-2 text-sm text-gray-800"
                                            >
                                                {{ university.name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>