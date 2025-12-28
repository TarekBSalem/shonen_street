<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { ShoppingCart } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
    image_url?: string;
}

const props = defineProps<{
    product: Product;
}>();

const emit = defineEmits<{
    addToCart: [productId: number];
}>();

const addToCart = () => {
    emit("addToCart", props.product.id);
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(price);
};
</script>

<template>
    <div
        class="group relative bg-card rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-border">
        <!-- Image Container -->
        <div class="relative aspect-square overflow-hidden bg-muted">
            <img v-if="product.image_url" :src="product.image_url" :alt="product.name"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
            <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-muted to-muted/50">
                <span class="text-6xl text-muted-foreground/20">📦</span>
            </div>

            <!-- Stock Badge -->
            <div class="absolute top-3 right-3">
                <Badge v-if="product.stock_quantity === 0" variant="destructive" class="shadow-lg">
                    Out of Stock
                </Badge>
                <Badge v-else-if="product.stock_quantity < 10" variant="secondary"
                    class="shadow-lg bg-orange-500 text-white hover:bg-orange-600">
                    Low Stock
                </Badge>
            </div>

            <!-- Quick Add Overlay -->
            <div
                class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <Button @click="addToCart" :disabled="product.stock_quantity === 0" size="lg"
                    class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <ShoppingCart class="mr-2 h-5 w-5" />
                    Add to Cart
                </Button>
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-5">
            <h3
                class="font-semibold text-lg mb-2 line-clamp-2 min-h-[3.5rem] group-hover:text-primary transition-colors">
                {{ product.name }}
            </h3>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-primary">
                        {{ formatPrice(product.price) }}
                    </p>
                    <p class="text-sm text-muted-foreground mt-1">
                        {{ product.stock_quantity }} in stock
                    </p>
                </div>

                <Button @click="addToCart" :disabled="product.stock_quantity === 0" size="icon" variant="outline"
                    class="md:hidden">
                    <ShoppingCart class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>
