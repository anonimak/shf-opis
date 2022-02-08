<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Update Reference Type Memo</h1>
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
                  :state="errors.department ? false : null"
                  description="Let this field blank for general memo."
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
                  label="Branch:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.id_branch ? errors.id_branch[0] : ''
                  "
                  :state="errors.id_branch ? false : null"
                >
                  <v-select
                    placeholder="-- Select Branch --"
                    label="branch_name"
                    :options="dataBranches"
                    v-model="form.id_branch"
                    :reduce="(branch) => branch.id"
                    :required="!form.id_branch"
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
                <b-form-group
                  class="mt-2"
                  id="input-group-title"
                  label="Type Memo"
                  label-for="input-title"
                  :invalid-feedback="errors.type ? errors.type[0] : ''"
                  :state="errors.type ? false : null"
                >
                  <b-form-select
                    placeholder="-- Select Type Memo --"
                    :options="options"
                    v-model="form.type"
                  >
                  </b-form-select>
                </b-form-group>
                <b-form-group
                  v-if="form.with_payment"
                  class="mt-2"
                  id="input-group-title"
                  label="Overtake Payment By:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.id_overtake ? errors.id_overtake[0] : ''
                  "
                  :state="errors.id_overtake ? false : null"
                  description="Let this field blank if no need to overtake memo payment."
                >
                  <v-select
                    placeholder=""
                    label="label"
                    :options="dataEmployee"
                    v-model="form.id_overtake"
                    :reduce="(employee) => employee.id"
                    :required="!form.id_overtake"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group
                  v-if="form.with_payment || form.type == 'payment'"
                  class="mt-2"
                  id="input-group-title"
                  label="Confirmed Payment By:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.id_confirmed_payment_by
                      ? errors.id_confirmed_payment_by[0]
                      : ''
                  "
                  :state="errors.id_confirmed_payment_by ? false : null"
                  description="Fill in this column to indicate the employee who is responsible for confirming payments."
                >
                  <v-select
                    placeholder=""
                    label="label"
                    :options="dataEmployee"
                    v-model="form.id_confirmed_payment_by"
                    :reduce="(employee) => employee.id"
                    :required="!form.id_confirmed_payment_by"
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
    "notif",
    "breadcrumbItems",
    "errors",
    "dataRef_Type_Memo",
    "dataDepartments",
    "dataBranches",
    "dataEmployee",
    "dataRefModuleApprovers",
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
      options: [
        {
          value: null,
          text: "--Please select a type memo--",
        },
        { value: "approval", text: "Approval" },
        { value: "payment", text: "Payment" },
      ],
    };
  },
  watch: {
    "form.with_payment": function (val) {
      if (!val) {
        this.form.id_overtake = null;
        if (this.form.type != "payment") {
          this.form.id_confirmed_payment_by = null;
        }
      }
    },
    "form.type": function (val) {
      if (val != 'payment') {
        this.form.id_overtake = null;
        if (this.form.with_payment != true) {
          this.form.id_confirmed_payment_by = null;
        }
      }
    },
  },
  mounted() {
    this.fillForm();
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataRef_Type_Memo };
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