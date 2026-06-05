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
    { type: 'title', label: 'Main' },
    { label: 'Dashboard', icon: 'uil-create-dashboard', to: 'dashboard', pattern: 'dashboard' },
    { label: 'Analytics', icon: 'uil-chart-line', to: 'reports.index', pattern: 'reports.*' },

    { type: 'title', label: 'Management' },
    {
        label: 'User Management',
        icon: 'uil-users-alt',
        pattern: 'users.*',
        children: [
            { label: 'All Users', to: 'users.index', pattern: 'users.index' },
            { label: 'Add User', to: 'users.create', pattern: 'users.create' },
        ],
    },
    { label: 'Roles & Permissions', icon: 'uil-shield-check', to: 'roles.index', pattern: 'roles.*' },
    { label: 'Activity Log', icon: 'uil-history', to: 'activity.index', pattern: 'activity.*' },

    { type: 'title', label: 'Apps' },
    { label: 'Calendar', icon: 'uil-calendar-alt', to: 'calendar.index', pattern: 'calendar.*' },
    { label: 'Task Board', icon: 'uil-clipboard-notes', to: 'kanban.index', pattern: 'kanban.*' },
    { label: 'Inbox', icon: 'uil-envelope', to: 'inbox.index', pattern: 'inbox.*' },
    { label: 'Notifications', icon: 'uil-bell', to: 'notifications.index', pattern: 'notifications.*' },

    { type: 'title', label: 'Account' },
    { label: 'Profile Settings', icon: 'uil-user', to: 'profile.edit', pattern: 'profile.edit' },
    { label: 'Settings', icon: 'uil-setting', to: 'settings.edit', pattern: 'settings.*' },
    { label: 'Help / FAQ', icon: 'uil-question-circle', to: 'faq.index', pattern: 'faq.*' },
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
                        <!-- Section title -->
                        <li v-if="item.type === 'title'" class="menu-title mt-20">
                            <span>{{ item.label }}</span>
                        </li>

                        <!-- Leaf item -->
                        <li v-else-if="!item.children" :class="{ active: isActive(item.pattern) }">
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
