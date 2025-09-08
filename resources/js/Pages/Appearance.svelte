<script lang="ts">
    import { useAppearance, type Appearance } from "@/hooks/useAppearance";
    import { Monitor, Moon, Sun, ChevronDown } from "lucide-svelte";
    import { onMount } from "svelte";

    const appearanceStore = useAppearance();
    const { updateAppearance } = appearanceStore;

    const options = [
        { value: "light", Icon: Sun, label: "Light" },
        { value: "dark", Icon: Moon, label: "Dark" },
        { value: "system", Icon: Monitor, label: "System" },
    ] as const;

    let isOpen = $state(false);
    let dropdownRef = $state<HTMLDivElement>();

    const currentOption = $derived(
        options.find((option) => option.value === $appearanceStore) ||
            options[0],
    );

    function toggleDropdown() {
        isOpen = !isOpen;
    }

    function selectOption(value: Appearance) {
        updateAppearance(value);
        isOpen = false;
    }

    function handleClickOutside(event: MouseEvent) {
        if (dropdownRef && !dropdownRef.contains(event.target as Node)) {
            isOpen = false;
        }
    }

    onMount(() => {
        document.addEventListener("click", handleClickOutside);
        return () => {
            document.removeEventListener("click", handleClickOutside);
        };
    });
</script>

<div class="relative" bind:this={dropdownRef}>
    <button
        onclick={toggleDropdown}
        class="flex items-center justify-between rounded-lg bg-neutral-100 px-3.5 py-2 text-sm transition-colors hover:bg-neutral-200 dark:bg-neutral-900 dark:hover:bg-neutral-900 min-w-[120px]"
    >
        <div class="flex items-center">
            <currentOption.Icon class="h-4 w-4" />
            <span class="ml-2">{currentOption.label}</span>
        </div>
        <ChevronDown
            class="h-4 w-4 transition-transform {isOpen ? 'rotate-180' : ''}"
        />
    </button>

    {#if isOpen}
        <div
            class="absolute top-full left-0 mt-1 w-full rounded-lg bg-white shadow-lg border border-neutral-200 dark:bg-neutral-900 dark:border-neutral-700 z-10"
        >
            {#each options as { value, Icon, label } (value)}
                <button
                    onclick={() => selectOption(value)}
                    class="flex items-center w-full px-3.5 py-2 text-sm text-left transition-colors hover:bg-neutral-100 dark:hover:bg-neutral-700 first:rounded-t-lg last:rounded-b-lg {$appearanceStore ===
                    value
                        ? 'bg-neutral-50 dark:bg-neutral-700/50 text-neutral-900 dark:text-neutral-100'
                        : 'text-neutral-700 dark:text-neutral-300'}"
                >
                    <Icon class="h-4 w-4" />
                    <span class="ml-2">{label}</span>
                    {#if $appearanceStore === value}
                        <div
                            class="ml-auto h-2 w-2 rounded-full bg-blue-500"
                        ></div>
                    {/if}
                </button>
            {/each}
        </div>
    {/if}
</div>
