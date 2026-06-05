<script setup>
import { computed } from 'vue';

const props = defineProps({
    value: { type: [String, Number], required: true },
    label: { type: String, required: true },
    icon: { type: String, default: 'uil-chart' },
    color: { type: String, default: 'primary' }, // primary | secondary | success | info | warning | danger
    change: { type: [String, Number], default: null },
    trend: { type: String, default: 'up' }, // up | down
    caption: { type: String, default: 'Since last month' },
});

const trendColor = computed(() => (props.trend === 'down' ? 'color-danger' : 'color-success'));
const trendIcon = computed(() => (props.trend === 'down' ? 'la-arrow-down' : 'la-arrow-up'));
</script>

<template>
    <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
        <div class="overview-content w-100">
            <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                <div class="ap-po-details__titlebar">
                    <h1>{{ value }}</h1>
                    <p>{{ label }}</p>
                </div>
                <div class="ap-po-details__icon-area">
                    <div class="svg-icon" :class="[`order-bg-opacity-${color}`, `color-${color}`]">
                        <i class="uil" :class="icon"></i>
                    </div>
                </div>
            </div>
            <div v-if="change !== null" class="ap-po-details-time">
                <span :class="trendColor"><i class="las" :class="trendIcon"></i> <strong>{{ change }}</strong></span>
                <small>{{ caption }}</small>
            </div>
        </div>
    </div>
</template>
