<script lang="ts">
    import SidebarHeader from "./SidebarHeader.svelte";
    import SidebarNavigation from "./SidebarNavigation.svelte";
    import SidebarFooter from "./SidebarFooter.svelte";
    import { cn } from "../../../lib/utils";

    interface Props {
        isDesktop: boolean;
        sidebarCollapsed: boolean;
        data: any;
        handleNavClick: () => void;
    }

    let { isDesktop, sidebarCollapsed, data, handleNavClick }: Props = $props();
</script>

<!-- Sidebar Content -->
<aside
    class={cn(
        "flex flex-col h-screen bg-sidebar text-sidebar-foreground border-r border-sidebar-border transition-all duration-300 ease-in-out overflow-hidden",
        isDesktop
            ? sidebarCollapsed
                ? "w-16"
                : "w-64"
            : "w-64",
    )}
    aria-label="Barra lateral de navegación"
>
    <SidebarHeader 
        {isDesktop} 
        {sidebarCollapsed} 
        {data} 
        {handleNavClick} 
    />
    
    <SidebarNavigation 
        {isDesktop} 
        {sidebarCollapsed} 
        {data} 
        {handleNavClick} 
    />
    
    <SidebarFooter 
        {isDesktop} 
        {sidebarCollapsed} 
        {data} 
    />
</aside>