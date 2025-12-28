<script setup lang="ts">
import ClientHeader from '@/components/client/ClientHeader.vue';
import { Toaster } from '@/components/ui/toast';
</script>

<template>
    <div class="min-h-screen bg-background">
        <ClientHeader />

        <main class="container mx-auto px-4 py-8">
            <slot />
        </main>

        <footer class="border-t mt-auto">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between text-sm text-muted-foreground">
                    <p>&copy; {{ new Date().getFullYear() }} Shonen Street. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-foreground">Terms</a>
                        <a href="#" class="hover:text-foreground">Privacy</a>
                        <a href="#" class="hover:text-foreground">Contact</a>
                    </div>
                </div>
            </div>
        </footer>

        <Toaster />
    </div>
</template>
