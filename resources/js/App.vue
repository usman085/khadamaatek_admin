<template>
  <router-view></router-view>
</template>

<script>
import { mapGetters } from "vuex";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

export default {
  name: "App",

  computed: {
    ...mapGetters(["isLogged"]),
  },

  methods: {
    logout() {
      this.$store.dispatch("logout");
    },
  },

  data: () => ({
    //
  }),
  mounted() {
    // Clear the browser cache data in localStorage when closing the browser window
    // window.onbeforeunload = function (e) {
    //   var storage = window.localStorage;
    //   storage.clear();
    // };
  },
};
</script>
<style lang="scss" src="./assets/style/custom.scss"></style>
