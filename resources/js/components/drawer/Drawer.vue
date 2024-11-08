<template>
  <v-navigation-drawer class="drawer" permanent app>
    <div class="drawer--title text-center">
      <router-link class="logo-link" active-class="active" :exact="true" :to="{name: 'DashBoard'}">
        <img src="../../assets/logo.png" alt="Logo" class="logo" />
      </router-link>
      <!-- <span>Q</span>
      <span>S</span>Learning-->
    </div>
    <div class="drawer--nav">
      <drawer-item v-for="(link, index) in links" :key="index" :link="link" :active="link.active" />
    </div>
    <div class="nav-bg"></div>
  </v-navigation-drawer>
</template>

<script>
import DrawerItem from "./DrawerItem";
export default {
  name: "Drawer",
  components: { DrawerItem },
  data() {
    return {
      links: [
        {
          icon: "mdi-poll-box",
          text: "Dashboard",
          exact: true,
          to: {
            name: "DashBoard"
          }
        },
        // {
        //   icon: "",
        //   text: "Admin",
        //   exact: true,
        //   to: {
        //     name: "Profile"
        //   }
        // },
        {
          icon: "mdi-school",
          text: "Students",
          exact: false,
          to: {
            name: "Students"
          }
        },
        {
          icon: "mdi-teach",
          text: "Tutors",
          exact: false,
          to: {
            name: "Tutors"
          }
        },
        {
          icon: "mdi-account-group",
          text: "Classes",
          exact: false,
          to: {
            name: "Classes"
          }
        },
        {
          icon: "fas fa-file-word",
          text: "CatchUp",
          exact: false,
          to: {
            name: "CatchUps"
          }
        },
        {
          icon: "fas fa-file-word",
          text: "Work",
          exact: false,
          to: {
            name: "Works"
          }
        },
        {
          icon: "mdi-account-cash-outline",
          text: "Accounts",
          exact: false,
          to: {
            name: "Accounts"
          }
        },
        {
          icon: "mdi-cog",
          text: "Settings",
          exact: false,
          to: {
            name: "Settings"
          }
        },
        {
          icon: "mdi-school",
          text: "Student",
          exact: false,
          to: {
            name: "StudentProfile"
          }
        },
        {
          icon: "mdi-teach",
          text: "Classes",
          exact: false,
          to: {
            name: "StudentClasses"
          }
        },
        {
          icon: "fas fa-file-word",
          text: "Work",
          exact: false,
          to: {
            name: "StudentWork"
          }
        },
        {
          icon: "fas fa-file-word",
          text: "Catch up",
          exact: false,
          to: {
            name: "StudentCatchUp"
          }
        },
        {
          icon: "mdi-account-cash-outline",
          text: "Accounts",
          exact: false,
          to: {
            name: "StudentAccounts"
          }
        },
        // Tutor Modules
        {
          icon: "fas fa-user",
          text: "Tutor",
          exact: false,
          to: {
            name: "TutorProfile"
          }
        },
        {
          icon: "mdi-teach",
          text: "Classes",
          exact: false,
          to: {
            name: "TutorClasses"
          }
        },
        {
          icon: "mdi-account-cash-outline",
          text: "Accounts",
          exact: false,
          to: {
            name: "TutorAccounts"
          }
        }
      ]
    };
  }
};
</script>

<style lang="scss">
.drawer {
  overflow: visible !important;

  & .nav-bg {
    background-image: url("../../assets/nav-bg.png");
    background-repeat: no-repeat;
    min-height: 200px;
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 0px;
    background-size: auto;
  }
  &--title {
    color: rgb(107, 22, 143);
    font-size: large;
    background: #ffffff;
    height: 64px;
    line-height: 64px;
    & span {
      background: rgb(107, 22, 143);
      color: white;
      padding: 5px;
      margin-right: 3px;
    }
  }
  & .v-navigation-drawer__content {
    display: flex;
    background: #2e3032;
    flex-direction: column;
  }
  &--nav {
    flex-grow: 2;
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    grid-auto-rows: 100px;
    padding-top: 30px;
    margin: 0 auto;
    position: relative;
    z-index: 9;
  }
  @media only screen and (max-width: 900px) {
    &--title {
      color: rgb(107, 22, 143);
      font-size: 1.5rem;
      font-weight: 900;
      height: 56px;
      line-height: 56px;
    }
  }
}
</style>