<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Heading from "@/components/Heading.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Search, Eye, Package, ChevronLeft, ChevronRight } from "lucide-vue-next";
import { ref, watch } from "vue";

interface Order {
    id: number;
    user: {
        id: number;
        name: string;
        email: string;
    };
    total_amount: number;
    status: string;
    items_count: number;
    created_at: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    orders: {
        data: Order[];
        current_page: number;
        last_page: number;
        links: PaginationLink[];
    };
    filters: {
        status?: string;
        search?: string;
        sort_by?: string;
        sort_order?: string;
    };
    statusCounts: {
        all: number;
        pending: number;
        processing: number;
        shipped: number;
        delivered: number;
        cancelled: number;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || "");
const selectedStatus = ref(props.filters.status || "all");

const applyFilters = () => {
    const params: any = {};
    if (search.value) params.search = search.value;
    if (selectedStatus.value && selectedStatus.value !== "all")
        params.status = selectedStatus.value;

    router.get("/admin/orders", params, {
        preserveState: true,
        preserveScroll: true,
    });
};

watch(selectedStatus, () => {
    applyFilters();
});

const goToPage = (url: string | null) => {
    if (url) {
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    }
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
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>

<template>

    <Head title="Orders Management" />

    <AppLayout>
        <Heading title="Orders Management" description="Manage and track all customer orders" />

        <div class="space-y-6">
            <!-- Status Filters -->
            <div class="flex gap-2 overflow-x-auto pb-2">
                <Button @click="selectedStatus = 'all'" :variant="selectedStatus === 'all' ? 'default' : 'outline'"
                    size="sm">
                    All ({{ statusCounts.all }})
                </Button>
                <Button @click="selectedStatus = 'pending'"
                    :variant="selectedStatus === 'pending' ? 'default' : 'outline'" size="sm">
                    Pending ({{ statusCounts.pending }})
                </Button>
                <Button @click="selectedStatus = 'processing'" :variant="selectedStatus === 'processing' ? 'default' : 'outline'
                    " size="sm">
                    Processing ({{ statusCounts.processing }})
                </Button>
                <Button @click="selectedStatus = 'shipped'"
                    :variant="selectedStatus === 'shipped' ? 'default' : 'outline'" size="sm">
                    Shipped ({{ statusCounts.shipped }})
                </Button>
                <Button @click="selectedStatus = 'delivered'" :variant="selectedStatus === 'delivered' ? 'default' : 'outline'
                    " size="sm">
                    Delivered ({{ statusCounts.delivered }})
                </Button>
                <Button @click="selectedStatus = 'cancelled'" :variant="selectedStatus === 'cancelled' ? 'default' : 'outline'
                    " size="sm">
                    Cancelled ({{ statusCounts.cancelled }})
                </Button>
            </div>

            <!-- Search -->
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input v-model="search" placeholder="Search by order ID or customer name..." class="pl-10"
                        @keyup.enter="applyFilters" />
                </div>
                <Button @click="applyFilters">
                    <Search class="mr-2 h-4 w-4" />
                    Search
                </Button>
            </div>

            <!-- Orders Table -->
            <div class="border rounded-lg">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Order ID</TableHead>
                            <TableHead>Customer</TableHead>
                            <TableHead>Items</TableHead>
                            <TableHead>Total</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="order in orders.data" :key="order.id">
                            <TableCell class="font-medium">
                                #{{ order.id }}
                            </TableCell>
                            <TableCell>
                                <div>
                                    <p class="font-medium">{{ order.user.name }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ order.user.email }}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <Package class="h-4 w-4 text-muted-foreground" />
                                    {{ order.items_count }}
                                </div>
                            </TableCell>
                            <TableCell class="font-semibold">
                                {{ formatPrice(order.total_amount) }}
                            </TableCell>
                            <TableCell>
                                <Badge :variant="getStatusColor(order.status)">
                                    {{ order.status }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-sm text-muted-foreground">
                                {{ formatDate(order.created_at) }}
                            </TableCell>
                            <TableCell class="text-right">
                                <Button @click="
                                    router.visit(`/admin/orders/${order.id}`)
                                    " variant="ghost" size="sm">
                                    <Eye class="h-4 w-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="orders.data.length === 0">
                            <TableCell colspan="7" class="text-center py-8">
                                <p class="text-muted-foreground">No orders found</p>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!-- Pagination -->
            <div v-if="orders.last_page > 1" class="flex items-center justify-center gap-2">
                <Button @click="
                    goToPage(
                        orders.links.find((l) => l.label === '&laquo; Previous')
                            ?.url
                    )
                    " :disabled="orders.current_page === 1" variant="outline" size="icon">
                    <ChevronLeft class="h-4 w-4" />
                </Button>

                <div class="flex items-center gap-2">
                    <template v-for="(link, index) in orders.links" :key="index">
                        <Button v-if="
                            link.label !== '&laquo; Previous' &&
                            link.label !== 'Next &raquo;'
                        " @click="goToPage(link.url)" :variant="link.active ? 'default' : 'outline'" size="icon"
                            class="min-w-10">
                            {{ link.label }}
                        </Button>
                    </template>
                </div>

                <Button @click="
                    goToPage(
                        orders.links.find((l) => l.label === 'Next &raquo;')?.url
                    )
                    " :disabled="orders.current_page === orders.last_page" variant="outline" size="icon">
                    <ChevronRight class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
