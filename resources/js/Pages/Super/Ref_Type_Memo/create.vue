<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Reference Type Memo</h1>
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
                  label="Type Memo Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.name ? errors.name[0] : ''"
                  :state="errors.name ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="name"
                    v-model="form.name"
                    placeholder="Type Memo Name"
                    :state="errors.name ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Department:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.department ? errors.department[0] : ''
                  "
                  :state="errors.departement ? false : null"
                >
                  <v-select
                    placeholder="-- Select Department --"
                    label="department_name"
                    :options="dataDepartments"
                    v-model="form.department"
                    :reduce="(department) => department.id"
                    :required="!form.department"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Role Module Approver:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.refmoduleapprover ? errors.refmoduleapprover[0] : ''
                  "
                  :state="errors.refmoduleapprover ? false : null"
                >
                  <v-select
                    placeholder="-- Select Module Approver --"
                    label="name"
                    :options="dataRefModuleApprovers"
                    v-model="form.refmoduleapprover"
                    :reduce="(refmoduleapprover) => refmoduleapprover.id"
                    :required="!form.refmoduleapprover"
                  >
                  </v-select>
                </b-form-group>
                <b-form-checkbox
                  v-model="form.with_po"
                  name="checkbox-1"
                  :value="true"
                  :unchecked-value="false"
                >
                  with Purchase Order
                </b-form-checkbox>
                <b-form-checkbox
                  v-model="form.with_payment"
                  name="checkbox-2"
                  :value="true"
                  :unchecked-value="false"
                >
                  with Payment
                </b-form-checkbox>
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
    "notif",
    "breadcrumbItems",
    "dataDepartments",
    "dataRefModuleApprovers",
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
        name: "",
        refmoduleapprover: null,
        department: null,
        with_po: false,
        with_payment: false,
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