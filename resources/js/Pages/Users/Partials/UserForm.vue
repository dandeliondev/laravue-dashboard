<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    form: { type: Object, required: true },
    isEdit: { type: Boolean, default: false },
    submitLabel: { type: String, default: 'Save' },
});

const emit = defineEmits(['submit']);
</script>

<template>
    <form @submit.prevent="emit('submit')">
        <div class="row">
            <div class="col-md-6 mb-25">
                <label class="form-label" for="name">Full Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.name }"
                    placeholder="Jane Doe"
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="invalid-feedback d-block">{{ form.errors.name }}</div>
            </div>

            <div class="col-md-6 mb-25">
                <label class="form-label" for="email">Email Address</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.email }"
                    placeholder="jane@example.com"
                    autocomplete="email"
                />
                <div v-if="form.errors.email" class="invalid-feedback d-block">{{ form.errors.email }}</div>
            </div>

            <div class="col-md-6 mb-25">
                <label class="form-label" for="password">
                    Password <span v-if="isEdit" class="text-muted fs-13">(leave blank to keep current)</span>
                </label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">{{ form.errors.password }}</div>
            </div>

            <div class="col-md-6 mb-25">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                    autocomplete="new-password"
                />
            </div>

            <div class="col-md-12 mb-25">
                <div class="form-check">
                    <input id="verified" v-model="form.verified" type="checkbox" class="form-check-input" />
                    <label class="form-check-label" for="verified">Mark email as verified</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                {{ submitLabel }}
            </button>
            <Link :href="route('users.index')" class="btn btn-light px-4">Cancel</Link>
        </div>
    </form>
</template>
