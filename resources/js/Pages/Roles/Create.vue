<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import RoleForm from '@/Pages/Roles/Partials/RoleForm.vue';

defineProps({
    permissionGroups: { type: Object, required: true },
});

const form = useForm({
    name: '',
    description: '',
    color: 'primary',
    permissions: [],
});

const submit = () => form.post(route('roles.store'));
</script>

<template>
    <Head title="Add Role" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Add Role" :breadcrumbs="[{ label: 'Roles', to: route('roles.index') }, { label: 'Add Role' }]" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0"><h6 class="mb-0">New Role</h6></div>
                        <div class="card-body">
                            <RoleForm :form="form" :permission-groups="permissionGroups" submit-label="Create Role" @submit="submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
