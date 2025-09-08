import './bootstrap';
import '../css/app.css'

import { createInertiaApp } from '@inertiajs/svelte'
import type { SvelteComponent } from 'svelte'
import { mount } from 'svelte'
import { initializeTheme } from './hooks/useAppearance';
// import { initializeTheme } from './useAppearance';


createInertiaApp({
    resolve: (name: string) => {
        const pages = import.meta.glob<{ default: typeof SvelteComponent }>('./Pages/**/*.svelte', {
            eager: true,
        })

        const page = pages[`./Pages/${name}.svelte`]

        if (!page || !page.default) {
            throw new Error(`Página no encontrada: ./Pages/${name}.svelte`)
        }

        return { default: page.default }
    },

    setup({ el, App, props }) {
        mount(App, {
            target: el!,
            props,
        })
    },
});
initializeTheme();

