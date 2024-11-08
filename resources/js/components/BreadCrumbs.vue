<template>
    <v-breadcrumbs :items="items" light divider=">">
        <template v-slot:item="{ item }">
            <v-breadcrumbs-item
                    @click="$router.push(item.to)"
                    :disabled="item.disabled"
            >
                <a class="v-breadcrumbs__item" :class="item.disabled?'v-breadcrumbs__item v-breadcrumbs__item--disabled':''">{{ item.text.toUpperCase() }}</a>
            </v-breadcrumbs-item>
        </template>
    </v-breadcrumbs>
</template>

<script>
    export default {
        name: "BreadCrumbs",
        props:{
            items:{
                type:Array,
                required:true
            }
        },
    }
</script>

<style scoped lang="scss">
    .v-breadcrumbs__item{
        cursor: pointer !important;
    }
</style>