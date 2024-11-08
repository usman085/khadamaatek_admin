<template>
  <v-card>
    <delete-dialog @closeDialog="delete_dialog=false" :dialog="delete_dialog" title="User"></delete-dialog>
    <v-data-table
      :page.sync="page"
      @page-count="pageCount = $event"
      :items="students"
      :headers="headers"
      hide-default-footer
    >
      <template v-slot:item.srno="{ item }">
        <span class="table-users-srno">{{item.srno}}</span>
      </template>

      <template v-slot:item.name="{ item }">
        <span class="table-users-name">{{item.name}}</span>
      </template>

      <template v-slot:item.status="{ item }">
        <span class="table-users-status st-success" v-if="item.status">Active</span>
        <span class="table-users-status st-error" v-else>Inactive</span>
      </template>

      <template v-slot:item.action="{ item }">
        <router-link class="profile-link" active-class :exact="true" :to="{name: 'EditUser'}">
          <v-icon color="success">mdi-file-edit</v-icon>
        </router-link>
        <v-icon color="red" @click.stop="delete_dialog = true">mdi-delete</v-icon>
      </template>
    </v-data-table>
    <div class="pa-2 d-flex justify-end">
      <span class="pa-2">
        Total Users
        <span
          :style="{'color':this.$vuetify.theme.themes.light.primary}"
        >{{students.length}}</span>
      </span>
      <v-spacer></v-spacer>
      <v-pagination circle v-model="page" :length="pageCount"></v-pagination>
    </div>
  </v-card>
</template>

<script>
import DeleteDialog from "../Dialogs/DeleteDialog";

export default {
  name: "ClassTable",
  components: {
    DeleteDialog
  },
  data() {
    return {
      delete_dialog: false,
      page: 1,
      pageCount: 3,
      itemsPerPage: 10,
      headers: [
        { text: "SrNo.", sortable: true, value: "srno" },
        { text: "Name", value: "name", sortable: true },
        { text: "Email", value: "email", sortable: false },
        { text: "Password", value: "password", sortable: false },
        { text: "Status", value: "status", sortable: false },
        { text: "Role", value: "role", sortable: true },
        { text: "Action", value: "action", sortable: false }
      ],
      students: [
        {
          srno: this.getZeroAddedNum(1),
          name: "Keinjei",
          email: "Keinjei@example.com",
          password: "********",
          status: true,
          role: "Admin",
          action: null
        },
        {
          srno: this.getZeroAddedNum(2),
          name: "Kylen",
          email: "Kylen@example.com",
          password: "********",
          status: false,
          role: "Admin",
          action: null
        },
        {
          srno: this.getZeroAddedNum(3),
          name: "Hikron",
          email: "Hikron@example.com",
          password: "********",
          status: true,
          role: "Admin",
          action: null
        },
        {
          srno: this.getZeroAddedNum(4),
          name: "Zenstr",
          email: "Zenstr@example.com",
          password: "********",
          status: false,
          role: "Admin",
          action: null
        }
      ]
    };
  },
  methods: {
    getZeroAddedNum(num) {
      return num.toString().padStart(2, "0");
    }
  }
};
</script>

<style lang='scss'>
.v-data-table-header th span {
  font: 300 14px Gotham;
  font-family: "Gotham Narrow";
  color: #8898aa;
}
.table-users {
  &-srno {
    font: 500 14px/13px Gotham;
    color: #172b4d;
  }
  &-name {
    display: block;
    font: 500 14px/13px Gotham;
    color: #6a158e;
  }
  &-email {
    font: 400 12px/13px Lato;
    color: #172b4d4d;
  }
  &-time {
    display: block;
    font: 400 11px/10px Lato;
    color: #0e0edff7;
  }
  &-days {
    font: 400 10px/15px Lato;
    color: #172b4db3;
  }
  &-status {
    font: 500 14px/13px Gotham;
    &.st-success {
      color: #129b11;
    }
    &.st-error {
      color: #e41b1bf7;
    }
  }
  &-tutor {
    font: 500 13.5px Gotham;
    color: #529b11;
  }
}

.v-btn.v-size--default {
  font-size: 12px;
  text-transform: none;
}
</style>