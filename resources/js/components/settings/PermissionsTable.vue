<template>
  <v-card>
    <v-row class="pl-4">
      <v-col sm="6">
        <label class="custom-label">User</label>
        <v-select :items="users" label="Choose User" placeholder="Choose User" solo></v-select>
      </v-col>
    </v-row>
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

      <template v-slot:item.modules="{ item }">
        <span class="table-users-name">{{item.modules}}</span>
      </template>

      <template v-slot:item.add="{ item }">
        <v-checkbox v-model="item.add" color="#0EBDDFF7"></v-checkbox>
      </template>
      <template v-slot:item.update="{ item }">
        <v-checkbox v-model="item.update" color="#0EBDDFF7"></v-checkbox>
      </template>
      <template v-slot:item.view="{ item }">
        <v-checkbox v-model="item.view" color="#0EBDDFF7"></v-checkbox>
      </template>
      <template v-slot:item.delete="{ item }">
        <v-checkbox v-model="item.delete" color="#0EBDDFF7"></v-checkbox>
      </template>

      <template v-slot:item.action="{ item }">
        <router-link class="profile-link" active-class :exact="true" :to="{name: 'EditUser'}">
          <v-icon color="success">mdi-file-edit</v-icon>
        </router-link>
        <v-icon color="red">mdi-delete</v-icon>
      </template>
    </v-data-table>
    <div class="pa-2 d-flex justify-end">
      <span class="pa-2">
        Total Modules
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
export default {
  name: "PermssionTable",
  components: {},
  data() {
    return {
      users: ["Admin", "Ali Raza", "Ahmad Fraz", "Ali Arsalan"],
      page: 1,
      pageCount: 3,
      itemsPerPage: 10,
      headers: [
        { text: "SrNo.", sortable: true, value: "srno" },
        { text: "Modules", value: "modules", sortable: true },
        { text: "Add", value: "add", sortable: false },
        { text: "Update", value: "update", sortable: false },
        { text: "View", value: "view", sortable: false },
        { text: "Delete", value: "delete", sortable: true }
      ],
      students: [
        {
          srno: this.getZeroAddedNum(1),
          modules: "Students",
          add: true,
          update: true,
          view: true,
          delete: true
        },
        {
          srno: this.getZeroAddedNum(2),
          modules: "Tutors",
          add: true,
          update: false,
          view: false,
          delete: false
        },
        {
          srno: this.getZeroAddedNum(3),
          modules: "Classes",
          add: true,
          update: true,
          view: true,
          delete: true
        },
        {
          srno: this.getZeroAddedNum(4),
          modules: "Catch up Session",
          add: true,
          update: false,
          view: false,
          delete: false
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