<script lang="ts">
    import AppLayout from "@/Layouts/AppLayout.svelte";
    import { Settings, Bell, Shield, Palette, Globe, Database, User, Mail } from "lucide-svelte";
    
    let notifications = {
        email: true,
        push: false,
        sms: true
    };
    
    let privacy = {
        profileVisible: true,
        showEmail: false,
        showPhone: true
    };
    
    let theme = 'light';
    let language = 'es';
</script>

<AppLayout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Configuración</h1>
            <p class="text-gray-600 dark:text-gray-400">Personaliza tu experiencia y gestiona tus preferencias</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Settings Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                    <nav class="space-y-2">
                        <a href="#account" class="flex items-center space-x-3 px-3 py-2 text-blue-600 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <User class="w-5 h-5" />
                            <span>Cuenta</span>
                        </a>
                        <a href="#notifications" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <Bell class="w-5 h-5" />
                            <span>Notificaciones</span>
                        </a>
                        <a href="#privacy" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <Shield class="w-5 h-5" />
                            <span>Privacidad</span>
                        </a>
                        <a href="#appearance" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <Palette class="w-5 h-5" />
                            <span>Apariencia</span>
                        </a>
                        <a href="#language" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <Globe class="w-5 h-5" />
                            <span>Idioma</span>
                        </a>
                        <a href="#data" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <Database class="w-5 h-5" />
                            <span>Datos</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Account Settings -->
                <div id="account" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <User class="w-6 h-6 text-blue-600" />
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Configuración de Cuenta</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre de usuario</label>
                            <input type="text" value="Dylan" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" value="dylan@example.com" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biografía</label>
                            <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cuéntanos sobre ti..."></textarea>
                        </div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Guardar Cambios
                        </button>
                    </div>
                </div>

                <!-- Notifications -->
                <div id="notifications" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <Bell class="w-6 h-6 text-blue-600" />
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Notificaciones</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notificaciones por email</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Recibe actualizaciones por correo electrónico</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" bind:checked={notifications.email} class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notificaciones push</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Recibe notificaciones en el navegador</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" bind:checked={notifications.push} class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notificaciones SMS</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Recibe mensajes de texto importantes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" bind:checked={notifications.sms} class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div id="privacy" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <Shield class="w-6 h-6 text-blue-600" />
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Privacidad y Seguridad</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Perfil público</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Permite que otros vean tu perfil</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" bind:checked={privacy.profileVisible} class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Mostrar email</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Permite que otros vean tu email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" bind:checked={privacy.showEmail} class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Cambiar Contraseña
                        </button>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div id="appearance" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <Palette class="w-6 h-6 text-blue-600" />
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Apariencia</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tema</label>
                            <select bind:value={theme} class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="light">Claro</option>
                                <option value="dark">Oscuro</option>
                                <option value="auto">Automático</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Language Settings -->
                <div id="language" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <Globe class="w-6 h-6 text-blue-600" />
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Idioma y Región</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Idioma</label>
                            <select bind:value={language} class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="es">Español</option>
                                <option value="en">English</option>
                                <option value="fr">Français</option>
                                <option value="de">Deutsch</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>