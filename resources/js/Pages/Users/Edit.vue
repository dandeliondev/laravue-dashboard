<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import UserForm from '@/Pages/Users/Partials/UserForm.vue';

const props = defineProps({
    user: { type: Object, required: true },
    roles: { type: Array, default: () => [] },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role_id: props.user.role_id ?? null,
    verified: props.user.verified,
});

const submit = () => form.put(route('users.update', props.user.id));
</script>

<template>
    <Head :title="`Edit ${user.name}`" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader
                        :title="`Edit User`"
                        :breadcrumbs="[{ label: 'Users', to: route('users.index') }, { label: user.name }]"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 col-xl-8 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0">
                            <h6 class="mb-0">Edit User Details</h6>
                        </div>
                        <div class="card-body">
                            <UserForm :form="form" :roles="roles" is-edit submit-label="Save Changes" @submit="submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
