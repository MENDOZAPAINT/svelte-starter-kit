<script lang="ts">
    import type { Snippet } from "svelte";
    import { cn } from "../lib/utils";

    // Interfaces para tokens reutilizables
    interface CustomToken { custom: string }
    interface VarToken { var: string }

    // Uniones necesarias para mapear a clases Tailwind (no se pueden representar solo con interfaces)
    type GridCols =
        | number // grid-cols-<number>
        | "none" // grid-cols-none
        | "subgrid" // grid-cols-subgrid
        | CustomToken // grid-cols-[<value>]
        | VarToken; // grid-cols-[var(--...)]
    type GridRows =
        | number // grid-rows-<number>
        | "none" // grid-rows-none
        | "subgrid" // grid-rows-subgrid
        | CustomToken // grid-rows-[<value>]
        | VarToken; // grid-rows-[var(--...)]
    type Gap =
        | number // gap-<number>
        | "px" // gap-px
        | CustomToken // gap-[<value>]
        | VarToken; // gap-[var(--...)]
    
    type GridAutoFlow =
        | "row" // grid-flow-row
        | "col" // grid-flow-col
        | "dense" // grid-flow-dense
        | "row-dense" // grid-flow-row-dense
        | "col-dense"; // grid-flow-col-dense

    type GridAutoColumns =
        | "auto" // auto-cols-auto
        | "min" // auto-cols-min
        | "max" // auto-cols-max
        | "fr" // auto-cols-fr
        | CustomToken // auto-cols-[<value>]
        | VarToken; // auto-cols-[var(--...)]

    // Interfaces responsivas (en lugar de Partial<Record<...>>)
    interface Responsive<T> {
        sm?: T;
        md?: T;
        lg?: T;
        xl?: T;
        "2xl"?: T;
    }
    interface ResponsiveGrid extends Responsive<GridCols> {}
    interface ResponsiveRows extends Responsive<GridRows> {}
    interface ResponsiveGap extends Responsive<Gap> {}
    interface ResponsiveAutoFlow extends Responsive<GridAutoFlow> {}
    interface ResponsiveAutoColumns extends Responsive<GridAutoColumns> {}

    // Breakpoints compartidos
    const BREAKPOINTS = ["sm", "md", "lg", "xl", "2xl"] as const;

    // Type guards y utilidades
    const isObject = (v: unknown): v is Record<string, unknown> => typeof v === "object" && v !== null;
    const isCustomToken = (v: unknown): v is CustomToken => isObject(v) && "custom" in v;
    const isVarToken = (v: unknown): v is VarToken => isObject(v) && "var" in v;

    interface GridProps {
        cols?: GridCols;
        rows?: GridRows;
        gap?: Gap;
        autoFlow?: GridAutoFlow;
        autoColumns?: GridAutoColumns;
        responsiveCols?: ResponsiveGrid;
        responsiveRows?: ResponsiveRows;
        responsiveGap?: ResponsiveGap;
        responsiveAutoFlow?: ResponsiveAutoFlow;
        responsiveAutoColumns?: ResponsiveAutoColumns;
        class?: string;
        style?: string;
        children?: Snippet;
    }

    let {
        cols,
        rows,
        gap,
        autoFlow,
        autoColumns,
        responsiveCols = {} as ResponsiveGrid,
        responsiveRows = {} as ResponsiveRows,
        responsiveGap = {} as ResponsiveGap,
        responsiveAutoFlow = {} as ResponsiveAutoFlow,
        responsiveAutoColumns = {} as ResponsiveAutoColumns,
        class: className = "",
        style = "",
        children,
    }: GridProps = $props();

    // Helper para soportar CSS variables correctamente en Tailwind
    const formatVar = (v: string): string => {
        const trimmed = v.trim();
        return /^var\(.+\)$/.test(trimmed) ? trimmed : `var(${trimmed})`;
    };

    // Generador genérico para grid cols/rows
    const generateGridClass = (prefix: "cols" | "rows", value: GridCols | GridRows): string => {
        if (typeof value === "number") return `grid-${prefix}-${value}`;
        if (value === "none") return `grid-${prefix}-none`;
        if (value === "subgrid") return `grid-${prefix}-subgrid`;
        if (isCustomToken(value)) return `grid-${prefix}-[${value.custom}]`;
        if (isVarToken(value)) return `grid-${prefix}-[${formatVar(value.var)}]`;
        return "";
    };

    // Función para generar clases de columnas (grid-template-columns)
    const generateColsClass = (value: GridCols): string => generateGridClass("cols", value);

    // Función para generar clases de filas (grid-template-rows)
    const generateRowsClass = (value: GridRows): string => generateGridClass("rows", value);

    // Generador para gap
    const generateGapClass = (value: Gap): string => {
        if (typeof value === "number") return `gap-${value}`;
        if (value === "px") return `gap-px`;
        if (isCustomToken(value)) return `gap-[${value.custom}]`;
        if (isVarToken(value)) return `gap-[${formatVar(value.var)}]`;
        return "";
    };

    // Generador para grid-auto-flow
    const generateAutoFlowClass = (value: GridAutoFlow): string => {
        switch (value) {
            case "row": return "grid-flow-row";
            case "col": return "grid-flow-col";
            case "dense": return "grid-flow-dense";
            case "row-dense": return "grid-flow-row-dense";
            case "col-dense": return "grid-flow-col-dense";
            default: return "";
        }
    };

    // Generador para grid-auto-columns
    const generateAutoColumnsClass = (value: GridAutoColumns): string => {
        if (value === "auto") return "auto-cols-auto";
        if (value === "min") return "auto-cols-min";
        if (value === "max") return "auto-cols-max";
        if (value === "fr") return "auto-cols-fr";
        if (isCustomToken(value)) return `auto-cols-[${value.custom}]`;
        if (isVarToken(value)) return `auto-cols-[${formatVar(value.var)}]`;
        return "";
    };

    const baseColsClass = $derived.by((): string => {
        return cols ? generateColsClass(cols) : "";
    });

    const baseRowsClass = $derived.by((): string => {
        return rows ? generateRowsClass(rows) : "";
    });

    const baseGapClass = $derived.by((): string => {
        return gap ? generateGapClass(gap) : "";
    });

    const baseAutoFlowClass = $derived.by((): string => {
        return autoFlow ? generateAutoFlowClass(autoFlow) : "";
    });

    const baseAutoColumnsClass = $derived.by((): string => {
        return autoColumns ? generateAutoColumnsClass(autoColumns) : "";
    });
    // Helper genérico para responsive (basado en interfaces)
    const generateResponsive = <T>(
        obj: Responsive<T>,
        generator: (v: T) => string,
    ): string => {
        const out: string[] = [];
        for (const bp of BREAKPOINTS) {
            const val = obj[bp];
            if (val !== undefined) {
                const c = generator(val);
                if (c) out.push(`${bp}:${c}`);
            }
        }
        return out.join(" ");
    };

    const responsiveColsClasses = $derived.by((): string => {
        return generateResponsive(responsiveCols, generateColsClass);
    });

    const responsiveRowsClasses = $derived.by((): string => {
        return generateResponsive(responsiveRows, generateRowsClass);
    });

    const responsiveGapClasses = $derived.by((): string => {
        return generateResponsive(responsiveGap, generateGapClass);
    });

    const responsiveAutoFlowClasses = $derived.by((): string => {
        return generateResponsive(responsiveAutoFlow, generateAutoFlowClass);
    });

    const responsiveAutoColumnsClasses = $derived.by((): string => {
        return generateResponsive(responsiveAutoColumns, generateAutoColumnsClass);
    });

    const classes = $derived.by((): string => {
        return cn(
            "grid",
            baseColsClass,
            baseRowsClass,
            baseGapClass,
            baseAutoFlowClass,
            baseAutoColumnsClass,
            responsiveColsClasses,
            responsiveRowsClasses,
            responsiveGapClasses,
            responsiveAutoFlowClasses,
            responsiveAutoColumnsClasses,
            className,
        );
    });
</script>

<div class={classes} {style}>
    {@render children?.()}
</div>
