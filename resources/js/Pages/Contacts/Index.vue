<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const initials = (n) => { const p = (n || '?').trim().split(/\s+/); return ((p[0]?.[0] || '') + (p[1]?.[0] || '')).toUpperCase(); };
const colors = ['primary', 'info', 'success', 'warning', 'danger', 'secondary'];

const contacts = [
    { id: 1, name: 'Ada Lovelace', role: 'Product Designer', email: 'ada@example.com', phone: '+1 202 555 0140', location: 'London, UK', tag: 'Team' },
    { id: 2, name: 'Gloria Howe', role: 'Data Analyst', email: 'gloria@example.com', phone: '+1 202 555 0177', location: 'New York, US', tag: 'Team' },
    { id: 3, name: 'Colton Spencer', role: 'Frontend Engineer', email: 'colton@example.com', phone: '+1 202 555 0192', location: 'Berlin, DE', tag: 'Team' },
    { id: 4, name: 'Vinnie Johnson', role: 'Project Manager', email: 'vinnie@example.com', phone: '+1 202 555 0118', location: 'Manila, PH', tag: 'Team' },
    { id: 5, name: 'Myrl Thiel', role: 'QA Engineer', email: 'myrl@example.com', phone: '+1 202 555 0133', location: 'Tokyo, JP', tag: 'Vendor' },
    { id: 6, name: 'Alaina Ondricka', role: 'Marketing Lead', email: 'alaina@example.com', phone: '+1 202 555 0166', location: 'Sydney, AU', tag: 'Client' },
    { id: 7, name: 'Otis Stamm', role: 'Backend Engineer', email: 'otis@example.com', phone: '+1 202 555 0155', location: 'Toronto, CA', tag: 'Team' },
    { id: 8, name: 'Dana Botsford', role: 'UX Researcher', email: 'dana@example.com', phone: '+1 202 555 0144', location: 'Paris, FR', tag: 'Client' },
];

const search = ref('');
const selected = ref(null);
const filtered = computed(() => {
    const q = search.value.trim().toLowerCase();
    if (!q) return contacts;
    return contacts.filter((c) => `${c.name} ${c.role} ${c.email}`.toLowerCase().includes(q));
});
</script>

<template>
    <Head title="Contacts" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Contacts" :breadcrumbs="[{ label: 'Contacts' }]">
                        <template #actions>
                            <div class="hx-search-inline">
                                <i class="uil uil-search"></i>
                                <input v-model="search" type="search" class="form-control" placeholder="Search contacts..." />
                            </div>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <div v-for="(c, i) in filtered" :key="c.id" class="col-xxl-3 col-md-4 col-sm-6 mb-25">
                    <div class="card border-0 text-center h-100 hx-contact" @click="selected = c">
                        <div class="card-body">
                            <span class="hexadash-avatar hexadash-avatar--lg mx-auto mb-2" :style="{ background: `var(--color-${colors[i % colors.length]}, #5f63f2)` }">{{ initials(c.name) }}</span>
                            <h6 class="mb-0">{{ c.name }}</h6>
                            <small class="text-muted d-block mb-2">{{ c.role }}</small>
                            <span class="badge" :class="`badge-${colors[i % colors.length]}`">{{ c.tag }}</span>
                            <div class="d-flex justify-content-center gap-3 mt-3 text-muted">
                                <i class="uil uil-envelope"></i>
                                <i class="uil uil-phone"></i>
                                <i class="uil uil-comment-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!filtered.length" class="col-12 text-center text-muted py-5">No contacts found.</div>
            </div>
        </div>

        <!-- Detail drawer -->
        <Teleport to="body">
            <Transition name="hx-drawer">
                <div v-if="selected" class="hx-drawer-overlay" @click.self="selected = null">
                    <div class="hx-drawer">
                        <div class="text-end"><button class="btn btn-sm btn-outline-light" @click="selected = null"><i class="uil uil-times"></i></button></div>
                        <div class="text-center mb-3">
                            <span class="hexadash-avatar hexadash-avatar--xl mx-auto mb-2">{{ initials(selected.name) }}</span>
                            <h5 class="mb-0">{{ selected.name }}</h5>
                            <small class="text-muted">{{ selected.role }}</small>
                        </div>
                        <ul class="hx-detail-list">
                            <li><i class="uil uil-envelope"></i><span>{{ selected.email }}</span></li>
                            <li><i class="uil uil-phone"></i><span>{{ selected.phone }}</span></li>
                            <li><i class="uil uil-map-marker"></i><span>{{ selected.location }}</span></li>
                            <li><i class="uil uil-tag-alt"></i><span>{{ selected.tag }}</span></li>
                        </ul>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-search-inline { position: relative; }
.hx-search-inline i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9299b8; }
.hx-search-inline .form-control { padding-left: 34px; min-width: 220px; }
.hx-contact { cursor: pointer; transition: transform .15s, box-shadow .15s; }
.hx-contact:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(146,153,184,.18); }
.hexadash-avatar--lg { width: 64px; height: 64px; font-size: 20px; }
.hx-drawer-overlay { position: fixed; inset: 0; background: rgba(15,18,38,.45); z-index: 3000; display: flex; justify-content: flex-end; }
.hx-drawer { width: 360px; max-width: 90vw; background: #fff; height: 100%; padding: 20px; overflow-y: auto; }
.hx-detail-list { list-style: none; margin: 0; padding: 0; }
.hx-detail-list li { display: flex; gap: 12px; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border-color, #f1f2f6); }
.hx-detail-list i { color: #5f63f2; }
.hx-drawer-enter-active, .hx-drawer-leave-active { transition: opacity .25s; }
.hx-drawer-enter-active .hx-drawer, .hx-drawer-leave-active .hx-drawer { transition: transform .25s; }
.hx-drawer-enter-from, .hx-drawer-leave-to { opacity: 0; }
.hx-drawer-enter-from .hx-drawer, .hx-drawer-leave-to .hx-drawer { transform: translateX(100%); }
</style>
