<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const faqs = [
    { cat: 'Getting Started', q: 'How do I add a new user?', a: 'Go to User Management → Add User, fill in the name, email and password, optionally assign a role, then save. The user appears immediately in the list.' },
    { cat: 'Getting Started', q: 'What are the demo login credentials?', a: 'Use test@example.com with the password "password". These are prefilled on the login screen for convenience.' },
    { cat: 'Roles & Permissions', q: 'How do roles and permissions work?', a: 'Each role carries a set of permissions grouped by area (Users, Roles, Content, Settings). Assign a role to a user from the user form, and the role’s permissions apply to them.' },
    { cat: 'Roles & Permissions', q: 'Can I delete a role that has users?', a: 'No. To keep data consistent, a role can only be deleted once no users are assigned to it. Reassign those users first.' },
    { cat: 'Appearance', q: 'How do I switch between light and dark mode?', a: 'Use the sun/moon icon in the top bar. Your preference is saved in the browser and restored on your next visit.' },
    { cat: 'Appearance', q: 'Can I change the primary color?', a: 'Yes — open Settings → Appearance and pick a primary color. (In this demo the value is stored but not yet applied globally.)' },
    { cat: 'Account', q: 'How do I update my profile?', a: 'Open Profile Settings from the sidebar to change your name, email, or password.' },
];

const search = ref('');
const openIdx = ref(0);

const filtered = computed(() => {
    const q = search.value.trim().toLowerCase();
    if (!q) return faqs;
    return faqs.filter((f) => f.q.toLowerCase().includes(q) || f.a.toLowerCase().includes(q));
});
const categories = computed(() => [...new Set(filtered.value.map((f) => f.cat))]);

const toggle = (key) => (openIdx.value = openIdx.value === key ? null : key);
</script>

<template>
    <Head title="Help / FAQ" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <PageHeader title="Help &amp; FAQ" :breadcrumbs="[{ label: 'FAQ' }]" />
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card border-0 mb-25">
                        <div class="card-body text-center py-4">
                            <h5 class="mb-1">How can we help?</h5>
                            <p class="text-muted mb-3">Search the most common questions below.</p>
                            <div class="hx-faq-search mx-auto">
                                <i class="uil uil-search"></i>
                                <input v-model="search" type="search" class="form-control" placeholder="Search help articles..." />
                            </div>
                        </div>
                    </div>

                    <template v-for="cat in categories" :key="cat">
                        <h6 class="mb-2 mt-2">{{ cat }}</h6>
                        <div class="card border-0 mb-25">
                            <div class="card-body p-0">
                                <div v-for="f in filtered.filter((x) => x.cat === cat)" :key="f.q" class="hx-acc">
                                    <button type="button" class="hx-acc__head" :class="{ open: openIdx === f.q }" @click="toggle(f.q)">
                                        <span>{{ f.q }}</span>
                                        <i class="uil" :class="openIdx === f.q ? 'uil-angle-up' : 'uil-angle-down'"></i>
                                    </button>
                                    <div v-show="openIdx === f.q" class="hx-acc__body">{{ f.a }}</div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <p v-if="!filtered.length" class="text-center text-muted py-4">No results for “{{ search }}”.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-faq-search {
    position: relative;
    max-width: 420px;
}
.hx-faq-search i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9299b8;
}
.hx-faq-search .form-control {
    padding-left: 38px;
}
.hx-acc {
    border-bottom: 1px solid var(--border-color, #f1f2f6);
}
.hx-acc:last-child {
    border-bottom: 0;
}
.hx-acc__head {
    width: 100%;
    text-align: left;
    border: 0;
    background: transparent;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 500;
}
.hx-acc__head.open {
    color: #5f63f2;
}
.hx-acc__body {
    padding: 0 24px 20px;
    color: #5a5f7d;
    line-height: 1.8;
}
</style>
