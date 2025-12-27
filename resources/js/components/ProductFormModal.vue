<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { ImagePlus, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

interface Product {
    id: number;
    name: string;
    image?: string | null;
    price: number;
    stock_quantity: number;
}

const props = defineProps<{
    open: boolean;
    product?: Product | null;
}>();

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
}>();

const isEditing = computed(() => !!props.product);
const imagePreview = ref<string | null>(null);
const fileInputRef = ref<HTMLInputElement | null>(null);

const form = useForm({
    name: '',
    image: null as File | null,
    price: 0,
    stock_quantity: 0,
});

watch(
    () => props.product,
    (newProduct) => {
        if (newProduct) {
            form.name = newProduct.name;
            form.price = newProduct.price;
            form.stock_quantity = newProduct.stock_quantity;
            imagePreview.value = newProduct.image || null;
        } else {
            form.reset();
            imagePreview.value = null;
        }
    },
    { immediate: true },
);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = props.product?.image || null;
    if (fileInputRef.value) {
        fileInputRef.value.value = '';
    }
};

const handleSubmit = () => {
    if (isEditing.value && props.product) {
        form.post(`/admin/products/${props.product.id}`, {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                emit('update:open', false);
                form.reset();
                imagePreview.value = null;
            },
            headers: {
                'X-HTTP-Method-Override': 'PUT',
            },
        });
    } else {
        form.post('/admin/products', {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                emit('update:open', false);
                form.reset();
                imagePreview.value = null;
            },
        });
    }
};

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);
    if (!value) {
        form.reset();
        form.clearErrors();
        imagePreview.value = null;
    }
};
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>
                    {{ isEditing ? 'Edit Product' : 'Create Product' }}
                </DialogTitle>
                <DialogDescription>
                    {{
                        isEditing
                            ? 'Update the product information below.'
                            : 'Add a new product to the catalog.'
                    }}
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="name">Product Name</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Enter product name"
                        :disabled="form.processing"
                    />
                    <p v-if="form.errors.name" class="text-sm text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="image">Product Image</Label>
                    <div class="space-y-2">
                        <div
                            v-if="imagePreview"
                            class="relative w-full h-48 rounded-lg border overflow-hidden"
                        >
                            <img
                                :src="imagePreview"
                                alt="Product preview"
                                class="w-full h-full object-cover"
                            />
                            <Button
                                type="button"
                                variant="destructive"
                                size="icon"
                                class="absolute top-2 right-2"
                                @click="removeImage"
                                :disabled="form.processing"
                            >
                                <X class="h-4 w-4" />
                            </Button>
                        </div>
                        <div
                            v-else
                            class="flex items-center justify-center w-full h-48 border-2 border-dashed rounded-lg hover:border-primary/50 transition-colors"
                        >
                            <label
                                for="image"
                                class="flex flex-col items-center justify-center cursor-pointer"
                            >
                                <ImagePlus class="h-12 w-12 text-muted-foreground mb-2" />
                                <span class="text-sm text-muted-foreground">
                                    Click to upload image
                                </span>
                            </label>
                        </div>
                        <Input
                            id="image"
                            ref="fileInputRef"
                            type="file"
                            accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                            class="hidden"
                            @change="handleImageChange"
                            :disabled="form.processing"
                        />
                    </div>
                    <p v-if="form.errors.image" class="text-sm text-destructive">
                        {{ form.errors.image }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="price">Price</Label>
                    <Input
                        id="price"
                        v-model="form.price"
                        type="number"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        :disabled="form.processing"
                    />
                    <p v-if="form.errors.price" class="text-sm text-destructive">
                        {{ form.errors.price }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="stock_quantity">Stock Quantity</Label>
                    <Input
                        id="stock_quantity"
                        v-model="form.stock_quantity"
                        type="number"
                        min="0"
                        placeholder="0"
                        :disabled="form.processing"
                    />
                    <p
                        v-if="form.errors.stock_quantity"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.stock_quantity }}
                    </p>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        @click="handleOpenChange(false)"
                        :disabled="form.processing"
                    >
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ isEditing ? 'Update' : 'Create' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

