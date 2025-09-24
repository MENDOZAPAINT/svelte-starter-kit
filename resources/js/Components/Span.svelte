<!-- Span.svelte -->
<script lang="ts">
    type TagVariant =
        | "blue"
        | "green"
        | "purple"
        | "orange"
        | "red"
        | "yellow"
        | "gray"
        | "indigo"
        | "pink"
        | "teal";
    type TagSize = "xs" | "sm" | "md" | "lg";

    interface Props {
        variant?: TagVariant;
        size?: TagSize;
        disabled?: boolean;
        class?: string;
        children: any;
    }

    let {
        variant = "blue",
        size = "sm",
        disabled = false,
        class: customClass = "",
        children,
    }: Props = $props();

    const variantClasses: Record<TagVariant, string> = {
        blue: "bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 border-none",
        green: "bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 border-green-200 dark:border-green-700",
        purple: "bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-700",
        orange: "bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 border-orange-200 dark:border-orange-700",
        red: "bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-700",
        yellow: "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-700",
        gray: "bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-700",
        indigo: "bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-200 border-indigo-200 dark:border-indigo-700",
        pink: "bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-200 border-pink-200 dark:border-pink-700",
        teal: "bg-teal-100 dark:bg-teal-900/30 text-teal-800 dark:text-teal-200 border-teal-200 dark:border-teal-700",
    };

    const sizeClasses: Record<TagSize, string> = {
        xs: "px-2 py-0.5 text-xs",
        sm: "px-3 py-1 text-sm",
        md: "px-4 py-1.5 text-base",
        lg: "px-5 py-2 text-lg",
    };

    const baseClasses =
        "inline-flex items-center gap-1 rounded-full font-medium border transition-all duration-200";

    const getClasses = () => {
        let classes = `${baseClasses} ${sizeClasses[size]} ${variantClasses[variant]}`;

        if (disabled) {
            classes += " opacity-50 cursor-not-allowed";
        }

        if (customClass) {
            classes += ` ${customClass}`;
        }

        return classes;
    };




</script>

<span class={`${getClasses()} my-0.5`}>
    {@render children()}
</span>
