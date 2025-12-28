<script setup lang="ts">
import { dashboard, login } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingBag, Sparkles, Zap, Shield } from 'lucide-vue-next';
</script>

<template>

    <Head title="Welcome to Shonen Street" />

    <div class="min-h-screen bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50">
        <!-- Navigation -->
        <header class="absolute top-0 left-0 right-0 z-50">
            <nav class="container mx-auto px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="/assets/logos/logo_header.png" alt="Shonen Street"
                            class="h-16 w-auto object-contain" />
                    </div>
                    <div class="flex items-center gap-3">
                        <template v-if="$page.props.auth.user">
                            <Link v-if="$page.props.auth.user.is_admin" :href="dashboard()"
                                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-lg hover:from-red-700 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Dashboard
                            </Link>
                            <Link v-else href="/shop"
                                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-lg hover:from-red-700 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Shop Now
                            </Link>
                        </template>
                        <template v-else>
                            <Link href="/login"
                                class="px-6 py-2.5 text-gray-700 font-medium hover:text-red-600 transition-colors duration-300">
                                Login
                            </Link>
                            <Link href="/register"
                                class="px-6 py-2.5 bg-white text-gray-800 font-semibold rounded-lg hover:bg-gray-50 transition-all duration-300 shadow-md hover:shadow-lg border border-gray-200">
                                Register
                            </Link>
                            <Link :href="login()"
                                class="px-6 py-2.5 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold rounded-lg hover:from-gray-900 hover:to-black transition-all duration-300 shadow-lg hover:shadow-xl">
                                Admin
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="container mx-auto px-6 pt-32 pb-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full shadow-md">
                        <Sparkles class="w-5 h-5 text-orange-500" />
                        <span class="text-sm font-semibold text-gray-700">Your Ultimate Manga Destination</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 leading-tight">
                        Welcome to
                        <span
                            class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent">
                            Shonen Street
                        </span>
                    </h1>

                    <p class="text-xl text-gray-600 leading-relaxed">
                        Dive into the world of epic adventures! Discover the latest manga volumes, exclusive editions,
                        and rare
                        collectibles.
                        From classic shonen heroes to modern masterpieces, we've got everything a true manga fan needs.
                    </p>

                    <!-- Features -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <ShoppingBag class="w-5 h-5 text-red-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Vast Collection</h3>
                                <p class="text-sm text-gray-600">Thousands of manga titles at your fingertips</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <Zap class="w-5 h-5 text-orange-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Fast Delivery</h3>
                                <p class="text-sm text-gray-600">Get your manga delivered in record time</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <Shield class="w-5 h-5 text-yellow-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Secure Payment</h3>
                                <p class="text-sm text-gray-600">Shop with confidence and peace of mind</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                <Sparkles class="w-5 h-5 text-pink-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Exclusive Deals</h3>
                                <p class="text-sm text-gray-600">Special offers for manga enthusiasts</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 pt-4">
                        <template v-if="$page.props.auth.user">
                            <Link href="/shop"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 text-white font-bold rounded-xl hover:from-red-700 hover:via-orange-700 hover:to-yellow-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                <ShoppingBag class="w-5 h-5" />
                                Start Shopping
                            </Link>
                        </template>
                        <template v-else>
                            <Link href="/register"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 text-white font-bold rounded-xl hover:from-red-700 hover:via-orange-700 hover:to-yellow-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                <Sparkles class="w-5 h-5" />
                                Get Started Free
                            </Link>
                            <Link href="/shop"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-gray-800 font-bold rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-200">
                                <ShoppingBag class="w-5 h-5" />
                                Browse Collection
                            </Link>
                        </template>
                    </div>
                </div>

                <!-- Right Content - Logo Showcase -->
                <div class="relative">
                    <div class="relative z-10 flex items-center justify-center">
                        <div class="relative">
                            <!-- Animated Background Circles -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="w-96 h-96 bg-gradient-to-r from-red-400 to-orange-400 rounded-full opacity-20 blur-3xl animate-pulse">
                                </div>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center animation-delay-1000">
                                <div
                                    class="w-80 h-80 bg-gradient-to-r from-yellow-400 to-red-400 rounded-full opacity-20 blur-3xl animate-pulse">
                                </div>
                            </div>

                            <!-- Main Logo -->
                            <div class="relative bg-white rounded-3xl p-12 shadow-2xl">
                                <img src="/assets/logos/logo.png" alt="Shonen Street Logo"
                                    class="w-full h-auto object-contain animate-float" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white rounded-xl shadow-md">
                    <div
                        class="text-4xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent mb-2">
                        1000+</div>
                    <div class="text-gray-600 font-medium">Manga Titles</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-md">
                    <div
                        class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-yellow-600 bg-clip-text text-transparent mb-2">
                        500+</div>
                    <div class="text-gray-600 font-medium">Happy Customers</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-md">
                    <div
                        class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-red-600 bg-clip-text text-transparent mb-2">
                        24/7</div>
                    <div class="text-gray-600 font-medium">Support</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-md">
                    <div
                        class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        100%</div>
                    <div class="text-gray-600 font-medium">Authentic</div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="container mx-auto px-6 py-8 border-t border-gray-200">
            <div class="text-center text-gray-600">
                <p>&copy; {{ new Date().getFullYear() }} Shonen Street. All rights reserved. Built with ❤️ for manga
                    fans.</p>
            </div>
        </footer>
    </div>

</template>
    <style scoped>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }
    </style>