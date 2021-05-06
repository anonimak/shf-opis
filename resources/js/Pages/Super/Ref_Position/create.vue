<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Reference Position</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="3" md="auto">
                <b-form-group
                  id="input-group-title"
                  label="Position Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.position ? errors.position[0] : ''"
                  :state="errors.position ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="position"
                    v-model="form.position"
                    placeholder="Position Name"
                    :state="errors.position ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Department:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.departement ? errors.departement[0] : ''
                  "
                  :state="errors.departement ? false : null"
                >
                  <v-select
                    placeholder="-- Select Department --"
                    label="department_name"
                    :options="dataDepartments"
                    v-model="form.departement"
                    :reduce="(departement) => departement.id"
                    :required="!form.departement"
                  >
                  </v-select>
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
    "dataDepartments",
    "errors",
    "__store",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
  },
  data: () => {
    return {
      submitState: false,
      form: {
        position: "",
        departement: null,
      },
    };
  },
  methods: {
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia
          .post(route(this.__store), this.form)
          .then(() => (this.submitState = false));
      }
    },
  },
};
</script>