<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const items = ref([
    { id: 1, icon: 'uil-user-plus', color: 'primary', title: 'New user registered', text: 'Ada Lovelace just created an account.', time: '2 min ago', read: false },
    { id: 2, icon: 'uil-comment-alt-message', color: 'info', title: 'New message', text: 'You have a new message from Gloria Howe.', time: '25 min ago', read: false },
    { id: 3, icon: 'uil-check-circle', color: 'success', title: 'Report ready', text: 'Your weekly analytics report is ready to view.', time: '1 hour ago', read: false },
    { id: 4, icon: 'uil-exclamation-triangle', color: 'warning', title: 'Storage almost full', text: 'You have used 85% of your storage quota.', time: '4 hours ago', read: true },
    { id: 5, icon: 'uil-shield-check', color: 'info', title: 'Security alert', text: 'A new device signed in to your account.', time: 'Yesterday', read: true },
    { id: 6, icon: 'uil-bill', color: 'danger', title: 'Payment failed', text: 'We could not process your subscription payment.', time: '2 days ago', read: true },
]);

const tab = ref('all');
const filtered = computed(() => (tab.value === 'unread' ? items.value.filter((i) => !i.read) : items.value));
const unread = computed(() => items.value.filter((i) => !i.read).length);

const markRead = (n) => (n.read = true);
const markAllRead = () => items.value.forEach((i) => (i.read = true));
</script>

<template>
    <Head title="Notifications" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Notifications" :breadcrumbs="[{ label: 'Notifications' }]" />
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm" :class="tab === 'all' ? 'btn-primary' : 'btn-outline-light'" @click="tab = 'all'">All</button>
                                <button type="button" class="btn btn-sm" :class="tab === 'unread' ? 'btn-primary' : 'btn-outline-light'" @click="tab = 'unread'">
                                    Unread <span v-if="unread" class="badge badge-light ms-1">{{ unread }}</span>
                                </button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" :disabled="!unread" @click="markAllRead">
                                <i class="uil uil-check-circle"></i> Mark all read
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <ul class="hx-notif">
                                <li v-for="n in filtered" :key="n.id" :class="{ unread: !n.read }" @click="markRead(n)">
                                    <span class="hx-notif__icon" :class="`bg-${n.color}`"><i class="uil" :class="n.icon"></i></span>
                                    <div class="hx-notif__body">
                                        <p class="mb-0 fw-500">{{ n.title }}</p>
                                        <small class="text-muted">{{ n.text }}</small>
                                    </div>
                                    <small class="text-muted hx-notif__time">{{ n.time }}</small>
                                </li>
                                <li v-if="!filtered.length" class="justify-content-center text-muted py-4">You're all caught up 🎉</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-notif {
    list-style: none;
    margin: 0;
    padding: 0;
}
.hx-notif li {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border-color, #f1f2f6);
    cursor: pointer;
    transition: background 0.15s;
}
.hx-notif li:hover {
    background: rgba(95, 99, 242, 0.03);
}
.hx-notif li.unread {
    background: rgba(95, 99, 242, 0.05);
}
.hx-notif li:last-child {
    border-bottom: 0;
}
.hx-notif__icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    flex: 0 0 auto;
}
.hx-notif__body {
    flex: 1;
}
.hx-notif__time {
    white-space: nowrap;
}
.bg-primary { background: #5f63f2; }
.bg-info { background: #00aaff; }
.bg-success { background: #01b81a; }
.bg-warning { background: #fa8b0c; }
.bg-danger { background: #ff4d4f; }
</style>
