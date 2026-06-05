<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <form @submit.prevent="updatePassword">
        <div class="form-group mb-20">
            <label for="current_password">Current Password</label>
            <input
                id="current_password"
                ref="currentPasswordInput"
                v-model="form.current_password"
                type="password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.current_password }"
                autocomplete="current-password"
            />
            <div v-if="form.errors.current_password" class="invalid-feedback d-block">{{ form.errors.current_password }}</div>
        </div>

        <div class="form-group mb-20">
            <label for="password">New Password</label>
            <input
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.password }"
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
                autocomplete="new-password"
            />
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">Save</button>
            <Transition name="hx-fade">
                <span v-if="form.recentlySuccessful" class="text-success fs-13">Saved.</span>
            </Transition>
        </div>
    </form>
</template>
