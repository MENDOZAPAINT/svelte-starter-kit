<script lang="ts">
    import { onDestroy, type Snippet } from "svelte";
    import { cubicOut, backOut } from "svelte/easing";

    // Gestor global del tooltip activo (similar a un Provider)
    const ACTIVE_KEY = "__tooltip_global_active__" as const;
    type ActiveEntry = {
        token: symbol;
        hideImmediately: () => void;
        cancelClose: () => void;
    };
    function getActive(): ActiveEntry | undefined {
        return (globalThis as any)[ACTIVE_KEY] as ActiveEntry | undefined;
    }
    function setActive(entry: ActiveEntry) {
        (globalThis as any)[ACTIVE_KEY] = entry;
    }
    function clearActive(token: symbol) {
        const a = getActive();
        if (a && a.token === token) {
            (globalThis as any)[ACTIVE_KEY] = undefined;
        }
    }

    interface Props {
        content: string;
        position?: "top" | "bottom" | "left" | "right";
        disabled?: boolean;
        openDelay?: number;
        closeDelay?: number;
        fastTransition?: boolean;
        animationDuration?: number;
        children: Snippet;
    }

    let {
        content,
        position = "right",
        disabled = false,
        openDelay = 0,
        closeDelay = 300,
        fastTransition = false,
        animationDuration,
        children,
    }: Props = $props();

    let showTooltip = $state(false);
    let tooltipElement: HTMLElement | null = $state(null);
    let triggerElement: HTMLElement;
    let openTimeoutId: number;
    let closeTimeoutId: number;
    let tooltipPosition = $state({ x: 0, y: 0 });

    // Identificador único de esta instancia
    const INSTANCE_TOKEN = Symbol("tooltip-instance");

    function hideImmediately() {
        if (openTimeoutId) {
            clearTimeout(openTimeoutId);
        }
        if (closeTimeoutId) {
            clearTimeout(closeTimeoutId);
        }
        showTooltip = false;
    }

    function cancelClose() {
        if (closeTimeoutId) {
            clearTimeout(closeTimeoutId);
        }
    }

    function computePosition() {
        if (!triggerElement) return;
        const rect = triggerElement.getBoundingClientRect();
        const spacing = 12;
        switch (position) {
            case "top":
                tooltipPosition.x = rect.left + rect.width / 2;
                tooltipPosition.y = rect.top - spacing;
                break;
            case "bottom":
                tooltipPosition.x = rect.left + rect.width / 2;
                tooltipPosition.y = rect.bottom + spacing;
                break;
            case "left":
                tooltipPosition.x = rect.left - spacing;
                tooltipPosition.y = rect.top + rect.height / 2;
                break;
            case "right":
                tooltipPosition.x = rect.right + spacing;
                tooltipPosition.y = rect.top + rect.height / 2;
                break;
        }
    }

    function handleMouseEnter() {
        if (disabled) return;
        const active = getActive();
        if (active && active.token !== INSTANCE_TOKEN) {
            // Oculta inmediatamente el anterior para cambiar rápido
            active.hideImmediately();
        }
        setActive({ token: INSTANCE_TOKEN, hideImmediately, cancelClose });

        cancelClose();
        // Asegura posición antes de mostrar
        computePosition();
        openTimeoutId = window.setTimeout(() => {
            showTooltip = true;
        }, openDelay);
    }

    function handleMouseLeave() {
        if (openTimeoutId) {
            clearTimeout(openTimeoutId);
        }
        closeTimeoutId = window.setTimeout(() => {
            showTooltip = false;
        }, closeDelay);
    }

    function handleFocus() {
        if (disabled) return;
        const active = getActive();
        if (active && active.token !== INSTANCE_TOKEN) {
            active.hideImmediately();
        }
        setActive({ token: INSTANCE_TOKEN, hideImmediately, cancelClose });

        cancelClose();
        computePosition();
        showTooltip = true;
    }

    function handleBlur() {
        closeTimeoutId = window.setTimeout(() => {
            showTooltip = false;
        }, closeDelay);
    }

    onDestroy(() => {
        if (openTimeoutId) {
            clearTimeout(openTimeoutId);
        }
        if (closeTimeoutId) {
            clearTimeout(closeTimeoutId);
        }
        clearActive(INSTANCE_TOKEN);
    });

    function getTooltipClasses() {
        return "fixed z-[9999] px-3 py-2 text-sm font-medium text-white dark:text-black bg-black dark:bg-white rounded-lg shadow-xl whitespace-nowrap pointer-events-none backdrop-blur-sm transform-gpu";
    }

    function getPositionClasses() {
        switch (position) {
            case "top":
                return "transform -translate-x-1/2 -translate-y-full";
            case "bottom":
                return "transform -translate-x-1/2";
            case "left":
                return "transform -translate-x-full -translate-y-1/2";
            case "right":
            default:
                return "transform -translate-y-1/2";
        }
    }

    function getArrowClasses() {
        switch (position) {
            case "right":
                return "absolute left-0 top-1/2 transform -translate-x-full -translate-y-1/2 border-[6px] border-transparent border-r-black dark:border-r-white transition-none";
            case "left":
                return "absolute right-0 top-1/2 transform translate-x-full -translate-y-1/2 border-[6px] border-transparent border-l-black dark:border-l-white transition-none";
            case "top":
                return "absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full border-[6px] border-transparent border-t-black dark:border-t-white transition-none";
            case "bottom":
            default:
                return "absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-full border-[6px] border-transparent border-b-black dark:border-b-white transition-none";
        }
    }
    // Spring config inspired by Animate UI defaults
    const SPRING = { stiffness: 300, damping: 35, mass: 1 } as const;

    // Create a spring-based easing function using a damped harmonic oscillator model
    function createSpringEasing({
        stiffness,
        damping,
        mass,
    }: {
        stiffness: number;
        damping: number;
        mass: number;
    }) {
        const w0 = Math.sqrt(stiffness / mass); // undamped natural frequency (rad/s)
        const zeta = damping / (2 * Math.sqrt(stiffness * mass)); // damping ratio
        if (zeta < 1) {
            // underdamped
            const wd = w0 * Math.sqrt(1 - zeta * zeta); // damped natural frequency
            const A = 1 / Math.sqrt(1 - zeta * zeta);
            const phi = Math.acos(zeta);
            return (t: number, totalMs: number) => {
                const time = (t * totalMs) / 1000; // seconds
                return (
                    1 -
                    A * Math.exp(-zeta * w0 * time) * Math.sin(wd * time + phi)
                );
            };
        } else {
            // critically damped or overdamped
            return (t: number, totalMs: number) => {
                const time = (t * totalMs) / 1000; // seconds
                return 1 - Math.exp(-w0 * time) * (1 + w0 * time);
            };
        }
    }

    const springEase = createSpringEasing(SPRING);

    const ANIMATION_CONFIG = {
        // Aprox. a la sensación por defecto de Animate UI
        duration: 320,
        delay: 0,
        easing: cubicOut,
        scaleRange: { min: 0.96, max: 1.0 },
        offset: 10, // px directional slide (sideOffset)
    } as const;

    const TRANSFORM_ORIGINS = {
        top: "bottom center",
        bottom: "top center",
        left: "right center",
        right: "left center",
    } as const;

    function getTransformOrigin(): string {
        return TRANSFORM_ORIGINS[position] || TRANSFORM_ORIGINS.right;
    }

    function calculateScale(progress: number): number {
        const { min, max } = ANIMATION_CONFIG.scaleRange;
        return min + (max - min) * progress;
    }

    function getDirectionalOffset(p: number): string {
        // p = 0 (hidden) -> full offset; p = 1 (shown) -> no offset
        const d = (1 - p) * ANIMATION_CONFIG.offset;
        switch (position) {
            case "top":
                return `translate3d(0, ${-d}px, 0)`;
            case "bottom":
                return `translate3d(0, ${d}px, 0)`;
            case "left":
                return `translate3d(${-d}px, 0, 0)`;
            case "right":
            default:
                return `translate3d(${d}px, 0, 0)`;
        }
    }

    function tooltipTransition(node: Element, options = {}) {
        const duration =
            animationDuration ||
            (fastTransition ? 220 : ANIMATION_CONFIG.duration);
        const config = {
            ...ANIMATION_CONFIG,
            duration,
            ...options,
        } as typeof ANIMATION_CONFIG & { duration: number };

        return {
            delay: config.delay,
            duration: config.duration,
            // easing is handled by the custom spring function below via p
            css: (t: number) => {
                // spring progress in [0,1]
                const p = springEase(t, config.duration);
                const scale = calculateScale(p);
                const opacity = p;
                const transformOrigin = getTransformOrigin();
                const directionalOffset = getDirectionalOffset(p);

                return `
                    transform-origin: ${transformOrigin};
                    transform: ${directionalOffset} scale(${scale});
                    opacity: ${opacity};
                    will-change: transform, opacity;
                `;
            },
        };
    }

    const transitionVariants = {
        default: (node: Element) => tooltipTransition(node),
        fast: (node: Element) => tooltipTransition(node, { duration: 200 }),
        slow: (node: Element) => tooltipTransition(node, { duration: 380 }),
        bounce: (node: Element) =>
            tooltipTransition(node, { easing: backOut, duration: 260 }),
    } as const;

    function getTransitionFunction() {
        if (fastTransition) return transitionVariants.fast;
        return transitionVariants.default;
    }
</script>

<div>
    <div
        class="relative inline-block"
        bind:this={triggerElement}
        onmouseenter={handleMouseEnter}
        onmouseleave={handleMouseLeave}
        onfocus={handleFocus}
        onblur={handleBlur}
        role="button"
        tabindex="0"
    >
        {@render children()}

        {#if showTooltip && content}
            <!-- Outer wrapper: positioned and statically transformed -->
            <div
                bind:this={tooltipElement}
                class={`${getTooltipClasses()} ${getPositionClasses()}`}
                style="left: {tooltipPosition.x}px; top: {tooltipPosition.y}px;"
                role="tooltip"
                aria-hidden="false"
            >
                <!-- Arrow now rendered with the outer container (no animation) -->
                <div class={getArrowClasses()}></div>

                <!-- Inner: animated content only (no static position transforms here) -->
                <div
                    transition:getTransitionFunction()
                    style="transform-origin: {getTransformOrigin()};"
                >
                    {content}
                </div>
            </div>
        {/if}
    </div>
</div>
