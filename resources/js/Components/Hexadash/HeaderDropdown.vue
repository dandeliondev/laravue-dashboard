<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

defineProps({
    wrapperClass: { type: String, default: '' },
});

const open = ref(false);
const root = ref(null);

const toggle = () => (open.value = !open.value);
const close = () => (open.value = false);

const onClickOutside = (e) => {
    if (root.value && !root.value.contains(e.target)) close();
};

onMounted(() => document.addEventListener('click', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside));
</script>

<template>
    <div ref="root" class="dropdown-custom" :class="{ 'is-open': open }">
        <a href="javascript:;" class="nav-item-toggle" @click.prevent="toggle">
            <slot name="toggle" />
        </a>
        <div class="dropdown-parent-wrapper">
            <div class="dropdown-wrapper" :class="wrapperClass" @click="close">
                <slot name="menu" />
            </div>
        </div>
    </div>
</template>

<!-- Theme shows these on :hover; map a reactive class so click + touch work too. -->
<style>
.dropdown-custom.is-open .dropdown-wrapper {
    visibility: visible;
    opacity: 1;
    pointer-events: all;
    transform: scale(1);
}
</style>
