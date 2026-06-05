<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const visible = ref(true);

// Re-show whenever a new flash arrives after an Inertia visit.
watch(
    () => [page.props.flash?.success, page.props.flash?.error],
    () => (visible.value = true)
);
</script>

<template>
    <div v-if="visible && (page.props.flash?.success || page.props.flash?.error)" class="hx-flash">
        <div v-if="page.props.flash?.success" class="alert alert-success d-flex align-items-center justify-content-between">
            <span><i class="uil uil-check-circle me-2"></i>{{ page.props.flash.success }}</span>
            <button type="button" class="btn-close-flash" @click="visible = false"><i class="uil uil-times"></i></button>
        </div>
        <div v-if="page.props.flash?.error" class="alert alert-danger d-flex align-items-center justify-content-between">
            <span><i class="uil uil-exclamation-octagon me-2"></i>{{ page.props.flash.error }}</span>
            <button type="button" class="btn-close-flash" @click="visible = false"><i class="uil uil-times"></i></button>
        </div>
    </div>
</template>

<style>
.hx-flash {
    position: fixed;
    top: 80px;
    right: 24px;
    z-index: 2500;
    min-width: 320px;
    max-width: 420px;
}
.hx-flash .alert {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}
.hx-flash .btn-close-flash {
    background: none;
    border: 0;
    opacity: 0.6;
    line-height: 1;
}
.hx-flash .btn-close-flash:hover {
    opacity: 1;
}
</style>
