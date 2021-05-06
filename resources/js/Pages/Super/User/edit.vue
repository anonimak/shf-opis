<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Update User</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="3" md="auto">
                <b-form-group
                  label="User Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.name ? errors.name[0] : ''"
                  :state="errors.name ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="user"
                    v-model="form.name"
                    placeholder="User Name"
                    :state="errors.name ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  label="Email:"
                  label-for="input-title"
                  :invalid-feedback="errors.email ? errors.email[0] : ''"
                  :state="errors.email ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="email"
                    name="email"
                    v-model="form.email"
                    placeholder="Email"
                    :state="errors.email ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Role:"
                  label-for="input-title"
                  :invalid-feedback="errors.role ? errors.role[0] : ''"
                  :state="errors.role ? false : null"
                >
                  <v-select
                    label="name"
                    placeholder="-- Select Role --"
                    :options="dataRoles"
                    v-model="form.role"
                    :reduce="(role) => role.id"
                    :required="!form.role"
                  ></v-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="NIK Employee:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.id_employee ? errors.id_employee[0] : ''
                  "
                  :state="errors.id_employee ? false : null"
                >
                  <v-select
                    placeholder="-- Select NIK --"
                    label="nik"
                    :options="dataEmployees"
                    v-model="form.id_employee"
                    :reduce="(employee) => employee.id"
                    :required="!form.id_employee"
                  >
                  </v-select>
                </b-form-group>
                <b-form-checkbox
                  id="checkbox-1"
                  class="mt-5 mb-3"
                  v-model="checknewpass"
                  name="checkbox-1"
                  :value="true"
                  :unchecked-value="false"
                >
                  Set new password
                </b-form-checkbox>
                <b-form-group
                  v-if="checknewpass"
                  id="input-group-title"
                  label="New Password:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.newpassword ? errors.newpassword[0] : ''
                  "
                  :state="errors.newpassword ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="password"
                    name="newpassword"
                    v-model="form.newpassword"
                    placeholder="New Password"
                    :state="errors.newpassword ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary">Submit</b-button>
                  <b-button type="reset" variant="secondary">Reset</b-button>
                </b-button-group>
              </b-row>
            </b-card-body>
          </b-form>
        </b-card>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/SuperLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";

export default {
  props: [
    "_token",
    "userinfo",
    "breadcrumbItems",
    "dataRoles",
    "dataEmployees",
    "errors",
    "dataUser",
    "__update",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
  },
  data() {
    return {
      submitState: false,
      form: {},
      checknewpass: false,
    };
  },
  watch: {
    checknewpass: function (val) {
      if (val) {
        this.form.newpassword = null;
      }
    },
  },
  mounted() {
    this.fillForm();
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataUser };
    },
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia
          .put(this.route(this.__update, this.form.id), this.form)
          .then(() => (this.submitState = false));
      }
    },
  },
};
</script>