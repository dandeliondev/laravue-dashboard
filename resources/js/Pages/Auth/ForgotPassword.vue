<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: { type: String },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <GuestLayout title="Reset your password">
        <p class="mb-20 text-muted fs-14">
            Forgot your password? No problem. Enter your email address and we'll send you a reset link.
        </p>

        <div v-if="status" class="alert alert-success mb-20">{{ status }}</div>

        <form @submit.prevent="submit">
            <div class="form-group mb-20">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.email }"
                    placeholder="name@example.com"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="invalid-feedback d-block">{{ form.errors.email }}</div>
            </div>

            <div class="admin__button-group button-group d-flex pt-1 justify-content-center">
                <button
                    type="submit"
                    class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                    Email password reset link
                </button>
            </div>
        </form>

        <template #footer>
            <div class="admin-topbar">
                <p class="mb-0">
                    Remembered it?
                    <Link :href="route('login')" class="color-primary">Back to sign in</Link>
                </p>
            </div>
        </template>
    </GuestLayout>
</template>
