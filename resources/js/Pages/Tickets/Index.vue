<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const statusColor = { Open: 'success', Pending: 'warning', Closed: 'secondary' };
const prioColor = { High: 'danger', Medium: 'warning', Low: 'info' };

const tickets = ref([
    { id: 1042, subject: 'Cannot reset my password', requester: 'Ada Lovelace', status: 'Open', priority: 'High', updated: '10 min ago', body: 'I keep getting an error when trying to reset my password from the login screen.' },
    { id: 1041, subject: 'Invoice amount looks incorrect', requester: 'Gloria Howe', status: 'Pending', priority: 'Medium', updated: '1 hour ago', body: 'The total on my June invoice doesn’t match the plan I’m on.' },
    { id: 1040, subject: 'Feature request: dark mode for emails', requester: 'Colton Spencer', status: 'Open', priority: 'Low', updated: '3 hours ago', body: 'Would love a dark theme option for the email notifications too.' },
    { id: 1039, subject: 'Export to CSV fails for large lists', requester: 'Vinnie Johnson', status: 'Open', priority: 'High', updated: 'Yesterday', body: 'When I export more than ~5,000 users the download never starts.' },
    { id: 1038, subject: 'Thanks for the quick fix!', requester: 'Myrl Thiel', status: 'Closed', priority: 'Low', updated: '2 days ago', body: 'Just wanted to say the latest update resolved my issue. Appreciate it.' },
    { id: 1037, subject: 'Two-factor auth not sending codes', requester: 'Alaina Ondricka', status: 'Pending', priority: 'High', updated: '3 days ago', body: 'I’m not receiving the 2FA codes by email when signing in.' },
]);

const filters = ['All', 'Open', 'Pending', 'Closed'];
const active = ref('All');
const selected = ref(null);
const filtered = computed(() => active.value === 'All' ? tickets.value : tickets.value.filter((t) => t.status === active.value));
const counts = (s) => (s === 'All' ? tickets.value.length : tickets.value.filter((t) => t.status === s).length);
</script>

<template>
    <Head title="Support Tickets" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Support Tickets" :breadcrumbs="[{ label: 'Tickets' }]">
                        <template #actions>
                            <button class="btn btn-primary btn-sm"><i class="uil uil-plus"></i> New Ticket</button>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0">
                            <div class="btn-group">
                                <button v-for="f in filters" :key="f" type="button" class="btn btn-sm"
                                    :class="active === f ? 'btn-primary' : 'btn-outline-light'" @click="active = f">
                                    {{ f }} <span class="badge badge-light ms-1">{{ counts(f) }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr><th class="ps-25">#</th><th>Subject</th><th>Requester</th><th>Priority</th><th>Status</th><th>Updated</th></tr>
                                </thead>
                                <tbody>
                                    <tr v-for="t in filtered" :key="t.id" class="hx-row" @click="selected = t">
                                        <td class="ps-25 text-muted">#{{ t.id }}</td>
                                        <td class="fw-500">{{ t.subject }}</td>
                                        <td>{{ t.requester }}</td>
                                        <td><span class="badge" :class="`badge-${prioColor[t.priority]}`">{{ t.priority }}</span></td>
                                        <td><span class="badge" :class="`badge-${statusColor[t.status]}`">{{ t.status }}</span></td>
                                        <td class="text-muted">{{ t.updated }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <Transition name="hx-fade">
                <div v-if="selected" class="hx-modal-overlay" @click.self="selected = null">
                    <div class="hx-modal-box text-start" style="max-width: 520px; width: 100%">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <small class="text-muted">Ticket #{{ selected.id }}</small>
                                <h5 class="mb-0">{{ selected.subject }}</h5>
                            </div>
                            <button class="btn btn-sm btn-outline-light" @click="selected = null"><i class="uil uil-times"></i></button>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge" :class="`badge-${statusColor[selected.status]}`">{{ selected.status }}</span>
                            <span class="badge" :class="`badge-${prioColor[selected.priority]}`">{{ selected.priority }} priority</span>
                        </div>
                        <p class="text-muted mb-2"><i class="uil uil-user"></i> {{ selected.requester }} · {{ selected.updated }}</p>
                        <p class="hx-ticket-body">{{ selected.body }}</p>
                        <div class="d-flex gap-2 mt-3">
                            <input type="text" class="form-control" placeholder="Write a reply..." />
                            <button class="btn btn-primary"><i class="uil uil-message"></i></button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-row { cursor: pointer; }
.hx-row:hover { background: rgba(95,99,242,.03); }
.hx-modal-overlay { position: fixed; inset: 0; background: rgba(15,18,38,.5); z-index: 3000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.hx-modal-box { background: #fff; border-radius: 10px; padding: 26px; box-shadow: 0 15px 50px rgba(0,0,0,.25); }
.hx-ticket-body { background: rgba(146,153,184,.06); border-radius: 8px; padding: 14px; line-height: 1.8; color: #5a5f7d; }
.hx-fade-enter-active, .hx-fade-leave-active { transition: opacity .2s; }
.hx-fade-enter-from, .hx-fade-leave-to { opacity: 0; }
</style>
