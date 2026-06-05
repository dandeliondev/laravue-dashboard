<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const props = defineProps({
    user: { type: Object, required: true },
});

const initials = computed(() => {
    const n = (props.user.name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase();
});

const fmt = (iso) =>
    iso ? new Date(iso).toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' }) : '—';
</script>

<template>
    <Head :title="user.name" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="User Profile" :breadcrumbs="[{ label: 'Users', to: route('users.index') }, { label: user.name }]">
                        <template #actions>
                            <Link :href="route('users.edit', user.id)" class="btn btn-primary btn-sm">
                                <i class="uil uil-edit"></i> Edit
                            </Link>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <!-- Identity card -->
                <div class="col-lg-4 mb-25">
                    <div class="card border-0 text-center h-100">
                        <div class="card-body">
                            <span class="hexadash-avatar hexadash-avatar--xl mx-auto mb-3">{{ initials }}</span>
                            <h5 class="mb-1">{{ user.name }}</h5>
                            <p class="text-muted mb-2">{{ user.email }}</p>
                            <span v-if="user.role" class="badge" :class="`badge-${user.role.color}`">{{ user.role.name }}</span>
                            <span v-else class="badge badge-secondary">No role</span>
                            <span class="badge ms-1" :class="user.verified ? 'badge-success' : 'badge-warning'">
                                {{ user.verified ? 'Verified' : 'Unverified' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="col-lg-8 mb-25">
                    <div class="card border-0 mb-25">
                        <div class="card-header border-0"><h6 class="mb-0">Account Details</h6></div>
                        <div class="card-body">
                            <div class="row hx-detail">
                                <div class="col-sm-6 mb-3"><small class="text-muted d-block">Full name</small>{{ user.name }}</div>
                                <div class="col-sm-6 mb-3"><small class="text-muted d-block">Email</small>{{ user.email }}</div>
                                <div class="col-sm-6 mb-3"><small class="text-muted d-block">Role</small>{{ user.role?.name ?? '—' }}</div>
                                <div class="col-sm-6 mb-3"><small class="text-muted d-block">Email verified</small>{{ fmt(user.verified_at) }}</div>
                                <div class="col-sm-6 mb-3"><small class="text-muted d-block">Joined</small>{{ fmt(user.created_at) }}</div>
                                <div class="col-sm-6"><small class="text-muted d-block">Last updated</small>{{ fmt(user.updated_at) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0">
                        <div class="card-header border-0"><h6 class="mb-0">Role Permissions</h6></div>
                        <div class="card-body">
                            <p v-if="user.role" class="text-muted fs-13 mb-3">{{ user.role.description }}</p>
                            <div v-if="user.role && user.role.permissions.length" class="d-flex flex-wrap gap-2">
                                <span v-for="p in user.role.permissions" :key="p" class="badge badge-outline-primary">{{ p }}</span>
                            </div>
                            <p v-else class="text-muted mb-0">No permissions assigned.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-detail .fw,
.hx-detail > div {
    font-weight: 500;
}
.badge-outline-primary {
    border: 1px solid rgba(95, 99, 242, 0.4);
    color: #5f63f2;
    background: rgba(95, 99, 242, 0.06);
}
</style>
