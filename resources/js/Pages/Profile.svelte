<script lang="ts">
    import Grid from "@/Components/Grid.svelte";
    import GridItem from "@/Components/GridItem.svelte";
    import AppLayout from "@/Layouts/AppLayout.svelte";
</script>

<AppLayout title="Profile">
    <div class="space-y-8 p-6">
        <div>
            <h2 class="text-2xl font-bold mb-4">
                Responsive Grid - Individual Props
            </h2>
            <Grid
                cols={1}
                smCols={2}
                mdCols={3}
                class="lg:grid-cols-4 bg-amber-900"
            >
                <div class="bg-blue-400 p-4 rounded text-center">Item 1</div>
                <div class="bg-green-800 p-4 rounded text-center">Item 2</div>
                <div class="bg-blue-400 p-4 rounded text-center">Item 3</div>
                <div class="bg-green-800 p-4 rounded text-center">Item 4</div>
                <div class="bg-purple-500 p-4 rounded text-center">Item 5</div>
                <div class="bg-orange-500 p-4 rounded text-center">Item 6</div>
            </Grid>
        </div>
    </div>
</AppLayout>

<!-- <Grid cols={1} smCols={2} mdCols={3} class="lg:grid-cols-4 bg-amber-900">
    <div class="bg-blue-400 p-4 rounded text-center">Item 1</div>
    <div class="bg-green-800 p-4 rounded text-center">Item 2</div>
    <div class="bg-blue-400 p-4 rounded text-center">Item 3</div>
    <div class="bg-green-800 p-4 rounded text-center">Item 4</div>
    <div class="bg-purple-500 p-4 rounded text-center">Item 5</div>
    <div class="bg-orange-500 p-4 rounded text-center">Item 6</div>
</Grid> -->
