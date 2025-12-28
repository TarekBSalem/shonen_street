<script setup lang="ts">
import { ScrollAreaCorner, ScrollAreaRoot, ScrollAreaScrollbar, ScrollAreaThumb, ScrollAreaViewport } from 'reka-ui';
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
    orientation?: 'vertical' | 'horizontal' | 'both';
}>();
</script>

<template>
    <ScrollAreaRoot :class="cn('relative overflow-hidden', props.class)">
        <ScrollAreaViewport class="h-full w-full rounded-[inherit]">
            <slot />
        </ScrollAreaViewport>
        <ScrollBar v-if="orientation === 'vertical' || orientation === 'both'" />
        <ScrollBar
            v-if="orientation === 'horizontal' || orientation === 'both'"
            orientation="horizontal"
        />
        <ScrollAreaCorner />
    </ScrollAreaRoot>
</template>

<script lang="ts">
import { defineComponent, h } from 'vue';

export const ScrollBar = defineComponent({
    props: {
        orientation: {
            type: String as () => 'vertical' | 'horizontal',
            default: 'vertical',
        },
    },
    setup(props) {
        return () =>
            h(
                ScrollAreaScrollbar,
                {
                    orientation: props.orientation,
                    class: cn(
                        'flex touch-none select-none transition-colors',
                        props.orientation === 'vertical' &&
                            'h-full w-2.5 border-l border-l-transparent p-[1px]',
                        props.orientation === 'horizontal' &&
                            'h-2.5 flex-col border-t border-t-transparent p-[1px]',
                    ),
                },
                {
                    default: () =>
                        h(ScrollAreaThumb, {
                            class: 'relative flex-1 rounded-full bg-border',
                        }),
                },
            );
    },
});
</script>

