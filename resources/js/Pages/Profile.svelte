<script lang="ts">
    import Span from "@/Components/Span.svelte";
    import UpdateAvatar from "@/Form/UpdateAvatar.svelte";
    import UpdatePassword from "@/Form/UpdatePassword.svelte";
    import UpdateUser from "@/Form/UpdateUser.svelte";
    import AppLayout from "@/Layouts/AppLayout.svelte";
    import { page } from "@inertiajs/svelte";
    import { User } from "lucide-svelte";

    const user: User | null = $state($page.props.auth?.user ?? null);
</script>

<AppLayout title="Profile">
    <div class="space-y-8 p-6">
        <div
            class="bg-amber-900 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 p-3 rounded-lg"
        >
            <div
                class="bg-blue-400 p-4 rounded-lg col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2 xl:col-span-2"
            >
                <div class="grid grid-cols-3 gap-1">
                    <div class="col-span-1">
                        <div class="w-32 h-32 p-4">
                            <img
                                src={user?.avatar ?? "https://img.freepik.com/vector-premium/ilustracion-vector-prueba-trabajo-examen_138676-243.jpg"}
                                alt={user?.name ?? "User Avatar"}
                                class="rounded-full w-full h-full object-cover"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2 p-2">
                        <h2>{user?.name}</h2>
                        <Span variant="purple">{user?.email}</Span>
                    </div>
                </div>
            </div>
            <div
                class="bg-green-800 p-4 rounded-lg col-span-1 sm:col-span-1 md:col-span-2 lg:col-span-2 xl:col-span-4"
            >
                <span
                    class="text-lg sm:text-xl md:text-2xl font-semibold text-white"
                    >02</span
                >
                <UpdateUser />
                <UpdateAvatar />
                <UpdatePassword />
            </div>
        </div>
    </div>
</AppLayout>
