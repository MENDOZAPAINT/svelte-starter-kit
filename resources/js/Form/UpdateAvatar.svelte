<!-- UpdateAvatar.svelte -->
<script lang="ts">
    import Button from "@/Components/Button.svelte";
    import Drawer from "@/Components/Drawer.svelte";
    import Input from "@/Components/Input.svelte";
    import Label from "@/Components/Label.svelte";
    import { router, page } from "@inertiajs/svelte";
    import { User, Upload, X } from "lucide-svelte";

    // const currentUser = $derived($page.props.auth.user);
    const currentUser: User | null = $state($page.props.auth?.user ?? null);

    let showRightDrawer = $state(false);
    let isLoading = $state(false);
    let errors = $state({});
    let fileInput: HTMLInputElement | null = $state(null);
    let selectedFile: File | null = $state(null);
    let previewUrl: string | null = $state(null);

    // Initialize form data when drawer opens
    function openDrawer() {
        if (!currentUser) return;

        // Reset form and errors
        selectedFile = null;
        previewUrl = null;
        errors = {};
        showRightDrawer = true;
    }

    function handleFileSelect(event: Event) {
        const target = event.target as HTMLInputElement;
        const file = target.files?.[0];
        
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                errors = { avatar: 'Por favor selecciona un archivo de imagen válido.' };
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                errors = { avatar: 'El archivo debe ser menor a 2MB.' };
                return;
            }
            
            selectedFile = file;
            errors = {};
            
            // Create preview URL
            const reader = new FileReader();
            reader.onload = (e) => {
                previewUrl = e.target?.result as string;
            };
            reader.readAsDataURL(file);
        }
    }

    function removeSelectedFile() {
        selectedFile = null;
        previewUrl = null;
        if (fileInput) {
            fileInput.value = '';
        }
    }

    function handleSubmit(e?: Event) {
        e?.preventDefault();
        if (!currentUser || isLoading || !selectedFile) return;

        isLoading = true;
        errors = {}; // Reset errors

        const formData = new FormData();
        formData.append('avatar', selectedFile);
        formData.append('_method', 'PUT');

        router.post(`/user/${currentUser.id}/avatar`, formData, {
            forceFormData: true,
            preserveState: false, // Refresca toda la página
            preserveScroll: false, // Reinicia scroll position
            replace: true, // Reemplaza historial
            onSuccess: () => {
                console.log("Avatar actualizado - página refrescada");
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
        selectedFile = null;
        previewUrl = null;
        if (fileInput) {
            fileInput.value = '';
        }
        showRightDrawer = false;
    }
</script>

{#if currentUser}
    <Button variant="secondary" onclick={openDrawer}>Actualizar Avatar</Button>

    <Drawer bind:showDrawer={showRightDrawer} position="right" size="lg">
        {#snippet header()}
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Actualizar Avatar
            </h2>
        {/snippet}

        <form onsubmit={handleSubmit} class="space-y-6">
            <!-- Current Avatar Display -->
            <div class="text-center">
                <div class="mb-4">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                        {#if currentUser.avatar}
                            <img 
                                src={currentUser.avatar} 
                                alt="Avatar actual" 
                                class="w-full h-full object-cover"
                            />
                        {:else}
                            <User class="w-12 h-12 text-gray-400" />
                        {/if}
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Avatar actual</p>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="space-y-4">
                <Label for="avatar">Seleccionar nuevo avatar:</Label>
                
                <!-- File Input (Hidden) -->
                <input
                    bind:this={fileInput}
                    id="avatar"
                    type="file"
                    accept="image/*"
                    onchange={handleFileSelect}
                    class="hidden"
                    disabled={isLoading}
                />
                
                <!-- Custom Upload Button -->
                <div class="flex flex-col items-center space-y-4">
                    {#if !selectedFile}
                        <button
                            type="button"
                            onclick={() => fileInput?.click()}
                            disabled={isLoading}
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <Upload class="w-8 h-8 text-gray-400 mb-2" />
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Haz clic para seleccionar una imagen
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                PNG, JPG, GIF hasta 2MB
                            </span>
                        </button>
                    {:else}
                        <!-- Preview Selected File -->
                        <div class="w-full">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    {#if previewUrl}
                                        <img 
                                            src={previewUrl} 
                                            alt="Vista previa" 
                                            class="w-12 h-12 rounded-full object-cover"
                                        />
                                    {/if}
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {selectedFile.name}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {(selectedFile.size / 1024 / 1024).toFixed(2)} MB
                                        </p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    onclick={removeSelectedFile}
                                    disabled={isLoading}
                                    class="p-1 text-gray-400 hover:text-red-500 transition-colors disabled:opacity-50"
                                >
                                    <X class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    {/if}
                </div>

                <!-- Error Display -->
                <!-- {#if errors.avatar}
                    <p class="text-sm text-red-600 dark:text-red-400">
                        {errors.avatar}
                    </p>
                {/if} -->
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
                    disabled={isLoading || !selectedFile}
                    loadingText="Actualizando avatar..."
                    {isLoading}
                    onclick={handleSubmit}
                >
                    Actualizar Avatar
                </Button>
            </div>
        {/snippet}
    </Drawer>
{:else}
    <p class="text-gray-500 dark:text-gray-400">Usuario no autenticado</p>
{/if}
