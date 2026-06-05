<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: { type: String },
});

const form = useForm({});

const submit = () => form.post(route('verification.send'));

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <GuestLayout title="Verify your email">
        <p class="mb-20 text-muted fs-14">
            Thanks for signing up! Please verify your email by clicking the link we just emailed you. Didn't get it?
            We'll gladly send another.
        </p>

        <div v-if="verificationLinkSent" class="alert alert-success mb-20">
            A new verification link has been sent to your email address.
        </div>

        <form @submit.prevent="submit">
            <div class="admin__button-group button-group d-flex pt-1 justify-content-center">
                <button type="submit" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal" :disabled="form.processing">
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                    Resend verification email
                </button>
            </div>
        </form>

        <template #footer>
            <div class="admin-topbar">
                <p class="mb-0">
                    <Link :href="route('logout')" method="post" as="button" class="color-primary border-0 bg-transparent">Log out</Link>
                </p>
            </div>
        </template>
    </GuestLayout>
</template>
