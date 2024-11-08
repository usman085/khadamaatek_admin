<template>
  <router-link
    tag="button"
    active-class="active"
    :exact="link.exact"
    :to="link.to"
    v-ripple="{ class: 'primary--text' }"
    class="drawer--nav-item"
  >
    <v-icon class="drawer--nav-item__icon">{{link.icon}}</v-icon>
    <span class="drawer--nav-item__title">{{link.text}}</span>
  </router-link>
  <!--    <button @click="$router.push(link.to)" >-->
  <!--        -->
  <!--    </button>-->
</template>

<script>
export default {
  name: "DrawerItem",
  props: {
    active: {
      type: Boolean,
      default: false
    },
    link: {
      type: Object,
      required: true
    }
  }
};
</script>

<style lang="scss">
.drawer--nav-item {
  outline: none;
  border: none;
  width: 100px;
  height: 100px;
  background: #ffffff;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  &__icon {
    font-size: 2.5rem !important;
    color: rgb(46, 48, 50) !important;
  }
  &.active &__icon {
    color: rgb(240, 203, 0) !important;
  }
  &__title {
    font-size: 1rem;
    font-weight: 800;
    color: rgb(103, 104, 106);
  }
}
</style>