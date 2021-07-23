<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Memo {{ form.doc_no }}</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-row class="mb-2">
                <b-col col lg="6" md="auto">
                  <b-form-group
                    id="input-group-title"
                    label="Title Memo:"
                    label-for="input-title"
                    :invalid-feedback="errors.title ? errors.title[0] : ''"
                    :state="errors.title ? false : null"
                  >
                    <b-form-input
                      id="input-title"
                      type="text"
                      name="title"
                      v-model="form.title"
                      placeholder="Title Memo"
                      :state="errors.title ? false : null"
                      trim
                      readonly
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-type-memo"
                    label="Type Memo:"
                    label-for="input-title"
                    :invalid-feedback="errors.id_type ? errors.id_type[0] : ''"
                    :state="errors.id_type ? false : null"
                  >
                    <v-select
                      placeholder="-- Select Type Memo --"
                      label="name"
                      :options="dataTypeMemo"
                      v-model="form.id_type"
                      :reduce="(id_type) => id_type.id"
                      :required="!form.id_type"
                      disabled
                    >
                    </v-select>
                  </b-form-group>
                </b-col>
                <b-col col lg="6">
                  <table class="table table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th>#</th>
                        <th>Approver</th>
                        <th>Position</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="approver in dataApprovers" :key="approver.idx">
                        <td>{{ approver.idx }}</td>
                        <td>
                          {{
                            approver.employee.firstname +
                            " " +
                            approver.employee.lastname
                          }}
                        </td>
                        <td>
                          <strong>
                            {{
                              approver.employee.position_now.position
                                .position_name +
                              " in " +
                              approver.employee.position_now.position.department
                                .department_name
                            }}
                          </strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </b-col>
              </b-row>
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Background:"
                    label-for="input-text"
                  >
                    <editor v-model="form.background" />
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Information:"
                    label-for="input-text"
                  >
                    <Editor2 v-model="form.information" />
                  </b-form-group>
                </div>
              </b-row>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary" class="btn-lg"
                    >Create Memo</b-button
                  >
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
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
// Import the editor
import Editor from "@/components/Editor";
import Editor2 from "@/components/Editor2";
export default {
  props: [
    "_token",
    "userinfo",
    "breadcrumbItems",
    "dataMemo",
    "dataTypeMemo",
    "errors",
    "__store",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Editor,
    Editor2,
  },
  data: () => {
    return {
      submitState: false,
      form: {},
      dataApprovers: [],
    };
  },
  mounted() {
    this.fillForm();
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataMemo };
      this.dataApprovers = [...this.form.approvers];
    },
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
