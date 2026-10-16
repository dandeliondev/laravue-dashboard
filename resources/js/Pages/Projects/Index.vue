<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const projects = [
    { id: 1, name: 'Admin Dashboard Revamp', client: 'Internal', status: 'In Progress', color: 'warning', progress: 68, due: 'Jun 30, 2026', team: ['TU', 'AL', 'GH'], tasks: { done: 17, total: 25 } },
    { id: 2, name: 'Mobile App Launch', client: 'Acme Co', status: 'In Progress', color: 'warning', progress: 42, due: 'Jul 15, 2026', team: ['CS', 'VJ'], tasks: { done: 8, total: 19 } },
    { id: 3, name: 'Marketing Website', client: 'Globex', status: 'Completed', color: 'success', progress: 100, due: 'May 20, 2026', team: ['AO', 'DA'], tasks: { done: 22, total: 22 } },
    { id: 4, name: 'API Integration', client: 'Initech', status: 'On Hold', color: 'secondary', progress: 25, due: 'Aug 1, 2026', team: ['OS', 'TU'], tasks: { done: 4, total: 16 } },
    { id: 5, name: 'Data Migration', client: 'Internal', status: 'In Progress', color: 'warning', progress: 80, due: 'Jun 24, 2026', team: ['GH', 'MT'], tasks: { done: 12, total: 15 } },
    { id: 6, name: 'Brand Refresh', client: 'Umbrella', status: 'Planning', color: 'info', progress: 10, due: 'Sep 5, 2026', team: ['AL', 'DA'], tasks: { done: 2, total: 20 } },
];

const filters = ['All', 'In Progress', 'Completed', 'On Hold', 'Planning'];
const active = ref('All');
const selected = ref(null);
const filtered = computed(() => active.value === 'All' ? projects : projects.filter((p) => p.status === active.value));
</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Projects" :breadcrumbs="[{ label: 'Projects' }]">
                        <template #actions>
                            <button class="btn btn-primary btn-sm"><i class="uil uil-plus"></i> New Project</button>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="btn-group mb-3">
                <button v-for="f in filters" :key="f" type="button" class="btn btn-sm"
                    :class="active === f ? 'btn-primary' : 'btn-outline-light'" @click="active = f">{{ f }}</button>
            </div>

            <div class="row">
                <div v-for="p in filtered" :key="p.id" class="col-xxl-4 col-md-6 mb-25">
                    <div class="card border-0 h-100 hx-project" @click="selected = p">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge" :class="`badge-${p.color}`">{{ p.status }}</span>
                                <small class="text-muted"><i class="uil uil-calendar-alt"></i> {{ p.due }}</small>
                            </div>
                            <h6 class="mb-1">{{ p.name }}</h6>
                            <small class="text-muted d-block mb-3">{{ p.client }}</small>
                            <div class="d-flex justify-content-between fs-13 mb-1">
                                <span>Progress</span><span class="fw-600">{{ p.progress }}%</span>
                            </div>
                            <div class="hx-progress mb-3"><span :class="`bg-${p.color}`" :style="{ width: p.progress + '%' }"></span></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="hx-avatars">
                                    <span v-for="t in p.team" :key="t" class="hexadash-avatar hx-mini">{{ t }}</span>
                                </div>
                                <small class="text-muted"><i class="uil uil-check-circle"></i> {{ p.tasks.done }}/{{ p.tasks.total }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <Transition name="hx-fade">
                <div v-if="selected" class="hx-modal-overlay" @click.self="selected = null">
                    <div class="hx-modal-box hx-project-modal text-start">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge mb-2" :class="`badge-${selected.color}`">{{ selected.status }}</span>
                                <h5 class="mb-0">{{ selected.name }}</h5>
                                <small class="text-muted">{{ selected.client }} · due {{ selected.due }}</small>
                            </div>
                            <button class="btn btn-sm btn-outline-light" @click="selected = null"><i class="uil uil-times"></i></button>
                        </div>
                        <div class="d-flex justify-content-between fs-13 mb-1"><span>Progress</span><span class="fw-600">{{ selected.progress }}%</span></div>
                        <div class="hx-progress mb-3"><span :class="`bg-${selected.color}`" :style="{ width: selected.progress + '%' }"></span></div>
                        <div class="row text-center mb-3">
                            <div class="col-4"><div class="fw-600 fs-18">{{ selected.tasks.total }}</div><small class="text-muted">Tasks</small></div>
                            <div class="col-4"><div class="fw-600 fs-18">{{ selected.tasks.done }}</div><small class="text-muted">Done</small></div>
                            <div class="col-4"><div class="fw-600 fs-18">{{ selected.team.length }}</div><small class="text-muted">Members</small></div>
                        </div>
                        <label class="form-label">Team</label>
                        <div class="hx-avatars">
                            <span v-for="t in selected.team" :key="t" class="hexadash-avatar me-1">{{ t }}</span>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-project { cursor: pointer; transition: transform .15s, box-shadow .15s; }
.hx-project:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(146,153,184,.18); }
.hx-progress { height: 6px; background: rgba(146,153,184,.18); border-radius: 4px; overflow: hidden; }
.hx-progress span { display: block; height: 100%; border-radius: 4px; }
.hx-avatars { display: flex; }
.hx-avatars .hexadash-avatar { border: 2px solid #fff; }
.hx-avatars .hx-mini { width: 30px; height: 30px; font-size: 11px; margin-left: -8px; }
.hx-avatars .hx-mini:first-child { margin-left: 0; }
.bg-warning { background: #fa8b0c; } .bg-success { background: #01b81a; } .bg-info { background: #00aaff; } .bg-secondary { background: #a0a0a0; }
.hx-modal-overlay { position: fixed; inset: 0; background: rgba(15,18,38,.5); z-index: 3000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.hx-modal-box { background: #fff; border-radius: 10px; padding: 26px; box-shadow: 0 15px 50px rgba(0,0,0,.25); }
.hx-project-modal { max-width: 460px; width: 100%; }
.hx-fade-enter-active, .hx-fade-leave-active { transition: opacity .2s; }
.hx-fade-enter-from, .hx-fade-leave-to { opacity: 0; }
</style>
