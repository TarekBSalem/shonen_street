<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    token: string;
    email: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    form.post('/reset-password', {
        onFinish: () => {
            form.password = '';
            form.password_confirmation = '';
        },
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <div class="min-h-screen flex items-center justify-center bg-muted/40 px-4">
        <div class="w-full max-w-md">
            <div class="bg-background rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-6">
                        <img 
                            src="/assets/logos/logo_header.png" 
                            alt="Shonen Street" 
                            class="h-20 w-auto object-contain"
                        />
                    </div>
                    <h1 class="text-3xl font-bold">Reset Password</h1>
                    <p class="text-muted-foreground mt-2">
                        Enter your new password below
                    </p>
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            :disabled="true"
                            class="bg-muted"
                        />
                        <p v-if="form.errors.email" class="text-sm text-destructive">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="password">New Password</Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            :disabled="form.processing"
                            required
                        />
                        <p
                            v-if="form.errors.password"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="password_confirmation">
                            Confirm New Password
                        </Label>
                        <Input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            :disabled="form.processing"
                            required
                        />
                        <p
                            v-if="form.errors.password_confirmation"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <Button
                        type="submit"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        Reset Password
                    </Button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <Link href="/login" class="text-primary hover:underline">
                        ← Back to login
                    </Link>
                </div>

                <div class="mt-4 text-center">
                    <Link href="/" class="text-sm text-muted-foreground hover:underline">
                        Back to home
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

