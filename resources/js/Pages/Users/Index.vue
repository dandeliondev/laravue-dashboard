<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import Pagination from '@/Components/Hexadash/Pagination.vue';
import ConfirmModal from '@/Components/Hexadash/ConfirmModal.vue';

const props = defineProps({
    users: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

// --- Search (debounced, preserves scroll/state) ---
const search = ref(props.filters.search ?? '');
let timeout = null;
watch(search, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('users.index'), { search: value }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});

// --- Delete flow ---
const deleting = ref(null);
const deleteForm = useForm({});

const confirmDelete = () => {
    deleteForm.delete(route('users.destroy', deleting.value.id), {
        preserveScroll: true,
        onSuccess: () => (deleting.value = null),
    });
};

const initials = (name) => {
    const n = (name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase();
};
const formatDate = (iso) =>
    new Date(iso).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="User Management" :breadcrumbs="[{ label: 'All Users' }]">
                        <template #actions>
                            <Link :href="route('users.create')" class="btn btn-primary btn-sm">
                                <i class="uil uil-plus"></i> Add User
                            </Link>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h6 class="mb-0">Users <span class="text-muted fw-normal">({{ users.total }})</span></h6>
                            <div class="hx-search-box">
                                <i class="uil uil-search"></i>
                                <input v-model="search" type="search" class="form-control" placeholder="Search name or email..." />
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="ps-25">User</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Joined</th>
                                            <th class="text-end pe-25">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="u in users.data" :key="u.id">
                                            <td class="ps-25">
                                                <div class="d-flex align-items-center">
                                                    <span class="hexadash-avatar me-2">{{ initials(u.name) }}</span>
                                                    <Link :href="route('users.show', u.id)" class="fw-500 hx-user-link">{{ u.name }}</Link>
                                                </div>
                                            </td>
                                            <td>{{ u.email }}</td>
                                            <td>
                                                <span v-if="u.role" class="badge" :class="`badge-${u.role.color}`">{{ u.role.name }}</span>
                                                <span v-else class="text-muted">—</span>
                                            </td>
                                            <td>
                                                <span v-if="u.verified" class="badge badge-success">Verified</span>
                                                <span v-else class="badge badge-warning">Unverified</span>
                                            </td>
                                            <td>{{ formatDate(u.created_at) }}</td>
                                            <td class="text-end pe-25">
                                                <Link :href="route('users.show', u.id)" class="btn btn-sm btn-outline-light me-1" title="View">
                                                    <i class="uil uil-eye"></i>
                                                </Link>
                                                <Link :href="route('users.edit', u.id)" class="btn btn-sm btn-outline-light me-1" title="Edit">
                                                    <i class="uil uil-edit"></i>
                                                </Link>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" @click="deleting = u">
                                                    <i class="uil uil-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="!users.data.length">
                                            <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if="users.data.length" class="card-footer border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="text-muted fs-13">Showing {{ users.from }}–{{ users.to }} of {{ users.total }}</span>
                            <Pagination :links="users.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmModal
            :show="!!deleting"
            title="Delete this user?"
            :message="deleting ? `This will permanently remove ${deleting.name}. This action cannot be undone.` : ''"
            :processing="deleteForm.processing"
            @confirm="confirmDelete"
            @cancel="deleting = null"
        />
    </AuthenticatedLayout>
</template>

<style>
.hx-search-box {
    position: relative;
}
.hx-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9299b8;
}
.hx-search-box .form-control {
    padding-left: 38px;
    min-width: 260px;
}
.hx-user-link {
    color: inherit;
}
.hx-user-link:hover {
    color: var(--color-primary, #5f63f2);
}
</style>
