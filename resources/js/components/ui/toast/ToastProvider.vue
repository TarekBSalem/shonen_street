<script setup lang="ts">
import { ToastProvider, type ToastProviderProps } from 'radix-vue'

const props = withDefaults(defineProps<ToastProviderProps>(), {
    label: 'Notification',
    duration: 5000,
    swipeDirection: 'right',
    swipeThreshold: 50,
})
</script>

<template>
    <ToastProvider v-bind="props">
        <slot />
    </ToastProvider>
</template>
