<script setup>
import { ref, computed, nextTick } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const initials = (name) => {
    const n = (name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase();
};

const conversations = ref([
    { id: 1, name: 'Ada Lovelace', last: 'Sounds great, thanks!', time: '9:41', online: true, unread: 2,
        messages: [
            { me: false, text: 'Hi! Quick question about roles.', time: '9:30' },
            { me: true, text: 'Sure, what do you need?', time: '9:32' },
            { me: false, text: 'Can a user have more than one role?', time: '9:33' },
            { me: true, text: 'Right now it’s one role per user.', time: '9:40' },
            { me: false, text: 'Sounds great, thanks!', time: '9:41' },
        ] },
    { id: 2, name: 'Gloria Howe', last: 'The report is attached.', time: '8:12', online: true, unread: 0,
        messages: [
            { me: false, text: 'Morning! The weekly report is attached.', time: '8:12' },
            { me: true, text: 'Perfect, reviewing now.', time: '8:20' },
        ] },
    { id: 3, name: 'Colton Spencer', last: 'Left a few comments.', time: 'Yesterday', online: false, unread: 0,
        messages: [
            { me: false, text: 'Left a few comments on the settings page.', time: 'Yesterday' },
        ] },
    { id: 4, name: 'Vinnie Johnson', last: 'I’ll prep the backlog.', time: 'Mon', online: false, unread: 0,
        messages: [
            { me: false, text: 'I’ll prep the backlog before Monday.', time: 'Mon' },
        ] },
]);

const activeId = ref(1);
const active = computed(() => conversations.value.find((c) => c.id === activeId.value));
const draft = ref('');
const thread = ref(null);

const select = (c) => {
    activeId.value = c.id;
    c.unread = 0;
};

const send = async () => {
    const text = draft.value.trim();
    if (!text) return;
    active.value.messages.push({ me: true, text, time: 'now' });
    active.value.last = text;
    draft.value = '';
    await nextTick();
    thread.value?.scrollTo({ top: thread.value.scrollHeight, behavior: 'smooth' });
};
</script>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><PageHeader title="Chat" :breadcrumbs="[{ label: 'Chat' }]" /></div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="hx-chat">
                            <!-- conversation list -->
                            <div class="hx-chat__list">
                                <div class="p-3 border-bottom"><strong>Messages</strong></div>
                                <ul>
                                    <li v-for="c in conversations" :key="c.id" :class="{ active: c.id === activeId }" @click="select(c)">
                                        <div class="hx-chat__avatar">
                                            <span class="hexadash-avatar">{{ initials(c.name) }}</span>
                                            <span v-if="c.online" class="hx-chat__online"></span>
                                        </div>
                                        <div class="hx-chat__meta">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-500 text-truncate">{{ c.name }}</span>
                                                <small class="text-muted">{{ c.time }}</small>
                                            </div>
                                            <small class="text-muted text-truncate d-block">{{ c.last }}</small>
                                        </div>
                                        <span v-if="c.unread" class="badge badge-primary rounded-pill">{{ c.unread }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- conversation thread -->
                            <div class="hx-chat__main" v-if="active">
                                <div class="hx-chat__header">
                                    <span class="hexadash-avatar me-2">{{ initials(active.name) }}</span>
                                    <div>
                                        <strong>{{ active.name }}</strong>
                                        <small class="d-block text-muted">{{ active.online ? 'Online' : 'Offline' }}</small>
                                    </div>
                                </div>
                                <div ref="thread" class="hx-chat__thread">
                                    <div v-for="(m, i) in active.messages" :key="i" class="hx-msg" :class="{ me: m.me }">
                                        <div class="hx-msg__bubble">{{ m.text }}<span class="hx-msg__time">{{ m.time }}</span></div>
                                    </div>
                                </div>
                                <form class="hx-chat__input" @submit.prevent="send">
                                    <input v-model="draft" type="text" class="form-control" placeholder="Type a message..." />
                                    <button type="submit" class="btn btn-primary"><i class="uil uil-message"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-chat { display: flex; height: 600px; }
.hx-chat__list { flex: 0 0 320px; border-right: 1px solid var(--border-color, #f1f2f6); overflow-y: auto; }
.hx-chat__list ul { list-style: none; margin: 0; padding: 0; }
.hx-chat__list li { display: flex; gap: 12px; align-items: center; padding: 14px 18px; cursor: pointer; border-bottom: 1px solid var(--border-color, #f1f2f6); }
.hx-chat__list li:hover { background: rgba(95,99,242,.03); }
.hx-chat__list li.active { background: rgba(95,99,242,.07); }
.hx-chat__avatar { position: relative; }
.hx-chat__online { position: absolute; right: 0; bottom: 0; width: 11px; height: 11px; background: #01b81a; border: 2px solid #fff; border-radius: 50%; }
.hx-chat__meta { flex: 1; min-width: 0; }
.hx-chat__main { flex: 1; display: flex; flex-direction: column; }
.hx-chat__header { display: flex; align-items: center; padding: 14px 20px; border-bottom: 1px solid var(--border-color, #f1f2f6); }
.hx-chat__thread { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 10px; background: rgba(146,153,184,.03); }
.hx-msg { display: flex; }
.hx-msg.me { justify-content: flex-end; }
.hx-msg__bubble { max-width: 70%; background: #fff; padding: 10px 14px; border-radius: 10px; box-shadow: 0 3px 10px rgba(146,153,184,.1); position: relative; }
.hx-msg.me .hx-msg__bubble { background: #5f63f2; color: #fff; }
.hx-msg__time { display: block; font-size: 10px; opacity: .6; margin-top: 4px; }
.hx-chat__input { display: flex; gap: 10px; padding: 14px 20px; border-top: 1px solid var(--border-color, #f1f2f6); }
@media (max-width: 991px) { .hx-chat { flex-direction: column; height: auto; } .hx-chat__list { flex-basis: auto; border-right: 0; } .hx-chat__thread { height: 360px; } }
</style>
