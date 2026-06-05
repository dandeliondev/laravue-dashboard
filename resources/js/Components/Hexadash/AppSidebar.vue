<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    collapsed: { type: Boolean, default: false },
});

// Re-evaluate active state whenever Inertia swaps the page.
const page = usePage();
const isActive = (pattern) => {
    void page.url; // reactive dependency
    return route().current(pattern);
};

const menu = [
    { label: 'Dashboard', icon: 'uil-create-dashboard', to: 'dashboard', pattern: 'dashboard' },
    {
        label: 'User Management',
        icon: 'uil-users-alt',
        pattern: 'users.*',
        children: [
            { label: 'All Users', to: 'users.index', pattern: 'users.index' },
            { label: 'Add User', to: 'users.create', pattern: 'users.create' },
        ],
    },
    { label: 'Profile Settings', icon: 'uil-setting', to: 'profile.edit', pattern: 'profile.edit' },
];

const groupActive = (item) => item.children?.some((c) => isActive(c.pattern));

// Track which groups the user has manually toggled; default open follows the active route.
const manual = ref({});
const isOpen = (item) =>
    item.label in manual.value ? manual.value[item.label] : groupActive(item);
const toggleGroup = (item) => (manual.value = { ...manual.value, [item.label]: !isOpen(item) });
</script>

<template>
    <div class="sidebar-wrapper">
        <div class="sidebar" :class="{ collapsed }" id="sidebar">
            <div class="sidebar__menu-group">
                <ul class="sidebar_nav">
                    <template v-for="item in menu" :key="item.label">
                        <!-- Leaf item -->
                        <li v-if="!item.children" :class="{ active: isActive(item.pattern) }">
                            <Link :href="route(item.to)" :class="{ active: isActive(item.pattern) }">
                                <span class="nav-icon uil" :class="item.icon"></span>
                                <span class="menu-text">{{ item.label }}</span>
                            </Link>
                        </li>

                        <!-- Group with children -->
                        <li v-else class="has-child" :class="{ open: isOpen(item) }">
                            <a href="javascript:;" :class="{ active: groupActive(item) }" @click.prevent="toggleGroup(item)">
                                <span class="nav-icon uil" :class="item.icon"></span>
                                <span class="menu-text">{{ item.label }}</span>
                                <span class="toggle-icon"></span>
                            </a>
                            <ul v-show="isOpen(item)">
                                <li v-for="child in item.children" :key="child.label" :class="{ active: isActive(child.pattern) }">
                                    <Link :href="route(child.to)">{{ child.label }}</Link>
                                </li>
                            </ul>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</template>
