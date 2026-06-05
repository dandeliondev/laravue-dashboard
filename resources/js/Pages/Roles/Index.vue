<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import ConfirmModal from '@/Components/Hexadash/ConfirmModal.vue';

defineProps({
    roles: { type: Array, required: true },
    totalPermissions: { type: Number, default: 0 },
});

const deleting = ref(null);
const deleteForm = useForm({});
const confirmDelete = () => {
    deleteForm.delete(route('roles.destroy', deleting.value.id), {
        preserveScroll: true,
        onSuccess: () => (deleting.value = null),
    });
};
</script>

<template>
    <Head title="Roles & Permissions" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Roles & Permissions" :breadcrumbs="[{ label: 'Roles' }]">
                        <template #actions>
                            <Link :href="route('roles.create')" class="btn btn-primary btn-sm">
                                <i class="uil uil-plus"></i> Add Role
                            </Link>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <div v-for="role in roles" :key="role.id" class="col-xxl-3 col-md-6 mb-25">
                    <div class="card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge" :class="`badge-${role.color}`">{{ role.name }}</span>
                                <div class="dropdown-no-js d-flex gap-1">
                                    <Link :href="route('roles.edit', role.id)" class="btn btn-sm btn-outline-light" title="Edit">
                                        <i class="uil uil-edit"></i>
                                    </Link>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" @click="deleting = role">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="text-muted fs-13 mb-3" style="min-height: 38px">{{ role.description }}</p>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <div>
                                    <div class="fw-600 fs-18">{{ role.users_count }}</div>
                                    <small class="text-muted">Users</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-600 fs-18">{{ role.permissions_count }}<span class="text-muted fs-13">/{{ totalPermissions }}</span></div>
                                    <small class="text-muted">Permissions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmModal
            :show="!!deleting"
            title="Delete this role?"
            :message="deleting ? `Remove the “${deleting.name}” role? Users keep their accounts but lose this role.` : ''"
            :processing="deleteForm.processing"
            @confirm="confirmDelete"
            @cancel="deleting = null"
        />
    </AuthenticatedLayout>
</template>
