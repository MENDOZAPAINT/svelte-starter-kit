// index.d.ts
import type { ComponentType } from "svelte";
import type Home from "lucide-svelte/icons/home"; // importa cualquier icono


declare global {
    // Todos los íconos de lucide-svelte tienen el mismo tipo que Home
    type IconComponent = typeof Home;

    interface NavItem {
        title: string;
        href: string;
        icon?: IconComponent;
        isActive?: boolean;
        badge?: string;
        items?: NavItem[];
    }

    namespace App {
        interface PageProps {
            auth: {
                user: User;
            };
            flash: {
                success?: string;
                error?: string;
                message?: string;
            };
            app: {
                name: string;
                url: string;
                locale: string;
            };
        }
    }
}
// Augmentar el módulo de Inertia
declare module '@inertiajs/core' {
    interface PageProps extends App.PageProps { }
}


export { };
