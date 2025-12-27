<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import ProductFormModal from '@/components/ProductFormModal.vue';
import ProductDeleteModal from '@/components/ProductDeleteModal.vue';
import { Head } from '@inertiajs/vue3';
import { Edit, Plus, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
interface Product {
    id: number;
    name: string;
    image?: string | null;
    price: number;
    stock_quantity: number;
    created_at: string;
}

interface PaginatedProducts {
    data: Product[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

const props = defineProps<{
    products: PaginatedProducts;
}>();

const isFormModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedProduct = ref<Product | null>(null);

const openCreateModal = () => {
    selectedProduct.value = null;
    isFormModalOpen.value = true;
};

const openEditModal = (product: Product) => {
    selectedProduct.value = product;
    isFormModalOpen.value = true;
};

const openDeleteModal = (product: Product) => {
    selectedProduct.value = product;
    isDeleteModalOpen.value = true;
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};

const getStockBadgeVariant = (quantity: number) => {
    if (quantity === 0) return 'destructive';
    if (quantity < 20) return 'default';
    return 'secondary';
};
</script>

<template>
    <AppLayout>

        <Head title="Products Management" />

        <div class="space-y-6 px-4 py-6">
            <div class="flex items-center justify-between">
                <Heading title="Products Management" description="Manage your product catalog" />
                <Button @click="openCreateModal">
                    <Plus class="mr-2 h-4 w-4" />
                    Add Product
                </Button>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Image</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Price</TableHead>
                            <TableHead>Stock</TableHead>
                            <TableHead>Created At</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in props.products.data" :key="product.id">
                            <TableCell>
                                <div
                                    class="w-16 h-16 rounded-md overflow-hidden bg-muted flex items-center justify-center">
                                    <img v-if="product.image" :src="product.image" :alt="product.name"
                                        class="w-full h-full object-cover" />
                                    <span v-else class="text-xs text-muted-foreground">
                                        No image
                                    </span>
                                </div>
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ product.name }}
                            </TableCell>
                            <TableCell>
                                {{ formatPrice(product.price) }}
                            </TableCell>
                            <TableCell>
                                <Badge :variant="getStockBadgeVariant(
                                    product.stock_quantity,
                                )
                                    ">
                                    {{ product.stock_quantity }} units
                                </Badge>
                            </TableCell>
                            <TableCell>
                                {{ product.created_at }}
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="icon" @click="openEditModal(product)">
                                        <Edit class="h-4 w-4" />
                                    </Button>
                                    <Button variant="ghost" size="icon" @click="openDeleteModal(product)">
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div v-if="props.products.last_page > 1" class="flex items-center justify-between">
                <p class="text-sm text-muted-foreground">
                    Showing {{ props.products.data.length }} of
                    {{ props.products.total }} products
                </p>
                <div class="flex gap-2">
                    <Button v-for="page in props.products.last_page" :key="page" :variant="page === props.products.current_page
                        ? 'default'
                        : 'outline'
                        " size="sm" :href="`/admin/products?page=${page}`" as="a">
                        {{ page }}
                    </Button>
                </div>
            </div>
        </div>

        <ProductFormModal v-model:open="isFormModalOpen" :product="selectedProduct" />
        <ProductDeleteModal v-model:open="isDeleteModalOpen" :product="selectedProduct" />
    </AppLayout>
</template>
