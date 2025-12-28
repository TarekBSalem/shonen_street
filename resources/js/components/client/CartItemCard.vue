<script setup lang="ts">
import { ref } from "vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Trash2, Plus, Minus } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

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

const props = defineProps<{
    item: CartItem;
}>();

const quantity = ref(props.item.quantity);
const isUpdating = ref(false);

const updateQuantity = (newQuantity: number) => {
    if (newQuantity < 1) return;
    if (newQuantity > props.item.product.stock_quantity) return;

    quantity.value = newQuantity;
    isUpdating.value = true;

    router.patch(
        `/cart/${props.item.id}`,
        { quantity: newQuantity },
        {
            preserveScroll: true,
            onFinish: () => {
                isUpdating.value = false;
            },
        }
    );
};

const removeItem = () => {
    router.delete(`/cart/${props.item.id}`, {
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
    <div class="bg-card rounded-lg border border-border p-4 md:p-6 transition-all hover:shadow-md"
        :class="{ 'opacity-50': isUpdating }">
        <div class="flex gap-4">
            <!-- Product Image -->
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-lg overflow-hidden bg-muted flex-shrink-0">
                <img v-if="item.product.image_url" :src="item.product.image_url" :alt="item.product.name"
                    class="w-full h-full object-cover" />
                <div v-else
                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-muted to-muted/50">
                    <span class="text-4xl text-muted-foreground/20">📦</span>
                </div>
            </div>

            <!-- Product Details -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-lg mb-1 line-clamp-2">
                            {{ item.product.name }}
                        </h3>
                        <p class="text-sm text-muted-foreground mb-2">
                            {{ formatPrice(item.price) }} each
                        </p>
                        <p v-if="item.product.stock_quantity < 10" class="text-sm text-orange-500 font-medium">
                            Only {{ item.product.stock_quantity }} left in stock
                        </p>
                    </div>

                    <!-- Mobile Price -->
                    <div class="md:hidden text-right">
                        <p class="font-bold text-lg text-primary">
                            {{ formatPrice(item.total) }}
                        </p>
                    </div>
                </div>

                <!-- Quantity Controls -->
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <Button @click="updateQuantity(quantity - 1)" :disabled="quantity <= 1 || isUpdating"
                            size="icon" variant="outline" class="h-8 w-8">
                            <Minus class="h-4 w-4" />
                        </Button>

                        <Input v-model.number="quantity" @blur="updateQuantity(quantity)" type="number" min="1"
                            :max="item.product.stock_quantity" class="w-16 text-center" :disabled="isUpdating" />

                        <Button @click="updateQuantity(quantity + 1)" :disabled="quantity >= item.product.stock_quantity ||
                            isUpdating
                            " size="icon" variant="outline" class="h-8 w-8">
                            <Plus class="h-4 w-4" />
                        </Button>
                    </div>

                    <!-- Desktop Price -->
                    <div class="hidden md:block flex-1 text-right">
                        <p class="font-bold text-xl text-primary">
                            {{ formatPrice(item.total) }}
                        </p>
                    </div>

                    <!-- Remove Button -->
                    <Button @click="removeItem" variant="ghost" size="icon"
                        class="text-destructive hover:text-destructive hover:bg-destructive/10">
                        <Trash2 class="h-5 w-5" />
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
