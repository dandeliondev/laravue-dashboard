<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

let nextId = 7;
const todos = ref([
    { id: 1, text: 'Review pull request for roles feature', done: false, prio: 'High' },
    { id: 2, text: 'Reply to support ticket #1042', done: false, prio: 'High' },
    { id: 3, text: 'Prepare weekly analytics summary', done: false, prio: 'Medium' },
    { id: 4, text: 'Update project documentation', done: false, prio: 'Low' },
    { id: 5, text: 'Set up demo accounts', done: true, prio: 'Medium' },
    { id: 6, text: 'Deploy theme to staging', done: true, prio: 'High' },
]);

const prioColor = { High: 'danger', Medium: 'warning', Low: 'info' };
const draft = ref('');
const draftPrio = ref('Medium');
const filter = ref('all');

const filtered = computed(() => {
    if (filter.value === 'active') return todos.value.filter((t) => !t.done);
    if (filter.value === 'done') return todos.value.filter((t) => t.done);
    return todos.value;
});
const remaining = computed(() => todos.value.filter((t) => !t.done).length);

const add = () => {
    const text = draft.value.trim();
    if (!text) return;
    todos.value.unshift({ id: nextId++, text, done: false, prio: draftPrio.value });
    draft.value = '';
};
const remove = (t) => (todos.value = todos.value.filter((x) => x.id !== t.id));
const clearDone = () => (todos.value = todos.value.filter((t) => !t.done));
</script>

<template>
    <Head title="To-Do" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><PageHeader title="To-Do List" :breadcrumbs="[{ label: 'To-Do' }]" /></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 mb-25">
                    <div class="card border-0">
                        <div class="card-body">
                            <form class="d-flex gap-2 mb-3" @submit.prevent="add">
                                <input v-model="draft" type="text" class="form-control" placeholder="Add a new task..." />
                                <select v-model="draftPrio" class="form-control form-select" style="max-width: 130px">
                                    <option>High</option><option>Medium</option><option>Low</option>
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="uil uil-plus"></i></button>
                            </form>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="btn-group">
                                    <button v-for="f in ['all','active','done']" :key="f" type="button"
                                        class="btn btn-sm text-capitalize" :class="filter === f ? 'btn-primary' : 'btn-outline-light'"
                                        @click="filter = f">{{ f }}</button>
                                </div>
                                <small class="text-muted">{{ remaining }} remaining</small>
                            </div>

                            <ul class="hx-todos">
                                <li v-for="t in filtered" :key="t.id" :class="{ done: t.done }">
                                    <label class="hx-check">
                                        <input type="checkbox" v-model="t.done" />
                                        <span class="hx-check__box"><i class="uil uil-check"></i></span>
                                    </label>
                                    <span class="hx-todos__text">{{ t.text }}</span>
                                    <span class="badge" :class="`badge-${prioColor[t.prio]}`">{{ t.prio }}</span>
                                    <button class="btn btn-sm btn-link text-danger" @click="remove(t)"><i class="uil uil-trash-alt"></i></button>
                                </li>
                                <li v-if="!filtered.length" class="justify-content-center text-muted py-3">Nothing here.</li>
                            </ul>

                            <div class="text-end mt-2">
                                <button class="btn btn-sm btn-outline-light" @click="clearDone">Clear completed</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-todos { list-style: none; margin: 0; padding: 0; }
.hx-todos li { display: flex; align-items: center; gap: 12px; padding: 12px 4px; border-bottom: 1px solid var(--border-color, #f1f2f6); }
.hx-todos li:last-child { border-bottom: 0; }
.hx-todos__text { flex: 1; }
.hx-todos li.done .hx-todos__text { text-decoration: line-through; color: #9299b8; }
.hx-check { position: relative; display: inline-flex; cursor: pointer; }
.hx-check input { display: none; }
.hx-check__box { width: 22px; height: 22px; border: 2px solid #c6cbe0; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #fff; transition: .15s; }
.hx-check__box i { font-size: 14px; opacity: 0; }
.hx-check input:checked + .hx-check__box { background: #5f63f2; border-color: #5f63f2; }
.hx-check input:checked + .hx-check__box i { opacity: 1; }
</style>
