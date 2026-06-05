<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const today = new Date();
const cursor = ref(new Date(today.getFullYear(), today.getMonth(), 1));

const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const monthLabel = computed(() =>
    cursor.value.toLocaleDateString(undefined, { month: 'long', year: 'numeric' })
);

const iso = (y, m, d) => `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

// Demo events keyed by day-of-month for the current cursor month.
const events = computed(() => {
    const y = cursor.value.getFullYear();
    const m = cursor.value.getMonth();
    return {
        [iso(y, m, 3)]: [{ title: 'Team standup', color: 'primary' }],
        [iso(y, m, 8)]: [{ title: 'Product demo', color: 'success' }, { title: 'Design review', color: 'info' }],
        [iso(y, m, 12)]: [{ title: 'Release v1.2', color: 'warning' }],
        [iso(y, m, 18)]: [{ title: '1:1 with Gloria', color: 'info' }],
        [iso(y, m, 25)]: [{ title: 'Sprint planning', color: 'primary' }],
        [iso(y, m, 27)]: [{ title: 'Payroll run', color: 'danger' }],
    };
});

const cells = computed(() => {
    const y = cursor.value.getFullYear();
    const m = cursor.value.getMonth();
    const firstDay = new Date(y, m, 1).getDay();
    const daysInMonth = new Date(y, m + 1, 0).getDate();
    const out = [];
    for (let i = 0; i < firstDay; i++) out.push(null);
    for (let d = 1; d <= daysInMonth; d++) {
        const key = iso(y, m, d);
        out.push({
            day: d,
            key,
            isToday: y === today.getFullYear() && m === today.getMonth() && d === today.getDate(),
            events: events.value[key] || [],
        });
    }
    return out;
});

const go = (delta) => {
    cursor.value = new Date(cursor.value.getFullYear(), cursor.value.getMonth() + delta, 1);
};
const goToday = () => {
    cursor.value = new Date(today.getFullYear(), today.getMonth(), 1);
};
</script>

<template>
    <Head title="Calendar" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Calendar" :breadcrumbs="[{ label: 'Calendar' }]" />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-outline-light" @click="go(-1)"><i class="uil uil-angle-left"></i></button>
                                <h6 class="mb-0" style="min-width: 160px; text-align: center">{{ monthLabel }}</h6>
                                <button class="btn btn-sm btn-outline-light" @click="go(1)"><i class="uil uil-angle-right"></i></button>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" @click="goToday">Today</button>
                        </div>
                        <div class="card-body">
                            <div class="hx-cal">
                                <div class="hx-cal__head" v-for="w in weekdays" :key="w">{{ w }}</div>
                                <div v-for="(cell, i) in cells" :key="i" class="hx-cal__cell" :class="{ empty: !cell, today: cell?.isToday }">
                                    <template v-if="cell">
                                        <span class="hx-cal__day">{{ cell.day }}</span>
                                        <div class="hx-cal__events">
                                            <span v-for="(ev, j) in cell.events" :key="j" class="hx-cal__event" :class="`ev-${ev.color}`">{{ ev.title }}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-cal {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 6px;
}
.hx-cal__head {
    text-align: center;
    font-weight: 600;
    color: #5a5f7d;
    padding: 8px 0;
    font-size: 13px;
}
.hx-cal__cell {
    min-height: 104px;
    border: 1px solid var(--border-color, #f1f2f6);
    border-radius: 8px;
    padding: 8px;
    overflow: hidden;
}
.hx-cal__cell.empty {
    background: rgba(146, 153, 184, 0.04);
    border-style: dashed;
}
.hx-cal__cell.today {
    border-color: #5f63f2;
    box-shadow: inset 0 0 0 1px #5f63f2;
}
.hx-cal__day {
    font-weight: 600;
    font-size: 13px;
}
.hx-cal__events {
    margin-top: 6px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.hx-cal__event {
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 4px;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ev-primary { background: #5f63f2; }
.ev-info { background: #00aaff; }
.ev-success { background: #01b81a; }
.ev-warning { background: #fa8b0c; }
.ev-danger { background: #ff4d4f; }
@media (max-width: 767px) {
    .hx-cal__cell { min-height: 70px; }
    .hx-cal__event { display: none; }
}
</style>
