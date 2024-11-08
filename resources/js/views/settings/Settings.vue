<template>
  <v-container>
    <div class="d-flex justify-end">
      <v-breadcrumbs :items="breadItems" divider=">"></v-breadcrumbs>
    </div>
    <v-row>
      <v-col sm="12">
        <v-card class="setting-card">
          <router-link class="profile-link" active-class :exact="true" :to="{name: 'SettingClass'}">
            <div class="menu-box">
              <v-img
                src="../../assets/presentation.png"
                class="menu-box__photo"
                max-height="60px"
                max-width="60px"
                contain
              ></v-img>
              <h3 class="menu-box__title">Classes</h3>
            </div>
          </router-link>

          <router-link class="profile-link" active-class :exact="true" :to="{name: 'Users'}">
            <div class="menu-box">
              <v-icon class="drawer--nav-item__icon">fas fa-users</v-icon>

              <h3 class="menu-box__title">Users</h3>
            </div>
          </router-link>

          <router-link class="profile-link" active-class :exact="true" :to="{name: 'Discounts'}">
            <div class="menu-box">
              <v-icon class="drawer--nav-item__icon">mdi-sale</v-icon>
              <h3 class="menu-box__title">Discounts</h3>
            </div>
          </router-link>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
export default {
  name: "Settings",
  components: { BreadCrumbs },
  data() {
    return {
      breadItems: [
        {
          text: "Dashboard",
          disabled: false,
          href: "/",
          to: {
            name: "DashBoard"
          }
        },
        {
          text: this.$route.meta.title,
          disabled: true,
          to: {
            name: this.$route.name
          }
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.setting-card {
  min-height: 70vh;
  background: #fff;
  box-shadow: 0px 3px 6px #2c28281c;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.menu-box {
  background: #fafafa;
  border-radius: 10px;
  opacity: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  //   padding: 40px;
  margin-right: 15px;
  width: 162px;
  height: 162px;
}
</style>