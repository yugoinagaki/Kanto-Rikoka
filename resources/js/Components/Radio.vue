<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        required: true,
    },
    value: {
        required: true,
    },
});

const proxyValue = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit('update:modelValue', val);
    },
});
</script>

<template>
    <input
        type="radio"
        :value="value"
        v-model="proxyValue"
        class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    />
</template>