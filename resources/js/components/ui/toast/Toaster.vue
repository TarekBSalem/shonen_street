<script setup lang="ts">
import { isVNode } from 'vue'
import { useToast } from './use-toast'
import {
    Toast,
    ToastClose,
    ToastDescription,
    ToastProvider,
    ToastTitle,
    ToastViewport,
} from '.'

const { toasts } = useToast()
</script>

<template>
    <ToastProvider :duration="5000">
        <Toast v-for="toast in toasts" :key="toast.id" :open="toast.open"
            @update:open="(value: boolean) => toast.onOpenChange?.(value)">
            <div class="grid gap-1">
                <ToastTitle v-if="toast.title">
                    {{ toast.title }}
                </ToastTitle>
                <template v-if="toast.description">
                    <ToastDescription v-if="isVNode(toast.description)">
                        <component :is="toast.description" />
                    </ToastDescription>
                    <ToastDescription v-else>
                        {{ toast.description }}
                    </ToastDescription>
                </template>
            </div>
            <ToastClose />
        </Toast>
        <ToastViewport />
    </ToastProvider>
</template>
