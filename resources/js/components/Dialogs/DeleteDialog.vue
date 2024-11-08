<template>
  <v-dialog @click:outside="$emit('closeDialog',true)" v-model="dialog" persistent max-width="290">
    <v-card class="text-center" style="padding: 10px 15px">
      <v-card-title class="headline d-block text-center" color="#172B4D">Are your Sure?</v-card-title>
      <v-card-text>You won't be to delete this {{ title }}!</v-card-text>
      <v-card-actions class="justify-space-between">
        <v-btn color="#6A158E" dark @click="$emit('closeDialog',true)">Yes, Delete it</v-btn>
        <v-btn color="default" @click="$emit('closeDialog',true)">Cancel</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "DeleteDialog",
  props: {
    dialog: false,
    title: ""
  },
  data() {
    return {};
  }
};
</script>

<style lang="scss">
</style>