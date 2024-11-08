<template>
  <v-card>
    <v-form>
      <v-container>
        <fieldset>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Full Name</label>
              <v-text-field v-model="currentName" label="Name" placeholder="Name" solo></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Email</label>
              <v-text-field
                v-model="currentEmail"
                type="email"
                label="Email"
                placeholder="Email"
                solo
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Password</label>
              <v-text-field
                v-model="currentPassword"
                type="password"
                label="Password"
                placeholder="Password"
                solo
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Status</label>
              <v-select
                v-model="selectStatus"
                :items="statuses"
                label="Choose Status"
                placeholder="Choose Status"
                solo
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Role</label>
              <v-select
                v-model="selectRole"
                :items="roles"
                label="Choose Role"
                placeholder="Choose Role"
                solo
              ></v-select>
            </v-col>

            <v-col cols="12">
              <v-btn color="#6A158E" dark>Save</v-btn>
            </v-col>
          </v-row>
        </fieldset>
      </v-container>
    </v-form>
  </v-card>
</template>

<script>
export default {
  name: "ClassForm",
  data() {
    return {
      currentName: "",
      currentEmail: "",
      currentPassword: "",
      fare: "",
      selectStatus: "",
      statuses: ["Active", "Inactive"],
      selectRole: "",
      roles: ["Admin", "User", "Tutor"]
    };
  }
};
</script>

<style lang="scss" scoped>
fieldset {
  border: 0;
  &:not(:last-of-type) {
    border-bottom: 1px dashed #8898aa80;
    margin-bottom: 20px;
  }

  & legend {
    font: Bold 20px/25px Lato;
    color: #172b4d;
  }

  & label {
    font: Bold 15px/40px Lato;
    color: #172b4d;
  }
}
</style>