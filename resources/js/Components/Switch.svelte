<script lang="ts">
    import type { Snippet } from "svelte";

    interface Props {
        checked?: boolean;
        disabled?: boolean;
        size?: "sm" | "md" | "lg";
        name?: string;
        value?: string;
        startIcon?: Snippet;
        endIcon?: Snippet;
        thumbIcon?: Snippet;
    }

    let {
        checked = $bindable(false),
        disabled = false,
        size = "md",
        name,
        value,
        startIcon,
        endIcon,
        thumbIcon
    }: Props = $props();

    const sizeConfig = {
        sm: {
            width: "w-8",
            height: "h-5",
            thumbSize: "w-3 h-3",
            padding: "p-0.5",
            iconSize: "w-2.5 h-2.5",
            iconLeft: "left-1",
            iconRight: "right-1"
        },
        md: {
            width: "w-12",
            height: "h-6",
            thumbSize: "w-4 h-4",
            padding: "p-1",
            iconSize: "w-3 h-3",
            iconLeft: "left-1.5",
            iconRight: "right-1.5"
        },
        lg: {
            width: "w-14",
            height: "h-7",
            thumbSize: "w-5 h-5",
            padding: "p-1",
            iconSize: "w-4 h-4",
            iconLeft: "left-2",
            iconRight: "right-2"
        }
    };

    const config = $derived(sizeConfig[size]);

    function toggle() {
        if (!disabled) {
            checked = !checked;
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
    role="switch"
    aria-checked={checked}
    {disabled}
    class="
        relative inline-flex items-center overflow-hidden rounded-full
        transition-colors duration-200 ease-in-out
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
        {config.width} {config.height}
        {disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'}
        {checked
            ? 'bg-black hover:bg-black/90 dark:bg-white dark:hover:bg-white/90'
            : 'bg-slate-200 hover:bg-gray-400 dark:bg-zinc-800 dark:hover:bg-zinc-700'}
    "
    onclick={toggle}
    onkeydown={handleKeyDown}
>
    <!-- Start Icon -->
    {#if startIcon && !checked}
        <div class="absolute z-10 {config.iconLeft} {config.iconSize} flex items-center justify-center text-white dark:text-black">
            {@render startIcon()}
        </div>
    {/if}

    <!-- End Icon -->
    {#if endIcon && checked}
        <div class="absolute z-10 {config.iconRight} {config.iconSize} flex items-center justify-center text-black dark:text-white">
            {@render endIcon()}
        </div>
    {/if}

    <!-- Thumb -->
    <div
        class="absolute {config.padding} transition-transform duration-200 ease-in-out {checked ? 'translate-x-full' : 'translate-x-0'}"
    >
        <div
            class="
                {config.thumbSize} rounded-full shadow-lg
                flex items-center justify-center
                transition-colors duration-200 ease-in-out
                {checked ? 'bg-white dark:bg-black' : 'bg-black dark:bg-white'}
            "
        >
            {#if thumbIcon}
                <div class="{config.iconSize} text-zinc-800 dark:text-white">
                    {@render thumbIcon()}
                </div>
            {/if}
        </div>
    </div>

    <!-- Hidden input -->
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
        will-change: background-color;
    }

    button > div {
        will-change: transform;
    }
</style>

<!--
<script lang="ts">
    import Switch from "@/Components/Switch.svelte";
    import { Check, X } from "lucide-svelte";


    let iconSwitch = $state(true);
</script> 
    <Switch bind:checked={iconSwitch} size="md">
        {#snippet startIcon()}<X class="w-3 h-3" />{/snippet}
        {#snippet endIcon()}<Check class="w-3 h-3" />{/snippet}
    </Switch>
-->