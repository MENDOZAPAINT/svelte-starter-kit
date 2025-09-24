<!-- Button.svelte -->
<script lang="ts">
    import type { Snippet } from "svelte";
    import { cn } from "@/lib/utils";

    interface Props {
        isLoading?: boolean;
        disabled?: boolean;
        loadingText?: string;
        defaultText?: string;
        variant?: "primary" | "secondary" | "success" | "danger" | "ghost" | "outline";
        size?: "sm" | "md" | "lg";
        type?: "button" | "submit" | "reset";
        onclick?: () => void;
        class?: string;
        children?: Snippet;
    }

    let {
        isLoading = false,
        disabled = false,
        loadingText = "Cargando...",
        defaultText = "Enviar",
        variant = "primary",
        size = "md",
        type = "button",
        onclick,
        class: className = "",
        children,
    }: Props = $props();

    // Variantes de color coherentes con la aplicación
    const variants = {
        primary:
            "text-white bg-blue-600 border border-transparent hover:bg-blue-700 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600 shadow-sm transition-all duration-200",
        secondary:
            "text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-blue-500 dark:bg-black dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-900 shadow-sm transition-all duration-200",
        success:
            "text-white bg-green-600 border border-transparent hover:bg-green-700 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-600 shadow-sm transition-all duration-200",
        danger: 
            "text-white bg-red-600 border border-transparent hover:bg-red-700 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600 shadow-sm transition-all duration-200",
        ghost:
            "text-gray-700 bg-transparent border border-transparent hover:bg-gray-50 focus:ring-blue-500 dark:text-gray-300 dark:hover:bg-gray-900 transition-all duration-200",
        outline:
            "text-blue-600 bg-transparent border border-blue-600 hover:bg-blue-50 focus:ring-blue-500 dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-900/20 transition-all duration-200",
    };

    // Tamaños
    const sizes = {
        sm: "px-3 py-1.5 text-xs",
        md: "px-4 py-2 text-sm",
        lg: "px-6 py-3 text-base",
    };

    // Estados computados
    const isDisabled = $derived(isLoading || disabled);

    const buttonClasses = $derived(cn(
        "inline-flex items-center justify-center",
        "font-medium rounded-md transition-colors",
        "focus:outline-none focus:ring-2 focus:ring-offset-2",
        "disabled:opacity-50 disabled:cursor-not-allowed",
        variants[variant],
        sizes[size],
        className
    ));

    function handleClick() {
        if (!isDisabled && onclick) {
            onclick();
        }
    }
</script>

<button
    {type}
    class={buttonClasses}
    disabled={isDisabled}
    onclick={handleClick}
>
    {#if isLoading}
        <div class="flex items-center">
            <svg
                class="animate-spin -ml-1 mr-2 h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
            </svg>
            {loadingText}
        </div>
    {:else if children}
        {@render children()}
    {:else}
        {defaultText}
    {/if}
</button>
