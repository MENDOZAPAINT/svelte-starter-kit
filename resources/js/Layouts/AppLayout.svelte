<script lang="ts">
    import type { Snippet } from "svelte";
    import SidebarLayout from "../Layouts/App/SidebarLayout.svelte";
    interface Props {
        children: Snippet;
        title: string;
    }
    let { children, title = "" }: Props = $props();
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<SidebarLayout title={title}>
    {#if children}
        {@render children()}
    {/if}
</SidebarLayout>
