<script lang="ts">
    import { Link, router } from "@inertiajs/svelte";
    import { LogOut } from "lucide-svelte";

    function handleLogout() {
        router.flushAll();
    }
</script>

<Link
    href="/logout"
    method="post"
    as="button"
    class="group flex items-center gap-2 w-full px-2 py-1.5 text-sm text-destructive hover:bg-destructive/10 hover:text-destructive rounded-md transition-all duration-200 ease-out hover:scale-[1.02] hover:translate-x-1 active:scale-[0.98] active:translate-x-0 hover:shadow-sm focus:ring-2 focus:ring-red-500/20 focus:outline-none"
    on:click={handleLogout}
>
    <LogOut
        class="h-4 w-4 transition-all duration-200 ease-out group-hover:scale-110 group-hover:rotate-3"
        aria-hidden="true"
    />
    Cerrar sesión
</Link>
