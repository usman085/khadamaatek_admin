<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <h2 color="#6A158E" class="page-heading">Group Code # 08</h2>

      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>
    <v-card>
      <div class="nmt-1">
        <!-- card -->
        <v-row style="padding: 0 20px; margin-bottom: 20px;">
          <v-col md="6">
            <v-card class="card-blue">
              <v-simple-table class="group-detail__table">
                <template v-slot:default>
                  <tbody>
                    <tr v-for="item in classes" :key="item.name">
                      <th>{{ item.name }}</th>
                      <td>{{ item.value }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card>
          </v-col>

          <v-col md="6">
            <v-card class="card-blue">
              <v-simple-table class="group-detail__table">
                <template v-slot:default>
                  <tbody>
                    <tr v-for="item in students" :key="item.name">
                      <th>{{ item.name }}</th>
                      <td>{{ item.value }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <v-btn color="#F0CB00" block tile elevation="0">Add</v-btn>
              <span class="note">You may add two more students</span>
            </v-card>
          </v-col>
        </v-row>
        <session-table></session-table>
      </div>
    </v-card>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import SessionTable from "../../components/classes/SessionTable";

export default {
  name: "Classes",
  components: { SessionTable, BreadCrumbs },
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
          text: "Groups",
          disabled: false,
          to: {
            name: "Groups"
          }
        },
        {
          text: this.$route.meta.title,
          disabled: true,
          to: {
            name: this.$route.name
          }
        }
      ],
      classes: [
        {
          name: "Class",
          value: "7th"
        },
        {
          name: "Subject",
          value: "Maths & English"
        },
        {
          name: "Tutor Name",
          value: "Yaquoob Dewan"
        },
        {
          name: "Days",
          value: "Mon, Tue"
        },
        {
          name: "Time",
          value: "2:00 PM to 3:00 PM"
        }
      ],
      students: [
        {
          name: "Student 1",
          value: "+2 340 1234567"
        },
        {
          name: "Student 2",
          value: "+2 340 1234567"
        },
        {
          name: "Student 3",
          value: "+2 340 1234567"
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.note {
  display: block;
  margin-top: 5px;
  text-align: center;
  font: 300 12px/15px Lato;
  color: #9333bb;
}
.group-detail {
  &__table {
    & th,
    & td {
      background: #b8b8b812;
    }
    & th {
      font: 500 14px/22px Gotham !important;
      color: #172b4d;
    }
    & td {
      font: 300 14px/19px Gotham !important;
      color: #172b4d;
      text-align: right;
    }
  }
}
.card-blue {
  box-shadow: 0px 3px 6px #2c28281c;
  border-radius: 10px;
  border-left: 5px solid #9333bb;
  padding: 10px 0px;
  height: 100%;
}
.page-heading {
  font: 300 22px/26px;
  font-family: "Gotham Narrow";
  color: #6a158e;
}
</style>