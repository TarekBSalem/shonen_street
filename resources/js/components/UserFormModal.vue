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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

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
}>();

const isEditing = computed(() => !!props.user);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

watch(
    () => props.user,
    (newUser) => {
        if (newUser) {
            form.name = newUser.name;
            form.email = newUser.email;
            form.password = '';
            form.password_confirmation = '';
        } else {
            form.reset();
        }
    },
    { immediate: true },
);

const handleSubmit = () => {
    if (isEditing.value && props.user) {
        form.put(`/admin/users/${props.user.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                emit('update:open', false);
                form.reset();
            },
        });
    } else {
        form.post('/admin/users', {
            preserveScroll: true,
            onSuccess: () => {
                emit('update:open', false);
                form.reset();
            },
        });
    }
};

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);
    if (!value) {
        form.reset();
        form.clearErrors();
    }
};
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>
                    {{ isEditing ? 'Edit User' : 'Create New User' }}
                </DialogTitle>
                <DialogDescription>
                    {{
                        isEditing
                            ? 'Update user information. Leave password blank to keep current password.'
                            : 'Fill in the information to create a new user.'
                    }}
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" type="text" placeholder="John Doe"
                        :disabled="form.processing" />
                    <p v-if="form.errors.name" class="text-sm text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input id="email" v-model="form.email" type="email" placeholder="john@example.com"
                        :disabled="form.processing" />
                    <p v-if="form.errors.email" class="text-sm text-destructive">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="password">
                        Password
                        <span v-if="!isEditing" class="text-destructive">*</span>
                        <span v-else class="text-sm text-muted-foreground">
                            (leave blank to keep current)
                        </span>
                    </Label>
                    <Input id="password" v-model="form.password" type="password" placeholder="••••••••"
                        :disabled="form.processing" />
                    <p v-if="form.errors.password" class="text-sm text-destructive">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation">Confirm Password</Label>
                    <Input id="password_confirmation" v-model="form.password_confirmation" type="password"
                        placeholder="••••••••" :disabled="form.processing" />
                    <p v-if="form.errors.password_confirmation" class="text-sm text-destructive">
                        {{ form.errors.password_confirmation }}
                    </p>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" @click="handleOpenChange(false)"
                        :disabled="form.processing">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ isEditing ? 'Update User' : 'Create User' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
