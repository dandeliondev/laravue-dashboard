<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const props = defineProps({
    settings: { type: Object, required: true },
    timezones: { type: Array, default: () => [] },
});

const tabs = [
    { key: 'general', label: 'General', icon: 'uil-setting' },
    { key: 'appearance', label: 'Appearance', icon: 'uil-palette' },
    { key: 'notifications', label: 'Notifications', icon: 'uil-bell' },
];
const active = ref('general');

const form = useForm({ ...props.settings });
const submit = () => form.put(route('settings.update'), { preserveScroll: true });
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Settings" :breadcrumbs="[{ label: 'Settings' }]" />
                </div>
            </div>

            <div class="row">
                <!-- Tabs -->
                <div class="col-lg-3 mb-25">
                    <div class="card border-0">
                        <div class="card-body p-2">
                            <ul class="hx-settings-tabs">
                                <li v-for="t in tabs" :key="t.key">
                                    <button type="button" :class="{ active: active === t.key }" @click="active = t.key">
                                        <i class="uil" :class="t.icon"></i> {{ t.label }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Panels -->
                <div class="col-lg-9 mb-25">
                    <div class="card border-0">
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <!-- General -->
                                <div v-show="active === 'general'">
                                    <h6 class="mb-3">General</h6>
                                    <div class="form-group mb-20">
                                        <label class="form-label">Application Name</label>
                                        <input v-model="form.app_name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.app_name }" />
                                        <div v-if="form.errors.app_name" class="invalid-feedback d-block">{{ form.errors.app_name }}</div>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label class="form-label">Tagline</label>
                                        <input v-model="form.app_tagline" type="text" class="form-control" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-20">
                                            <label class="form-label">Support Email</label>
                                            <input v-model="form.support_email" type="email" class="form-control"
                                                :class="{ 'is-invalid': form.errors.support_email }" />
                                            <div v-if="form.errors.support_email" class="invalid-feedback d-block">{{ form.errors.support_email }}</div>
                                        </div>
                                        <div class="col-md-6 form-group mb-20">
                                            <label class="form-label">Timezone</label>
                                            <select v-model="form.timezone" class="form-control form-select">
                                                <option v-for="tz in timezones" :key="tz" :value="tz">{{ tz }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Appearance -->
                                <div v-show="active === 'appearance'">
                                    <h6 class="mb-3">Appearance</h6>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-20">
                                            <label class="form-label">Primary Color</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input v-model="form.primary_color" type="color" class="form-control form-control-color" style="max-width: 60px" />
                                                <input v-model="form.primary_color" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-20">
                                            <label class="form-label">Default Theme</label>
                                            <select v-model="form.default_theme" class="form-control form-select">
                                                <option value="light">Light</option>
                                                <option value="dark">Dark</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input id="sidebar_collapsed" v-model="form.sidebar_default_collapsed" type="checkbox" class="form-check-input" />
                                        <label class="form-check-label" for="sidebar_collapsed">Collapse sidebar by default</label>
                                    </div>
                                </div>

                                <!-- Notifications -->
                                <div v-show="active === 'notifications'">
                                    <h6 class="mb-3">Email Notifications</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input id="n1" v-model="form.notify_new_user" type="checkbox" class="form-check-input" />
                                        <label class="form-check-label" for="n1">Notify me when a new user registers</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input id="n2" v-model="form.notify_weekly_report" type="checkbox" class="form-check-input" />
                                        <label class="form-check-label" for="n2">Send me a weekly summary report</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input id="n3" v-model="form.notify_product_updates" type="checkbox" class="form-check-input" />
                                        <label class="form-check-label" for="n3">Product updates &amp; announcements</label>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3 mt-3 border-top pt-3">
                                    <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                                        <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>Save Changes
                                    </button>
                                    <Transition name="hx-fade">
                                        <span v-if="form.recentlySuccessful" class="text-success fs-13">Saved.</span>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-settings-tabs {
    list-style: none;
    margin: 0;
    padding: 0;
}
.hx-settings-tabs button {
    width: 100%;
    text-align: left;
    border: 0;
    background: transparent;
    padding: 11px 16px;
    border-radius: 8px;
    color: #5a5f7d;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}
.hx-settings-tabs button.active {
    background: rgba(95, 99, 242, 0.08);
    color: #5f63f2;
}
.hx-fade-enter-active,
.hx-fade-leave-active {
    transition: opacity 0.3s ease;
}
.hx-fade-enter-from,
.hx-fade-leave-to {
    opacity: 0;
}
</style>
