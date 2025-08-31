<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    tournamentPointRules: Array,
});

const form = useForm({
    name: '',
    starts_on: '',
    ends_on: '',
    year: new Date().getFullYear(),
    categories: [],
    tournament_point_rule_id: null,
});

const newCategory = ref('');
const isComposing = ref(false);

const addCategory = () => {
    if (newCategory.value.trim()) {
        form.categories.push(newCategory.value.trim());
        newCategory.value = '';
    }
};

const handleKeyUp = (event) => {
    if (event.key === 'Enter' && !isComposing.value) {
        addCategory();
    }
};

const handleCompositionStart = () => {
    isComposing.value = true;
};

const handleCompositionEnd = () => {
    isComposing.value = false;
};

const removeCategory = (index) => {
    form.categories.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.tournaments.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="新規大会作成" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    新規大会作成
                </h2>
                <SecondaryButton 
                    type="button"
                    @click="$inertia.get(route('admin.tournaments.index'))"
                >
                    戻る
                </SecondaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="space-y-6">
                            <div>
                                <InputLabel for="name" value="大会名" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="year" value="開催年" />
                                <TextInput
                                    id="year"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.year"
                                    required
                                    min="2000"
                                    max="2099"
                                />
                                <InputError class="mt-2" :message="form.errors.year" />
                            </div>

                            <div>
                                <InputLabel for="starts_on" value="開始日" />
                                <TextInput
                                    id="starts_on"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.starts_on"
                                />
                                <InputError class="mt-2" :message="form.errors.starts_on" />
                            </div>

                            <div>
                                <InputLabel for="ends_on" value="終了日" />
                                <TextInput
                                    id="ends_on"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.ends_on"
                                />
                                <InputError class="mt-2" :message="form.errors.ends_on" />
                            </div>

                            <div>
                                <InputLabel value="カテゴリ" />
                                <div class="mt-2 space-y-2">
                                    <div class="flex gap-2">
                                        <TextInput
                                            v-model="newCategory"
                                            placeholder="カテゴリを入力"
                                            class="flex-1"
                                            @keyup="handleKeyUp"
                                            @compositionstart="handleCompositionStart"
                                            @compositionend="handleCompositionEnd"
                                        />
                                        <PrimaryButton type="button" @click="addCategory">追加</PrimaryButton>
                                    </div>
                                    <div v-if="form.categories.length > 0" class="space-y-1">
                                        <div
                                            v-for="(category, index) in form.categories"
                                            :key="index"
                                            class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded"
                                        >
                                            <span>{{ category }}</span>
                                            <button
                                                type="button"
                                                @click="removeCategory(index)"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                削除
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.categories" />
                            </div>

                            <div>
                                <InputLabel for="tournament_point_rule_id" value="ポイントルール" />
                                <select
                                    id="tournament_point_rule_id"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.tournament_point_rule_id"
                                >
                                    <option value="">選択してください</option>
                                    <option
                                        v-for="rule in props.tournamentPointRules"
                                        :key="rule.id"
                                        :value="rule.id"
                                    >
                                        {{ rule.grade }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.tournament_point_rule_id" />
                            </div>

                            <div class="flex items-center justify-end space-x-4">
                                <SecondaryButton 
                                    type="button"
                                    @click="form.get(route('admin.tournaments.index'))"
                                >
                                    キャンセル
                                </SecondaryButton>
                                <PrimaryButton 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                >
                                    作成
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>