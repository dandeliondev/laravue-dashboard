<script setup>
import { ref, onMounted, watch } from 'vue';
import AppSidebar from '@/Components/Hexadash/AppSidebar.vue';
import AppHeader from '@/Components/Hexadash/AppHeader.vue';
import FlashMessages from '@/Components/Hexadash/FlashMessages.vue';

const collapsed = ref(false);
const dark = ref(false);

const applyDark = (value) => {
    const body = document.body;
    body.classList.toggle('layout-dark', value);
    body.classList.toggle('layout-light', !value);
};

onMounted(() => {
    // Collapse the sidebar by default on smaller screens.
    collapsed.value = window.innerWidth < 1150;

    dark.value = localStorage.getItem('hexadash-dark') === 'true';
    applyDark(dark.value);
});

watch(dark, (value) => {
    localStorage.setItem('hexadash-dark', String(value));
    applyDark(value);
});

const toggleSidebar = () => (collapsed.value = !collapsed.value);
const toggleDark = () => (dark.value = !dark.value);
</script>

<template>
    <AppHeader :dark="dark" @toggle-sidebar="toggleSidebar" @toggle-dark="toggleDark" />
    <FlashMessages />

    <main class="main-content">
        <AppSidebar :collapsed="collapsed" />

        <div class="contents" :class="{ expanded: collapsed }">
            <slot />
        </div>
    </main>
</template>
