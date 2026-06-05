<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: { type: String, required: true },
    token: { type: String, required: true },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <GuestLayout title="Set a new password">
        <form @submit.prevent="submit">
            <div class="form-group mb-20">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.email }"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="invalid-feedback d-block">{{ form.errors.email }}</div>
            </div>

            <div class="form-group mb-20">
                <label for="password">New Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
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
                    Reset Password
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
