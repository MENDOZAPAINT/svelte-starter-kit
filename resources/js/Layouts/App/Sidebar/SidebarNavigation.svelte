<script lang="ts">
    import { Link } from "@inertiajs/svelte";
    import { cn } from "../../../lib/utils";
    import Tooltip from "@/Components/Tooltip.svelte";

    interface Props {
        isDesktop: boolean;
        sidebarCollapsed: boolean;
        data: {
            navMain: NavItem[];
        };
        handleNavClick: () => void;
    }

    let { isDesktop, sidebarCollapsed, data, handleNavClick }: Props = $props();
</script>

<!-- Main Navigation Content -->
<nav
    class="flex-1 overflow-y-auto overflow-x-hidden py-2 min-h-0 scrollbar-thin scrollbar-thumb-sidebar-border"
    aria-label="Navegación principal"
>
    <!-- Primary Navigation Section -->
    <section
        class={cn(
            "py-2",
            isDesktop && sidebarCollapsed ? "px-1" : "px-3",
        )}
        aria-labelledby="primary-nav-heading"
    >
        <h2 id="primary-nav-heading" class="sr-only">Navegación Principal</h2>
        <ul class="space-y-1" role="list" aria-label="Enlaces de navegación principales">
            {#each data.navMain as item}
                <li role="listitem">
                    {#if isDesktop && sidebarCollapsed}
                        <!-- Collapsed Navigation Item with Tooltip -->
                        <Tooltip
                            content={item.title}
                            position="right"
                        >
                            <Link
                                href={item.href}
                                class={cn(
                                    "flex items-center justify-center rounded-lg h-10 w-10 mx-2 text-sm hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus:outline-none focus:ring-2 focus:ring-sidebar-ring transition-colors duration-200",
                                    item.isActive
                                        ? "bg-sidebar-accent text-sidebar-accent-foreground"
                                        : "text-sidebar-foreground",
                                )}
                                onclick={handleNavClick}
                                aria-current={item.isActive ? "page" : undefined}
                                aria-label={`Ir a ${item.title}`}
                                role="menuitem"
                            >
                                <item.icon
                                    class="h-4 w-4"
                                    style="transition: none !important; transform: none !important;"
                                    aria-hidden="true"
                                />
                                <span class="sr-only">{item.title}</span>
                            </Link>
                        </Tooltip>
                    {:else}
                        <!-- Expanded Navigation Item -->
                        <Link
                            href={item.href}
                            class={cn(
                                "flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus:outline-none focus:ring-2 focus:ring-sidebar-ring transition-all duration-200",
                                item.isActive
                                    ? "bg-sidebar-accent text-sidebar-accent-foreground"
                                    : "text-sidebar-foreground hover:translate-x-1",
                            )}
                            onclick={handleNavClick}
                            aria-current={item.isActive ? "page" : undefined}
                            role="menuitem"
                        >
                            <item.icon
                                class="h-4 w-4 flex-shrink-0"
                                style="transition: none !important; transform: none !important;"
                                aria-hidden="true"
                            />
                            <span class="flex-1 truncate font-medium">{item.title}</span>
                            {#if item.isActive}
                                <span class="w-2 h-2 bg-sidebar-primary rounded-full" aria-hidden="true"></span>
                            {/if}
                        </Link>
                    {/if}
                </li>
            {/each}
        </ul>
    </section>
</nav>