<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import Button from '../../Components/ui/Button.svelte';
	import Input from '../../Components/Input.svelte';
	import Card from '../../Components/ui/Card.svelte';
	import CardHeader from '../../Components/ui/CardHeader.svelte';
	import CardTitle from '../../Components/ui/CardTitle.svelte';
	import CardDescription from '../../Components/ui/CardDescription.svelte';
	import CardContent from '../../Components/ui/CardContent.svelte';
	import CardFooter from '../../Components/ui/CardFooter.svelte';

	let email = '';
	let errors: Record<string, string> = {};
	let processing = false;
	let status = '';

	function handleSubmit() {
		processing = true;
		// Aquí iría la lógica de recuperación de contraseña
		console.log('Password reset request:', { email });
		setTimeout(() => {
			processing = false;
			status = 'Hemos enviado un enlace de recuperación a tu email.';
		}, 1000);
	}
</script>

<svelte:head>
	<title>Recuperar Contraseña</title>
</svelte:head>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
	<div class="max-w-md w-full space-y-8">
		<Card class="w-full">
			<CardHeader class="space-y-1">
				<CardTitle class="text-2xl font-bold text-center">Recuperar Contraseña</CardTitle>
				<CardDescription class="text-center">
					Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña
				</CardDescription>
			</CardHeader>
			<CardContent class="space-y-4">
				{#if status}
					<div class="p-4 bg-green-50 border border-green-200 rounded-md">
						<p class="text-sm text-green-800">{status}</p>
					</div>
				{/if}

				<form on:submit|preventDefault={handleSubmit} class="space-y-4">
					<div class="space-y-2">
						<Input
							label="Email"
							type="email"
							bind:value={email}
							placeholder="tu@ejemplo.com"
							required
							error={errors.email}
							autocomplete="username"
						/>
					</div>

					<Button type="submit" class="w-full" disabled={processing}>
						{processing ? 'Enviando enlace...' : 'Enviar Enlace de Recuperación'}
					</Button>
				</form>
			</CardContent>
			<CardFooter>
				<div class="text-center text-sm text-gray-600 w-full">
					¿Recordaste tu contraseña?
					<Link href="/login" class="text-primary hover:underline ml-1">
						Volver al inicio de sesión
					</Link>
				</div>
			</CardFooter>
		</Card>
	</div>
</div>