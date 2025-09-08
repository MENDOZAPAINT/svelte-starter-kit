<script lang="ts">
    import { onDestroy, type Snippet } from "svelte";
    import { fade } from "svelte/transition";

    interface Props {
        content: string;
        position?: "top" | "bottom" | "left" | "right";
        disabled?: boolean;
        delay?: number;
        children: Snippet;
    }

    let {
        content,
        position = "right",
        disabled = false,
        delay = 200,
        children,
    }: Props = $props();

    let showTooltip = $state(false);
    let tooltipElement: HTMLElement | null = $state(null);
    let triggerElement: HTMLElement;
    let timeoutId: number;
    let tooltipPosition = $state({ x: 0, y: 0 });

    function handleMouseEnter() {
        if (disabled) return;

        // Calculate position relative to viewport
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

        timeoutId = window.setTimeout(() => {
            showTooltip = true;
        }, delay);
    }

    function handleMouseLeave() {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        showTooltip = false;
    }

    function handleFocus() {
        if (disabled) return;
        showTooltip = true;
    }

    function handleBlur() {
        showTooltip = false;
    }

    onDestroy(() => {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
    });

    function getTooltipClasses() {
        const baseClasses =
            "fixed z-[9999] px-3 py-2 text-sm font-medium text-slate-900 bg-slate-300 dark:bg-white rounded-md shadow-lg whitespace-nowrap pointer-events-none border border-slate-300";

        switch (position) {
            case "top":
                return `${baseClasses} transform -translate-x-1/2 -translate-y-full`;
            case "bottom":
                return `${baseClasses} transform -translate-x-1/2`;
            case "left":
                return `${baseClasses} transform -translate-x-full -translate-y-1/2`;
            case "right":
                return `${baseClasses} transform -translate-y-1/2`;
            default:
                return `${baseClasses} transform -translate-y-1/2`;
        }
    }
</script>

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
        <div
            bind:this={tooltipElement}
            class={getTooltipClasses()}
            style="left: {tooltipPosition.x}px; top: {tooltipPosition.y}px;"
            transition:fade={{ duration: 150 }}
            role="tooltip"
            aria-hidden="false"
        >
            {content}

            <!-- Arrow -->
            {#if position === "right"}
                <div
                    class="absolute left-0 top-1/2 transform -translate-x-full -translate-y-1/2 border-[6px] border-transparent border-r-slate-300 dark:border-r-slate-300"
                ></div>
            {:else if position === "left"}
                <div
                    class="absolute right-0 top-1/2 transform translate-x-full -translate-y-1/2 border-[6px] border-transparent border-l-gray-900 dark:border-l-gray-800"
                ></div>
            {:else if position === "top"}
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full border-[6px] border-transparent border-t-gray-900 dark:border-t-gray-800"
                ></div>
            {:else if position === "bottom"}
                <div
                    class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-full border-[6px] border-transparent border-b-gray-900 dark:border-b-gray-800"
                ></div>
            {/if}
        </div>
    {/if}
</div>
