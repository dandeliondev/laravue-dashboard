<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import UserForm from '@/Pages/Users/Partials/UserForm.vue';

defineProps({
    roles: { type: Array, default: () => [] },
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: null,
    verified: false,
});

const submit = () => form.post(route('users.store'));
</script>

<template>
    <Head title="Add User" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader
                        title="Add User"
                        :breadcrumbs="[{ label: 'Users', to: route('users.index') }, { label: 'Add User' }]"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 col-xl-8 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0">
                            <h6 class="mb-0">New User Details</h6>
                        </div>
                        <div class="card-body">
                            <UserForm :form="form" :roles="roles" submit-label="Create User" @submit="submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
