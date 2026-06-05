<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const columns = ref([
    {
        key: 'backlog', title: 'Backlog', color: 'secondary', cards: [
            { id: 1, title: 'Research competitor dashboards', tag: 'Research', tagColor: 'info', who: 'AL' },
            { id: 2, title: 'Define analytics requirements', tag: 'Planning', tagColor: 'primary', who: 'TU' },
        ],
    },
    {
        key: 'todo', title: 'To Do', color: 'primary', cards: [
            { id: 3, title: 'Build settings page', tag: 'Feature', tagColor: 'success', who: 'GH' },
            { id: 4, title: 'Write role permission tests', tag: 'QA', tagColor: 'warning', who: 'CS' },
        ],
    },
    {
        key: 'progress', title: 'In Progress', color: 'warning', cards: [
            { id: 5, title: 'Implement user CRUD', tag: 'Feature', tagColor: 'success', who: 'TU' },
        ],
    },
    {
        key: 'done', title: 'Done', color: 'success', cards: [
            { id: 6, title: 'Set up Hexadash theme', tag: 'Setup', tagColor: 'info', who: 'TU' },
            { id: 7, title: 'Seed demo users', tag: 'Data', tagColor: 'primary', who: 'AL' },
        ],
    },
]);

const dragged = ref(null);

const onDragStart = (colKey, card) => (dragged.value = { colKey, card });
const onDrop = (targetKey) => {
    if (!dragged.value) return;
    const { colKey, card } = dragged.value;
    if (colKey === targetKey) return (dragged.value = null);
    const from = columns.value.find((c) => c.key === colKey);
    const to = columns.value.find((c) => c.key === targetKey);
    from.cards = from.cards.filter((c) => c.id !== card.id);
    to.cards.push(card);
    dragged.value = null;
};
</script>

<template>
    <Head title="Task Board" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Task Board" :breadcrumbs="[{ label: 'Task Board' }]" />
                </div>
            </div>

            <p class="text-muted fs-13 mb-3"><i class="uil uil-info-circle"></i> Drag cards between columns to update their status.</p>

            <div class="hx-board">
                <div v-for="col in columns" :key="col.key" class="hx-board__col"
                    @dragover.prevent @drop="onDrop(col.key)">
                    <div class="hx-board__head">
                        <span class="d-flex align-items-center gap-2">
                            <span class="hx-dot" :class="`bg-${col.color}`"></span>{{ col.title }}
                        </span>
                        <span class="badge badge-light">{{ col.cards.length }}</span>
                    </div>
                    <div class="hx-board__cards">
                        <div v-for="card in col.cards" :key="card.id" class="hx-card" draggable="true"
                            @dragstart="onDragStart(col.key, card)">
                            <span class="badge mb-2" :class="`badge-${card.tagColor}`">{{ card.tag }}</span>
                            <p class="mb-2 fw-500">{{ card.title }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="hexadash-avatar hx-mini">{{ card.who }}</span>
                                <i class="uil uil-bars text-muted"></i>
                            </div>
                        </div>
                        <p v-if="!col.cards.length" class="text-muted fs-13 text-center py-3 mb-0">Drop cards here</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-board {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 10px;
}
.hx-board__col {
    flex: 0 0 290px;
    background: rgba(146, 153, 184, 0.05);
    border-radius: 10px;
    padding: 14px;
}
.hx-board__head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    margin-bottom: 14px;
}
.hx-board__cards {
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-height: 60px;
}
.hx-card {
    background: var(--color-white, #fff);
    border-radius: 8px;
    padding: 14px;
    box-shadow: 0 5px 15px rgba(146, 153, 184, 0.08);
    cursor: grab;
}
.hx-card:active {
    cursor: grabbing;
}
.hx-mini {
    width: 28px;
    height: 28px;
    font-size: 11px;
}
.hx-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.bg-primary { background: #5f63f2; }
.bg-secondary { background: #a0a0a0; }
.bg-warning { background: #fa8b0c; }
.bg-success { background: #01b81a; }
</style>
