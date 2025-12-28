<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import ClientLayout from "@/layouts/ClientLayout.vue";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Badge } from "@/components/ui/badge";
import { CheckCircle, Package, MapPin, CreditCard, ShoppingBag } from "lucide-vue-next";

interface OrderItem {
    id: number;
    product: {
        id: number;
        name: string;
        image_url?: string;
    };
    quantity: number;
    price: number;
}

interface Order {
    id: number;
    total_amount: number;
    status: string;
    shipping_address: {
        name: string;
        email: string;
        phone: string;
        address: string;
        city: string;
        state: string;
        zip: string;
        country: string;
    };
    created_at: string;
    items: OrderItem[];
}

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const formatPrice = (price: number) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(price);
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>

<template>

    <Head title="Order Confirmation" />

    <ClientLayout>
        <div class="max-w-4xl mx-auto">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div
                    class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/20 flex items-center justify-center mx-auto mb-4">
                    <CheckCircle class="h-10 w-10 text-green-600 dark:text-green-500" />
                </div>
                <h1 class="text-3xl font-bold mb-2">Order Confirmed!</h1>
                <p class="text-muted-foreground">
                    Thank you for your order. We'll send you a confirmation email
                    shortly.
                </p>
            </div>

            <!-- Order Details -->
            <Card class="mb-6">
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <CardTitle>Order Details</CardTitle>
                        <Badge variant="secondary">{{ order.status }}</Badge>
                    </div>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-muted-foreground">Order Number</p>
                            <p class="font-semibold">#{{ order.id }}</p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Order Date</p>
                            <p class="font-semibold">{{ formatDate(order.created_at) }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-muted-foreground">Total Amount</p>
                            <p class="font-semibold text-primary text-lg">
                                {{ formatPrice(order.total_amount) }}
                            </p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Order Items -->
            <Card class="mb-6">
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Package class="h-5 w-5 text-primary" />
                        Order Items
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <div v-for="item in order.items" :key="item.id" class="flex gap-4">
                            <div class="w-16 h-16 rounded-md overflow-hidden bg-muted flex-shrink-0">
                                <img v-if="item.product.image_url" :src="item.product.image_url"
                                    :alt="item.product.name" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <span class="text-2xl text-muted-foreground/20">📦</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ item.product.name }}</p>
                                <p class="text-sm text-muted-foreground">
                                    Quantity: {{ item.quantity }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">
                                    {{ formatPrice(item.price * item.quantity) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Shipping Address -->
            <Card class="mb-6">
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <MapPin class="h-5 w-5 text-primary" />
                        Shipping Address
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-sm space-y-1">
                        <p class="font-semibold">{{ order.shipping_address.name }}</p>
                        <p>{{ order.shipping_address.address }}</p>
                        <p>
                            {{ order.shipping_address.city }},
                            {{ order.shipping_address.state }}
                            {{ order.shipping_address.zip }}
                        </p>
                        <p>{{ order.shipping_address.country }}</p>
                        <p class="text-muted-foreground pt-2">
                            {{ order.shipping_address.email }}
                        </p>
                        <p class="text-muted-foreground">
                            {{ order.shipping_address.phone }}
                        </p>
                    </div>
                </CardContent>
            </Card>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <Link href="/shop">
                    <Button variant="outline" size="lg" class="w-full sm:w-auto">
                        <ShoppingBag class="mr-2 h-5 w-5" />
                        Continue Shopping
                    </Button>
                </Link>
                <Button size="lg" class="w-full sm:w-auto" disabled>
                    <Package class="mr-2 h-5 w-5" />
                    Track Order (Coming Soon)
                </Button>
            </div>
        </div>
    </ClientLayout>
</template>
