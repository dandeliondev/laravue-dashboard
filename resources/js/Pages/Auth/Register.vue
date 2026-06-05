<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <GuestLayout title="Create your account">
        <form @submit.prevent="submit">
            <div class="form-group mb-20">
                <label for="name">Full Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.name }"
                    placeholder="Jane Doe"
                    required
                    autofocus
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="invalid-feedback d-block">{{ form.errors.name }}</div>
            </div>

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
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="invalid-feedback d-block">{{ form.errors.email }}</div>
            </div>

            <div class="form-group mb-20">
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    placeholder="Password"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">{{ form.errors.password }}</div>
            </div>

            <div class="form-group mb-20">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                    placeholder="Confirm Password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="admin__button-group button-group d-flex pt-1 justify-content-center">
                <button
                    type="submit"
                    class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                    Create account
                </button>
            </div>
        </form>

        <template #footer>
            <div class="admin-topbar">
                <p class="mb-0">
                    Already have an account?
                    <Link :href="route('login')" class="color-primary">Sign in</Link>
                </p>
            </div>
        </template>
    </GuestLayout>
</template>
