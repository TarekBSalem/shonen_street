<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import ClientLayout from "@/layouts/ClientLayout.vue";
import CartItemCard from "@/components/client/CartItemCard.vue";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { ShoppingCart, ArrowLeft, ShoppingBag } from "lucide-vue-next";

interface CartItem {
    id: number;
    product: {
        id: number;
        name: string;
        price: number;
        stock_quantity: number;
        image_url?: string;
    };
    quantity: number;
    price: number;
    total: number;
}

interface Props {
    cartItems: CartItem[];
    summary: {
        subtotal: number;
        shipping: number;
        total: number;
    };
}

const props = defineProps<Props>();

const formatPrice = (price: number) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(price);
};
</script>

<template>
    <Head title="Shopping Cart" />

    <ClientLayout>
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-3">
                        <ShoppingCart class="h-8 w-8 text-primary" />
                        Shopping Cart
                    </h1>
                    <p class="text-muted-foreground mt-2">
                        {{ cartItems.length }}
                        {{ cartItems.length === 1 ? "item" : "items" }} in your
                        cart
                    </p>
                </div>
                <Link href="/shop">
                    <Button variant="outline">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Continue Shopping
                    </Button>
                </Link>
            </div>

            <!-- Empty Cart -->
            <div
                v-if="cartItems.length === 0"
                class="text-center py-16"
            >
                <div
                    class="w-24 h-24 rounded-full bg-muted flex items-center justify-center mx-auto mb-6"
                >
                    <ShoppingCart class="h-12 w-12 text-muted-foreground" />
                </div>
                <h2 class="text-2xl font-semibold mb-2">Your cart is empty</h2>
                <p class="text-muted-foreground mb-6">
                    Add some awesome products to get started!
                </p>
                <Link href="/shop">
                    <Button size="lg">
                        <ShoppingBag class="mr-2 h-5 w-5" />
                        Browse Products
                    </Button>
                </Link>
            </div>

            <!-- Cart Content -->
            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    <CartItemCard
                        v-for="item in cartItems"
                        :key="item.id"
                        :item="item"
                    />
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <Card class="sticky top-6">
                        <CardHeader>
                            <CardTitle>Order Summary</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-muted-foreground"
                                        >Subtotal</span
                                    >
                                    <span class="font-medium">{{
                                        formatPrice(summary.subtotal)
                                    }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-muted-foreground"
                                        >Shipping</span
                                    >
                                    <span class="font-medium">{{
                                        formatPrice(summary.shipping)
                                    }}</span>
                                </div>
                            </div>

                            <Separator />

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold">Total</span>
                                <span class="text-2xl font-bold text-primary">{{
                                    formatPrice(summary.total)
                                }}</span>
                            </div>

                            <Link href="/checkout">
                                <Button size="lg" class="w-full">
                                    Proceed to Checkout
                                </Button>
                            </Link>

                            <div
                                class="bg-muted rounded-lg p-4 text-sm text-muted-foreground"
                            >
                                <p class="font-medium mb-1">
                                    🔒 Secure Checkout
                                </p>
                                <p>Your payment information is safe with us</p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>

