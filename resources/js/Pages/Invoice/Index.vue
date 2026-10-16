<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const items = [
    { desc: 'Pro Plan subscription (June 2026)', qty: 1, price: 49 },
    { desc: 'Additional team seats', qty: 5, price: 9 },
    { desc: 'Priority support add-on', qty: 1, price: 19 },
    { desc: 'Extra storage (50 GB)', qty: 2, price: 5 },
];

const subtotal = computed(() => items.reduce((s, i) => s + i.qty * i.price, 0));
const taxRate = 0.1;
const tax = computed(() => +(subtotal.value * taxRate).toFixed(2));
const total = computed(() => +(subtotal.value + tax.value).toFixed(2));
const money = (n) => `$${n.toFixed(2)}`;

const print = () => window.print();
</script>

<template>
    <Head title="Invoice" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Invoice" :breadcrumbs="[{ label: 'Invoice' }]">
                        <template #actions>
                            <button class="btn btn-outline-light btn-sm me-1" @click="print"><i class="uil uil-print"></i> Print</button>
                            <button class="btn btn-primary btn-sm"><i class="uil uil-download-alt"></i> Download</button>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card border-0" id="invoice">
                        <div class="card-body p-4 p-md-5">
                            <!-- Header -->
                            <div class="d-flex justify-content-between flex-wrap mb-5">
                                <div>
                                    <img src="/hexadash/img/logo-dark.png" alt="logo" style="height: 32px" />
                                    <p class="text-muted fs-13 mt-2 mb-0">123 Market Street<br />San Francisco, CA 94103</p>
                                </div>
                                <div class="text-md-end">
                                    <h4 class="mb-1">Invoice</h4>
                                    <p class="text-muted fs-13 mb-0">#INV-2026-0612</p>
                                    <p class="text-muted fs-13 mb-0">Issued: Jun 5, 2026</p>
                                    <p class="text-muted fs-13 mb-0">Due: Jun 19, 2026</p>
                                </div>
                            </div>

                            <!-- Bill to -->
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <small class="text-muted text-uppercase">Billed To</small>
                                    <p class="mb-0 fw-500 mt-1">Test User</p>
                                    <p class="text-muted fs-13 mb-0">test@example.com<br />Acme Corporation</p>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <small class="text-muted text-uppercase">Status</small>
                                    <div class="mt-1"><span class="badge badge-warning">Unpaid</span></div>
                                </div>
                            </div>

                            <!-- Items -->
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr><th>Description</th><th class="text-center">Qty</th><th class="text-end">Unit</th><th class="text-end">Amount</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(i, idx) in items" :key="idx">
                                            <td>{{ i.desc }}</td>
                                            <td class="text-center">{{ i.qty }}</td>
                                            <td class="text-end">{{ money(i.price) }}</td>
                                            <td class="text-end fw-500">{{ money(i.qty * i.price) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Totals -->
                            <div class="d-flex justify-content-end">
                                <table class="hx-totals">
                                    <tr><td>Subtotal</td><td class="text-end">{{ money(subtotal) }}</td></tr>
                                    <tr><td>Tax (10%)</td><td class="text-end">{{ money(tax) }}</td></tr>
                                    <tr class="hx-totals__grand"><td>Total</td><td class="text-end">{{ money(total) }}</td></tr>
                                </table>
                            </div>

                            <p class="text-muted fs-13 mt-5 mb-0">Thank you for your business. Payment is due within 14 days.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-totals { width: 280px; }
.hx-totals td { padding: 8px 0; color: #5a5f7d; }
.hx-totals__grand td { border-top: 2px solid var(--border-color, #e3e6ef); font-weight: 700; font-size: 18px; color: #272b41; padding-top: 12px; }
</style>

<!-- Print: show only the invoice card -->
<style>
@media print {
    .header-top, .sidebar-wrapper, .breadcrumb-main, .hx-flash { display: none !important; }
    .contents { padding: 0 !important; }
    #invoice { box-shadow: none !important; }
}
</style>
