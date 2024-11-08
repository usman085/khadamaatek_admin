<template>
  <v-app-bar elevation="1" color="#ffffff" class="app-bar" app>
    <div class="d-flex flex-column pl-4">
      <div class="d-flex align-content-center pt-2">
        <span class="app-bar--icon pr-1">
          <v-icon>{{$route.meta.icon}}</v-icon>
        </span>
        <span class="app-bar--title">{{$route.meta.title}}</span>
      </div>
      <div
        class="app-bar--subtitle"
      >{{$route.meta.subtitle!==''?$route.meta.subtitle:'Welcome to QS Learning'}}</div>
    </div>
    <v-spacer></v-spacer>
    <v-btn icon>
      <v-icon>mdi-bell-outline</v-icon>
    </v-btn>
    <v-avatar size="36px">
      <img src="https://i.pinimg.com/originals/4c/09/06/4c09067dfd891f0f1ef6da9a461c10e6.jpg" />
    </v-avatar>
    <!-- <router-link
      v-if="isVisible"
      class="profile-link"
      active-class
      :exact="true"
    :to="{name: 'StudentProfile'}"-->
    <!-- > -->
    <v-btn text color="primary" v-if="isVisible">John Doe</v-btn>
    <!-- </router-link> -->
    <v-btn v-else text color="primary">Admin</v-btn>
  </v-app-bar>
</template>

<script>
export default {
  name: "AppBar",
  mounted() {
    this.checkPanelType();
  },
  data() {
    return {
      isVisible: false
    };
  },
  methods: {
    checkPanelType() {
      this.isVisible = (this.$route.meta.panelType == "Student" || this.$route.meta.panelType == "Tutor") ? true : false;
    }
  }
};
</script>

<style lang="scss">
.app-bar {
  background: rgb(255, 255, 255);
  &--icon {
    color: #656c7d;
  }
  &--title {
    color: #656c7d;
    font-size: 1.2rem;
    font-weight: bold;
  }
  &--subtitle {
    color: rgb(223, 223, 223);
    font-size: 0.7rem;
  }
}

.profile-link {
  text-decoration: none;
}
</style>