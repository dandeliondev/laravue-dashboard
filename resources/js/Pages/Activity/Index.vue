<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

// Demo activity feed (client-side).
const activities = [
    { id: 1, type: 'user', icon: 'uil-user-plus', color: 'primary', title: 'New user registered', who: 'Ada Lovelace', when: '2 minutes ago', day: 'Today' },
    { id: 2, type: 'role', icon: 'uil-shield-check', color: 'info', title: 'Role “Editor” permissions updated', who: 'Test User', when: '1 hour ago', day: 'Today' },
    { id: 3, type: 'settings', icon: 'uil-setting', color: 'warning', title: 'Application settings changed', who: 'Test User', when: '3 hours ago', day: 'Today' },
    { id: 4, type: 'user', icon: 'uil-trash-alt', color: 'danger', title: 'User account deleted', who: 'Test User', when: 'Yesterday, 4:21 PM', day: 'Yesterday' },
    { id: 5, type: 'user', icon: 'uil-check-circle', color: 'success', title: 'Email verified', who: 'Gloria Howe', when: 'Yesterday, 11:02 AM', day: 'Yesterday' },
    { id: 6, type: 'role', icon: 'uil-plus-circle', color: 'primary', title: 'New role “Manager” created', who: 'Test User', when: 'Jun 2, 2026', day: 'Earlier' },
    { id: 7, type: 'settings', icon: 'uil-palette', color: 'info', title: 'Theme switched to dark mode', who: 'Colton Spencer', when: 'Jun 1, 2026', day: 'Earlier' },
];

const filters = ['All', 'user', 'role', 'settings'];
const active = ref('All');
const filtered = computed(() =>
    active.value === 'All' ? activities : activities.filter((a) => a.type === active.value)
);
const days = computed(() => [...new Set(filtered.value.map((a) => a.day))]);
</script>

<template>
    <Head title="Activity Log" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Activity Log" :breadcrumbs="[{ label: 'Activity' }]" />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h6 class="mb-0">Recent Activity</h6>
                            <div class="btn-group">
                                <button v-for="f in filters" :key="f" type="button"
                                    class="btn btn-sm text-capitalize" :class="active === f ? 'btn-primary' : 'btn-outline-light'"
                                    @click="active = f">{{ f }}</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <template v-for="day in days" :key="day">
                                <p class="hx-day-label">{{ day }}</p>
                                <ul class="hx-timeline">
                                    <li v-for="a in filtered.filter((x) => x.day === day)" :key="a.id">
                                        <span class="hx-timeline__dot" :class="`bg-${a.color}`"><i class="uil" :class="a.icon"></i></span>
                                        <div class="hx-timeline__body">
                                            <p class="mb-0 fw-500">{{ a.title }}</p>
                                            <small class="text-muted">by {{ a.who }} · {{ a.when }}</small>
                                        </div>
                                    </li>
                                </ul>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-day-label {
    font-weight: 600;
    color: #5a5f7d;
    margin: 18px 0 12px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.hx-timeline {
    list-style: none;
    margin: 0 0 8px;
    padding: 0;
    position: relative;
}
.hx-timeline li {
    display: flex;
    gap: 14px;
    padding-bottom: 20px;
    position: relative;
}
.hx-timeline li::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 40px;
    bottom: 0;
    width: 2px;
    background: var(--border-color, #f1f2f6);
}
.hx-timeline li:last-child::before {
    display: none;
}
.hx-timeline__dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    flex: 0 0 auto;
    z-index: 1;
}
.bg-primary { background: #5f63f2; }
.bg-info { background: #00aaff; }
.bg-success { background: #01b81a; }
.bg-warning { background: #fa8b0c; }
.bg-danger { background: #ff4d4f; }
</style>
