<script lang="ts">
    import { Link } from "@inertiajs/svelte";
    import { ArrowRight, Shield, Zap, Users, Star } from "lucide-svelte";
</script>

<svelte:head>
    <title>Bienvenido</title>
</svelte:head>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">Mi App</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <Link href="/login">
                        <button>Iniciar Sesión</button>
                    </Link>
                    <Link href="/register">
                        <button>Registrarse</button>
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</div>
