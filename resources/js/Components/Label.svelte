<script lang="ts">
  import type { Snippet } from "svelte";

  interface Props {
    children: Snippet;
    for: string;
  }

  let { children, for: htmlFor }: Props = $props();
</script>

<label
  for={htmlFor}
  class="block text-sm font-medium dark:text-slate-200 mb-1"
>
  {@render children()}
</label>