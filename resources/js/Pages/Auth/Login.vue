<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

// Demo credentials (seeded user) — prefilled so reviewers can sign in with one click.
const form = useForm({
    email: 'test@example.com',
    password: 'password',
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

            <div class="demo-note mt-25">
                <span class="demo-note__title"><i class="uil uil-info-circle"></i> Demo account</span>
                <span class="demo-note__row">Email <code>test@example.com</code></span>
                <span class="demo-note__row">Password <code>password</code></span>
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

<style scoped>
.demo-note {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 14px 16px;
    border-radius: 8px;
    background: rgba(95, 99, 242, 0.07);
    border: 1px solid rgba(95, 99, 242, 0.18);
    font-size: 13px;
}
.demo-note__title {
    font-weight: 600;
    color: var(--color-primary, #5f63f2);
    margin-bottom: 2px;
}
.demo-note__row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #5a5f7d;
}
.demo-note__row code {
    color: #5f63f2;
}
</style>
