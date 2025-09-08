<script lang="ts">
    import { Link } from "@inertiajs/svelte";
    import { User, Home, Settings } from "lucide-svelte";

    const navItems: NavItem[] = [
        { icon: Home, title: "Inicio", href: "/" },
        { icon: User, title: "Perfil", href: "/profile" },
        { icon: Settings, title: "Configuración", href: "/settings" }
    ];
</script>

<aside class="w-64 h-screen bg-black text-white p-4">
    {#each navItems as item}
        <Link href={item.href} class="flex items-center space-x-2 p-2 hover:bg-gray-900 rounded">
            {#if item.icon}
                {@const Icon = item.icon}
                <Icon size={20} class="text-gray-600" />
            {/if}
            {#if item.title}
                <span>{item.title}</span>
            {/if}
        </Link>
    {/each}
</aside>
