<template>
  <b-navbar toggleable="sm" class="menubar">
    <router-link :to="{name: 'Home'}" class="navbar-brand">
      <img
        :src="require(`../../assets/logo/${logoType}`)"
        alt="Logo"
        height="125"
        class="img-fluid"
      />
    </router-link>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav class="ml-auto bg-white menubar__menu">
        <li class="nav-item">
          <router-link :to="{name: 'Home'}" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{name: 'Services'}" class="nav-link">Services</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{name: 'AboutUs'}" class="nav-link">About Us</router-link>
        </li>
        <!-- <b-nav-item href="/contact-us">Contact Us</b-nav-item> -->
        <li class="nav-item" v-if="isLoggedin">
          <router-link :to="{name: 'Profile'}" class="nav-link">{{ userName }}</router-link>
        </li>

        <li class="nav-item" v-else>
          <router-link :to="{name: 'Signin'}" class="nav-link">Signin</router-link>
        </li>
      </b-navbar-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="registration">
        <router-link
          :to="{name: 'Signup'}"
          class="btn btn-primary menubar__registration"
          v-if="!isLoggedin"
        >Registration</router-link>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  name: "MenuBar",
  props: {
    logoType: {
      type: String,
      default: "logo.png",
    },
  },
  data() {
    return {
      isLoggedin: false,
      userName: "",
    };
  },
  created() {
    const loggedIn = JSON.parse(localStorage.getItem("user"));
    const isVerified = localStorage.getItem("isUserVerfied");
    
    if ((loggedIn && loggedIn.token && loggedIn.user) && isVerified == 'true') {
      this.isLoggedin = true,
      this.userName = loggedIn.user.first_name + " " + loggedIn.user.last_name;
    }
  },
};
</script>

<style lang="scss">
.navbar-brand {
  & img {
    max-height: 70px !important;
  }
}

.menubar {
  position: relative;
  z-index: 2;
  margin-bottom: 10px;
  padding-left: 5rem;
  &__menu {
    background: #ffffff;
    border: 1px solid #ce9718;
    padding: 15px 20px;
  }

  &__registration {
    font: 500 18px/23px Poppins;
    padding: 22px 40px;
    border-radius: 0;
    background: #004120;
    border: 0;
  }
}

.navbar-light .navbar-nav .nav-link {
  font: 500 18px/23px Poppins;
  color: #006c35;
  &.router-link-exact-active {
    color: #cd9e33;
    border-bottom: 3px solid #cd9e33;
  }
}
</style>