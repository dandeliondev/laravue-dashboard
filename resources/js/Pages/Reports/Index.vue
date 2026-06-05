<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';
import StatCard from '@/Components/Hexadash/StatCard.vue';

const props = defineProps({
    kpis: { type: Object, required: true },
    signups: { type: Object, required: true },
    roleDistribution: { type: Object, required: true },
    verification: { type: Object, required: true },
});

const signupSeries = computed(() => [{ name: 'Sign-ups', data: props.signups.data }]);
const signupOptions = computed(() => ({
    chart: { type: 'bar', toolbar: { show: false }, fontFamily: 'Jost, sans-serif' },
    colors: ['#5f63f2'],
    plotOptions: { bar: { borderRadius: 4, columnWidth: '45%' } },
    dataLabels: { enabled: false },
    grid: { borderColor: 'rgba(146,153,184,0.15)', strokeDashArray: 4 },
    xaxis: { categories: props.signups.labels, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { formatter: (v) => Math.round(v) } },
}));

const roleSeries = computed(() => props.roleDistribution.data);
const roleOptions = computed(() => ({
    chart: { type: 'donut', fontFamily: 'Jost, sans-serif' },
    labels: props.roleDistribution.labels,
    colors: ['#5f63f2', '#01b81a', '#fa8b0c', '#ff4d4f', '#00aaff', '#a0a0a0'],
    legend: { position: 'bottom' },
    stroke: { width: 0 },
}));

const verifSeries = computed(() => [props.verification.verified, props.verification.unverified]);
const verifOptions = {
    chart: { type: 'pie', fontFamily: 'Jost, sans-serif' },
    labels: ['Verified', 'Unverified'],
    colors: ['#01b81a', '#fa8b0c'],
    legend: { position: 'bottom' },
    stroke: { width: 0 },
};
</script>

<template>
    <Head title="Analytics" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Analytics &amp; Reports" :breadcrumbs="[{ label: 'Analytics' }]" />
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3 col-sm-6 mb-25"><StatCard :value="kpis.total" label="Total Users" icon="uil-users-alt" color="primary" /></div>
                <div class="col-xxl-3 col-sm-6 mb-25"><StatCard :value="`${kpis.verifiedRate}%`" label="Verified Rate" icon="uil-check-circle" color="success" /></div>
                <div class="col-xxl-3 col-sm-6 mb-25"><StatCard :value="kpis.roles" label="Active Roles" icon="uil-shield-check" color="info" /></div>
                <div class="col-xxl-3 col-sm-6 mb-25"><StatCard :value="kpis.last30" label="New (30 days)" icon="uil-user-plus" color="warning" /></div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-25">
                    <div class="card border-0 h-100">
                        <div class="card-header border-0"><h6 class="mb-0">Sign-ups by Month</h6></div>
                        <div class="card-body">
                            <apexchart type="bar" height="320" :options="signupOptions" :series="signupSeries" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-25">
                    <div class="card border-0 h-100">
                        <div class="card-header border-0"><h6 class="mb-0">Users by Role</h6></div>
                        <div class="card-body d-flex align-items-center">
                            <apexchart class="w-100" type="donut" height="300" :options="roleOptions" :series="roleSeries" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-25">
                    <div class="card border-0">
                        <div class="card-header border-0"><h6 class="mb-0">Verification</h6></div>
                        <div class="card-body d-flex align-items-center">
                            <apexchart class="w-100" type="pie" height="280" :options="verifOptions" :series="verifSeries" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-25">
                    <div class="card border-0 h-100">
                        <div class="card-header border-0"><h6 class="mb-0">Summary</h6></div>
                        <div class="card-body">
                            <ul class="hx-summary">
                                <li><span>Total users</span><strong>{{ kpis.total }}</strong></li>
                                <li><span>Verified users</span><strong>{{ verification.verified }}</strong></li>
                                <li><span>Unverified users</span><strong>{{ verification.unverified }}</strong></li>
                                <li><span>Verification rate</span><strong>{{ kpis.verifiedRate }}%</strong></li>
                                <li><span>New in last 30 days</span><strong>{{ kpis.last30 }}</strong></li>
                                <li><span>Active roles</span><strong>{{ kpis.roles }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-summary {
    list-style: none;
    margin: 0;
    padding: 0;
}
.hx-summary li {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--border-color, #f1f2f6);
}
.hx-summary li:last-child {
    border-bottom: 0;
}
.hx-summary span {
    color: #5a5f7d;
}
</style>
