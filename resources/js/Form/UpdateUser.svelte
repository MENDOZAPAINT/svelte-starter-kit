<!-- UpdateUserForm.svelte -->
<script lang="ts">
    import Button from "@/Components/Button.svelte";
    import Drawer from "@/Components/Drawer.svelte";
    import Input from "@/Components/Input.svelte";
    import Label from "@/Components/Label.svelte";
    import { router, page } from "@inertiajs/svelte";
    import { User } from "lucide-svelte";

    // const currentUser = $derived($page.props.auth.user);
    const currentUser: User | null = $state($page.props.auth?.user ?? null);

    let showRightDrawer = $state(false);
    let isLoading = $state(false);
    let errors = $state({});

    // Form data - reactive object
    let formData = $state({
        name: "",
        email: "",
    });

    // Initialize form data when drawer opens
    function openDrawer() {
        if (!currentUser) return;

        // Reset form and errors
        formData.name = currentUser.name;
        formData.email = currentUser.email;
        errors = {};
        showRightDrawer = true;
    }

    function handleSubmit(e?: Event) {
        e?.preventDefault();
        if (!currentUser || isLoading) return;

        isLoading = true;
        errors = {}; // Reset errors

        router.put(`/user/${currentUser.id}`, formData, {
            // 🔑 Simula redirección completa pero suave
            preserveState: false, // Refresca toda la página
            preserveScroll: false, // Reinicia scroll position
            replace: true, // Reemplaza historial
            onSuccess: () => {
                // El drawer se cerrará automáticamente porque toda la página se refresca
                console.log("Usuario actualizado - página refrescada");
            },
            onError: (validationErrors) => {
                errors = validationErrors;
                console.log("Errores de validación:", validationErrors);
            },
            onFinish: () => {
                isLoading = false;
            },
        });
    }

    // Función para limpiar formulario al cerrar
    function handleDrawerClose() {
        errors = {};
        showRightDrawer = false;
    }
</script>

{#if currentUser}
    <Button variant="secondary" onclick={openDrawer}>Editar Usuario</Button>

    <Drawer bind:showDrawer={showRightDrawer} position="right" size="lg">
        {#snippet header()}
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Actualizar Usuario
            </h2>
        {/snippet}

        <form onsubmit={handleSubmit} class="space-y-4">
            <div>
                <Label for="name">Nombre:</Label>
                <Input
                    id="name"
                    bind:value={formData.name}
                    placeholder="Nombre completo"
                    disabled={isLoading}
                />
            </div>

            <div>
                <Label for="email">Email:</Label>
                <Input
                    id="email"
                    type="email"
                    bind:value={formData.email}
                    placeholder="correo@ejemplo.com"
                    disabled={isLoading}
                />
            </div>
        </form>

        {#snippet footer({ closeDrawer })}
            <div class="flex justify-end space-x-3">
                <Button
                    variant="ghost"
                    onclick={() => {
                        handleDrawerClose();
                        closeDrawer();
                    }}
                    disabled={isLoading}
                >
                    Cancelar
                </Button>
                <Button
                    variant="success"
                    disabled={isLoading}
                    loadingText="Actualizando..."
                    {isLoading}
                    onclick={handleSubmit}
                >
                    Actualizar Usuario
                </Button>
            </div>
        {/snippet}
    </Drawer>
{:else}
    <p class="text-gray-500 dark:text-gray-400">Usuario no autenticado</p>
{/if}
