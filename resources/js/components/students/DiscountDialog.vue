<template>
    <v-dialog @click:outside="$emit('closeDialog',true)" v-model="dialog" max-width="600px">
        <v-card>
            <v-toolbar flat elevation="1" >
                <v-spacer></v-spacer>
                <v-toolbar-title class="primary--text" >Discount Offers</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
                <v-sheet elevation="1" class="d-flex pt-2 pb-2 mb-1 mt-3">
                    <input class="offer-search pl-2 pr-2" placeholder="Enter Discount Code">
                    <v-btn color="primary">Add</v-btn>
                </v-sheet>
                <div style="max-height: 500px ;overflow: auto">
                    <v-banner class="my-4" single-line  elevation="2" v-for="(offer,i) in offers" :key="i">
                        <template v-slot:icon>
                        <span class="offer-discount">
                            {{offer.discount}}
                        </span>
                        </template>
                        {{offer.text}}
                        <template v-slot:actions>
                            <v-btn small color="primary" disabled >{{offer.code}}</v-btn>
                        </template>
                    </v-banner>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "DiscountDialog",
        props:{
            dialog:false,
        },
        data(){
            return{
                offers:[
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    },
                    {
                        text:"Discount on Student First Registration",
                        discount:'10%',
                        code:"123456"
                    }
                ]
            }
        }
    }
</script>

<style lang="scss">
.offer-discount{
    font-weight: bold;
    font-size: 1.4rem;
}
    .offer-search{
        flex-grow: 1;
        &:focus{
            outline: none;
            border: none;
        }
    }
</style>