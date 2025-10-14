<!-- UpdatePassword.svelte -->
<script lang="ts">
    import Button from "@/Components/Button.svelte";
    import Drawer from "@/Components/Drawer.svelte";
    import Input from "@/Components/Input.svelte";
    import Label from "@/Components/Label.svelte";
    import { router, page } from "@inertiajs/svelte";
    import { Lock, User } from "lucide-svelte";

    // const currentUser = $derived($page.props.auth.user);
    const currentUser: User | null = $state($page.props.auth?.user ?? null);

    let showRightDrawer = $state(false);
    let isLoading = $state(false);
    let errors = $state<{
        current_password?: string;
        password?: string;
        password_confirmation?: string;
    }>({});
    
    // Form data for password update
    let formData = $state<{
        current_password: string;
        password: string;
        password_confirmation: string;
    }>({
        current_password: '',
        password: '',
        password_confirmation: ''
    });

    // Initialize form data when drawer opens
    function openDrawer() {
        if (!currentUser) return;

        // Reset form and errors
        formData = {
            current_password: '',
            password: '',
            password_confirmation: ''
        };
        errors = {};
        showRightDrawer = true;
    }

    function handleSubmit(e?: Event) {
        e?.preventDefault();
        if (!currentUser || isLoading) return;

        isLoading = true;
        errors = {}; // Reset errors

        router.put('/password', formData, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                console.log("Contraseña actualizada exitosamente");
                // Reset form after successful update
                formData = {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                };
                showRightDrawer = false;
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
        formData = {
            current_password: '',
            password: '',
            password_confirmation: ''
        };
        showRightDrawer = false;
    }
</script>

{#if currentUser}
    <Button variant="secondary" onclick={openDrawer}>Cambiar Contraseña</Button>

    <Drawer bind:showDrawer={showRightDrawer} position="right" size="lg">
        {#snippet header()}
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Cambiar Contraseña
            </h2>
        {/snippet}

        <form onsubmit={handleSubmit} class="space-y-6">
            <!-- Current Password -->
            <div class="space-y-2">
                <Label for="current_password">Contraseña Actual</Label>
                <Input
                    id="current_password"
                    type="password"
                    bind:value={formData.current_password}
                    placeholder="Ingresa tu contraseña actual"
                    disabled={isLoading}
                    required
                />
                {#if errors.current_password}
                    <p class="text-sm text-red-600 dark:text-red-400">
                        {errors.current_password}
                    </p>
                {/if}
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <Label for="password">Nueva Contraseña</Label>
                <Input
                    id="password"
                    type="password"
                    bind:value={formData.password}
                    placeholder="Ingresa tu nueva contraseña"
                    disabled={isLoading}
                    required
                />
                {#if errors.password}
                    <p class="text-sm text-red-600 dark:text-red-400">
                        {errors.password}
                    </p>
                {/if}
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <Label for="password_confirmation">Confirmar Nueva Contraseña</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    bind:value={formData.password_confirmation}
                    placeholder="Confirma tu nueva contraseña"
                    disabled={isLoading}
                    required
                />
                {#if errors.password_confirmation}
                    <p class="text-sm text-red-600 dark:text-red-400">
                        {errors.password_confirmation}
                    </p>
                {/if}
            </div>

            <!-- Security Notice -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <Lock class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                    <div class="text-sm text-blue-800 dark:text-blue-200">
                        <p class="font-medium mb-1">Consejos de seguridad:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Usa al menos 8 caracteres</li>
                            <li>Incluye mayúsculas, minúsculas y números</li>
                            <li>Evita información personal</li>
                        </ul>
                    </div>
                </div>
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
                    disabled={isLoading || !formData.current_password || !formData.password || !formData.password_confirmation}
                    loadingText="Actualizando contraseña..."
                    {isLoading}
                    onclick={handleSubmit}
                >
                    Cambiar Contraseña
                </Button>
            </div>
        {/snippet}
    </Drawer>
{:else}
    <p class="text-gray-500 dark:text-gray-400">Usuario no autenticado</p>
{/if}
