import './bootstrap';
import '@iconscout/unicons/css/line.css'; // Self-hosted Unicons (CDN copy is corrupted); bundled by Vite.

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueApexCharts from 'vue3-apexcharts';

const appName = import.meta.env.VITE_APP_NAME || 'Laravue Dashboard';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: '#5f63f2',
    },
});
