<template>
  <b-tab title="Digital Wallet" title-link-class="subtabs">
    <div class="tab-card">
      <h2 class="tab-card__title">Digital Wallet</h2>
      <div class="total-balance">
        <h1>
          <span class="currency">{{ currency }}</span>
          <span class="balance">{{ balance }}</span>
        </h1>
        <h3 class="balance-text">Total Balance</h3>
      </div>
    </div>
  </b-tab>
</template>

<script>
export default {
  name: "DigitalWallet",
  async created() {
    const loggedin = JSON.parse(localStorage.getItem("user"));
    const getPendingOrders = await axios
      .post("wallet/get-wallet-balance", { user_id: loggedin.user.id })
      .then(({ data }) => {
        this.balance = data.data.balance;
        this.currency = data.currency;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  data() {
    return {
      currency: "$",
      balance: "0.00",
    };
  },
};
</script>

<style lang="css" scoped>
.total-balance {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding-top: 7rem;
  font-size: 48px;
  border-top: 1px solid #999;
}
.total-balance h1 {
  font-size: 50px;
  margin-bottom: 0;
  color: var(--secondary-color);
}
.balance-text {
  color: var(--primary-color);
}
</style>