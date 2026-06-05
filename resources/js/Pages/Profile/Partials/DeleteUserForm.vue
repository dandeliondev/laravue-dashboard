<script setup>
import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const confirming = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmDeletion = () => {
    confirming.value = true;
    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirming.value = false;
    form.reset();
};
</script>

<template>
    <div>
        <p class="text-muted mb-3">
            Once your account is deleted, all of its resources and data will be permanently removed. This action cannot
            be undone.
        </p>
        <button type="button" class="btn btn-danger px-4" @click="confirmDeletion">Delete Account</button>

        <Teleport to="body">
            <Transition name="hx-modal">
                <div v-if="confirming" class="hx-modal-overlay" @click.self="closeModal">
                    <div class="hx-modal-box" role="dialog" aria-modal="true">
                        <div class="hx-modal-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <h5 class="mb-2">Delete your account?</h5>
                        <p class="text-muted mb-3">
                            Enter your password to confirm you want to permanently delete your account.
                        </p>
                        <div class="form-group mb-3 text-start">
                            <input
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.password }"
                                placeholder="Password"
                                @keyup.enter="deleteUser"
                            />
                            <div v-if="form.errors.password" class="invalid-feedback d-block">{{ form.errors.password }}</div>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light px-4" :disabled="form.processing" @click="closeModal">Cancel</button>
                            <button type="button" class="btn btn-danger px-4" :disabled="form.processing" @click="deleteUser">
                                <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
