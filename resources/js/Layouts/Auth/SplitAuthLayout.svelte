<script lang="ts">
  import { cn } from '@/lib/utils';
  import type { Snippet } from 'svelte';

  let { 
    title = $bindable('Authentication'), 
    class: className = '',
    children
  }: {
    title?: string;
    class?: string;
    children?: Snippet;
  } = $props();
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>
<div class={cn('grid min-h-svh lg:grid-cols-2', className)}>
  <div class="flex flex-col gap-4 p-6 md:p-10">
    <div class="flex justify-center gap-2 md:justify-start">
      <a href="#" class="flex items-center gap-2 font-medium">
        <div class="flex h-6 w-6 items-center justify-center rounded-md bg-primary text-primary-foreground">
          <svg class="size-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M11.572 0c-.176 0-.31.001-.358.007a19.76 19.76 0 0 1-.364.033C7.443.346 4.25 2.185 2.228 5.012a11.875 11.875 0 0 0-2.119 5.243c-.096.659-.108.854-.108 1.747s.012 1.089.108 1.748c.652 4.506 3.86 8.292 8.209 9.695.779.25 1.6.422 2.534.525.363.04 1.935.04 2.299 0 1.611-.178 2.977-.577 4.323-1.264.207-.106.247-.134.219-.158-.02-.013-.9-.1200-1.955-1.384a3312.874 3312.874 0 0 0-1.955-1.384l.002-.003c-.114-.065-.227-.129-.332-.200-.433-.29-.577-.49-.19-.635.704-.263 1.188-.531 1.846-.942a4.52 4.52 0 0 0 .742-.62c.265-.274.456-.623.456-.623.001-.001.048-.083.104-.183.362-.646.599-1.372.702-2.152.027-.196.025-.742-.004-.928-.148-1.273-.572-2.4-1.277-3.384-.274-.382-.603-.724-.985-1.024l.013-.016c.44-.682.684-1.426.684-2.202 0-.827-.258-1.594-.739-2.235C15.574.014 14.127-.364 11.572 0zm.001 1.125c1.945 0 3.513.53 4.681 1.581a5.3 5.3 0 0 1 1.658 3.963c0 .538-.116 1.05-.334 1.529-.12.264-.29.51-.503.729-.18.185-.39.346-.627.48-.473.267-1.04.4-1.696.4-.656 0-1.223-.133-1.696-.4a3.32 3.32 0 0 1-.627-.48 3.06 3.06 0 0 1-.503-.729 4.53 4.53 0 0 1-.334-1.529c0-1.553.59-2.913 1.658-3.963C8.06 1.655 9.628 1.125 11.573 1.125z"/>
          </svg>
        </div>
        Acme Inc
      </a>
    </div>
    <div class="flex flex-1 items-center justify-center">
      <div class="w-full max-w-xs">
        {#if children}
          {@render children()}
        {/if}
      </div>
    </div>
  </div>
  <div class="relative hidden bg-muted lg:block">
    <img
      src="/placeholder.svg"
      alt="Image"
      class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
    />
  </div>
</div>