<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const folders = [
    { name: 'Documents', items: 24, color: 'primary' },
    { name: 'Images', items: 132, color: 'info' },
    { name: 'Projects', items: 18, color: 'success' },
    { name: 'Invoices', items: 9, color: 'warning' },
];

const files = [
    { name: 'Q2-report.pdf', size: '2.4 MB', type: 'pdf', icon: 'uil-file-alt', color: 'danger', date: 'Jun 4' },
    { name: 'dashboard-mockup.fig', size: '8.1 MB', type: 'figma', icon: 'uil-vector-square', color: 'primary', date: 'Jun 3' },
    { name: 'users-export.csv', size: '320 KB', type: 'csv', icon: 'uil-file-export', color: 'success', date: 'Jun 2' },
    { name: 'logo-pack.zip', size: '14 MB', type: 'zip', icon: 'uil-archive', color: 'warning', date: 'Jun 1' },
    { name: 'onboarding.mp4', size: '54 MB', type: 'video', icon: 'uil-video', color: 'info', date: 'May 28' },
    { name: 'contract.docx', size: '180 KB', type: 'doc', icon: 'uil-file-edit-alt', color: 'primary', date: 'May 25' },
    { name: 'budget.xlsx', size: '96 KB', type: 'sheet', icon: 'uil-file-bookmark-alt', color: 'success', date: 'May 22' },
    { name: 'hero-banner.png', size: '1.2 MB', type: 'image', icon: 'uil-image', color: 'info', date: 'May 20' },
];
</script>

<template>
    <Head title="File Manager" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="File Manager" :breadcrumbs="[{ label: 'Files' }]">
                        <template #actions>
                            <button class="btn btn-primary btn-sm"><i class="uil uil-upload"></i> Upload</button>
                        </template>
                    </PageHeader>
                </div>
            </div>

            <div class="row">
                <!-- Main -->
                <div class="col-lg-9">
                    <h6 class="mb-3">Folders</h6>
                    <div class="row">
                        <div v-for="f in folders" :key="f.name" class="col-md-3 col-sm-6 mb-25">
                            <div class="card border-0 hx-folder">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <span class="hx-folder__icon" :class="`bg-soft-${f.color}`"><i class="uil uil-folder"></i></span>
                                    <div>
                                        <p class="mb-0 fw-500">{{ f.name }}</p>
                                        <small class="text-muted">{{ f.items }} items</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3 mt-2">Recent Files</h6>
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <table class="table mb-0 align-middle">
                                <thead><tr><th class="ps-25">Name</th><th>Size</th><th>Modified</th><th class="text-end pe-25"></th></tr></thead>
                                <tbody>
                                    <tr v-for="file in files" :key="file.name">
                                        <td class="ps-25">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="hx-file-icon" :class="`color-${file.color}`"><i class="uil" :class="file.icon"></i></span>
                                                <span class="fw-500">{{ file.name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ file.size }}</td>
                                        <td class="text-muted">{{ file.date }}</td>
                                        <td class="text-end pe-25">
                                            <button class="btn btn-sm btn-outline-light"><i class="uil uil-download-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Storage sidebar -->
                <div class="col-lg-3 mb-25">
                    <div class="card border-0">
                        <div class="card-body text-center">
                            <h6 class="mb-3">Storage</h6>
                            <div class="hx-storage-ring" style="--pct: 64">
                                <span>64%</span>
                            </div>
                            <p class="text-muted fs-13 mt-3 mb-3">64 GB of 100 GB used</p>
                            <ul class="hx-storage-legend">
                                <li><span class="dot bg-primary"></span> Documents <b class="ms-auto">22 GB</b></li>
                                <li><span class="dot bg-info"></span> Images <b class="ms-auto">28 GB</b></li>
                                <li><span class="dot bg-warning"></span> Other <b class="ms-auto">14 GB</b></li>
                            </ul>
                            <button class="btn btn-outline-primary btn-sm w-100 mt-2">Upgrade plan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-folder { cursor: pointer; transition: transform .15s; }
.hx-folder:hover { transform: translateY(-2px); }
.hx-folder__icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
.bg-soft-primary { background: rgba(95,99,242,.12); color: #5f63f2; }
.bg-soft-info { background: rgba(0,170,255,.12); color: #00aaff; }
.bg-soft-success { background: rgba(1,184,26,.12); color: #01b81a; }
.bg-soft-warning { background: rgba(250,139,12,.12); color: #fa8b0c; }
.hx-file-icon { font-size: 18px; }
.color-danger { color: #ff4d4f; } .color-primary { color: #5f63f2; } .color-success { color: #01b81a; } .color-warning { color: #fa8b0c; } .color-info { color: #00aaff; }
.hx-storage-ring { width: 130px; height: 130px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 22px; color: #5f63f2;
    background: radial-gradient(closest-side, #fff 78%, transparent 79% 100%), conic-gradient(#5f63f2 calc(var(--pct) * 1%), rgba(146,153,184,.15) 0); }
.hx-storage-legend { list-style: none; margin: 0; padding: 0; text-align: left; }
.hx-storage-legend li { display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 13px; }
.dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.bg-primary { background: #5f63f2; } .bg-info { background: #00aaff; } .bg-warning { background: #fa8b0c; }
</style>
