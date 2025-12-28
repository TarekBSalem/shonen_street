<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const status = computed(() => page.props.status as string | undefined);

const form = useForm({
    email: '',
});

const handleSubmit = () => {
    form.post('/forgot-password');
};
</script>

<template>
    <Head title="Forgot Password" />

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
                    <h1 class="text-3xl font-bold">Forgot Password?</h1>
                    <p class="text-muted-foreground mt-2">
                        No problem. Just let us know your email address and we
                        will email you a password reset link.
                    </p>
                </div>

                <Alert v-if="status" class="mb-6">
                    <AlertDescription>
                        {{ status }}
                    </AlertDescription>
                </Alert>

                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="john@example.com"
                            :disabled="form.processing"
                            required
                        />
                        <p v-if="form.errors.email" class="text-sm text-destructive">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <Button
                        type="submit"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        Email Password Reset Link
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

