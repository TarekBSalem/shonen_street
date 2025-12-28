<script setup lang="ts">
import { computed, type HTMLAttributes } from 'vue'
import {
    ToastRoot,
    type ToastRootEmits,
    type ToastRootProps,
    useForwardPropsEmits,
} from 'radix-vue'
import { cn } from '@/lib/utils'
import { toastVariants } from '.'

const props = defineProps<ToastRootProps & { class?: HTMLAttributes['class'] }>()
const emits = defineEmits<ToastRootEmits>()

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props

    return delegated
})

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
    <ToastRoot v-bind="forwarded" :class="cn(toastVariants(), props.class)">
        <slot />
    </ToastRoot>
</template>
