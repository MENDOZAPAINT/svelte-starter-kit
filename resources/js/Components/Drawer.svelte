<!-- Drawer.svelte -->
<script lang="ts">
    import { X } from "lucide-svelte";
    import type { Snippet } from "svelte";
    import { cn } from "@/lib/utils";

    interface Props {
        showDrawer: boolean;
        header?: Snippet;
        children: Snippet;
        footer?: Snippet<[{ closeDrawer: () => void }]>;
        position?: "left" | "right" | "top" | "bottom";
        size?: "sm" | "md" | "lg" | "xl" | "full";
    }

    let {
        showDrawer = $bindable(),
        header,
        children,
        footer,
        position = "right",
        size = "md",
    }: Props = $props();

    let isClosing = $state(false);

    function closeDrawer() {
        if (isClosing) return; // Prevenir múltiples llamadas

        isClosing = true;
        setTimeout(() => {
            showDrawer = false;
            isClosing = false;
        }, 600);
    }

    // Cerrar drawer con Escape
    function handleKeydown(e: KeyboardEvent) {
        if (e.key === "Escape" && showDrawer) {
            closeDrawer();
        }
    }

    const sizeClasses = {
        sm:
            position === "left" || position === "right"
                ? "w-full sm:w-80"
                : "h-64",
        md:
            position === "left" || position === "right"
                ? "w-full sm:w-96"
                : "h-80",
        lg:
            position === "left" || position === "right"
                ? "w-full sm:w-[28rem]"
                : "h-96",
        xl:
            position === "left" || position === "right"
                ? "w-full sm:w-[32rem]"
                : "h-[28rem]",
        full: position === "left" || position === "right" ? "w-full" : "h-full",
    };

    const positionClasses = {
        left: "left-0 top-0 h-full",
        right: "right-0 top-0 h-full",
        top: "top-0 left-0 w-full",
        bottom: "bottom-0 left-0 w-full",
    };

    const animationClasses = $derived({
        left: isClosing
            ? "animate-drawer-exit-left"
            : "animate-drawer-enter-left",
        right: isClosing
            ? "animate-drawer-exit-right"
            : "animate-drawer-enter-right",
        top: isClosing ? "animate-drawer-exit-top" : "animate-drawer-enter-top",
        bottom: isClosing
            ? "animate-drawer-exit-bottom"
            : "animate-drawer-enter-bottom",
    });

    const drawerClasses = $derived(
        cn(
            "fixed bg-background/95 backdrop-blur-xl border border-border/50 shadow-2xl z-50",
            positionClasses[position],
            sizeClasses[size],
            animationClasses[position],
            isClosing && "pointer-events-none",
        ),
    );
</script>

<svelte:window on:keydown={handleKeydown} />

