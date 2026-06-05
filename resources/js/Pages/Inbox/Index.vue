<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const emails = ref([
    { id: 1, from: 'Ada Lovelace', initials: 'AL', subject: 'Welcome aboard!', preview: 'Thanks for setting up my account. Quick question about…', body: 'Hi there,\n\nThanks for setting up my account. I had a quick question about how roles work — can I be assigned more than one?\n\nBest,\nAda', time: '9:41 AM', read: false, starred: true },
    { id: 2, from: 'Gloria Howe', initials: 'GH', subject: 'Weekly report is ready', preview: 'The analytics summary for this week has been generated…', body: 'Hi,\n\nThe analytics summary for this week has been generated and is attached. Total sign-ups are up 12%.\n\nCheers,\nGloria', time: '8:12 AM', read: false, starred: false },
    { id: 3, from: 'Colton Spencer', initials: 'CS', subject: 'Design review feedback', preview: 'Left a few comments on the new settings page layout…', body: 'Hey,\n\nLeft a few comments on the new settings page layout. Overall looks great — just a couple of spacing tweaks.\n\nColton', time: 'Yesterday', read: true, starred: false },
    { id: 4, from: 'Billing', initials: 'BI', subject: 'Your invoice for June', preview: 'Your monthly invoice is now available to download…', body: 'Hello,\n\nYour monthly invoice is now available to download from your account billing page.\n\nThank you.', time: 'Jun 2', read: true, starred: false },
    { id: 5, from: 'Vinnie Johnson', initials: 'VJ', subject: 'Re: Sprint planning', preview: 'Sounds good, I’ll prepare the backlog before Monday…', body: 'Sounds good — I’ll prepare the backlog before Monday so we can prioritise quickly.\n\nVinnie', time: 'Jun 1', read: true, starred: true },
]);

const selectedId = ref(emails.value[0].id);
const selected = computed(() => emails.value.find((e) => e.id === selectedId.value));
const unread = computed(() => emails.value.filter((e) => !e.read).length);

const open = (e) => {
    selectedId.value = e.id;
    e.read = true;
};
</script>

<template>
    <Head title="Inbox" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Inbox" :breadcrumbs="[{ label: 'Inbox' }]" />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="hx-mail">
                            <!-- List -->
                            <div class="hx-mail__list">
                                <div class="hx-mail__list-head">
                                    <span class="fw-600">Inbox</span>
                                    <span class="badge badge-primary">{{ unread }} new</span>
                                </div>
                                <ul>
                                    <li v-for="e in emails" :key="e.id"
                                        :class="{ active: e.id === selectedId, unread: !e.read }" @click="open(e)">
                                        <span class="hexadash-avatar hx-mini">{{ e.initials }}</span>
                                        <div class="hx-mail__meta">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-500 text-truncate">{{ e.from }}</span>
                                                <small class="text-muted">{{ e.time }}</small>
                                            </div>
                                            <div class="fw-500 text-truncate">{{ e.subject }}</div>
                                            <small class="text-muted text-truncate d-block">{{ e.preview }}</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Reading pane -->
                            <div class="hx-mail__view" v-if="selected">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="hexadash-avatar">{{ selected.initials }}</span>
                                        <div>
                                            <h6 class="mb-0">{{ selected.subject }}</h6>
                                            <small class="text-muted">{{ selected.from }} · {{ selected.time }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-light"><i class="uil uil-corner-up-left-alt"></i></button>
                                        <button class="btn btn-sm btn-outline-light"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                                <p class="hx-mail__body">{{ selected.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-mail {
    display: flex;
    min-height: 540px;
}
.hx-mail__list {
    flex: 0 0 340px;
    border-right: 1px solid var(--border-color, #f1f2f6);
}
.hx-mail__list-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color, #f1f2f6);
}
.hx-mail__list ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
.hx-mail__list li {
    display: flex;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color, #f1f2f6);
    cursor: pointer;
}
.hx-mail__list li:hover {
    background: rgba(95, 99, 242, 0.03);
}
.hx-mail__list li.active {
    background: rgba(95, 99, 242, 0.07);
}
.hx-mail__list li.unread {
    border-left: 3px solid #5f63f2;
}
.hx-mail__meta {
    flex: 1;
    min-width: 0;
}
.hx-mini {
    width: 38px;
    height: 38px;
    font-size: 13px;
}
.hx-mail__view {
    flex: 1;
    padding: 24px;
}
.hx-mail__body {
    white-space: pre-line;
    line-height: 1.8;
    color: #5a5f7d;
}
@media (max-width: 991px) {
    .hx-mail { flex-direction: column; }
    .hx-mail__list { flex-basis: auto; border-right: 0; border-bottom: 1px solid var(--border-color, #f1f2f6); }
}
</style>
