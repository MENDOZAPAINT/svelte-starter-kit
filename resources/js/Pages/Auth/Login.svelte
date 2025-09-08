<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import Button from '../../Components/ui/Button.svelte';
	import SimpleAuthLayout from '../../Layouts/Auth/SimpleAuthLayout.svelte';

	let { canResetPassword = false }: { canResetPassword?: boolean } = $props();

	const form = useForm({
		email: '',
		password: '',
		remember: false
	});

	function submit() {
		$form.post('/login', {
			onFinish: () => $form.reset('password')
		});
	}
</script>

<SimpleAuthLayout title="Log in">
	<form on:submit|preventDefault={submit} class="grid gap-6">
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
				class="border rounded p-2"
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
				autocomplete="current-password"
				class="border rounded p-2"
			/>
			{#if $form.errors.password}
				<p class="text-sm text-destructive">{$form.errors.password}</p>
			{/if}
		</div>

		<!-- Remember me -->
		<div class="flex items-center gap-2">
			<input id="remember" type="checkbox" bind:checked={$form.remember} />
			<label for="remember">Remember me</label>
		</div>

		<Button type="submit" disabled={$form.processing}>
			{$form.processing ? 'Signing in...' : 'Login'}
		</Button>
	</form>
</SimpleAuthLayout>
