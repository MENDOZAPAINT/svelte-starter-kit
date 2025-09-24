<script lang="ts">
    import {
        Menu,
        Bell,
        PanelLeft,
        LayoutDashboard,
        User2Icon,
        Component,
    } from "lucide-svelte";
    import { fade, fly } from "svelte/transition";
    import { onDestroy } from "svelte";
    import SidebarContent from "./Sidebar/SidebarContent.svelte";
    import type { Snippet } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { cn } from "../../lib/utils";
    import Appearance from "@/Components/Appearance.svelte";

    interface Props {
        children?: Snippet;
        title?: string;
    }

    // Using global NavItem interface from types/index.d.ts

    let { children, title }: Props = $props();

    let sidebarOpen = $state(false);
    let sidebarCollapsed = $state(false);
    let isDesktop = $state(false);

    // Load sidebar state from localStorage on initialization
    function loadSidebarState() {
        if (typeof window !== "undefined") {
            const savedState = localStorage.getItem("sidebar-collapsed");
            if (savedState !== null) {
                sidebarCollapsed = JSON.parse(savedState);
            }
        }
    }

    // Save sidebar state to localStorage
    function saveSidebarState() {
        if (typeof window !== "undefined") {
            localStorage.setItem(
                "sidebar-collapsed",
                JSON.stringify(sidebarCollapsed),
            );
        }
    }

    // Check if we're on desktop
    function checkIsDesktop() {
        const wasDesktop = isDesktop;
        isDesktop = window.innerWidth >= 768;

        // Close mobile sidebar when switching to desktop
        if (!wasDesktop && isDesktop && sidebarOpen) {
            sidebarOpen = false;
        }
    }

    // Initialize and listen for resize events
    if (typeof window !== "undefined") {
        checkIsDesktop();
        loadSidebarState(); // Load saved sidebar state
        window.addEventListener("resize", checkIsDesktop);

        // Cleanup event listener on component destroy
        onDestroy(() => {
            window.removeEventListener("resize", checkIsDesktop);
        });
    }

    // Base navigation items without active state
    const baseNavItems: Omit<NavItem, "isActive">[] = [
        {
            title: "Dashboard",
            href: "/dashboard",
            icon: LayoutDashboard,
        },
        {
            title: "Components",
            href: "/components",
            icon: Component,
        },
        {
            title: "User",
            href: "/user",
            icon: User2Icon,
        },
        
    ];

    // Reactive navigation structure
    const data = $derived({
        user: {
            name: "Usuario",
            email: "usuario@example.com",
            avatar: "/avatars/user.jpg",
        },
        app: {
            name: "Mi App",
            logo: LayoutDashboard,
        },
        navMain: baseNavItems.map((item) => {
            const currentUrl = $page.url || window.location.pathname;
            return {
                ...item,
                isActive:
                    currentUrl === item.href ||
                    currentUrl.startsWith(item.href + "/"),
            };
        }) as NavItem[],
    });

    const toggleSidebar = () => {
        sidebarOpen = !sidebarOpen;
    };

    const toggleSidebarCollapse = () => {
        sidebarCollapsed = !sidebarCollapsed;
        saveSidebarState(); // Save state when toggling
    };

    const handleNavClick = () => {
        // Cerrar sidebar en mobile al hacer clic en un enlace
        if (window.innerWidth < 768) {
            sidebarOpen = false;
        }
    };
</script>