{#if showDrawer}
    <!-- Backdrop -->
    <div
        class={cn(
            "fixed inset-0 bg-black/1 backdrop-blur-md z-40 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]",
            isClosing
                ? "opacity-0 backdrop-blur-none scale-105"
                : "opacity-100 backdrop-blur-md scale-100",
        )}
        onclick={closeDrawer}
        onkeydown={(e) => e.key === "Enter" && closeDrawer()}
        role="button"
        tabindex="0"
        aria-label="Cerrar drawer"
    ></div>

    <!-- Drawer -->
    <div class={drawerClasses}>
        <div
            class={cn(
                "p-6 space-y-6 relative h-full overflow-y-auto flex flex-col",
                "transition-all duration-300 ease-out",
                isClosing ? "animate-content-fade-out blur-sm" : "blur-none",
            )}
        >
            <!-- Header Section -->
            {#if header}
                <div
                    class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-2 flex-shrink-0"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            {@render header()}
                        </div>
                        <button
                            onclick={closeDrawer}
                            class={cn(
                                "ml-4 p-2.5 rounded-xl text-muted-foreground hover:text-foreground",
                                "hover:bg-accent/80 hover:text-accent-foreground backdrop-blur-sm",
                                "transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]",
                                "hover:scale-110 hover:rotate-90 active:scale-95 hover:shadow-lg",
                            )}
                            aria-label="Cerrar drawer"
                        >
                            <X
                                class="w-4 h-4 transition-all duration-300 ease-out"
                            />
                        </button>
                    </div>
                </div>
            {:else}
                <!-- Close button when no header -->
                <div class="flex justify-end mb-4 flex-shrink-0">
                    <button
                        onclick={closeDrawer}
                        class={cn(
                            "p-2.5 rounded-xl text-muted-foreground hover:text-foreground",
                            "hover:bg-accent/80 hover:text-accent-foreground backdrop-blur-sm",
                            "transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]",
                            "hover:scale-110 hover:rotate-90 active:scale-95 hover:shadow-lg",
                        )}
                        aria-label="Cerrar drawer"
                    >
                        <X
                            class="w-4 h-4 transition-all duration-300 ease-out"
                        />
                    </button>
                </div>
            {/if}

            <!-- Content Section -->
            <div
                class="flex-1 text-gray-900 dark:text-gray-100 leading-relaxed overflow-y-auto"
            >
                {@render children()}
            </div>

            <!-- Footer Section -->
            {#if footer}
                <div
                    class={cn(
                        "border-t border-gray-200 dark:border-gray-700 pt-6 mt-6 flex-shrink-0",
                        "flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0",
                    )}
                >
                    {@render footer({ closeDrawer })}
                </div>
            {/if}
        </div>
    </div>
{/if}

<!-- 
<script lang="ts">
    import Button from "@/Components/Button.svelte";
    import Drawer from "@/Components/Drawer.svelte";

    let showRightDrawer = $state(false);
    let isLoading = $state(false);
    let errors = $state({});

    function openDrawer() {
        errors = {};
        showRightDrawer = true;
    }
    function handleDrawerClose() {
        errors = {};
        showRightDrawer = false;
    }
</script>

    <Button variant="secondary" onclick={openDrawer}>Editar Usuario</Button>

    <Drawer bind:showDrawer={showRightDrawer} position="right" size="lg">
        {#snippet header()}
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Actualizar Usuario
            </h2>
        {/snippet}
        Prueba

        {#snippet footer({ closeDrawer })}
            <div class="flex justify-end space-x-3">
                <Button
                    variant="ghost"
                    onclick={() => {
                        handleDrawerClose();
                        closeDrawer();
                    }}
                    disabled={isLoading}
                >
                    Cancelar
                </Button>
                <Button
                    variant="success"
                    disabled={isLoading}
                    loadingText="Actualizando..."
                    {isLoading}
                >
                    Actualizar Usuario
                </Button>
            </div>
        {/snippet}
    </Drawer>
-->

<style>
    /* Animaciones modernas para drawer desde la izquierda */
    @keyframes drawer-enter-left {
        from {
            transform: translateX(-100%);
            opacity: 0;
            filter: blur(4px);
        }
        to {
            transform: translateX(0);
            opacity: 1;
            filter: blur(0);
        }
    }

    @keyframes drawer-exit-left {
        from {
            transform: translateX(0);
            opacity: 1;
            filter: blur(0);
        }
        to {
            transform: translateX(-100%);
            opacity: 0;
            filter: blur(4px);
        }
    }

    /* Animaciones modernas para drawer desde la derecha */
    @keyframes drawer-enter-right {
        from {
            transform: translateX(100%);
            opacity: 0;
            filter: blur(4px);
        }
        to {
            transform: translateX(0);
            opacity: 1;
            filter: blur(0);
        }
    }

    @keyframes drawer-exit-right {
        from {
            transform: translateX(0);
            opacity: 1;
            filter: blur(0);
        }
        to {
            transform: translateX(100%);
            opacity: 0;
            filter: blur(4px);
        }
    }

    /* Animaciones modernas para drawer desde arriba */
    @keyframes drawer-enter-top {
        from {
            transform: translateY(-100%);
            opacity: 0;
            filter: blur(4px);
        }
        to {
            transform: translateY(0);
            opacity: 1;
            filter: blur(0);
        }
    }

    @keyframes drawer-exit-top {
        from {
            transform: translateY(0);
            opacity: 1;
            filter: blur(0);
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
            filter: blur(4px);
        }
    }

    /* Animaciones modernas para drawer desde abajo */
    @keyframes drawer-enter-bottom {
        from {
            transform: translateY(100%);
            opacity: 0;
            filter: blur(4px);
        }
        to {
            transform: translateY(0);
            opacity: 1;
            filter: blur(0);
        }
    }

    @keyframes drawer-exit-bottom {
        from {
            transform: translateY(0);
            opacity: 1;
            filter: blur(0);
        }
        to {
            transform: translateY(100%);
            opacity: 0;
            filter: blur(4px);
        }
    }

    @keyframes content-fade-out {
        from {
            opacity: 1;
            filter: blur(0);
        }
        to {
            opacity: 0;
            filter: blur(2px);
        }
    }

    .animate-drawer-enter-left {
        animation: drawer-enter-left 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animate-drawer-exit-left {
        animation: drawer-exit-left 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)
            forwards;
    }

    .animate-drawer-enter-right {
        animation: drawer-enter-right 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animate-drawer-exit-right {
        animation: drawer-exit-right 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)
            forwards;
    }

    .animate-drawer-enter-top {
        animation: drawer-enter-top 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animate-drawer-exit-top {
        animation: drawer-exit-top 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)
            forwards;
    }

    .animate-drawer-enter-bottom {
        animation: drawer-enter-bottom 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animate-drawer-exit-bottom {
        animation: drawer-exit-bottom 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)
            forwards;
    }

    .animate-content-fade-out {
        animation: content-fade-out 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)
            forwards;
    }
</style>
