<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Reference Template Memo</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card>
          <div class="row">
            <div class="col-12">
              <h5>Header Table Cost/Expense</h5>
              <hr />
              <b-button
                variant="primary"
                class="my-2 float-right"
                @click="showFormTemplateCost = true"
                v-if="!showFormTemplateCost"
              >
                <i class="fas fa-plus"></i>
                Add</b-button
              >
              <b-form
                @submit.prevent="onSubmitTemplateCost"
                @reset.prevent="onResetTemplateCost"
                v-if="showFormTemplateCost"
                class="col-6 my-4"
              >
                <b-form-group
                  id="input-group-1"
                  label="Column Name:"
                  label-for="input-1"
                  :invalid-feedback="errors.col_name ? errors.col_name[0] : ''"
                  :state="errors.col_name ? false : null"
                >
                  <b-form-input
                    id="input-1"
                    v-model="formTemplateCost.col_name"
                    type="text"
                    placeholder="Column name"
                    :state="errors.col_name ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>

                <b-form-group
                  id="input-group-2"
                  label="Width:"
                  label-for="input-2"
                  :invalid-feedback="errors.width ? errors.width[0] : ''"
                  :state="errors.width ? false : null"
                >
                  <b-form-input
                    id="input-2"
                    type="number"
                    v-model="formTemplateCost.width"
                    placeholder="Width"
                    :state="errors.width ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>

                <b-button type="submit" variant="primary">Submit</b-button>
                <b-button type="reset" variant="secondary">Cancel</b-button>
              </b-form>
              <table class="table table-stripped">
                <thead>
                  <tr>
                    <th>Column Name</th>
                    <th>Width</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in dataRefTemplateCost" :key="item.id">
                    <td scope="row" v-if="editId && editId == item.id">
                      <b-form-group
                        :invalid-feedback="
                          errorsEdit.length > 0
                            ? errorsEdit[0].edit_col_name
                            : ''
                        "
                        :state="
                          errorsEdit.length > 0 && errorsEdit[0].edit_col_name
                            ? false
                            : null
                        "
                      >
                        <b-form-input
                          v-model="formEditTemplateCost.edit_col_name"
                          type="text"
                          required
                          placeholder="Edit Column name"
                          :state="
                            errorsEdit.length > 0 && errorsEdit[0].edit_col_name
                              ? false
                              : null
                          "
                          trim
                        ></b-form-input>
                      </b-form-group>
                    </td>
                    <td scope="row" v-else>
                      {{ item.col_name }}
                    </td>
                    <td scope="row" v-if="editId && editId == item.id">
                      <b-form-group
                        :invalid-feedback="
                          errorsEdit.length > 0 ? errorsEdit[0].edit_width : ''
                        "
                        :state="
                          errorsEdit.length > 0 && errorsEdit[0].edit_width
                            ? false
                            : null
                        "
                      >
                        <b-form-input
                          v-model="formEditTemplateCost.edit_width"
                          type="number"
                          required
                          placeholder="Edit Width"
                          :state="
                            errorsEdit.length > 0 && errorsEdit[0].edit_width
                              ? false
                              : null
                          "
                          trim
                        ></b-form-input>
                      </b-form-group>
                    </td>
                    <td v-else>
                      {{ item.width }}
                    </td>
                    <td v-if="editId && editId == item.id">
                      <div class="float-right">
                        <b-button
                          variant="primary"
                          @click="onSaveEdit(item.id)"
                        >
                          save
                        </b-button>
                        <b-button variant="secondary" @click="resetEditMode">
                          cancel
                        </b-button>
                      </div>
                    </td>
                    <td v-else>
                      <b-dropdown
                        variant="white"
                        class="float-right"
                        no-caret
                        size="sm"
                      >
                        <template #button-content>
                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </template>
                        <b-dropdown-item href="#" @click="onEditClick(item.id)"
                          >edit</b-dropdown-item
                        >
                        <b-dropdown-item
                          href="#"
                          @click="showMsgBoxDeleteCost(item.id)"
                          >delete</b-dropdown-item
                        >
                      </b-dropdown>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
    "meta",
    "flash",
    "errors",
    "breadcrumbItems",
    "userinfo",
    "notif",
    "dataRefTemplateCost",
    "idTypeMemo",
    "__store_cost",
    "__update_cost",
    "__destroy_cost",
  ],
  metaInfo: { title: "Admin Reference Type Memo Page" },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
  },
  data() {
    return {
      showFormTemplateCost: false,
      formTemplateCost: {
        col_name: "",
        width: null,
      },
      formEditTemplateCost: {
        edit_col_name: "",
        edit_width: null,
      },
      editId: null,
      errorsEdit: [],
    };
  },
  methods: {
    submitDeleteCost(id) {
      this.$inertia.delete(route(this.__destroy_cost, id));
    },
    showMsgBoxDeleteCost: function (id) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this Header Cost.",
          {
            title: "Please Confirm",
            size: "sm",
            buttonSize: "sm",
            okVariant: "danger",
            okTitle: "YES",
            cancelTitle: "NO",
            footerClass: "p-2",
            hideHeaderClose: false,
            centered: true,
          }
        )
        .then((value) => {
          value && this.submitDeleteCost(id);
        })
        .catch((err) => {
          // An error occurred
        });
    },

    onSubmitTemplateCost() {
      this.$inertia
        .post(route(this.__store_cost, this.idTypeMemo), this.formTemplateCost)
        .then(() => (this.showFormTemplateCost = false));
    },
    onResetTemplateCost() {
      this.formTemplateCost.col_name = "";
      this.formTemplateCost.width = null;
      this.showFormTemplateCost = false;
    },
    onEditClick(id) {
      this.editId = id;

      // populate form value
      let editFormValue = _.find(this.dataRefTemplateCost, { id: id });
      this.formEditTemplateCost.edit_col_name = editFormValue.col_name;
      this.formEditTemplateCost.edit_width = editFormValue.width;
    },
    onSaveEdit(id) {
      if (this.checkFormEdit()) {
        this.$inertia
          .put(route(this.__update_cost, id), this.formEditTemplateCost)
          .then(() => this.resetEditMode());
      }
    },
    checkFormEdit() {
      this.errorsEdit = [];
      let errorMsg = {};

      if (this.formEditTemplateCost.edit_col_name === "") {
        // this.errorsEdit.push({ edit_col_name: "Edit Column Name Required." });
        errorMsg.edit_col_name = "Edit Column Name Required.";
      }
      if (!this.formEditTemplateCost.edit_width) {
        errorMsg.edit_width = "Edit Width Required.";
      }
      if (!_.isEmpty(errorMsg)) {
        this.errorsEdit[0] = errorMsg;
      }

      if (!this.errorsEdit.length) {
        return true;
      }
    },
    resetEditMode() {
      this.editId = null;
      this.errorsEdit = [];
      this.resetFormEdit();
    },
    resetFormEdit() {
      this.formEditTemplateCost.edit_col_name = "";
      this.formEditTemplateCost.edit_width = null;
    },
  },
};
</script>
