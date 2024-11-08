<template>
    <v-row>
        <dash-board-top-card-item></dash-board-top-card-item>
        <dash-board-top-card-item></dash-board-top-card-item>
        <dash-board-top-card-item></dash-board-top-card-item>
        <dash-board-top-card-item></dash-board-top-card-item>
    </v-row>
</template>

<script>
    import DashBoardTopCardItem from "./DashBoardTopCardItem";
    export default {
        name: "DashBoardTopCards",
        components: {DashBoardTopCardItem}
    }
</script>

<style scoped>

</style>