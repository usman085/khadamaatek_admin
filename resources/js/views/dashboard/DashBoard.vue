<template>
    <v-container >
        <div class="d-flex justify-space-between">
            <v-btn tile color="primary" class="text-capitalize">
                Date Filters
            </v-btn>
            <v-breadcrumbs :items="breadItems" divider=">"></v-breadcrumbs>
        </div>
        <DashBoardTopCards></DashBoardTopCards>
        <v-row>
            <v-col sm="12" md="8" lg="8">
                <v-card min-height="350px"></v-card>
            </v-col>
            <v-col sm="12" md="4" lg="4">
                <v-card min-height="350px"></v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import DashBoardTopCards from "./cards/DashBoardTopCards";
    export default {
        name: "DashBoard",
        components: {DashBoardTopCards},
        data(){
            return{
                breadItems:[
                    {
                        text: 'Dashboard',
                        disabled: true,
                        to: {
                            name:"DashBoard"
                        },
                    },
                ]
            }
        }
    }
</script>

<style scoped>

</style>