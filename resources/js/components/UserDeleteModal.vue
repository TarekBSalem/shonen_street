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
import { Form } from '@inertiajs/vue3';
import { Spinner } from '@/components/ui/spinner';
import { AlertTriangle } from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
    email: string;
}

interface Props {
    open: boolean;
    user?: User | null;
}

const props = withDefaults(defineProps<Props>(), {
    user: null,
});

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
    (e: 'success'): void;
}>();

const handleClose = () => {
    emit('update:open', false);
};

const handleSuccess = () => {
    emit('success');
    handleClose();
};
</script>

<template>
    <Dialog :open="open" @update:open="handleClose">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-destructive/10"
                    >
                        <AlertTriangle class="h-5 w-5 text-destructive" />
                    </div>
                    <DialogTitle>Delete User</DialogTitle>
                </div>
                <DialogDescription class="pt-2">
                    Are you sure you want to delete
                    <span class="font-semibold text-foreground">{{
                        user?.name
                    }}</span>
                    ({{ user?.email }})?
                    <br />
                    <span class="text-destructive">
                        This action cannot be undone.
                    </span>
                </DialogDescription>
            </DialogHeader>

            <Form
                v-if="user"
                :action="`/admin/users/${user.id}`"
                method="delete"
                @success="handleSuccess"
                v-slot="{ processing }"
            >
                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        @click="handleClose"
                        :disabled="processing"
                    >
                        Cancel
                    </Button>
                    <Button
                        type="submit"
                        variant="destructive"
                        :disabled="processing"
                    >
                        <Spinner v-if="processing" class="mr-2" />
                        Delete User
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>

