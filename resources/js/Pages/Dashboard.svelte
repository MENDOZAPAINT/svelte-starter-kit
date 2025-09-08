<script lang="ts">
    import AppLayout from "@/Layouts/AppLayout.svelte";
</script>

<AppLayout title="Dashboard">
    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                    <pattern
                        id="dots"
                        width="20"
                        height="20"
                        patternUnits="userSpaceOnUse"
                    >
                        <circle
                            cx="1"
                            cy="1"
                            r="1"
                            class="fill-neutral-400/20"
                        />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#dots)" />
                </svg>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                    <pattern
                        id="dots"
                        width="20"
                        height="20"
                        patternUnits="userSpaceOnUse"
                    >
                        <circle
                            cx="1"
                            cy="1"
                            r="1"
                            class="fill-neutral-400/20"
                        />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#dots)" />
                </svg>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                    <pattern
                        id="dots"
                        width="20"
                        height="20"
                        patternUnits="userSpaceOnUse"
                    >
                        <circle
                            cx="1"
                            cy="1"
                            r="1"
                            class="fill-neutral-400/20"
                        />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#dots)" />
                </svg>
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                <pattern
                    id="dots"
                    width="20"
                    height="20"
                    patternUnits="userSpaceOnUse"
                >
                    <circle cx="1" cy="1" r="1" class="fill-neutral-400/20" />
                </pattern>
                <rect width="100%" height="100%" fill="url(#dots)" />
            </svg>
        </div>
    </div>
</AppLayout>
