<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    start_date: '',
    end_date: '',
    year: new Date().getFullYear(),
});

const submit = () => {
    form.post(route('admin.leagues.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="新規団体戦作成" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    新規団体戦作成
                </h2>
                <SecondaryButton
                    type="button"
                    @click="$inertia.get(route('admin.leagues.index'))"
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
                                <InputLabel for="name" value="リーグ名" />
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
                                <InputLabel for="start_date" value="開始日" />
                                <TextInput
                                    id="start_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.start_date"
                                />
                                <InputError class="mt-2" :message="form.errors.start_date" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="終了日" />
                                <TextInput
                                    id="end_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.end_date"
                                />
                                <InputError class="mt-2" :message="form.errors.end_date" />
                            </div>

                            <div class="flex items-center justify-end space-x-4">
                                <SecondaryButton
                                    type="button"
                                    @click="form.get(route('admin.leagues.index'))"
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
