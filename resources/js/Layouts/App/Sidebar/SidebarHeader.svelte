<script lang="ts">
    import { Link } from "@inertiajs/svelte";
    import { ChevronsUpDown } from "lucide-svelte";
    import { cn } from "../../../lib/utils";

    interface Props {
        isDesktop: boolean;
        sidebarCollapsed: boolean;
        data: {
            app: {
                name: string;
            };
        };
        handleNavClick: () => void;
    }

    let { isDesktop, sidebarCollapsed, data, handleNavClick }: Props = $props();
</script>

<!-- Sidebar Header with Brand/Team Switcher -->
<header class="flex h-16 shrink-0 items-center border-b px-4 relative">
    <!-- Imagen fija en posición absoluta -->
    <img 
        src="https://media.revistagq.com/photos/6092742a235a5910299c918b/16:9/w_2560%2Cc_limit/dragon-ball-goku-entrenamiento-dieta-musculos.jpg" 
        alt="Logo"
        class="h-6 w-6 rounded-sm absolute left-5 top-1/2 -translate-y-1/2 z-10" 
        style="transition: none !important;" 
    />
    
    <Link
        href="#"
        class="flex items-center rounded-lg h-10 text-sm hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus:outline-none focus:ring-2 focus:ring-sidebar-ring transition-colors duration-200 text-sidebar-foreground {isDesktop && sidebarCollapsed ? 'w-10 justify-center px-2' : 'w-full pl-12 pr-2'}"
        onclick={handleNavClick}
        role="menuitem"
        title={isDesktop && sidebarCollapsed ? `Logo de ${data.app.name}` : "Cambiar equipo o configuración"}
        aria-label={isDesktop && sidebarCollapsed ? `Logo de ${data.app.name}` : undefined}
    >
        {#if !isDesktop || !sidebarCollapsed}
            <div class="flex-1 text-left text-sm leading-tight">
                <span class="truncate font-medium" title="{data.app.name}">
                    {data.app.name}
                </span>
            </div>
            <ChevronsUpDown
                class="h-4 w-4 text-sidebar-foreground/50 flex-shrink-0 ml-3"
                style="transition: none !important; transform: none !important;"
                aria-hidden="true"
            />
        {/if}
    </Link>
</header>