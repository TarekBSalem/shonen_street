<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    form.post('/register', {
        onFinish: () => {
            form.password = '';
            form.password_confirmation = '';
        },
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-muted/40 px-4 py-8">
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
                    <h1 class="text-3xl font-bold">Create Account</h1>
                    <p class="text-muted-foreground mt-2">
                        Sign up to start shopping
                    </p>
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="name">Full Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="John Doe"
                            :disabled="form.processing"
                            required
                        />
                        <p v-if="form.errors.name" class="text-sm text-destructive">
                            {{ form.errors.name }}
                        </p>
                    </div>

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

                    <div class="space-y-2">
                        <Label for="password">Password</Label>
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
                        <Label for="password_confirmation">Confirm Password</Label>
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
                        Create Account
                    </Button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <span class="text-muted-foreground">
                        Already have an account?
                    </span>
                    <Link href="/login" class="text-primary hover:underline ml-1">
                        Sign in
                    </Link>
                </div>

                <div class="mt-4 text-center">
                    <Link href="/" class="text-sm text-muted-foreground hover:underline">
                        ← Back to home
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

