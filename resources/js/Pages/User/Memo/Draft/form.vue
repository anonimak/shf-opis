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
          <a
            role="button"
            class="btn btn-secondary"
            v-b-tooltip.hover
            title="Preview Memo"
            :href="route(__preview, dataMemo.id)"
            target="_blank"
          >
            preview
          </a>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-row class="mb-2">
                <b-col col lg="6" md="auto">
                  <h5>Memo Information</h5>
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>Department</td>
                        <td>
                          {{
                            userinfo.employee.position_now.position.department
                              .department_name
                          }}
                        </td>
                      </tr>
                      <tr>
                        <td>Title</td>
                        <td>{{ form.title }}</td>
                      </tr>
                      <tr>
                        <td>Doc. No</td>
                        <td>{{ form.doc_no }}</td>
                      </tr>
                    </tbody>
                  </table>
                </b-col>
                <b-col col lg="6">
                  <b-row class="mb-4">
                    <b-col>
                      <b-row>
                        <b-col>
                          <h5>List Approver</h5>
                        </b-col>
                        <b-col>
                          <a
                            role="button"
                            v-if="!isApproverEdited"
                            class="float-right"
                            @click="isApproverEdited = true"
                            v-b-tooltip.hover
                            title="Edit Approver"
                          >
                            <i class="fas fa-edit"></i>
                          </a>
                        </b-col>
                      </b-row>
                      <b-form-group
                        v-if="isApproverEdited"
                        id="input-group-name"
                        label-for="input-name"
                      >
                        <v-select
                          class="mb-3"
                          :get-option-label="
                            (option) => option.position.position_name
                          "
                          placeholder="-- Add Approver --"
                          :options="dataPosition"
                          v-model="selected"
                          :reduce="(position) => position.id_employee"
                          @option:selected="actionApproverSelecting"
                        ></v-select>
                      </b-form-group>
                      <table class="table table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th>Approver Name</th>
                            <th>Position</th>
                            <th>Level</th>
                            <th v-if="isApproverEdited">#</th>
                          </tr>
                        </thead>
                        <draggable
                          tag="tbody"
                          handle=".handle"
                          :list="dataApprovers"
                        >
                          <tr
                            v-for="(approver, index) in dataApprovers"
                            :key="index"
                          >
                            <td>
                              <i
                                v-if="isApproverEdited"
                                class="fas fa-bars handle"
                                style="cursor: pointer"
                              ></i>
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
                                    .position_name
                                }}
                              </strong>
                            </td>
                            <td>
                              {{ index + 1 }}
                            </td>
                            <td v-if="isApproverEdited">
                              <b-button
                                variant="secondary"
                                size="sm"
                                @click="actionApproverRemoveAt(index)"
                                ><i class="fa fa-times"></i
                              ></b-button>
                            </td>
                          </tr>
                        </draggable>
                      </table>
                      <b-overlay
                        :show="isApproverbusy"
                        opacity="0.6"
                        spinner-small
                        spinner-variant="primary"
                        class="d-inline-block"
                      >
                        <b-button
                          v-if="isApproverEdited"
                          :disabled="$_.isEqual(form.approvers, dataApprovers)"
                          variant="primary"
                          size="sm"
                          @click="actionApproverSave"
                          >save</b-button
                        >
                      </b-overlay>
                      <b-button
                        v-if="isApproverEdited"
                        :disabled="isApproverbusy"
                        variant="secondary"
                        size="sm"
                        @click="actionApproverCanceled"
                        >cancel</b-button
                      >
                    </b-col>
                  </b-row>
                  <hr />
                  <b-row class="mb-4">
                    <b-col>
                      <h5>Acknowledge</h5>
                      <b-form-group
                        id="input-group-name"
                        label-for="input-name"
                      >
                        <b-overlay
                          :show="isAcknowledgebusy"
                          opacity="0.6"
                          spinner-small
                          spinner-variant="primary"
                        >
                          <v-select
                            class="mb-3"
                            multiple
                            :get-option-label="
                              (option) =>
                                `${option.employee.firstname} ${option.employee.lastname}`
                            "
                            placeholder="-- Add Acknowlege --"
                            :options="dataPosition"
                            v-model="selectedAcknowledge"
                            :reduce="(position) => position.id_employee"
                            @option:selected="actionAcknowledgeSelecting"
                            @option:deselecting="actionAcknowledgeRemoving"
                          ></v-select>
                        </b-overlay>
                      </b-form-group>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Background:"
                    label-for="input-text"
                  >
                    <Editor2 v-model="form.background" />
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
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Conclusion:"
                    label-for="input-text"
                  >
                    <Editor2 v-model="form.conclusion" />
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Cost /Expense:"
                    label-for="input-text"
                  >
                    <hot-table
                      ref="formCost"
                      :settings="hotSettings"
                    ></hot-table>
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12">
                  <b-form-group
                    id="input-group-text"
                    label="Attachment:"
                    label-for="input-text"
                  >
                    <table class="table">
                      <thead>
                        <tr>
                          <th>File</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(attachment, index) in dataAttachments"
                          :key="index"
                        >
                          <td>
                            {{ attachment.name }}
                          </td>
                          <td>
                            <b-button
                              size="sm"
                              variant="danger"
                              @click="removeAttachment(attachment.id)"
                              >remove</b-button
                            >
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <ul>
                      <li v-for="(file, index) in files" :key="index">
                        <span>{{ file.name }}</span>
                        <b-badge variant="secondary"
                          ><a href="#" @click.prevent="remove(file)"
                            >-</a
                          ></b-badge
                        >
                      </li>
                    </ul>
                    <file-upload
                      :extensions="['jpg', 'png', 'xls', 'xlsx', 'pdf']"
                      :maximum="3"
                      class="btn btn-primary"
                      ref="upload"
                      v-model="files"
                      :multiple="true"
                      :headers="{
                        'X-Token-CSRF': 'tdsr',
                      }"
                      :post-action="route(__attachment, dataMemo.id)"
                      @input-file="inputFile"
                      @input-filter="inputFilter"
                    >
                      Add Attachment file
                    </file-upload>
                    <!-- <button
                                            v-show="
                                                !$refs.upload ||
                                                    !$refs.upload.active
                                            "
                                            @click.prevent="
                                                $refs.upload.active = true
                                            "
                                            type="button"
                                        >
                                            Start upload
                                        </button> -->
                    <b-button
                      v-show="
                        (!$refs.upload || !$refs.upload.active) &&
                        files.length > 0
                      "
                      @click.prevent="uploadFile"
                      type="button"
                      variant="primary"
                    >
                      Start upload
                      <b-spinner
                        v-show="false"
                        label="Uploading..."
                        small
                      ></b-spinner>
                    </b-button>
                  </b-form-group>
                </div>
              </b-row>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary" class="btn-lg"
                    >Save Memo</b-button
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
import Handsontable from "handsontable";
import { HyperFormula } from "hyperformula";
import draggable from "vuedraggable";
// Import the editor

