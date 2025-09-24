<script lang="ts">
    import { onMount } from "svelte";
    import type { Snippet } from "svelte";
    import { X } from "lucide-svelte";
    import { cn } from "@/lib/utils";

    // Tipos mejorados y más específicos
    type ModalSize = "sm" | "md" | "lg" | "xl" | "2xl" | "full";
    type ModalPosition = "left" | "center" | "top" | "bottom";
    type AnimationState = "idle" | "opening" | "closing";

    interface Props {
        showModal: boolean;
        header?: Snippet;
        children: Snippet;
        footer?: Snippet<[{ closeModal: () => void }]>;
        position?: ModalPosition;
        size?: ModalSize;
        closeOnBackdrop?: boolean;
        closeOnEscape?: boolean;
        persistent?: boolean;
        zIndex?: number;
        maxHeight?: string;
        className?: string;
        id?: string;
        "aria-labelledby"?: string;
        "aria-describedby"?: string;
        onopen?: () => void;
        onclose?: () => void;
        onbackdrop?: () => void;
    }

    let {
        showModal = $bindable(),
        header,
        children,
        footer,
        position = "center",
        size = "lg",
        closeOnBackdrop = true,
        closeOnEscape = true,
        persistent = false,
        zIndex = 50,
        maxHeight = "90vh",
        className = "",
        id,
        "aria-labelledby": ariaLabelledby,
        "aria-describedby": ariaDescribedby,
        onopen,
        onclose,
        onbackdrop,
    }: Props = $props();

    // Estado del modal optimizado
    let dialog: HTMLDialogElement | undefined = $state();
    let animationState: AnimationState = $state("idle");
    let timeoutId: number | undefined = $state();

    // Configuración de animaciones
    const ANIMATION_CONFIG = {
        ENTER_DURATION: 500,
        EXIT_DURATION: 400,
    } as const;

    // Configuración de clases CSS mejorada
    const SIZE_CLASSES: Record<ModalSize, string> = {
        sm: "w-full max-w-sm sm:w-auto mx-4 sm:mx-auto",
        md: "w-full max-w-md sm:w-auto mx-4 sm:mx-auto",
        lg: "w-full max-w-lg sm:w-auto mx-4 sm:mx-auto",
        xl: "w-full max-w-xl sm:w-auto mx-4 sm:mx-auto",
        "2xl": "w-full max-w-2xl sm:w-auto mx-4 sm:mx-auto",
        full: "w-full max-w-full max-h-none m-0 rounded-none",
    };

    const POSITION_CLASSES: Record<ModalPosition, string> = {
        left: "mr-auto ml-4 mt-4 sm:ml-6 sm:mt-8 md:mt-16",
        center: "mx-auto my-auto",
        top: "mx-auto mt-4 sm:mt-8 md:mt-16",
        bottom: "mx-auto mt-auto mb-4 sm:mb-8 md:mb-16",
    };

    // Clases del modal optimizadas
    const modalClasses = $derived(
        cn(
            "rounded-lg sm:rounded-2xl border-1 p-0 shadow-2xl drop-shadow-xl bg-background overflow-hidden",
            "transform transition-all duration-300 ease-out",
            "backdrop:bg-black/50 backdrop:backdrop-blur-lg rounded-xl dark:backdrop:bg-white/10",
            `min-h-0 max-h-[${maxHeight}] sm:max-h-[85vh] z-${zIndex}`,
            getAnimationClass(),
            SIZE_CLASSES[size],
            POSITION_CLASSES[position],
            className,
        ),
    );

    // Función unificada para obtener la clase de animación
    function getAnimationClass(): string {
        switch (animationState) {
            case "closing":
                return "animate-modal-exit pointer-events-none";
            case "opening":
                return "animate-modal-enter";
            default:
                return "";
        }
    }

    // Función para limpiar timeouts
    function clearAnimationTimeout(): void {
        if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = undefined;
        }
    }

    // Efecto mejorado para manejar el ciclo de vida del modal
    $effect(() => {
        if (showModal && !dialog?.open && animationState === "idle") {
            openModal();
        } else if (!showModal && dialog?.open && animationState !== "closing") {
            closeModal();
        }
    });

    // Cleanup al desmontar el componente
    onMount(() => {
        return () => {
            clearAnimationTimeout();
        };
    });

    // Función optimizada para abrir el modal
    function openModal(): void {
        if (animationState !== "idle" || (persistent && !showModal)) return;

        clearAnimationTimeout();
        animationState = "opening";

        requestAnimationFrame(() => {
            dialog?.showModal();
            dialog?.focus();
            document.body.style.overflow = "hidden";
            onopen?.();
        });

        timeoutId = setTimeout(() => {
            animationState = "idle";
        }, ANIMATION_CONFIG.ENTER_DURATION);
    }

    // Función optimizada para cerrar el modal
    function closeModal(): void {
        if (animationState === "closing" || persistent) return;

        clearAnimationTimeout();
        animationState = "closing";
        document.body.style.overflow = "";

        timeoutId = setTimeout(() => {
            dialog?.close();
            showModal = false;
            animationState = "idle";
            onclose?.();
        }, ANIMATION_CONFIG.EXIT_DURATION);
    }

    // Manejadores de eventos optimizados
    function handleBackdropClick(event: MouseEvent): void {
        if (
            closeOnBackdrop &&
            event.target === dialog &&
            animationState !== "closing"
        ) {
            event.preventDefault();
            onbackdrop?.();
            closeModal();
        }
    }

    function handleKeydown(event: KeyboardEvent): void {
        if (!dialog?.open) return;

        if (
            event.key === "Escape" &&
            closeOnEscape &&
            animationState !== "closing"
        ) {
            event.preventDefault();
            event.stopPropagation();
            closeModal();
        } else if (event.key === "Tab") {
            handleTabKey(event);
        }
    }

    function handleTabKey(event: KeyboardEvent): void {
        if (!dialog) return;

        const focusableElements = dialog.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
        );
        const firstElement = focusableElements[0] as HTMLElement;
        const lastElement = focusableElements[
            focusableElements.length - 1
        ] as HTMLElement;

        if (event.shiftKey && document.activeElement === firstElement) {
            event.preventDefault();
            lastElement?.focus();
        } else if (!event.shiftKey && document.activeElement === lastElement) {
            event.preventDefault();
            firstElement?.focus();
        }
    }

    function handleDialogClose(): void {
        if (animationState !== "closing") {
            showModal = false;
            document.body.style.overflow = "";
        }
        clearAnimationTimeout();
        animationState = "idle";
    }

    function handleCloseClick(event?: Event): void {
        event?.preventDefault();
        event?.stopPropagation();
        closeModal();
    }
