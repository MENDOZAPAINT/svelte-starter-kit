<script lang="ts">
    import Span from "@/Components/Span.svelte";
    import UpdateUser from "@/Form/UpdateUser.svelte";
    import AppLayout from "@/Layouts/AppLayout.svelte";
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
                                src="https://img.freepik.com/vector-premium/ilustracion-vector-prueba-trabajo-examen_138676-243.jpg"
                                alt=""
                                class="rounded-full w-full h-full"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2 p-2">
                        <h2>Juan Mendoza Montoya</h2>
                        <Span variant="purple">Juan.Mendoza@example.com</Span>
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
                <UpdateUser/>
            </div>
        </div>
    </div>
</AppLayout>
