<template>
  <main class="app-page">
    <main-header heading="About" heading_bold="KHADAMATEEK" type="user"></main-header>

    <!-- Section 1 -->
    <section class="tabs-section">
      <b-container>
        <b-row>
          <b-col cols="12">
            <b-tabs v-model="step" b-tabs pills card vertical nav-wrapper-class="col-md-3 col-sm-4 profile-tabs">
              <service-order  @click="edit_order_id == null" :order_id="edit_order_id" :key="edit_order_id"></service-order>

              <pending-services @editOrder="editOrderDetail"></pending-services>

              <inprocess-services></inprocess-services>

              <bank-transfer></bank-transfer>

              <digital-wallet></digital-wallet>

              <approved-services></approved-services>

              <cancelled-services></cancelled-services>

              <!-- <b-tab title="Notifications">
                <div class="tab-card">
                  <h2 class="tab-card__title">Notifications</h2>
                </div>
              </b-tab>-->

              <documents></documents>

              <balance-share></balance-share>

              <my-profile></my-profile>

              <change-number></change-number>

              <b-tab>
                <template v-slot:title>
                  <span class="logout-text" @click.prevent="logout">Logout</span>
                </template>
                <b-card-text></b-card-text>
              </b-tab>
            </b-tabs>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <main-footer></main-footer>
  </main>
</template>

<script>
import MainHeader from "../../components/layout/Header";
import ServiceOrder from "../../components/users/ServiceOrder";
import PendingServices from "../../components/users/PendingServices";
import InprocessServices from "../../components/users/InprocessServices";
import BankTransfer from "../../components/users/BankTransfer";
import DigitalWallet from "../../components/users/DigitalWallet";
import ApprovedServices from "../../components/users/ApprovedServices";
import CancelledServices from "../../components/users/CancelledServices";
import BalanceShare from "../../components/users/BalanceShare";
import Documents from "../../components/users/Documents";
import MyProfile from "../../components/users/MyProfile";
import ChangeNumber from "../../components/users/ChangeNumber";
import MainFooter from "../../components/layout/Footer";

export default {
  name: "Profile",
  components: {
    MainHeader,
    ServiceOrder,
    PendingServices,
    InprocessServices,
    BankTransfer,
    DigitalWallet,
    ApprovedServices,
    CancelledServices,
    BalanceShare,
    Documents,
    MyProfile,
    ChangeNumber,
    MainFooter,
  },
  data() {
    return {
      edit_order_id: null,
      step: 0,
    };
  },
  methods: {
    editOrderDetail(id){
      this.edit_order_id = id;
      this.step = 0;
    },
    logout: function () {
      this.$store
        .dispatch("logout")
        .then(() => {
          this.$router.push({ name: "Home" });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },

  created() {
    const loggedIn = JSON.parse(localStorage.getItem("user"));

    if (loggedIn && loggedIn.token && loggedIn.user) {
      (this.isLoggedin = true),
        (this.userName =
          loggedIn.user.first_name + " " + loggedIn.user.last_name);
    }
  },
};
</script>

<style lang="scss">
.table.stack-table-left.b-table-stacked > tbody > tr > [data-label]::before {
  text-align: left;
}
.table.stack-table-left.b-table-stacked > tbody > tr > :first-child {
  border: 0;
}
.table.stack-table-left th,
.table.stack-table-left td {
  border: 0;
}

.order-summary {
  border: 1px dashed;
  padding: 15px;
}

.contact-info {
  margin-top: 6rem;

  &__title {
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
  }
}

.package-box {
  background: #fafafa;
  padding: 12px;

  &__heading {
    background: #f9f9f9;
    border: 1px solid #ffffff;
    padding: 10px;
    font-size: 20px;
    font-weight: 500;
    color: var(--text-color-1);
  }

  &__thumbnail {
    background: var(--secondary-color);
    text-align: center;
    border-radius: 12px;
    padding: 5px;
  }

  &__title {
    font-size: 32px;
    font-weight: bold;
    color: var(--secondary-color);
  }

  &__type {
    font-size: 14px;
    font-weight: 500;
    height: 100%;
    color: #646464;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__benefits {
    background: #f9f9f9;
    text-align: center;
    padding: 6px;
    margin-bottom: 10px;
  }

  &__total {
    font-size: 30px;
    font-weight: 500;
    color: var(--text-color-1);
    display: flex;
    justify-content: flex-end;
    align-items: center;

    & .color-primary {
      font-weight: bold;
      margin-left: 5px;
    }
  }

  &__heading {
    background: #f9f9f9;
    border: 1px solid #ffffff;
    padding: 10px;
    font-size: 20px;
    font-weight: 500;
    color: var(--text-color-1);
  }

  &__price {
    font: Bold 42px/67px Poppins;
    letter-spacing: 0px;
    color: var(--primary-color);
    opacity: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 25px 10px;
  }

  &__pkg-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--secondary-color);
  }

  &__pkg-type {
    font-size: 18px;
    font-weight: 500;
    color: #646464;
  }

  &__total-text {
    font: 500 16px Poppins;
    color: var(--text-color-1);
  }

  &__total-value {
    font: 700 16px Poppins;
    color: var(--text-color-3);
    text-align: right;
  }

  &__total-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 12px;
    margin-bottom: 10px;
  }

  &__total {
    font: 500 20px Poppins;
    color: var(--text-color-1);
    margin-bottom: 0;
  }

  &__total-amount {
    font: 700 20px Poppins;
    color: var(--secondary-color);
    margin-bottom: 0;
  }
}

