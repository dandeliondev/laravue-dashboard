<script setup>
import { watch, onBeforeUnmount } from 'vue';

const props = defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, default: 'Are you sure?' },
    message: { type: String, default: '' },
    confirmText: { type: String, default: 'Delete' },
    cancelText: { type: String, default: 'Cancel' },
    processing: { type: Boolean, default: false },
});

const emit = defineEmits(['confirm', 'cancel']);

const onKey = (e) => {
    if (e.key === 'Escape') emit('cancel');
};

watch(
    () => props.show,
    (open) => {
        if (open) document.addEventListener('keydown', onKey);
        else document.removeEventListener('keydown', onKey);
    }
);

onBeforeUnmount(() => document.removeEventListener('keydown', onKey));
</script>

<template>
    <Teleport to="body">
        <Transition name="hx-modal">
            <div v-if="show" class="hx-modal-overlay" @click.self="emit('cancel')">
                <div class="hx-modal-box" role="dialog" aria-modal="true">
                    <div class="hx-modal-icon">
                        <i class="uil uil-exclamation-triangle"></i>
                    </div>
                    <h5 class="mb-2">{{ title }}</h5>
                    <p class="text-muted mb-4" v-if="message">{{ message }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-4" :disabled="processing" @click="emit('cancel')">
                            {{ cancelText }}
                        </button>
                        <button type="button" class="btn btn-danger px-4" :disabled="processing" @click="emit('confirm')">
                            <span v-if="processing" class="spinner-border spinner-border-sm me-1"></span>
                            {{ confirmText }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style>
.hx-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 18, 38, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3000;
    padding: 16px;
}
.hx-modal-box {
    background: var(--color-white, #fff);
    border-radius: 10px;
    padding: 32px;
    max-width: 420px;
    width: 100%;
    text-align: center;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
}
.hx-modal-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 77, 79, 0.12);
    color: #ff4d4f;
    font-size: 30px;
}
.hx-modal-enter-active,
.hx-modal-leave-active {
    transition: opacity 0.2s ease;
}
.hx-modal-enter-from,
.hx-modal-leave-to {
    opacity: 0;
}
</style>
