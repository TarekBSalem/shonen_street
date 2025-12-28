<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
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
import UserFormModal from '@/components/UserFormModal.vue';
import UserDeleteModal from '@/components/UserDeleteModal.vue';
import { Plus, Pencil, Trash2, Mail, MailCheck } from 'lucide-vue-next';
import type { BreadcrumbItem } from '@/types';

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
}

interface PaginatedUsers {
    data: User[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

interface Props {
    users: PaginatedUsers;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Users Management',
        href: '/admin/users',
    },
];

// Modal states
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedUser = ref<User | null>(null);

const handleCreate = () => {
    selectedUser.value = null;
    showCreateModal.value = true;
};

const handleEdit = (user: User) => {
    selectedUser.value = user;
    showEditModal.value = true;
};

const handleDelete = (user: User) => {
    selectedUser.value = user;
    showDeleteModal.value = true;
};

const handleSuccess = () => {
    router.reload({ only: ['users'] });
};

const handlePageChange = (url: string | null) => {
    if (url) {
        router.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Users Management" />

        <div class="px-4 py-6">
            <div class="mb-6 flex items-center justify-between">
                <Heading title="Users Management" description="Manage regular users (non-admin)" />
                <Button @click="handleCreate">
                    <Plus class="mr-2 h-4 w-4" />
                    Add User
                </Button>
            </div>

            <!-- Users Table -->
            <div class="rounded-lg border bg-card">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Created At</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="users.data.length === 0" class="hover:bg-transparent">
                            <TableCell colspan="5" class="h-24 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <p class="text-muted-foreground">
                                        No users found.
                                    </p>
                                    <Button variant="outline" size="sm" @click="handleCreate">
                                        <Plus class="mr-2 h-4 w-4" />
                                        Create your first user
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>

                        <TableRow v-for="user in users.data" :key="user.id" class="group">
                            <TableCell class="font-medium">
                                {{ user.name }}
                            </TableCell>
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <Mail v-if="!user.email_verified_at" class="h-4 w-4 text-muted-foreground" />
                                    <MailCheck v-else class="h-4 w-4 text-green-600" />
                                    {{ user.email }}
                                </div>
                            </TableCell>
                            <TableCell>
                                <Badge v-if="user.email_verified_at" variant="default"
                                    class="bg-green-100 text-green-800 hover:bg-green-100 dark:bg-green-900 dark:text-green-100">
                                    Verified
                                </Badge>
                                <Badge v-else variant="secondary">
                                    Unverified
                                </Badge>
                            </TableCell>
                            <TableCell class="text-muted-foreground">
                                {{ user.created_at }}
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="icon" @click="handleEdit(user)" title="Edit user">
                                        <Pencil class="h-4 w-4" />
                                    </Button>
                                    <Button variant="ghost" size="icon" @click="handleDelete(user)" title="Delete user"
                                        class="text-destructive hover:text-destructive">
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Pagination -->
                <div v-if="users.last_page > 1" class="flex items-center justify-between border-t px-4 py-3">
                    <div class="text-sm text-muted-foreground">
                        Showing
                        <span class="font-medium">
                            {{ (users.current_page - 1) * users.per_page + 1 }}
                        </span>
                        to
                        <span class="font-medium">
                            {{
                                Math.min(
                                    users.current_page * users.per_page,
                                    users.total,
                                )
                            }}
                        </span>
                        of
                        <span class="font-medium">{{ users.total }}</span>
                        users
                    </div>
                    <div class="flex gap-2">
                        <Button v-for="link in users.links" :key="link.label"
                            :variant="link.active ? 'default' : 'outline'" size="sm" @click="handlePageChange(link.url)"
                            :disabled="!link.url" v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <UserFormModal v-model:open="showCreateModal" @success="handleSuccess" />
        <UserFormModal v-model:open="showEditModal" :user="selectedUser" @success="handleSuccess" />
        <UserDeleteModal v-model:open="showDeleteModal" :user="selectedUser" @success="handleSuccess" />
    </AppLayout>
</template>
