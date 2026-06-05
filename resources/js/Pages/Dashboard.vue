<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import StatCard from '@/Components/Hexadash/StatCard.vue';

const props = defineProps({
    stats: { type: Object, required: true },
    signups: { type: Object, required: true },
    recentUsers: { type: Array, default: () => [] },
});

const signupSeries = computed(() => [
    { name: 'New users', data: props.signups.data },
]);

const signupOptions = computed(() => ({
    chart: { type: 'area', toolbar: { show: false }, fontFamily: 'Jost, sans-serif' },
    colors: ['#5f63f2'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 3 },
    fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] },
    },
    grid: { borderColor: 'rgba(146,153,184,0.15)', strokeDashArray: 4 },
    xaxis: {
        categories: props.signups.labels,
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    yaxis: { labels: { formatter: (v) => Math.round(v) } },
    tooltip: { y: { formatter: (v) => `${v} users` } },
}));

const verifiedSeries = computed(() => [props.stats.verified, props.stats.unverified]);
const verifiedOptions = {
    chart: { type: 'donut', fontFamily: 'Jost, sans-serif' },
    labels: ['Verified', 'Unverified'],
    colors: ['#01b81a', '#fa8b0c'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: true },
    stroke: { width: 0 },
};

const formatDate = (iso) =>
    new Date(iso).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });

const initials = (name) => {
    const n = (name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase();
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Dashboard" :breadcrumbs="[{ label: 'Overview' }]" />
                </div>
            </div>

            <!-- Stat cards -->
            <div class="row">
                <div class="col-xxl-3 col-sm-6 mb-25">
                    <StatCard :value="stats.total" label="Total Users" icon="uil-users-alt" color="primary" />
                </div>
                <div class="col-xxl-3 col-sm-6 mb-25">
                    <StatCard :value="stats.verified" label="Verified Users" icon="uil-check-circle" color="success" />
                </div>
                <div class="col-xxl-3 col-sm-6 mb-25">
                    <StatCard :value="stats.unverified" label="Unverified" icon="uil-exclamation-circle" color="warning" />
                </div>
                <div class="col-xxl-3 col-sm-6 mb-25">
                    <StatCard
                        :value="stats.newThisMonth"
                        label="New This Month"
                        icon="uil-user-plus"
                        color="info"
                        :change="`${Math.abs(stats.growth)}%`"
                        :trend="stats.growth < 0 ? 'down' : 'up'"
                    />
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-lg-8 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">User Sign-ups</h6>
                            <span class="text-muted fs-13">Last 6 months</span>
                        </div>
                        <div class="card-body">
                            <apexchart type="area" height="320" :options="signupOptions" :series="signupSeries" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-25">
                    <div class="card border-0 h-100">
                        <div class="card-header border-0">
                            <h6 class="mb-0">Verification Status</h6>
                        </div>
                        <div class="card-body d-flex align-items-center">
                            <apexchart class="w-100" type="donut" height="300" :options="verifiedOptions" :series="verifiedSeries" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent users -->
            <div class="row">
                <div class="col-lg-12 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Recently Joined</h6>
                            <Link :href="route('users.index')" class="btn btn-sm btn-outline-primary">View all</Link>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-25">User</th>
                                            <th>Email</th>
                                            <th class="text-end pe-25">Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="u in recentUsers" :key="u.id">
                                            <td class="ps-25">
                                                <div class="d-flex align-items-center">
                                                    <span class="hexadash-avatar me-2">{{ initials(u.name) }}</span>
                                                    <span class="fw-500">{{ u.name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ u.email }}</td>
                                            <td class="text-end pe-25">{{ formatDate(u.created_at) }}</td>
                                        </tr>
                                        <tr v-if="!recentUsers.length">
                                            <td colspan="3" class="text-center py-4 text-muted">No users yet.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
