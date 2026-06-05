<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const user = computed(() => usePage().props.auth.user);
const initials = computed(() => {
    const n = (user.value.name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase();
});
</script>

<template>
    <Head title="Profile Settings" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Profile Settings" :breadcrumbs="[{ label: 'Profile' }]" />
                </div>
            </div>

            <div class="row">
                <!-- Summary -->
                <div class="col-lg-4 mb-25">
                    <div class="card border-0 text-center">
                        <div class="card-body">
                            <span class="hexadash-avatar hexadash-avatar--xl mx-auto mb-3">{{ initials }}</span>
                            <h5 class="mb-1">{{ user.name }}</h5>
                            <p class="text-muted mb-0">{{ user.email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Forms -->
                <div class="col-lg-8">
                    <div class="card border-0 mb-25">
                        <div class="card-header border-0">
                            <h6 class="mb-0">Profile Information</h6>
                        </div>
                        <div class="card-body">
                            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                        </div>
                    </div>

                    <div class="card border-0 mb-25">
                        <div class="card-header border-0">
                            <h6 class="mb-0">Update Password</h6>
                        </div>
                        <div class="card-body">
                            <UpdatePasswordForm />
                        </div>
                    </div>

                    <div class="card border-0 mb-25">
                        <div class="card-header border-0">
                            <h6 class="mb-0 text-danger">Danger Zone</h6>
                        </div>
                        <div class="card-body">
                            <DeleteUserForm />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.hexadash-avatar--xl {
    width: 90px;
    height: 90px;
    font-size: 30px;
}
</style>
