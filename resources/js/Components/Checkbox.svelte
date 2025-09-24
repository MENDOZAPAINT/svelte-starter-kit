<script lang="ts">
    import { Check, Minus } from "lucide-svelte";

    interface Props {
        checked?: boolean | null;
        indeterminate?: boolean;
        disabled?: boolean;
        variant?: "default" | "accent";
        size?: "sm" | "default" | "lg";
        name?: string;
        value?: string;
        id?: string;
        "aria-label"?: string;
        "aria-labelledby"?: string;
        "aria-describedby"?: string;
        onchange?: (event: Event) => void;
    }

    let {
        checked = $bindable(false),
        indeterminate = $bindable(false),
        disabled = false,
        variant = "default",
        size = "default",
        name,
        value,
        id,
        "aria-label": ariaLabel,
        "aria-labelledby": ariaLabelledby,
        "aria-describedby": ariaDescribedby,
        onchange
    }: Props = $props();

    const sizeConfig = {
        sm: {
            container: "w-4 h-4",
            icon: "w-3 h-3"
        },
        default: {
            container: "w-5 h-5",
            icon: "w-4 h-4"
        },
        lg: {
            container: "w-6 h-6",
            icon: "w-5 h-5"
        }
    };

    const config = $derived(sizeConfig[size]);

    const isChecked = $derived(checked && !indeterminate);
    const isIndeterminate = $derived(indeterminate);

    function toggle() {
        if (!disabled) {
            if (indeterminate) {
                indeterminate = false;
                checked = true;
            } else {
                checked = !checked;
            }

            // Call onchange callback if provided
            if (onchange) {
                const event = new Event('change', { bubbles: true });
                Object.defineProperty(event, 'target', {
                    value: { checked: checked },
                    enumerable: true
                });
                onchange(event);
            }
        }
    }

    function handleKeyDown(event: KeyboardEvent) {
        if (event.key === " " || event.key === "Enter") {
            event.preventDefault();
            toggle();
        }
    }
</script>

<button
    type="button"
    role="checkbox"
    aria-checked={isIndeterminate ? "mixed" : isChecked}
    aria-label={ariaLabel}
    aria-labelledby={ariaLabelledby}
    aria-describedby={ariaDescribedby}
    {id}
    {disabled}
    class="
        inline-flex items-center justify-center rounded-md border-2
        transition-all duration-150 ease-out
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2
        {config.container}
        {disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:scale-105 active:scale-95'}
        {isChecked || isIndeterminate
            ? 'bg-black border-black text-white shadow-md hover:bg-gray-800 hover:border-gray-800 hover:shadow-lg dark:bg-white dark:border-white dark:text-black dark:hover:bg-gray-100 dark:hover:border-gray-100'
            : 'border-gray-300 bg-white hover:border-black hover:bg-gray-50 dark:border-gray-800 dark:bg-black dark:hover:border-slate-900 dark:hover:bg-black'}
    "
    onclick={toggle}
    onkeydown={handleKeyDown}
>
    {#if isChecked}
        <Check 
            class="{config.icon} transition-all duration-150 ease-out transform {isChecked ? 'scale-100 opacity-100' : 'scale-75 opacity-0'}" 
        />
    {:else if isIndeterminate}
        <Minus 
            class="{config.icon} transition-all duration-150 ease-out transform {isIndeterminate ? 'scale-100 opacity-100' : 'scale-75 opacity-0'}" 
        />
    {/if}

    <!-- Hidden input for form submission -->
    <input
        type="checkbox"
        {name}
        {value}
        bind:checked
        {disabled}
        class="sr-only"
        tabindex="-1"
    />
</button>

<style>
    button {
        will-change: background-color, border-color, transform, box-shadow;
        backface-visibility: hidden;
        -webkit-font-smoothing: antialiased;
    }
    button:hover {
        transform: scale(1.05);
    }

    button:active {
        transform: scale(0.95);
    }

    button:disabled:hover {
        transform: none;
    }
</style>

<!-- 
        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2">
                <Checkbox size="sm" checked={true} />
                <span class="text-sm text-gray-600 dark:text-gray-400"
                    >Small (16px)</span
                >
            </div>
            <div class="flex items-center space-x-2">
                <Checkbox size="default" checked={true} />
                <span class="text-sm text-gray-600 dark:text-gray-400"
                    >Default (20px)</span
                >
            </div>
            <div class="flex items-center space-x-2">
                <Checkbox size="lg" checked={true} />
                <span class="text-sm text-gray-600 dark:text-gray-400"
                    >Large (24px)</span
                >
            </div>
        </div>
-->