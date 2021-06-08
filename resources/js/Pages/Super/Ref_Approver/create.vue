<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Reference Approver</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="3" md="auto">
                <b-form-group
                  id="input-group-name"
                  label="Name:"
                  label-for="input-name"
                  :invalid-feedback="errors.name ? errors.name[0] : ''"
                  :state="errors.name ? false : null"
                >
                  <b-form-input
                    id="input-name"
                    type="text"
                    name="name"
                    v-model="form.name"
                    placeholder="Name"
                    :state="errors.name ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-name" label-for="input-name">
                  <v-select
                    class="mb-3"
                    label="position_name"
                    placeholder="-- Add Position Role --"
                    :options="dataPosition"
                    v-model="selected"
                    :reduce="(position) => position.id"
                    @option:selected="selecting"
                  ></v-select>
                </b-form-group>
              </b-col>
              <b-col col lg="12" md="auto">
                <draggable
                  tag="div"
                  :list="form.detailApprover"
                  class="list-group list-group-horizontal mb-3"
                  handle=".handle"
                >
                  <b-list-group-item
                    class="handle"
                    v-for="(element, idx) in form.detailApprover"
                    :key="element.position_name"
                  >
                    <i class="fa fa-align-justify handle"></i>
                    {{ element.position_name }}
                    <i class="fa fa-times close" @click="removeAt(idx)"></i>
                  </b-list-group-item>
                </draggable>
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
import draggable from "vuedraggable";

export default {
  props: [
    "_token",
    "userinfo",
    "dataPosition",
    "breadcrumbItems",
    "errors",
    "__store",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    draggable,
  },
  data: () => {
    return {
      submitState: false,
      selected: null,
      form: {
        name: "",
        detailApprover: [],
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
    selecting(selectedOption) {
      console.log(selectedOption);
      this.addItem(selectedOption);
      this.selected = null;
    },
    addItem: function (item) {
      let id = this.form.detailApprover.find((data) => {
        return item.id === data.id;
      });
      if (id !== undefined) {
        return;
      }
      this.form.detailApprover = [...this.form.detailApprover, item];
    },
    removeAt(idx) {
      this.form.detailApprover.splice(idx, 1);
    },
  },
};
</script>