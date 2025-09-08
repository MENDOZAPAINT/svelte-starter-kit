<script lang="ts">
	import { useForm } from '@inertiajs/svelte';
	import SidebarLayout from '../Layouts/App/SidebarLayout.svelte';
	import Card from '../Components/ui/Card.svelte';
	import CardHeader from '../Components/ui/CardHeader.svelte';
	import CardTitle from '../Components/ui/CardTitle.svelte';
	import CardDescription from '../Components/ui/CardDescription.svelte';
	import CardContent from '../Components/ui/CardContent.svelte';
	import Button from '../Components/ui/Button.svelte';
	import Input from '../Components/Input.svelte';

	const form = useForm({
		current_password: '',
		password: '',
		password_confirmation: ''
	});

	function submit() {
		$form.put('/password', {
			onSuccess: () => {
				$form.reset();
			}
		});
	}
</script>

<svelte:head>
	<title>Update Password</title>
</svelte:head>

<SidebarLayout>
	{#snippet children()}
		<div class="space-y-6">
			<!-- Header -->
			<div class="border-b pb-6">
				<h1 class="text-3xl font-bold tracking-tight">Password</h1>
				<p class="text-muted-foreground">Update your password to keep your account secure.</p>
			</div>

			<div class="grid gap-6">
				<!-- Update Password Card -->
				<Card>
					<CardHeader>
						<CardTitle>Update Password</CardTitle>
						<CardDescription>
							Ensure your account is using a long, random password to stay secure.
						</CardDescription>
					</CardHeader>
					<CardContent class="space-y-6">
						<form on:submit|preventDefault={submit} class="space-y-6">
							<Input
								label="Current Password"
								type="password"
								bind:value={form.data.current_password}
								error={form.errors.current_password}
								required
								autocomplete="current-password"
							/>

							<Input
								label="New Password"
								type="password"
								bind:value={form.data.password}
								error={form.errors.password}
								required
								autocomplete="new-password"
							/>

							<Input
								label="Confirm Password"
								type="password"
								bind:value={form.data.password_confirmation}
								error={form.errors.password_confirmation}
								required
								autocomplete="new-password"
							/>

							<div class="flex justify-end">
								<Button type="submit" disabled={form.processing}>
									{form.processing ? 'Saving...' : 'Save'}
								</Button>
							</div>
						</form>
					</CardContent>
				</Card>
			</div>
		</div>
	{/snippet}
</SidebarLayout>