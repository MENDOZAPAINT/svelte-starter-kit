<script lang="ts">
    import {
        User,
        ChevronsUpDown,
        LogOut,
        Settings,
        UserIcon,
    } from "lucide-svelte";
    import { cn } from "../../../lib/utils";
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { fly } from "svelte/transition";
    import { backOut } from "svelte/easing";

    const user: User | null = $state($page.props.auth?.user ?? null);
    interface Props {
        isDesktop: boolean;
        sidebarCollapsed: boolean;
    }

    let { isDesktop, sidebarCollapsed }: Props = $props();
    let dropdownOpen = $state(false);
    let dropdownRef = $state<HTMLDivElement>();
    let buttonRef = $state<HTMLButtonElement>();
    let dropdownPosition = $state({ top: 0, left: 0 });

    const toggleDropdown = () => {
        dropdownOpen = !dropdownOpen;
        if (dropdownOpen && isDesktop && sidebarCollapsed && buttonRef) {
            // Calcular posición fija cuando está colapsado
            const rect = buttonRef.getBoundingClientRect();
            dropdownPosition = {
                top: rect.top - 190, // Altura aproximada del dropdown
                left: rect.right + 11, // 11px de margen
            };
        }
    };

    const closeDropdown = () => {
        dropdownOpen = false;
    };

    // Close dropdown when clicking outside
    const handleClickOutside = (event: MouseEvent) => {
        if (
            dropdownRef &&
            !dropdownRef.contains(event.target as Node) &&
            buttonRef &&
            !buttonRef.contains(event.target as Node)
        ) {
            closeDropdown();
        }
    };

    onMount(() => {
        document.addEventListener("click", handleClickOutside);
        return () => {
            document.removeEventListener("click", handleClickOutside);
        };
    });
</script>

<!-- User Account Footer -->
<footer
    class={cn(
        "mt-auto shrink-0 border-t relative",
        isDesktop && sidebarCollapsed ? "px-1 py-2" : "px-3 py-2",
    )}
    aria-label="Información de usuario"
>
    <div class="user-account-section">
        <button
            bind:this={buttonRef}
            class={cn(
                "flex items-center rounded-lg text-sm hover:bg-sidebar-accent hover:text-sidebar-accent-foreground h-10 transition-colors",
                isDesktop && sidebarCollapsed
                    ? "justify-center w-10 mx-2"
                    : "px-3 w-full",
                dropdownOpen
                    ? "bg-sidebar-accent text-sidebar-accent-foreground"
                    : "",
            )}
            type="button"
            aria-label="Menú de usuario: {user?.name}"
            aria-expanded={dropdownOpen}
            aria-haspopup="menu"
            title={isDesktop && sidebarCollapsed
                ? `${user?.name} - ${user?.email}`
                : undefined}
            onclick={toggleDropdown}
        >
            <User
                class="h-4 w-4 shrink-0"
                style="transition: none !important; transform: none !important;"
                aria-hidden="true"
            />
            {#if !isDesktop || !sidebarCollapsed}
                <div class="grid flex-1 text-left text-sm leading-tight ml-3">
                    <span
                        class="truncate font-semibold text-sidebar-foreground"
                        title={user?.name}>{user?.name}</span
                    >
                    <span
                        class="truncate text-xs text-sidebar-foreground/70"
                        title={user?.email}>{user?.email}</span
                    >
                </div>
                <ChevronsUpDown
                    class={cn(
                        "ml-auto h-4 w-4 text-sidebar-foreground/50 shrink-0 transition-all duration-300 ease-out group-hover:scale-110",
                        dropdownOpen ? "rotate-180" : "",
                    )}
                    style="transition: transform 300ms ease-out !important;"
                    aria-hidden="true"
                />
            {:else}
                <span class="sr-only">Abrir menú de usuario</span>
            {/if}
        </button>

        <!-- Dropdown Menu -->
        {#if dropdownOpen}
            <div
                bind:this={dropdownRef}
                class={cn(
                    "bg-black border border-border rounded-lg shadow-lg z-[9999] min-w-[250px]",
                    isDesktop && sidebarCollapsed
                        ? "fixed"
                        : "absolute bottom-full mb-1 left-0 right-0",
                )}
                style={isDesktop && sidebarCollapsed
                    ? `top: ${dropdownPosition.top}px; left: ${dropdownPosition.left}px; z-index: 9999;`
                    : ""}
                role="menu"
                aria-orientation="vertical"
                transition:fly={{
                    y: 10,
                    duration: 300,
                    easing: backOut,
                    opacity: 0,
                }}
            >
                <div class="p-2">
                    <!-- User Info Header -->
                    <div class="px-2 py-1.5 border-b border-border mb-1">
                        <p class="text-sm font-medium text-popover-foreground">
                            {user?.name}
                        </p>
                        <p class="text-xs text-muted-foreground">
                            {user?.email}
                        </p>
                    </div>

                    <!-- Menu Items -->
                    <div class="space-y-1">
                        <button
                            class="group flex items-center gap-2 w-full px-2 py-1.5 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground rounded-md transition-all duration-200 ease-out hover:scale-[1.02] hover:translate-x-1 active:scale-[0.98] active:translate-x-0 hover:shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            role="menuitem"
                            onclick={closeDropdown}
                        >
                            <UserIcon
                                class="h-4 w-4 transition-all duration-200 ease-out group-hover:scale-110 group-hover:rotate-3"
                                aria-hidden="true"
                            />
                            Perfil
                        </button>

                        <button
                            class="group flex items-center gap-2 w-full px-2 py-1.5 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground rounded-md transition-all duration-200 ease-out hover:scale-[1.02] hover:translate-x-1 active:scale-[0.98] active:translate-x-0 hover:shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            role="menuitem"
                            onclick={closeDropdown}
                        >
                            <Settings
                                class="h-4 w-4 transition-all duration-200 ease-out group-hover:scale-110 group-hover:rotate-3"
                                aria-hidden="true"
                            />
                            Configuración
                        </button>

                        <div
                            class="border-t border-border my-1 opacity-50 transition-opacity duration-300 hover:opacity-80"
                        ></div>

                        <button
                            class="group flex items-center gap-2 w-full px-2 py-1.5 text-sm text-destructive hover:bg-destructive/10 hover:text-destructive rounded-md transition-all duration-200 ease-out hover:scale-[1.02] hover:translate-x-1 active:scale-[0.98] active:translate-x-0 hover:shadow-sm focus:ring-2 focus:ring-red-500/20 focus:outline-none"
                            role="menuitem"
                            onclick={closeDropdown}
                        >
                            <LogOut
                                class="h-4 w-4 transition-all duration-200 ease-out group-hover:scale-110 group-hover:rotate-3"
                                aria-hidden="true"
                            />
                            Cerrar sesión
                        </button>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</footer>
