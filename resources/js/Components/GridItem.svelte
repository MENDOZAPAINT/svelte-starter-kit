<script lang="ts">
    import type { Snippet } from "svelte";

    // Helper para soportar CSS variables correctamente en Tailwind
    const formatVar = (v: string): string => {
        const trimmed = v.trim();
        return /^var\(.+\)$/.test(trimmed) ? trimmed : `var(${trimmed})`;
    };
    
    interface GridItemProps {
        // Soporte para col-span-<number> (1-12)
        colSpan?: number | 'full';
        // Soporte para col-start-<number> (1-13) y col-start-auto
        colStart?: number | 'auto';
        // Soporte para col-end-<number> (1-13) y col-end-auto
        colEnd?: number | 'auto';
        // Soporte para valores personalizados: col-[16_/_span_16]
        customCol?: string;
        // Soporte para col-span-[<value>]
        customColSpan?: string;
        // Soporte para col-start-[<value>]
        customColStart?: string;
        // Soporte para col-end-[<value>]
        customColEnd?: string;
        // Soporte para propiedades CSS personalizadas
        customProperty?: string;
        customSpanProperty?: string;
        customStartProperty?: string;
        customEndProperty?: string;
        
        // Soporte para grid-row
        // Soporte para row-span-<number> (1-12) y row-span-full
        rowSpan?: number | 'full';
        // Soporte para row-start-<number> (1-13) y row-start-auto
        rowStart?: number | 'auto';
        // Soporte para row-end-<number> (1-13) y row-end-auto
        rowEnd?: number | 'auto';
        // Soporte para valores personalizados: row-[16_/_span_16]
        customRow?: string;
        // Soporte para row-span-[<value>]
        customRowSpan?: string;
        // Soporte para row-start-[<value>]
        customRowStart?: string;
        // Soporte para row-end-[<value>]
        customRowEnd?: string;
        // Soporte para propiedades CSS personalizadas para rows
        customRowProperty?: string;
        customRowSpanProperty?: string;
        customRowStartProperty?: string;
        customRowEndProperty?: string;
        
        // Contenido del grid item
        children: Snippet;
        // Clases adicionales
        class?: string;
        // Soporte para diseño responsivo
        responsive?: {
            sm?: {
                colSpan?: number | 'full' | string;
                colStart?: number | 'auto' | string;
                colEnd?: number | 'auto' | string;
                rowSpan?: number | 'full' | string;
                rowStart?: number | 'auto' | string;
                rowEnd?: number | 'auto' | string;
            };
            md?: {
                colSpan?: number | 'full' | string;
                colStart?: number | 'auto' | string;
                colEnd?: number | 'auto' | string;
                rowSpan?: number | 'full' | string;
                rowStart?: number | 'auto' | string;
                rowEnd?: number | 'auto' | string;
            };
            lg?: {
                colSpan?: number | 'full' | string;
                colStart?: number | 'auto' | string;
                colEnd?: number | 'auto' | string;
                rowSpan?: number | 'full' | string;
                rowStart?: number | 'auto' | string;
                rowEnd?: number | 'auto' | string;
            };
            xl?: {
                colSpan?: number | 'full' | string;
                colStart?: number | 'auto' | string;
                colEnd?: number | 'auto' | string;
                rowSpan?: number | 'full' | string;
                rowStart?: number | 'auto' | string;
                rowEnd?: number | 'auto' | string;
            };
            '2xl'?: {
                colSpan?: number | 'full' | string;
                colStart?: number | 'auto' | string;
                colEnd?: number | 'auto' | string;
                rowSpan?: number | 'full' | string;
                rowStart?: number | 'auto' | string;
                rowEnd?: number | 'auto' | string;
            };
        };
    }
    
    let {
        colSpan,
        colStart,
        colEnd,
        customCol,
        customColSpan,
        customColStart,
        customColEnd,
        customProperty,
        customSpanProperty,
        customStartProperty,
        customEndProperty,
        rowSpan,
        rowStart,
        rowEnd,
        customRow,
        customRowSpan,
        customRowStart,
        customRowEnd,
        customRowProperty,
        customRowSpanProperty,
        customRowStartProperty,
        customRowEndProperty,
        children,
        class: className = '',
        responsive
    }: GridItemProps = $props();

    // Función para generar clases de columna
    function generateColClass(type: 'span' | 'start' | 'end', value: number | 'full' | 'auto' | string | undefined, prefix = ''): string {
        if (!value) return '';
        
        const prefixStr = prefix ? `${prefix}:` : '';
        
        if (type === 'span') {
            if (value === 'full') {
                return `${prefixStr}col-span-full`;
            } else if (typeof value === 'number') {
                return `${prefixStr}col-span-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        } else if (type === 'start') {
            if (value === 'auto') {
                return `${prefixStr}col-start-auto`;
            } else if (typeof value === 'number') {
                return `${prefixStr}col-start-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        } else if (type === 'end') {
            if (value === 'auto') {
                return `${prefixStr}col-end-auto`;
            } else if (typeof value === 'number') {
                return `${prefixStr}col-end-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        }
        
        return '';
    }

    // Función para generar clases de fila
    function generateRowClass(type: 'span' | 'start' | 'end', value: number | 'full' | 'auto' | string | undefined, prefix = ''): string {
        if (!value) return '';
        
        const prefixStr = prefix ? `${prefix}:` : '';
        
        if (type === 'span') {
            if (value === 'full') {
                return `${prefixStr}row-span-full`;
            } else if (typeof value === 'number') {
                return `${prefixStr}row-span-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        } else if (type === 'start') {
            if (value === 'auto') {
                return `${prefixStr}row-start-auto`;
            } else if (typeof value === 'number') {
                return `${prefixStr}row-start-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        } else if (type === 'end') {
            if (value === 'auto') {
                return `${prefixStr}row-end-auto`;
            } else if (typeof value === 'number') {
                return `${prefixStr}row-end-${value}`;
            } else if (typeof value === 'string') {
                return `${prefixStr}${value}`;
            }
        }
        
        return '';
    }

    // Generar clases de grid item usando $derived rune
    const gridItemClasses = $derived.by(() => {
        const classes: string[] = [];
        
        // Prioridad para columnas: customProperty > custom values > standard values
        if (customProperty) {
            classes.push(`col-[${formatVar(customProperty)}]`);
        } else if (customCol) {
            classes.push(`col-[${customCol}]`);
        } else {
            // Col span
            if (customSpanProperty) {
                classes.push(`col-span-[${formatVar(customSpanProperty)}]`);
            } else if (customColSpan) {
                classes.push(`col-span-[${customColSpan}]`);
            } else if (colSpan) {
                classes.push(generateColClass('span', colSpan));
            }
            
            // Col start
            if (customStartProperty) {
                classes.push(`col-start-[${formatVar(customStartProperty)}]`);
            } else if (customColStart) {
                classes.push(`col-start-[${customColStart}]`);
            } else if (colStart) {
                classes.push(generateColClass('start', colStart));
            }
            
            // Col end
            if (customEndProperty) {
                classes.push(`col-end-[${formatVar(customEndProperty)}]`);
            } else if (customColEnd) {
                classes.push(`col-end-[${customColEnd}]`);
            } else if (colEnd) {
                classes.push(generateColClass('end', colEnd));
            }
        }
        
        // Prioridad para filas: customRowProperty > custom values > standard values
        if (customRowProperty) {
            classes.push(`row-[${formatVar(customRowProperty)}]`);
        } else if (customRow) {
            classes.push(`row-[${customRow}]`);
        } else {
            // Row span
            if (customRowSpanProperty) {
                classes.push(`row-span-[${formatVar(customRowSpanProperty)}]`);
            } else if (customRowSpan) {
                classes.push(`row-span-[${customRowSpan}]`);
            } else if (rowSpan) {
                classes.push(generateRowClass('span', rowSpan));
            }
            
            // Row start
            if (customRowStartProperty) {
                classes.push(`row-start-[${formatVar(customRowStartProperty)}]`);
            } else if (customRowStart) {
                classes.push(`row-start-[${customRowStart}]`);
            } else if (rowStart) {
                classes.push(generateRowClass('start', rowStart));
            }
            
            // Row end
            if (customRowEndProperty) {
                classes.push(`row-end-[${formatVar(customRowEndProperty)}]`);
            } else if (customRowEnd) {
                classes.push(`row-end-[${customRowEnd}]`);
            } else if (rowEnd) {
                classes.push(generateRowClass('end', rowEnd));
            }
        }
        
        // Generar clases responsivas
        if (responsive) {
            Object.entries(responsive).forEach(([breakpoint, config]) => {
                // Columnas responsivas
                if (config.colSpan) {
                    classes.push(generateColClass('span', config.colSpan, breakpoint));
                }
                if (config.colStart) {
                    classes.push(generateColClass('start', config.colStart, breakpoint));
                }
                if (config.colEnd) {
                    classes.push(generateColClass('end', config.colEnd, breakpoint));
                }
                
                // Filas responsivas
                if (config.rowSpan) {
                    classes.push(generateRowClass('span', config.rowSpan, breakpoint));
                }
                if (config.rowStart) {
                    classes.push(generateRowClass('start', config.rowStart, breakpoint));
                }
                if (config.rowEnd) {
                    classes.push(generateRowClass('end', config.rowEnd, breakpoint));
                }
            });
        }
        
        // Concatenar clases
        return [...classes, className].filter(Boolean).join(' ');
    });
</script>

<div class={gridItemClasses}>
    {#if children}
        {@render children()}
    {/if}
</div>