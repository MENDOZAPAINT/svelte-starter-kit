<script lang="ts">
    import type { Snippet } from "svelte";
    import { cn } from "@/lib/utils";

    interface GridProps {
        children?: Snippet;
        cols?: number;
        rows?: number;
        smCols?: number;
        smRows?: number;
        mdCols?: number;
        mdRows?: number;
        lgCols?: number;
        lgRows?: number;
        gap?: number;
        class?: string;
    }

    let {
        children,
        cols = 1,
        rows = 1,
        smCols,
        smRows,
        mdCols,
        mdRows,
        lgCols,
        lgRows,
        gap = 4,
        class: className = "",
    }: GridProps = $props();

    const gridClasses = $derived(
        cn(
            "grid",
            cols ? `grid-cols-${cols}` : "",
            rows ? `grid-rows-${rows}` : "",
            smCols ? `sm:grid-cols-${smCols}` : "",
            smRows ? `sm:grid-rows-${smRows}` : "",
            mdCols ? `md:grid-cols-${mdCols}` : "",
            mdRows ? `md:grid-rows-${mdRows}` : "",
            lgCols ? `lg:grid-cols-${lgCols}` : "",
            lgRows ? `lg:grid-rows-${lgRows}` : "",
            gap ? `gap-${gap}` : "",
            className,
        ),
    );
</script>

<div class={gridClasses}>
    {@render children?.()}
</div>
<!-- <div class="grid lg:grid-cols-2"></div> -->
