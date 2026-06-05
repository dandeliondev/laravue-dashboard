<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Confirm Password" />

    <GuestLayout title="Confirm your password">
        <p class="mb-20 text-muted fs-14">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

        <form @submit.prevent="submit">
            <div class="form-group mb-20">
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">{{ form.errors.password }}</div>
            </div>

            <div class="admin__button-group button-group d-flex pt-1 justify-content-center">
                <button type="submit" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal" :disabled="form.processing">
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                    Confirm
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
