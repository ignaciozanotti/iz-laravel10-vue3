import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';
import { useAuthStore } from './Stores/auth';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia);

        const authStore = useAuthStore();
        authStore.loadToken();

        router.on('before', (event) => {
            authStore.loadToken();
            const token = authStore.token;
            //delete me
            console.log('Inertia Request:', {
                url: event.detail.visit.url,
                method: event.detail.visit.method,
                token: token,
            });
            if (token) {
                event.detail.visit.headers['Authorization'] = `Bearer ${token}`;
            }
        });

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
