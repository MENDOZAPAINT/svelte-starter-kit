<!-- Temporarily commented out - Email verification functionality disabled -->
<!--
<!--
<script lang="ts">
	import { Link, useForm } from '@inertiajs/svelte';
	import Button from '../../Components/ui/Button.svelte';
	import SimpleAuthLayout from '../../Layouts/Auth/SimpleAuthLayout.svelte';
	import { Mail } from 'lucide-svelte';

	let { status = '' }: { status?: string } = $props();

	const form = useForm({});

	function submit() {
		$form.post('/email/verification-notification');
	}
</script>

<SimpleAuthLayout title="Verify your email">
	<div class="flex flex-col gap-6">
		<div class="flex flex-col gap-2 text-center">
			<div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted">
				<Mail class="h-6 w-6" />
			</div>
			<h1 class="text-2xl font-semibold tracking-tight">Check your email</h1>
			<p class="text-sm text-muted-foreground">
				We've sent a verification link to your email address.
			</p>
		</div>

		{#if status === 'verification-link-sent'}
			<div class="rounded-md bg-green-50 p-4">
				<p class="text-sm text-green-800">
					A new verification link has been sent to your email address.
				</p>
			</div>
		{/if}

		<div class="flex flex-col gap-4">
			<form on:submit|preventDefault={submit}>
				<Button type="submit" class="w-full" disabled={$form.processing}>
					{$form.processing ? 'Sending...' : 'Resend verification email'}
				</Button>
			</form>

			<div class="text-center">
				<Link href="/logout" method="post" class="text-sm text-muted-foreground hover:text-primary">
					Sign out
				</Link>
			</div>
		</div>
	</div>
</SimpleAuthLayout>
-->