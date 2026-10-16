<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const yearly = ref(false);

const plans = [
    { name: 'Starter', monthly: 0, featured: false, blurb: 'For individuals getting started',
        features: ['1 project', 'Up to 3 users', 'Community support', '1 GB storage'] },
    { name: 'Pro', monthly: 29, featured: true, blurb: 'For growing teams',
        features: ['Unlimited projects', 'Up to 25 users', 'Priority support', '50 GB storage', 'Advanced analytics'] },
    { name: 'Enterprise', monthly: 99, featured: false, blurb: 'For large organizations',
        features: ['Everything in Pro', 'Unlimited users', 'Dedicated manager', '1 TB storage', 'SSO & audit logs'] },
];

const price = (m) => (yearly.value ? Math.round(m * 12 * 0.8) : m);
const period = computed(() => (yearly.value ? '/year' : '/month'));
</script>

<template>
    <Head title="Pricing" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><PageHeader title="Pricing" :breadcrumbs="[{ label: 'Pricing' }]" /></div>
            </div>

            <div class="text-center mb-4">
                <h4 class="mb-1">Choose the plan that fits your team</h4>
                <p class="text-muted">Simple, transparent pricing. Save 20% with yearly billing.</p>
                <div class="hx-toggle">
                    <span :class="{ active: !yearly }">Monthly</span>
                    <label class="hx-switch">
                        <input type="checkbox" v-model="yearly" />
                        <span class="hx-slider"></span>
                    </label>
                    <span :class="{ active: yearly }">Yearly <span class="badge badge-success ms-1">-20%</span></span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div v-for="p in plans" :key="p.name" class="col-lg-4 col-md-6 mb-25">
                    <div class="card border-0 h-100 hx-plan" :class="{ featured: p.featured }">
                        <div class="card-body text-center p-4">
                            <span v-if="p.featured" class="badge badge-primary mb-2">Most popular</span>
                            <h5 class="mb-1">{{ p.name }}</h5>
                            <p class="text-muted fs-13 mb-3">{{ p.blurb }}</p>
                            <div class="hx-price mb-3">
                                <span class="hx-price__amount">${{ price(p.monthly) }}</span>
                                <span class="text-muted">{{ p.monthly === 0 ? '/forever' : period }}</span>
                            </div>
                            <button class="btn w-100 mb-4" :class="p.featured ? 'btn-primary' : 'btn-outline-primary'">
                                {{ p.monthly === 0 ? 'Get started' : 'Choose ' + p.name }}
                            </button>
                            <ul class="hx-plan__features">
                                <li v-for="f in p.features" :key="f"><i class="uil uil-check-circle"></i> {{ f }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-toggle { display: inline-flex; align-items: center; gap: 12px; }
.hx-toggle span { color: #9299b8; font-weight: 500; }
.hx-toggle span.active { color: #272b41; }
.hx-switch { position: relative; display: inline-block; width: 46px; height: 24px; }
.hx-switch input { display: none; }
.hx-slider { position: absolute; inset: 0; background: rgba(146,153,184,.35); border-radius: 24px; cursor: pointer; transition: .25s; }
.hx-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .25s; }
.hx-switch input:checked + .hx-slider { background: #5f63f2; }
.hx-switch input:checked + .hx-slider::before { transform: translateX(22px); }
.hx-plan { transition: transform .2s, box-shadow .2s; }
.hx-plan:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(146,153,184,.18); }
.hx-plan.featured { border: 2px solid #5f63f2 !important; }
.hx-price__amount { font-size: 38px; font-weight: 700; color: #272b41; }
.hx-plan__features { list-style: none; margin: 0; padding: 0; text-align: left; }
.hx-plan__features li { padding: 7px 0; color: #5a5f7d; }
.hx-plan__features i { color: #01b81a; margin-right: 6px; }
</style>
