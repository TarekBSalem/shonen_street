<script setup lang="ts">
import { Head, router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Heading from "@/components/Heading.vue";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Label } from "@/components/ui/label";
import {
    ArrowLeft,
    Package,
    MapPin,
    User,
    Mail,
    Phone,
    Calendar,
} from "lucide-vue-next";
import { useToast } from "@/components/ui/toast/use-toast";

interface OrderItem {
    id: number;
    product: {
        id: number;
        name: string;
        image_url?: string;
    };
    quantity: number;
    price: number;
    total: number;
}

interface Order {
    id: number;
    user: {
        id: number;
        name: string;
        email: string;
    };
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
    updated_at: string;
    items: OrderItem[];
}

interface Props {
    order: Order;
}

const props = defineProps<Props>();
const { toast } = useToast();

const form = useForm({
    status: props.order.status,
});

const updateStatus = () => {
    form.patch(`/admin/orders/${props.order.id}/status`, {
        preserveScroll: true,
        onSuccess: () => {
            toast({
                title: "Status updated",
                description: "Order status has been updated successfully",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to update order status",
                variant: "destructive",
            });
        },
    });
};

const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: "secondary",
        processing: "default",
        shipped: "default",
        delivered: "default",
        cancelled: "destructive",
    };
    return colors[status] || "secondary";
};

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

const canUpdateStatus = () => {
    return !["delivered", "cancelled"].includes(props.order.status);
};
</script>

<template>

    <Head :title="`Order #${order.id}`" />

    <AppLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Button @click="router.visit('/admin/orders')" variant="ghost" size="icon">
                        <ArrowLeft class="h-5 w-5" />
                    </Button>
                    <div>
                        <Heading :title="`Order #${order.id}`"
                            :description="`Placed on ${formatDate(order.created_at)}`" />
                    </div>
                </div>
                <Badge :variant="getStatusColor(order.status)" class="text-lg px-4 py-2">
                    {{ order.status }}
                </Badge>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Package class="h-5 w-5 text-primary" />
                                Order Items
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div v-for="item in order.items" :key="item.id"
                                    class="flex gap-4 p-4 border rounded-lg">
                                    <div class="w-20 h-20 rounded-md overflow-hidden bg-muted flex-shrink-0">
                                        <img v-if="item.product.image_url" :src="item.product.image_url"
                                            :alt="item.product.name" class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full flex items-center justify-center">
                                            <span class="text-3xl text-muted-foreground/20">📦</span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-lg">
                                            {{ item.product.name }}
                                        </p>
                                        <p class="text-sm text-muted-foreground">
                                            {{ formatPrice(item.price) }} × {{ item.quantity }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg">
                                            {{ formatPrice(item.total) }}
                                        </p>
                                    </div>
                                </div>

                                <Separator />

                                <div class="flex justify-end">
                                    <div class="space-y-2 w-64">
                                        <div class="flex justify-between text-lg">
                                            <span class="font-semibold">Total Amount:</span>
                                            <span class="font-bold text-primary">
                                                {{ formatPrice(order.total_amount) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Shipping Address -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <MapPin class="h-5 w-5 text-primary" />
                                Shipping Address
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-muted-foreground">Name</p>
                                    <p class="font-medium">
                                        {{ order.shipping_address.name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Address</p>
                                    <p class="font-medium">
                                        {{ order.shipping_address.address }}
                                    </p>
                                    <p class="font-medium">
                                        {{ order.shipping_address.city }},
                                        {{ order.shipping_address.state }}
                                        {{ order.shipping_address.zip }}
                                    </p>
                                    <p class="font-medium">
                                        {{ order.shipping_address.country }}
                                    </p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-muted-foreground">Email</p>
                                        <p class="font-medium">
                                            {{ order.shipping_address.email }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-foreground">Phone</p>
                                        <p class="font-medium">
                                            {{ order.shipping_address.phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Customer Info -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <User class="h-5 w-5 text-primary" />
                                Customer Information
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div>
                                <p class="text-sm text-muted-foreground">Name</p>
                                <p class="font-medium">{{ order.user.name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Email</p>
                                <p class="font-medium">{{ order.user.email }}</p>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Order Details -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Calendar class="h-5 w-5 text-primary" />
                                Order Details
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div>
                                <p class="text-sm text-muted-foreground">Order ID</p>
                                <p class="font-medium">#{{ order.id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Created</p>
                                <p class="font-medium">{{ formatDate(order.created_at) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Last Updated</p>
                                <p class="font-medium">{{ formatDate(order.updated_at) }}</p>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Update Status -->
                    <Card v-if="canUpdateStatus()">
                        <CardHeader>
                            <CardTitle>Update Status</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="space-y-2">
                                <Label for="status">Order Status</Label>
                                <Select v-model="form.status">
                                    <SelectTrigger id="status">
                                        <SelectValue placeholder="Select status..." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="pending">Pending</SelectItem>
                                        <SelectItem value="processing">Processing</SelectItem>
                                        <SelectItem value="shipped">Shipped</SelectItem>
                                        <SelectItem value="delivered">Delivered</SelectItem>
                                        <SelectItem value="cancelled">Cancelled</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <Button @click="updateStatus" :disabled="form.processing || form.status === order.status"
                                class="w-full">
                                {{ form.processing ? "Updating..." : "Update Status" }}
                            </Button>
                        </CardContent>
                    </Card>

                    <Card v-else>
                        <CardContent class="pt-6">
                            <p class="text-sm text-muted-foreground text-center">
                                This order cannot be updated as it is
                                {{ order.status }}.
                            </p>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
