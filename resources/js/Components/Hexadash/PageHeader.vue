<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: { type: String, required: true },
    // [{ label, to }] — last item is rendered as the active (non-link) crumb.
    breadcrumbs: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="breadcrumb-main">
        <h4 class="text-capitalize breadcrumb-title">{{ title }}</h4>
        <div class="breadcrumb-action justify-content-center flex-wrap">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <Link :href="route('dashboard')"><i class="uil uil-estate"></i>Dashboard</Link>
                    </li>
                    <li
                        v-for="(crumb, i) in breadcrumbs"
                        :key="crumb.label"
                        class="breadcrumb-item"
                        :class="{ active: i === breadcrumbs.length - 1 }"
                        :aria-current="i === breadcrumbs.length - 1 ? 'page' : undefined"
                    >
                        <Link v-if="crumb.to && i !== breadcrumbs.length - 1" :href="crumb.to">{{ crumb.label }}</Link>
                        <template v-else>{{ crumb.label }}</template>
                    </li>
                </ol>
            </nav>
            <div v-if="$slots.actions" class="d-flex align-items-center ms-3">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>
