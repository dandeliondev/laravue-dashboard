<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <form @submit.prevent="form.patch(route('profile.update'))">
        <div class="form-group mb-20">
            <label for="name">Name</label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
                required
                autocomplete="name"
            />
            <div v-if="form.errors.name" class="invalid-feedback d-block">{{ form.errors.name }}</div>
        </div>

        <div class="form-group mb-20">
            <label for="email">Email</label>
            <input
                id="email"
                v-model="form.email"
                type="email"
                class="form-control"
                :class="{ 'is-invalid': form.errors.email }"
                required
                autocomplete="username"
            />
            <div v-if="form.errors.email" class="invalid-feedback d-block">{{ form.errors.email }}</div>
        </div>

        <div v-if="mustVerifyEmail && user.email_verified_at === null" class="alert alert-warning">
            Your email address is unverified.
            <Link :href="route('verification.send')" method="post" as="button" class="color-primary border-0 bg-transparent p-0">
                Click here to re-send the verification email.
            </Link>
            <span v-show="status === 'verification-link-sent'" class="d-block mt-1 text-success">
                A new verification link has been sent to your email address.
            </span>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">Save</button>
            <Transition name="hx-fade">
                <span v-if="form.recentlySuccessful" class="text-success fs-13">Saved.</span>
            </Transition>
        </div>
    </form>
</template>

<style>
.hx-fade-enter-active,
.hx-fade-leave-active {
    transition: opacity 0.3s ease;
}
.hx-fade-enter-from,
.hx-fade-leave-to {
    opacity: 0;
}
</style>
