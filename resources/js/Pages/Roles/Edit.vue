<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import RoleForm from '@/Pages/Roles/Partials/RoleForm.vue';

const props = defineProps({
    role: { type: Object, required: true },
    permissionGroups: { type: Object, required: true },
});

const form = useForm({
    name: props.role.name,
    description: props.role.description ?? '',
    color: props.role.color,
    permissions: [...props.role.permissions],
});

const submit = () => form.put(route('roles.update', props.role.id));
</script>

<template>
    <Head :title="`Edit ${role.name}`" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Edit Role" :breadcrumbs="[{ label: 'Roles', to: route('roles.index') }, { label: role.name }]" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0"><h6 class="mb-0">Edit Role</h6></div>
                        <div class="card-body">
                            <RoleForm :form="form" :permission-groups="permissionGroups" submit-label="Save Changes" @submit="submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
