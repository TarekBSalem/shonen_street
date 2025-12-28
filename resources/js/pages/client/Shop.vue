<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import ClientLayout from "@/layouts/ClientLayout.vue";
import ProductCard from "@/components/client/ProductCard.vue";
import FilterCard from "@/components/client/FilterCard.vue";
import { Button } from "@/components/ui/button";
import { ChevronLeft, ChevronRight, Package } from "lucide-vue-next";
import { useToast } from "@/components/ui/toast/use-toast";

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
    image_url?: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    products: {
        data: Product[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: PaginationLink[];
    };
    filters: {
        search?: string;
        min_price?: number;
        max_price?: number;
        in_stock?: boolean;
        sort_by?: string;
        sort_order?: string;
    };
    priceRange: {
        min: number;
        max: number;
    };
}

const props = defineProps<Props>();
const { toast } = useToast();

const addToCart = (productId: number) => {
    router.post(
        "/cart/add",
        { product_id: productId, quantity: 1 },
        {
            preserveScroll: true,
            onSuccess: () => {
                toast({
                    title: "Added to cart",
                    description: "Product has been added to your cart",
                });
            },
            onError: () => {
                toast({
                    title: "Error",
                    description: "Failed to add product to cart",
                    variant: "destructive",
                });
            },
        }
    );
};

const goToPage = (url: string | null) => {
    if (url) {
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    }
};
</script>

<template>

    <Head title="Shop" />

    <ClientLayout>
        <div class="space-y-8">
            <!-- Hero Section -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-500 via-red-600 to-orange-500 p-8 md:p-12 text-white shadow-2xl">
                <div class="relative z-10">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Shonen Street Shop
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-2xl">
                        Discover the best manga collection and exclusive
                        merchandise. Your next adventure starts here!
                    </p>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-48 -mb-48"></div>
            </div>

            <!-- Products Count -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Package class="h-5 w-5 text-muted-foreground" />
                    <p class="text-sm text-muted-foreground">
                        Showing
                        <span class="font-semibold text-foreground">{{
                            products.data.length
                            }}</span>
                        of
                        <span class="font-semibold text-foreground">{{
                            products.total
                            }}</span>
                        products
                    </p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <FilterCard :filters="filters" :price-range="priceRange" />
                </div>

                <!-- Products Grid -->
                <div class="lg:col-span-3">
                    <div v-if="products.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <ProductCard v-for="product in products.data" :key="product.id" :product="product"
                            @add-to-cart="addToCart" />
                    </div>

                    <!-- Empty State -->
                    <div v-else class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-24 h-24 rounded-full bg-muted flex items-center justify-center mb-6">
                            <Package class="h-12 w-12 text-muted-foreground" />
                        </div>
                        <h3 class="text-2xl font-semibold mb-2">
                            No products found
                        </h3>
                        <p class="text-muted-foreground mb-6 max-w-md">
                            We couldn't find any products matching your filters.
                            Try adjusting your search criteria.
                        </p>
                        <Button @click="
                            router.get('/shop', {}, { preserveScroll: true })
                            " variant="outline">
                            Clear Filters
                        </Button>
                    </div>

                    <!-- Pagination -->
                    <div v-if="products.last_page > 1" class="flex items-center justify-center gap-2 mt-8">
                        <Button @click="
                            goToPage(
                                products.links.find((l) => l.label === '&laquo; Previous')
                                    ?.url
                            )
                            " :disabled="products.current_page === 1" variant="outline" size="icon">
                            <ChevronLeft class="h-4 w-4" />
                        </Button>

                        <div class="flex items-center gap-2">
                            <template v-for="(link, index) in products.links" :key="index">
                                <Button v-if="
                                    link.label !== '&laquo; Previous' &&
                                    link.label !== 'Next &raquo;'
                                " @click="goToPage(link.url)" :variant="link.active ? 'default' : 'outline'"
                                    size="icon" class="min-w-10">
                                    {{ link.label }}
                                </Button>
                            </template>
                        </div>

                        <Button @click="
                            goToPage(
                                products.links.find((l) => l.label === 'Next &raquo;')
                                    ?.url
                            )
                            " :disabled="products.current_page === products.last_page" variant="outline" size="icon">
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>
