<script lang="ts">
    import { cn } from "@/lib/utils";
    import type { Snippet } from "svelte";
    import Card from "@/Components/ui/Card.svelte";
    import CardHeader from "@/Components/ui/CardHeader.svelte";

    let {
        title = $bindable("Authentication"),
        class: className = "",
        children,
    }: {
        title?: string;
        class?: string;
        children?: Snippet;
    } = $props();
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>
<div
    class={cn(
        "flex min-h-svh flex-col items-center justify-center bg-muted p-6 md:p-10",
        className,
    )}
>
    <div class="w-full max-w-sm md:max-w-3xl">
        <Card class="mx-auto w-full max-w-md">
            <CardHeader>
                {#if children}
                    {@render children()}
                {/if}
            </CardHeader>
        </Card>
    </div>
</div>
