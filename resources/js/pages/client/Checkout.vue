<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import ClientLayout from "@/layouts/ClientLayout.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { ShoppingBag, MapPin } from "lucide-vue-next";

interface CartItem {
    id: number;
    product: {
        id: number;
        name: string;
        price: number;
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
    user: {
        name: string;
        email: string;
    };
}

const props = defineProps<Props>();

const form = useForm({
    // Shipping Information
    shipping_name: props.user.name,
    shipping_email: props.user.email,
    shipping_phone: "",
    shipping_address: "",
    shipping_city: "",
    shipping_state: "",
    shipping_zip: "",
    shipping_country: "United States",
});

const submit = () => {
    form.post("/checkout", {
        preserveScroll: true,
    });
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(price);
};
</script>

<template>

    <Head title="Checkout" />

    <ClientLayout>
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <ShoppingBag class="h-8 w-8 text-primary" />
                    Checkout
                </h1>
                <p class="text-muted-foreground mt-2">
                    Complete your order securely
                </p>
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Information -->
                        <Card>
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2">
                                    <MapPin class="h-5 w-5 text-primary" />
                                    Shipping Information
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <Label for="shipping_name">Full Name *</Label>
                                        <Input id="shipping_name" v-model="form.shipping_name" placeholder="John Doe"
                                            required />
                                        <span v-if="form.errors.shipping_name" class="text-sm text-destructive">{{
                                            form.errors.shipping_name }}</span>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="shipping_email">Email *</Label>
                                        <Input id="shipping_email" v-model="form.shipping_email" type="email"
                                            placeholder="john@example.com" required />
                                        <span v-if="form.errors.shipping_email" class="text-sm text-destructive">{{
                                            form.errors.shipping_email }}</span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="shipping_phone">Phone *</Label>
                                    <Input id="shipping_phone" v-model="form.shipping_phone" type="tel"
                                        placeholder="+1 (555) 123-4567" required />
                                    <span v-if="form.errors.shipping_phone" class="text-sm text-destructive">{{
                                        form.errors.shipping_phone }}</span>
                                </div>

                                <div class="space-y-2">
                                    <Label for="shipping_address">Address *</Label>
                                    <Input id="shipping_address" v-model="form.shipping_address"
                                        placeholder="123 Main St, Apt 4B" required />
                                    <span v-if="form.errors.shipping_address" class="text-sm text-destructive">{{
                                        form.errors.shipping_address }}</span>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div class="space-y-2">
                                        <Label for="shipping_city">City *</Label>
                                        <Input id="shipping_city" v-model="form.shipping_city" placeholder="New York"
                                            required />
                                        <span v-if="form.errors.shipping_city" class="text-sm text-destructive">{{
                                            form.errors.shipping_city }}</span>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="shipping_state">State *</Label>
                                        <Input id="shipping_state" v-model="form.shipping_state" placeholder="NY"
                                            required />
                                        <span v-if="form.errors.shipping_state" class="text-sm text-destructive">{{
                                            form.errors.shipping_state }}</span>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="shipping_zip">ZIP Code *</Label>
                                        <Input id="shipping_zip" v-model="form.shipping_zip" placeholder="10001"
                                            required />
                                        <span v-if="form.errors.shipping_zip" class="text-sm text-destructive">{{
                                            form.errors.shipping_zip }}</span>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <Card class="sticky top-6">
                            <CardHeader>
                                <CardTitle>Order Summary</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <!-- Cart Items -->
                                <div class="space-y-3 max-h-64 overflow-y-auto">
                                    <div v-for="item in cartItems" :key="item.id" class="flex gap-3">
                                        <div class="w-16 h-16 rounded-md overflow-hidden bg-muted flex-shrink-0">
                                            <img v-if="item.product.image_url" :src="item.product.image_url"
                                                :alt="item.product.name" class="w-full h-full object-cover" />
                                            <div v-else class="w-full h-full flex items-center justify-center">
                                                <span class="text-2xl text-muted-foreground/20">📦</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium line-clamp-2">
                                                {{ item.product.name }}
                                            </p>
                                            <p class="text-xs text-muted-foreground">
                                                Qty: {{ item.quantity }}
                                            </p>
                                            <p class="text-sm font-semibold">
                                                {{ formatPrice(item.total) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <Separator />

                                <!-- Price Breakdown -->
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-muted-foreground">Subtotal</span>
                                        <span class="font-medium">{{
                                            formatPrice(summary.subtotal)
                                            }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-muted-foreground">Shipping</span>
                                        <span class="font-medium">{{
                                            formatPrice(summary.shipping)
                                            }}</span>
                                    </div>
                                </div>

                                <Separator />

                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-2xl font-bold text-primary">{{ formatPrice(summary.total)
                                        }}</span>
                                </div>

                                <Button type="submit" size="lg" class="w-full" :disabled="form.processing">
                                    <ShoppingBag class="mr-2 h-5 w-5" />
                                    {{
                                        form.processing
                                            ? "Processing..."
                                            : "Place Order"
                                    }}
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </form>
        </div>
    </ClientLayout>
</template>