</script>

<dialog
    bind:this={dialog}
    {id}
    class={modalClasses}
    onclose={handleDialogClose}
    onclick={handleBackdropClick}
    onkeydown={handleKeydown}
    aria-modal="true"
    aria-labelledby={ariaLabelledby}
    aria-describedby={ariaDescribedby}
>
    <div
        class="modal-content p-2 sm:p-3 md:p-4 lg:p-6 space-y-2 sm:space-y-4 md:space-y-6 relative min-h-0 max-h-full overflow-y-auto focus:outline-none"
        role="document"
    >
        <!-- Header Section Mejorada -->
        {#if header}
            <header
                class="border-b border-border pb-2 sm:pb-3 md:pb-4 mb-1 sm:mb-2 sticky top-0 bg-background/95 backdrop-blur-sm z-10"
                id={ariaLabelledby ? ariaLabelledby : undefined}
            >
                <div
                    class="flex items-center justify-between gap-2 sm:gap-3 md:gap-4"
                >
                    <div class="flex-1 min-w-0">
                        {@render header()}
                    </div>
                    {#if !persistent}
                        <button
                            type="button"
                            onclick={handleCloseClick}
                            class={cn(
                                "p-1 sm:p-1.5 md:p-2 rounded-full text-muted-foreground hover:text-foreground",
                                "hover:bg-accent hover:text-accent-foreground transition-all duration-200",
                                "flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
                                "disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent",
                            )}
                            aria-label="Cerrar modal"
                            title="Cerrar modal (Esc)"
                            disabled={animationState === "closing"}
                        >
                            <X
                                class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5"
                                aria-hidden="true"
                            />
                        </button>
                    {/if}
                </div>
            </header>
        {:else if !persistent}
            <!-- Botón de cierre flotante cuando no hay header -->
            <div
                class="absolute top-2 right-2 sm:top-3 sm:right-3 md:top-4 md:right-4 z-20"
            >
                <button
                    type="button"
                    onclick={handleCloseClick}
                    class={cn(
                        "p-1 sm:p-1.5 md:p-2 rounded-full text-muted-foreground hover:text-foreground",
                        "hover:bg-accent hover:text-accent-foreground transition-all duration-200",
                        "bg-background/90 backdrop-blur-sm shadow-lg",
                        "focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
                        "disabled:opacity-50 disabled:cursor-not-allowed",
                    )}
                    aria-label="Cerrar modal"
                    title="Cerrar modal (Esc)"
                    disabled={animationState === "closing"}
                >
                    <X
                        class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5"
                        aria-hidden="true"
                    />
                </button>
            </div>
        {/if}

        <!-- Contenido Principal Mejorado -->
        <main
            class={cn(
                "flex-1 text-foreground leading-relaxed text-xs sm:text-sm md:text-base",
                "overflow-x-hidden overflow-y-auto",
                "focus:outline-none",
            )}
            id={ariaDescribedby ? ariaDescribedby : undefined}
            tabindex="-1"
        >
            {@render children()}
        </main>

        <!-- Footer Section Mejorada -->
        {#if footer}
            <footer
                class={cn(
                    "border-t border-border pt-2 sm:pt-4 md:pt-6 mt-2 sm:mt-4 md:mt-6",
                    "flex flex-col sm:flex-row sm:justify-end gap-2 sm:gap-3 md:gap-4",
                    "sticky bottom-0 bg-background/95 backdrop-blur-sm z-10",
                )}
            >
                {@render footer({ closeModal: handleCloseClick })}
            </footer>
        {/if}
    </div>
</dialog>

<style>
    /* ===========================================
       ANIMACIONES Y COMPORTAMIENTOS
       =========================================== */

    /* Animaciones de entrada modernas */
    @keyframes modal-enter {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
            filter: blur(4px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
            filter: blur(0);
        }
    }

    /* Animaciones de salida modernas */
    @keyframes modal-exit {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
            filter: blur(0);
        }
        to {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
            filter: blur(4px);
        }
    }

    /* Clases de animación modernas */
    .animate-modal-enter {
        animation: modal-enter 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animate-modal-exit {
        animation: modal-exit 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    /* ===========================================
       RESPONSIVE Y ACCESIBILIDAD
       =========================================== */

    /* Respeto por las preferencias de movimiento reducido */
    @media (prefers-reduced-motion: reduce) {
        .animate-modal-enter,
        .animate-modal-exit {
            animation: none;
        }

        .modal-content {
            scroll-behavior: auto;
        }
    }

    /* Mejora del contraste en modo oscuro */
    @media (prefers-color-scheme: dark) {
        dialog {
            color-scheme: dark;
            border: none;
            outline: none;
        }
    }

    /* Comportamiento de scroll suave */
    .modal-content {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
</style>

<!-- 

<script lang="ts">
    import Button from "@/Components/Button.svelte";
    import Modal from "@/Components/Modal.svelte";
    import AppLayout from "@/Layouts/AppLayout.svelte";

    let isOpen = $state(false);
    let isLoading = $state(false);

    // Funciones del modal
    function openModal() {
        isOpen = true;
    }
    <Tooltip content="Actualizar Usuario" position="top" closeDelay={200}>
        <Button onclick={openModal} variant="secondary">Editar User</Button>
    </Tooltip>

    <Modal bind:showModal={isOpen} position="center" size="xl">
        {#snippet header()}
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                Actualizar Permisos
            </h2>
        {/snippet}
        <p>hola bb</p>

        {#snippet footer({ closeModal })}
            <div class="flex justify-end space-x-3">
                <Button
                    variant="ghost"
                    onclick={closeModal}
                    disabled={isLoading}
                >
                    Cancelar
                </Button>
                <Button
                    variant="success"
                    size="lg"
                    disabled={isLoading}
                    loadingText="Actualizando permisos..."
                    {isLoading}
                >
                    Actualizar Permisos
                </Button>
            </div>
        {/snippet}
    </Modal>
-->