<!-- Sidebar Provider equivalent -->
<div class="flex h-screen bg-background overflow-hidden">
    <!-- Sidebar Navigation (Desktop + Mobile) -->
    {#if sidebarOpen || isDesktop}
        <div
            class={cn(
                "fixed left-0 top-0 z-50 h-screen md:relative md:z-auto",
                isDesktop && sidebarCollapsed ? "w-16" : "w-64",
            )}
            style="transition: width 300ms ease-in-out; transform: none; overflow: hidden;"
            transition:fly|local={{
                x: isDesktop ? 0 : -256,
                duration: isDesktop ? 0 : 300,
                opacity: 1,
            }}
            aria-label="Navegación principal del sidebar"
            id="main-sidebar"
        >
            <SidebarContent 
                {isDesktop} 
                {sidebarCollapsed} 
                {data} 
                {handleNavClick} 
            />
        </div>
    {/if}

    <!-- Área de contenido principal -->
    <main
        class="flex flex-1 flex-col overflow-hidden transition-all duration-300"
        aria-label="Contenido principal"
        id="main-content"
    >
        <!-- Header principal con controles de navegación -->
        <header 
            class="flex h-16 shrink-0 items-center gap-2 border-b px-4"
            aria-label="Barra de navegación principal"
        >
            <!-- Control de barra lateral (Escritorio) -->
            <button
                class="h-7 w-7 shrink-0 hidden md:inline-flex items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground focus:outline-none transition-colors"
                onclick={toggleSidebarCollapse}
                type="button"
                aria-label={sidebarCollapsed ? "Expandir barra lateral" : "Contraer barra lateral"}
                aria-expanded={!sidebarCollapsed}
                aria-controls="main-sidebar"
            >
                <PanelLeft
                    class="h-4 w-4"
                    style="transition: none !important; transform: none !important;"
                    aria-hidden="true"
                />
                <span class="sr-only">{sidebarCollapsed ? "Expandir barra lateral" : "Contraer barra lateral"}</span>
            </button>

            <!-- Botón de menú móvil -->
            <button
                class="h-9 w-9 shrink-0 md:hidden flex items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 transition-colors"
                onclick={toggleSidebar}
                type="button"
                aria-label={sidebarOpen ? "Cerrar menú de navegación" : "Abrir menú de navegación"}
                aria-expanded={sidebarOpen}
                aria-controls="main-sidebar"
                title={sidebarOpen ? "Cerrar menú" : "Abrir menú"}
            >
                <Menu class="h-4 w-4" style="transition: none !important; transform: none !important;" aria-hidden="true" />
                <span class="sr-only">{sidebarOpen ? "Cerrar menú de navegación" : "Abrir menú de navegación"}</span>
            </button>

            <!-- Separador visual -->
            <div
                class="mr-2 h-4 w-px bg-border"
                role="separator"
                aria-orientation="vertical"
                aria-hidden="true"
            ></div>

            <!-- Área de navegación de ruta - personalizable por página -->
            <nav class="flex-1" aria-label="Navegación de ruta">
                <div class="flex items-center gap-2 text-sm">
                    {#if title}
                        <h1 class="font-medium text-foreground" id="page-title">{title}</h1>
                    {:else}
                        <ol class="flex items-center gap-2" role="list" aria-label="Ruta de navegación">
                            <li>
                                <span class="text-muted-foreground">Building Your Application</span>
                            </li>
                            <li aria-hidden="true">
                                <span class="text-muted-foreground">/</span>
                            </li>
                            <li>
                                <span class="font-medium text-foreground">Data Fetching</span>
                            </li>
                        </ol>
                    {/if}
                </div>
            </nav>

            <!-- Elementos del lado derecho -->
            <div class="ml-auto flex items-center gap-2" role="toolbar" aria-label="Herramientas de usuario">
                <Appearance />
                <button
                    class="h-9 w-9 flex items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 transition-colors relative"
                    type="button"
                    aria-label="Ver notificaciones"
                    title="Notificaciones"
                >
                    <Bell class="h-4 w-4" style="transition: none !important; transform: none !important;" aria-hidden="true" />
                    <span class="sr-only">Ver notificaciones</span>
                    <!-- Indicador de notificaciones pendientes -->
                    <span class="absolute -top-1 -right-1 h-2 w-2 bg-destructive rounded-full" aria-hidden="true"></span>
                </button>
            </div>
        </header>

        <!-- Contenido de la página -->
        <section 
            class="flex flex-1 flex-col gap-1 p-1 overflow-auto"
            aria-label="Contenido de la página"
            id="page-content"
            aria-labelledby="page-title"
        >
            {#if children}
                {@render children()}
            {/if}
        </section>
    </main>

    <!-- Overlay de barra lateral móvil -->
    {#if sidebarOpen}
        <div
            class="fixed inset-0 z-40 bg-black/80 backdrop-blur-sm md:hidden"
            transition:fade={{ duration: 200 }}
            onclick={toggleSidebar}
            onkeydown={(e) => {
                if (e.key === "Enter" || e.key === " " || e.key === "Escape") {
                    e.preventDefault();
                    toggleSidebar();
                }
            }}
            role="button"
            tabindex="0"
            aria-label="Cerrar menú de navegación"
            aria-hidden="false"
            title="Toca para cerrar el menú"
        ></div>
    {/if}
</div>
