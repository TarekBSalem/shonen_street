<script setup lang="ts">
import { ref, watch } from "vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Separator } from "@/components/ui/separator";
import { Search, SlidersHorizontal, X } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

interface Filters {
    search?: string;
    min_price?: number;
    max_price?: number;
    in_stock?: boolean;
    sort_by?: string;
    sort_order?: string;
}

interface PriceRange {
    min: number;
    max: number;
}

const props = defineProps<{
    filters: Filters;
    priceRange: PriceRange;
}>();

const search = ref(props.filters.search || "");
const minPrice = ref(props.filters.min_price?.toString() || "");
const maxPrice = ref(props.filters.max_price?.toString() || "");
const inStock = ref(props.filters.in_stock || false);
const sortBy = ref(props.filters.sort_by || "created_at");
const sortOrder = ref(props.filters.sort_order || "desc");

const applyFilters = () => {
    const params: any = {};

    if (search.value) params.search = search.value;
    if (minPrice.value) params.min_price = minPrice.value;
    if (maxPrice.value) params.max_price = maxPrice.value;
    if (inStock.value) params.in_stock = "1";
    if (sortBy.value) params.sort_by = sortBy.value;
    if (sortOrder.value) params.sort_order = sortOrder.value;

    router.get("/shop", params, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    search.value = "";
    minPrice.value = "";
    maxPrice.value = "";
    inStock.value = false;
    sortBy.value = "created_at";
    sortOrder.value = "desc";

    router.get("/shop", {}, {
        preserveState: true,
        preserveScroll: true,
    });
};

const hasActiveFilters = () => {
    return (
        search.value ||
        minPrice.value ||
        maxPrice.value ||
        inStock.value ||
        sortBy.value !== "created_at" ||
        sortOrder.value !== "desc"
    );
};

// Watch for sort changes and apply immediately
watch([sortBy, sortOrder], () => {
    applyFilters();
});
</script>

<template>
    <div class="bg-card rounded-xl shadow-sm border border-border p-6 sticky top-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <SlidersHorizontal class="h-5 w-5 text-primary" />
                <h2 class="text-xl font-bold">Filters</h2>
            </div>
            <Button v-if="hasActiveFilters()" @click="clearFilters" variant="ghost" size="sm"
                class="text-muted-foreground hover:text-foreground">
                <X class="h-4 w-4 mr-1" />
                Clear
            </Button>
        </div>

        <!-- Search -->
        <div class="space-y-4">
            <div class="space-y-2">
                <Label for="search">Search Products</Label>
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input id="search" v-model="search" placeholder="Search by name..." class="pl-10"
                        @keyup.enter="applyFilters" />
                </div>
            </div>

            <Separator />

            <!-- Price Range -->
            <div class="space-y-3">
                <Label>Price Range</Label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <Label for="min_price" class="text-xs text-muted-foreground">Min</Label>
                        <Input id="min_price" v-model="minPrice" type="number" :placeholder="`$${priceRange.min}`"
                            min="0" />
                    </div>
                    <div class="space-y-1">
                        <Label for="max_price" class="text-xs text-muted-foreground">Max</Label>
                        <Input id="max_price" v-model="maxPrice" type="number" :placeholder="`$${priceRange.max}`"
                            min="0" />
                    </div>
                </div>
            </div>

            <Separator />

            <!-- Stock Filter -->
            <div class="flex items-center space-x-2">
                <Checkbox id="in_stock" v-model:checked="inStock" />
                <Label for="in_stock"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer">
                    In Stock Only
                </Label>
            </div>

            <Separator />

            <!-- Sort -->
            <div class="space-y-3">
                <Label>Sort By</Label>
                <Select v-model="sortBy">
                    <SelectTrigger>
                        <SelectValue placeholder="Sort by..." />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="created_at">Newest</SelectItem>
                        <SelectItem value="name">Name</SelectItem>
                        <SelectItem value="price">Price</SelectItem>
                        <SelectItem value="stock_quantity">Stock</SelectItem>
                    </SelectContent>
                </Select>

                <Select v-model="sortOrder">
                    <SelectTrigger>
                        <SelectValue placeholder="Order..." />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="asc">Ascending</SelectItem>
                        <SelectItem value="desc">Descending</SelectItem>
                    </SelectContent>
                </Select>
            </div>

            <!-- Apply Button -->
            <Button @click="applyFilters" class="w-full" size="lg">
                <Search class="mr-2 h-4 w-4" />
                Apply Filters
            </Button>
        </div>
    </div>
</template>
