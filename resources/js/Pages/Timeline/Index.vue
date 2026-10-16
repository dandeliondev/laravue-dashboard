<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const groups = [
    {
        date: 'Today', events: [
            { time: '09:41', icon: 'uil-user-plus', color: 'primary', title: 'New user onboarded', text: 'Ada Lovelace completed account setup and joined the Design team.' },
            { time: '08:15', icon: 'uil-check-circle', color: 'success', title: 'Deployment successful', text: 'Release v1.2 was deployed to production with no downtime.' },
        ],
    },
    {
        date: 'Yesterday', events: [
            { time: '17:30', icon: 'uil-comment-alt-message', color: 'info', title: 'New comment', text: 'Colton left feedback on the settings page design.' },
            { time: '14:02', icon: 'uil-bill', color: 'warning', title: 'Invoice generated', text: 'Invoice #INV-2026-0612 was created for Acme Corporation.' },
            { time: '09:18', icon: 'uil-shield-check', color: 'primary', title: 'Role updated', text: 'Permissions for the “Manager” role were modified.' },
        ],
    },
    {
        date: 'Jun 1, 2026', events: [
            { time: '16:45', icon: 'uil-trash-alt', color: 'danger', title: 'Account removed', text: 'A duplicate user account was deleted by an administrator.' },
            { time: '11:30', icon: 'uil-folder-plus', color: 'success', title: 'Project created', text: 'The “Mobile App Launch” project was created and assigned a team.' },
        ],
    },
];
</script>

<template>
    <Head title="Timeline" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><PageHeader title="Timeline" :breadcrumbs="[{ label: 'Timeline' }]" /></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 mb-25">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="hx-tl">
                                <template v-for="group in groups" :key="group.date">
                                    <div class="hx-tl__date"><span>{{ group.date }}</span></div>
                                    <div v-for="(e, i) in group.events" :key="i" class="hx-tl__item">
                                        <span class="hx-tl__icon" :class="`bg-${e.color}`"><i class="uil" :class="e.icon"></i></span>
                                        <div class="hx-tl__content">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-600">{{ e.title }}</span>
                                                <small class="text-muted">{{ e.time }}</small>
                                            </div>
                                            <p class="text-muted fs-13 mb-0">{{ e.text }}</p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-tl { position: relative; padding-left: 8px; }
.hx-tl::before { content: ''; position: absolute; left: 27px; top: 6px; bottom: 6px; width: 2px; background: var(--border-color, #f1f2f6); }
.hx-tl__date { position: relative; margin: 18px 0 14px; }
.hx-tl__date span { background: rgba(95,99,242,.1); color: #5f63f2; font-weight: 600; font-size: 12px; padding: 4px 12px; border-radius: 20px; position: relative; z-index: 1; }
.hx-tl__item { display: flex; gap: 16px; margin-bottom: 18px; position: relative; }
.hx-tl__icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; flex: 0 0 auto; z-index: 1; }
.hx-tl__content { background: rgba(146,153,184,.05); border-radius: 8px; padding: 12px 16px; flex: 1; }
.bg-primary { background: #5f63f2; } .bg-info { background: #00aaff; } .bg-success { background: #01b81a; } .bg-warning { background: #fa8b0c; } .bg-danger { background: #ff4d4f; }
</style>
