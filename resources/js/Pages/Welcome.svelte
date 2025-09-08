<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import Button from '../Components/ui/Button.svelte';
	import Card from '../Components/ui/Card.svelte';
	import CardHeader from '../Components/ui/CardHeader.svelte';
	import CardTitle from '../Components/ui/CardTitle.svelte';
	import CardDescription from '../Components/ui/CardDescription.svelte';
	import CardContent from '../Components/ui/CardContent.svelte';
	import { ArrowRight, Shield, Zap, Users, Star } from 'lucide-svelte';

	const features = [
		{
			icon: Shield,
			title: 'Seguro y Confiable',
			description: 'Protección avanzada de datos con las mejores prácticas de seguridad.'
		},
		{
			icon: Zap,
			title: 'Rápido y Eficiente',
			description: 'Rendimiento optimizado para una experiencia de usuario excepcional.'
		},
		{
			icon: Users,
			title: 'Colaborativo',
			description: 'Herramientas diseñadas para facilitar el trabajo en equipo.'
		}
	];
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
						<Button variant="ghost">Iniciar Sesión</Button>
					</Link>
					<Link href="/register">
						<Button>Registrarse</Button>
					</Link>
				</div>
			</div>
		</div>
	</nav>

	<!-- Hero Section -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
		<div class="text-center">
			<h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
				Bienvenido a
				<span class="text-primary">Mi App</span>
			</h1>
			<p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
				Una aplicación moderna construida con Svelte 5, TypeScript y Tailwind CSS.
				Experimenta la velocidad y elegancia del desarrollo web moderno.
			</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<Link href="/register">
					<Button size="lg" class="w-full sm:w-auto">
						Comenzar Ahora
						<ArrowRight class="ml-2 h-4 w-4" />
					</Button>
				</Link>
				<Link href="/dashboard">
					<Button variant="outline" size="lg" class="w-full sm:w-auto">
						Ver Demo
					</Button>
				</Link>
			</div>
		</div>

		<!-- Features Section -->
		<div class="mt-20">
			<div class="text-center mb-12">
				<h2 class="text-3xl font-bold text-gray-900 mb-4">¿Por qué elegir Mi App?</h2>
				<p class="text-gray-600 max-w-2xl mx-auto">
					Descubre las características que hacen de nuestra aplicación la mejor opción para tus necesidades.
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				{#each features as feature}
					<Card class="text-center hover:shadow-lg transition-shadow">
						<CardContent class="p-6">
							<div class="mx-auto h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center mb-4">
								<svelte:component this={feature.icon} class="h-6 w-6 text-primary" />
							</div>
							<h3 class="text-xl font-semibold text-gray-900 mb-2">{feature.title}</h3>
							<p class="text-gray-600">{feature.description}</p>
						</CardContent>
					</Card>
				{/each}
			</div>
		</div>

		<!-- Stats Section -->
		<div class="mt-20">
			<Card class="bg-primary text-primary-foreground">
				<CardContent class="p-8">
					<div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
						<div>
							<div class="text-3xl font-bold mb-2">10K+</div>
							<div class="text-primary-foreground/80">Usuarios Activos</div>
						</div>
						<div>
							<div class="text-3xl font-bold mb-2">99.9%</div>
							<div class="text-primary-foreground/80">Tiempo de Actividad</div>
						</div>
						<div>
							<div class="text-3xl font-bold mb-2 flex items-center justify-center">
								4.9
								<Star class="h-6 w-6 ml-1 fill-current" />
							</div>
							<div class="text-primary-foreground/80">Calificación</div>
						</div>
					</div>
				</CardContent>
			</Card>
		</div>

		<!-- CTA Section -->
		<div class="mt-20 text-center">
			<Card>
				<CardContent class="p-8">
					<h2 class="text-3xl font-bold text-gray-900 mb-4">¿Listo para comenzar?</h2>
					<p class="text-gray-600 mb-6 max-w-2xl mx-auto">
						Únete a miles de usuarios que ya confían en nuestra plataforma.
						Crea tu cuenta gratuita en menos de 2 minutos.
					</p>
					<Link href="/register">
						<Button size="lg">
							Crear Cuenta Gratuita
							<ArrowRight class="ml-2 h-4 w-4" />
						</Button>
					</Link>
				</CardContent>
			</Card>
		</div>
	</div>

	<!-- Footer -->
	<footer class="bg-white border-t mt-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<div class="text-center text-gray-600">
				<p>&copy; 2024 Mi App. Todos los derechos reservados.</p>
			</div>
		</div>
	</footer>
</div>