import Editor2 from "@/components/Editor2";
export default {
  props: [
    "_token",
    "userinfo",
    "breadcrumbItems",
    "dataMemo",
    "dataTypeMemo",
    "errors",
    "dataPosition",
    "dataAttachments",
    "__store",
    "__updateApprover",
    "__updateAcknowledge",
    "__preview",
    "__attachment",
    "__removeAttachment",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Editor2,
    draggable,
  },
  data() {
    return {
      submitState: false,
      isApproverEdited: false,
      isApproverbusy: false,
      isAcknowledgebusy: false,
      selected: null,
      selectedAcknowledge: null,
      form: {},
      dataApprovers: [],
      files: [],
      dataCost: null,
      colHeaders: ["Product Name", "QTY", "Price", "Total"],
      hotSettings: {
        data: [],
        colHeaders: (index) => {
          return this.colHeaders[index];
        },
        height: "auto",
        width: "100%",
        startCols: 4,
        startRows: 10,
        minSpareRows: 1,
        rowHeaders: true,
        columns: [
          {
            data: "Product Name",
            type: "text",
            width: 800,
          },
          {
            data: "QTY",
            // type: "numeric",
            width: 100,
          },
          {
            data: "Price",
            // type: "numeric",
            // pattern: "IDR 0.0,00",
            culture: "en-ID",
            width: 300,
          },
          {
            data: "Total",
            // type: "numeric",
            // pattern: "IDR 0.0,00",
            culture: "en-ID",
            width: 350,
          },
        ],
        manualColumnResize: true,
        contextMenu: true,
        formulas: {
          engine: HyperFormula.buildEmpty({ maxColumns: 1000 }),
        },
        licenseKey: "non-commercial-and-evaluation",
        // columnSummary: [
        //     {
        //         destinationRow: 0,
        //         destinationColumn: 3,
        //         reversedRowCoords: true,
        //         forceNumeric: true,
        //         type: "sum"
        //     }
        // ],
        afterChange: () => {
          this.dataCost = this.$refs.formCost.hotInstance.getSourceData();
        },
      },
    };
  },
  mounted() {
    this.fillForm();

    if (!_.isNull(this.dataMemo.cost)) {
      let cost = this.dataMemo.cost;
      cost = _.toArray(JSON.parse(cost));
      this.$refs.formCost.hotInstance.loadData(cost);
    }
  },
  watch: {
    dataMemo: function (val) {
      this.fillForm();
    },
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataMemo };
      this.dataApprovers = [...this.form.approvers];
      this.selectedAcknowledge = [...this.form.acknowledges];
    },
    submit() {
      if (!this.submitState) {
        let arrayCost = _.map(this.dataCost, (valueCost) => {
          let objCost = {};
          _.map(this.colHeaders, (v) => {
            objCost[v] = valueCost[v];
          });
          objCost = _.pickBy(objCost, _.identity);
          if (!_.isEmpty(objCost)) {
            return objCost;
          }
        });
        arrayCost = _.pickBy(arrayCost, _.identity);
        if (!_.isEmpty(arrayCost)) this.form.cost = JSON.stringify(arrayCost);
        this.submitState = true;
        this.$inertia
          .post(route(this.__update, this.dataMemo.id), this.form)
          .then(() => {
            this.submitState = false;
            this.$refs.upload.remove();
          });
      }
    },
    uploadFile: function () {
      var formData = new FormData();
      // console.log(this.$refs.upload.get(0));
      _.forEach(this.files, function (file) {
        formData.append("attach[]", JSON.stringify(file));
      });

      this.$inertia.post(route(this.__attachment, this.dataMemo.id), formData);
    },
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log("response", newFile.response);
        if (newFile.xhr) {
          //  Get the response status code
          console.log("status", newFile.xhr.status);
        }
      }
    },
    inputFilter: function (newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Filter non-image file
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
      }

      // Create a blob field
      newFile.blob = "";
      let URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }
    },
    remove(file) {
      this.$refs.upload.remove(file);
    },
    removeAttachment(id) {
      this.$inertia.delete(route(this.__removeAttachment, id)).then(() => {});
    },
    onHidden() {
      // Return focus to the button once hidden
      this.$refs.button.focus();
    },
    actionAcknowledgeRemoving(removeOption) {
      console.log(removeOption);
      this.selectedAcknowledge = _.filter(
        this.selectedAcknowledge,
        (opt) => opt.id !== removeOption.id
      );
      this.isAcknowledgebusy = true;
      this.$inertia
        .post(route(this.__updateAcknowledge, this.dataMemo.id), {
          acknowledge: this.selectedAcknowledge,
        })
        .then(() => {
          this.isAcknowledgebusy = false;
        });
    },
    actionAcknowledgeSelecting(selectedOption) {
      this.isAcknowledgebusy = true;
      this.$inertia
        .post(route(this.__updateAcknowledge, this.dataMemo.id), {
          acknowledge: selectedOption,
        })
        .then(() => {
          this.isAcknowledgebusy = false;
        });
    },
    actionApproverSelecting(selectedOption) {
      this.actionApproverAddItem(selectedOption);
      this.selected = null;
    },
    actionApproverSave() {
      this.isApproverbusy = true;
      this.$inertia
        .post(route(this.__updateApprover, this.dataMemo.id), {
          approver: this.dataApprovers,
        })
        .then(() => {
          this.isApproverbusy = false;
          this.isApproverEdited = false;
        });
    },

    actionApproverCanceled() {
      this.isApproverEdited = false;
      this.dataApprovers = [...this.form.approvers];
    },
    actionApproverAddItem: function (item) {
      let id = this.dataApprovers.find((data) => {
        return item.id === data.employee.position_now.id;
      });
      if (id !== undefined) {
        this.pageFlashes.danger = `Approver ${item.position.position_name} is used`;
        return;
      }

      let new_detail_approver = {
        id_memo: this.dataMemo.id,
        id_employee: item.id_employee,
        employee: {
          firstname: item.employee.firstname,
          lastname: item.employee.lastname,
          id: item.employee.id,
          position_now: {
            id: item.id,
            position: item.position,
          },
        },
        status: "edit",
      };

      this.dataApprovers = [...this.dataApprovers, new_detail_approver];
    },
    actionApproverRemoveAt(index) {
      this.dataApprovers.splice(index, 1);
    },
  },
};
</script>
