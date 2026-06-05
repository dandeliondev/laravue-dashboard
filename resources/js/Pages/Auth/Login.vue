<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <GuestLayout title="Sign in to Laravue">
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

            <div class="form-group mb-15">
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">{{ form.errors.password }}</div>
            </div>

            <div class="admin-condition d-flex justify-content-between align-items-center mb-20">
                <div class="form-check mb-0">
                    <input id="remember" v-model="form.remember" type="checkbox" class="form-check-input" />
                    <label class="form-check-label" for="remember">Keep me logged in</label>
                </div>
                <Link v-if="canResetPassword" :href="route('password.request')" class="color-primary">Forgot password?</Link>
            </div>

            <div class="admin__button-group button-group d-flex pt-1 justify-content-center">
                <button
                    type="submit"
                    class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                    Sign in
                </button>
            </div>
        </form>

        <template #footer>
            <div class="admin-topbar">
                <p class="mb-0">
                    Don't have an account?
                    <Link :href="route('register')" class="color-primary">Sign up</Link>
                </p>
            </div>
        </template>
    </GuestLayout>
</template>