.btn-black {
  background: #000;
  font: 600 16px/32px Poppins;
  color: #ffffff;
  text-align: center;
  padding: 10px;

  &:hover {
    color: #000;
    background-color: #ffffff;
    border: 1.5px solid #000;
  }
}

.steps-content {
  margin-top: 16px;
  border: 1px dashed #e9e9e9;
  border-radius: 6px;
  background-color: #fafafa;
  min-height: 200px;
  text-align: center;
  padding-top: 80px;
}

.steps-action {
  margin-top: 24px;
}

.tabs-section {
  padding: 8rem 15px;
  background-color: #f8f8f8;
}
.profile-tabs {
  & .nav.nav-pills {
    padding: 0;
    background: transparent;

    & .nav-item {
      & .nav-link {
        position: relative;
        background-color: #ce9718;
        color: #fff;
        font-size: 1.5rem;
        border-bottom: 1px solid #f8f8f8;
        border-radius: 0;
        padding: 10px 25px;

        &.active::after {
          content: "\F00C";
          font-family: "Font Awesome 5 Free";
          font-weight: 900;
          color: #999;
          position: absolute;
          top: 1rem;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-pack: center;
          justify-content: center;
          -ms-flex-align: center;
          align-items: center;
          color: #fff;
          right: 5px;
          position: absolute;
          /* background: var(--secondary-color); */
          border-radius: 50%;
          font-size: 13px;
          height: 20px;
          width: 20px;
        }

        &.subtabs {
          background: #fff;
          color: #888;
          border-color: #999;

          &.active::after {
            color: var(--primary-color);
          }
        }
      }

      &:first-of-type .nav-link {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
      }
      &:last-of-type .nav-link {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
      }
    }
  }
}

.nav-tabs .nav-item .nav-link {
  border-color: #dee2e6 #dee2e6 #fff;
  background-color: #e7e7e7;
  color: #004120;
  font-size: 14px;
  padding: 8px 20px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  margin-right: 3px;

  &.active {
    color: #fff;
    background-color: #004120;
  }
}

.tab-card {
  background: #fff;
  min-height: 30rem;
  padding: 2rem;
  padding-bottom: 6rem;
  border-radius: 1rem;

  &__box {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90px;
    background: #fafafa;
    margin-bottom: 10px;
    color: #b1b4b7;
    font-size: 15px;
    padding: 15px;
    font-weight: 500;
    cursor: pointer;

    &.active::after {
      content: "\f00c";
      font-family: "Font Awesome\ 5 Free";
      font-weight: 900;
      color: #999;
      position: absolute;
      top: 5px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      right: 5px;
      background: var(--secondary-color);
      border-radius: 50%;
      font-size: 10px;
      height: 20px;
      width: 20px;
    }

    &.active {
      border: 2px solid var(--secondary-color);
    }
  }

  &__description {
    color: #bbbbbb;
    font-size: 14px;
  }

  &__label {
    font-size: 14px;
    font-weight: 500;
  }

  &__input {
    height: calc(2em + 0.75rem + 2px);
    border: none;
    font-size: 14px;
    border-bottom: 1px solid #ced4da;
  }

  &__btn {
    background-color: #fafafa;
    font-size: 1.4rem;
    padding: 8px 15px;
    border-radius: 8px;

    &.btn-secondary {
      background: #004120;
    }

    &.step-btn {
      padding: 8px 20px;
    }
  }

  &__table {
    font-size: 14px;
  }
}

.table.profile-table {
  margin-top: 1rem;
  border-collapse: separate !important;
  border-spacing: 0 3px !important;

  & thead {
    display: none;
  }

  & td {
    border-top: none;
    border-bottom: 1px solid #fff;
    font-size: 13px;
    background: #fafafa;
  }
}
</style>