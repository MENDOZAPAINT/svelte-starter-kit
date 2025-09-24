<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import SimpleAuthLayout from '../../Layouts/Auth/SimpleAuthLayout.svelte';

	// Declaramos el formulario
	const form = useForm({
		name: '',
		email: '',
		password: '',
		password_confirmation: ''
	});

	function submit() {
		$form.post('/register');
	}
</script>

<SimpleAuthLayout title="Create an account">
	<div class="flex flex-col gap-6">
		<div class="flex flex-col gap-2 text-center">
			<h1 class="text-2xl font-semibold tracking-tight">Create an account</h1>
			<p class="text-sm text-muted-foreground">
				Enter your email below to create your account
			</p>
		</div>

		<form on:submit|preventDefault={submit} class="grid gap-4">
			<!-- Name -->
			<div class="grid gap-2">
				<label for="name" class="text-sm font-medium">Name</label>
				<input
					id="name"
					type="text"
					bind:value={$form.name}
					placeholder="John Doe"
					required
					autocomplete="name"
					class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm"
				/>
				{#if $form.errors.name}
					<p class="text-sm text-destructive">{$form.errors.name}</p>
				{/if}
			</div>

			<!-- Email -->
			<div class="grid gap-2">
				<label for="email" class="text-sm font-medium">Email</label>
				<input
					id="email"
					type="email"
					bind:value={$form.email}
					placeholder="m@example.com"
					required
					autocomplete="username"
					class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm"
				/>
				{#if $form.errors.email}
					<p class="text-sm text-destructive">{$form.errors.email}</p>
				{/if}
			</div>

			<!-- Password -->
			<div class="grid gap-2">
				<label for="password" class="text-sm font-medium">Password</label>
				<input
					id="password"
					type="password"
					bind:value={$form.password}
					required
					autocomplete="new-password"
					class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm"
				/>
				{#if $form.errors.password}
					<p class="text-sm text-destructive">{$form.errors.password}</p>
				{/if}
			</div>

			<!-- Confirm Password -->
			<div class="grid gap-2">
				<label for="password_confirmation" class="text-sm font-medium">Confirm Password</label>
				<input
					id="password_confirmation"
					type="password"
					bind:value={$form.password_confirmation}
					required
					autocomplete="new-password"
					class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm"
				/>
				{#if $form.errors.password_confirmation}
					<p class="text-sm text-destructive">{$form.errors.password_confirmation}</p>
				{/if}
			</div>

			<button type="submit" class="w-full" disabled={$form.processing}>
				{$form.processing ? 'Creating account...' : 'Create account'}
			</button>
		</form>

		<div class="text-center text-sm">
			Already have an account?{' '}
			<Link href="/login" class="underline">Sign in</Link>
		</div>
	</div>
</SimpleAuthLayout>
