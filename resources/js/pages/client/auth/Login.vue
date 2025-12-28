<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const handleSubmit = () => {
    form.post('/login', {
        onFinish: () => {
            form.password = '';
        },
    });
};
</script>

<template>
    <Head title="Login" />

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
                    <h1 class="text-3xl font-bold">Welcome Back</h1>
                    <p class="text-muted-foreground mt-2">
                        Sign in to your account to continue
                    </p>
                </div>

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

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="remember"
                                v-model:checked="form.remember"
                                :disabled="form.processing"
                            />
                            <Label
                                for="remember"
                                class="text-sm font-normal cursor-pointer"
                            >
                                Remember me
                            </Label>
                        </div>

                        <Link
                            href="/forgot-password"
                            class="text-sm text-primary hover:underline"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <Button
                        type="submit"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        Sign In
                    </Button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <span class="text-muted-foreground">
                        Don't have an account?
                    </span>
                    <Link
                        href="/register"
                        class="text-primary hover:underline ml-1"
                    >
                        Sign up
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

