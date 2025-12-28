<script setup lang="ts">
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ShoppingCart, User, LogOut } from 'lucide-vue-next';

const page = usePage();
const cartCount = computed(() => page.props.cartCount || 0);

const handleLogout = () => {
    router.post('/logout');
};
</script>

<template>
    <header
        class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <Link href="/shop" class="flex items-center">
                    <img src="/assets/logos/logo_header.png" alt="Shonen Street" class="h-12 w-auto object-contain" />
                </Link>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <Link href="/shop" class="text-sm font-medium transition-colors hover:text-primary">
                        Shop
                    </Link>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-2">
                    <!-- Shopping Cart -->
                    <Link href="/cart">
                        <Button variant="ghost" size="icon" class="relative">
                            <ShoppingCart class="h-5 w-5" />
                            <span
                                v-if="cartCount > 0"
                                class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-primary text-[10px] font-medium text-primary-foreground flex items-center justify-center">
                                {{ cartCount > 9 ? '9+' : cartCount }}
                            </span>
                        </Button>
                    </Link>

                    <!-- User Menu -->
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="ghost" size="icon">
                                <User class="h-5 w-5" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <DropdownMenuLabel>
                                <div class="flex flex-col space-y-1">
                                    <p class="text-sm font-medium">
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                    <p class="text-xs text-muted-foreground">
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                </div>
                            </DropdownMenuLabel>
                            <DropdownMenuSeparator />
                            <DropdownMenuItem @click="handleLogout" class="cursor-pointer">
                                <LogOut class="mr-2 h-4 w-4" />
                                <span>Logout</span>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>
    </header>
</template>
