<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import { Home, User, Settings, LogOut, Menu, Search } from 'lucide-svelte';
	import Button from '../../Components/ui/Button.svelte';
	import ThemeToggle from '../../Components/ui/ThemeToggle.svelte';
	import type { Snippet } from 'svelte';

	let { children }: { children?: Snippet } = $props();

	let mobileMenuOpen = false;

	const navigation = [
		{ name: 'Dashboard', href: '/dashboard', current: true },
		{ name: 'Profile', href: '/profile', current: false },
		{ name: 'Settings', href: '/settings', current: false },
	];

	function toggleMobileMenu() {
		mobileMenuOpen = !mobileMenuOpen;
	}

	function logout() {
		// Aquí iría la lógica de logout
		console.log('Logout');
	}
</script>

<div class="min-h-screen bg-background">
	<header class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
		<div class="container flex h-14 items-center">
			<div class="mr-4 hidden md:flex">
				<Link href="/" class="mr-6 flex items-center space-x-2">
					<div class="flex h-6 w-6 items-center justify-center rounded-md bg-primary text-primary-foreground">
						<svg class="size-4" fill="currentColor" viewBox="0 0 24 24">
							<path d="M11.572 0c-.176 0-.31.001-.358.007a19.76 19.76 0 0 1-.364.033C7.443.346 4.25 2.185 2.228 5.012a11.875 11.875 0 0 0-2.119 5.243c-.096.659-.108.854-.108 1.747s.012 1.089.108 1.748c.652 4.506 3.86 8.292 8.209 9.695.779.25 1.6.422 2.534.525.363.04 1.935.04 2.299 0 1.611-.178 2.977-.577 4.323-1.264.207-.106.247-.134.219-.158-.02-.013-.9-.1200-1.955-1.384a3312.874 3312.874 0 0 0-1.955-1.384l.002-.003c-.114-.065-.227-.129-.332-.200-.433-.29-.577-.49-.19-.635.704-.263 1.188-.531 1.846-.942a4.52 4.52 0 0 0 .742-.62c.265-.274.456-.623.456-.623.001-.001.048-.083.104-.183.362-.646.599-1.372.702-2.152.027-.196.025-.742-.004-.928-.148-1.273-.572-2.4-1.277-3.384-.274-.382-.603-.724-.985-1.024l.013-.016c.44-.682.684-1.426.684-2.202 0-.827-.258-1.594-.739-2.235C15.574.014 14.127-.364 11.572 0zm.001 1.125c1.945 0 3.513.53 4.681 1.581a5.3 5.3 0 0 1 1.658 3.963c0 .538-.116 1.05-.334 1.529-.12.264-.29.51-.503.729-.18.185-.39.346-.627.48-.473.267-1.04.4-1.696.4-.656 0-1.223-.133-1.696-.4a3.32 3.32 0 0 1-.627-.48 3.06 3.06 0 0 1-.503-.729 4.53 4.53 0 0 1-.334-1.529c0-1.553.59-2.913 1.658-3.963C8.06 1.655 9.628 1.125 11.573 1.125z"/>
						</svg>
					</div>
					<span class="hidden font-bold sm:inline-block">Acme Inc</span>
				</Link>
				<nav class="flex items-center space-x-6 text-sm font-medium">
					{#each navigation as item}
						<Link
							href={item.href}
							class="transition-colors hover:text-foreground/80 {item.current ? 'text-foreground' : 'text-foreground/60'}"
						>
							{item.name}
						</Link>
					{/each}
				</nav>
			</div>
			<Button variant="outline" size="icon" class="mr-2 px-0 text-base hover:bg-transparent focus-visible:bg-transparent focus-visible:ring-0 focus-visible:ring-offset-0 md:hidden" onclick={toggleMobileMenu}>
				<Menu class="h-5 w-5" />
				<span class="sr-only">Toggle Menu</span>
			</Button>
			<div class="flex flex-1 items-center justify-between space-x-2 md:justify-end">
				<div class="w-full flex-1 md:w-auto md:flex-none">
					<Button variant="outline" class="inline-flex items-center rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 relative w-full justify-start text-sm text-muted-foreground sm:pr-12 md:w-40 lg:w-64">
						<Search class="mr-2 h-4 w-4" />
						Search...
						<kbd class="pointer-events-none absolute right-1.5 top-1.5 hidden h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium opacity-100 sm:flex">
							<span class="text-xs">⌘</span>K
						</kbd>
					</Button>
				</div>
				<nav class="flex items-center space-x-2">
					<ThemeToggle />
					<div class="relative">
						<Button variant="ghost" class="relative h-8 w-8 rounded-full">
							<div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-primary-foreground">
								<User class="h-4 w-4" />
							</div>
						</Button>
					</div>
				</nav>
			</div>
		</div>
		{#if mobileMenuOpen}
			<div class="border-t md:hidden">
				<nav class="grid gap-2 p-4">
					{#each navigation as item}
						<Link
							href={item.href}
							class="block px-2 py-1 text-lg {item.current ? 'font-semibold' : ''}"
							on:click={() => mobileMenuOpen = false}
						>
							{item.name}
						</Link>
					{/each}
					<div class="border-t pt-2">
						<Button variant="ghost" class="w-full justify-start" onclick={logout}>
							<LogOut class="mr-2 h-4 w-4" />
							Logout
						</Button>
					</div>
				</nav>
			</div>
		{/if}
	</header>
	<main class="flex-1">
		<div class="container py-6">
			{#if children}
				{@render children()}
			{/if}
		</div>
	</main>
</div>