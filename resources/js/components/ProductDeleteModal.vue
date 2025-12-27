<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { useForm } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
}

const props = defineProps<{
    open: boolean;
    product?: Product | null;
}>();

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
}>();

const form = useForm({});

const handleDelete = () => {
    if (!props.product) return;

    form.delete(`/admin/products/${props.product.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            emit('update:open', false);
        },
    });
};

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);
};
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Delete Product</DialogTitle>
                <DialogDescription>
                    Are you sure you want to delete "{{ product?.name }}"? This
                    action cannot be undone.
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button
                    type="button"
                    variant="outline"
                    @click="handleOpenChange(false)"
                    :disabled="form.processing"
                >
                    Cancel
                </Button>
                <Button
                    type="button"
                    variant="destructive"
                    @click="handleDelete"
                    :disabled="form.processing"
                >
                    Delete
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

