<template>
  <layout :userinfo="userinfo" :notif="notif">
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
                <b-col col lg="12" class="mb-4">
                  <h5>Memo Information</h5>
                  <div class="table-responsive">
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
                  </div>
                </b-col>
                <b-col col lg="12" class="mb-4">
                  <h5>Orientation</h5>
                  <b-form-group v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                      v-model="form.orientation_paper"
                      :aria-describedby="ariaDescribedby"
                      name="orientation-paper"
                    >
                      <b-form-radio value="portrait">Portrait</b-form-radio>
                      <b-form-radio value="landscape">Landscape</b-form-radio>
                    </b-form-radio-group>
                  </b-form-group>
                </b-col>
                <b-col col lg="12" class="mb-4">
                  <b-row>
                    <div class="table-responsive">
                      <table-edit-approver
                        :dataPosition="dataPosition"
                        :dataApprovers="dataApprovers"
                        :__updateApprover="__updateApprover"
                        :id_memo="dataMemo.id"
                      />
                    </div>
                  </b-row>
                  <!-- <hr /> -->
                  <b-row class="mb-4">
                    <b-col>
                      <h5>Send email after memo approved to:</h5>
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
                            :get-option-label="getOptionLabel"
                            placeholder="-- Employee --"
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
                <b-col col lg="12" class="mb-4">
                  <h5>Attachment:</h5>
                  <b-form-group id="input-group-text" label-for="input-text">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>File</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(attachment, index) in dataAttachments"
                            :key="index"
                          >
                            <td>
                              <a
                                :href="attachment.name"
                                target="_blank"
                                rel="noopener noreferrer"
                              >
                                {{ attachment.real_name }}
                              </a>
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
                    </div>
                    <VueFileAgent
                      class="mb-2"
                      ref="vueFileAgent"
                      :theme="'list'"
                      :multiple="true"
                      :deletable="true"
                      :meta="true"
                      :accept="'.png,.jpeg,.jpg,.xls,.xlsx,.doc,.docx,.pdf'"
                      :maxSize="'10MB'"
                      :maxFiles="10"
                      :helpText="'Choose images, pdf, excel or word files'"
                      :errorText="{
                        type: 'Invalid file type. Only images, excel, pdf and word files allowed',
                        size: 'Files should not exceed 2MB in size',
                      }"
                      @select="filesSelected($event)"
                      @beforedelete="onBeforeDelete($event)"
                      @delete="fileDeleted($event)"
                      v-model="fileRecords"
                    ></VueFileAgent>
                    <button
                      class="btn btn-primary btn-sm"
                      :disabled="!fileRecordsForUpload.length"
                      @click.prevent="uploadFiles()"
                    >
                      Upload {{ fileRecordsForUpload.length }} files
                    </button>
                  </b-form-group>
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
              <!-- <b-row
                v-if="
                  dataMemoType.ref_table.with_po == 1 ||
                  dataMemoType.ref_table.with_payment == 1
                "
              >
                <div class="col-5">
                  <b-form-group
                    id="input-group-text"
                    label=""
                    label-for="input-text"
                  >
                    <b-input-group prepend="Sub Total" class="mb-2 mt-5">
                      <b-form-input
                        aria-label="sub_total"
                        v-model="sub_total"
                      ></b-form-input>
                    </b-input-group>
                    <b-input-group prepend="Pph23 (2%)" class="mb-2 mt-2">
                      <b-form-input
                        aria-label="pph23"
                        v-model="pph"
                        v-on:change="pphValueChange"
                      ></b-form-input>
                    </b-input-group>
                    <b-input-group prepend="PPN (10%)" class="mb-2 mt-2">
                      <b-form-input
                        disabled
                        aria-label="ppn"
                        v-model="ppn"
                      ></b-form-input>
                    </b-input-group>
                    <b-form-checkbox
                      id="checkbox-1"
                      v-model="checkPPNInclude"
                      name="checkbox-1"
                      :value="true"
                      :unchecked-value="false"
                    >
                      PPN included with sub total
                    </b-form-checkbox>
                    <b-input-group prepend="Grand Total" class="mb-2 mt-2">
                      <b-form-input
                        aria-label="grand_total"
                        v-model="grand_total"
                        disabled
                      ></b-form-input>
                    </b-input-group>
                    <b-button
                      size="sm"
                      text="Button"
                      variant="danger"
                      @click="reset()"
                      >Reset</b-button
                    >
                  </b-form-group>
                </div>
              </b-row> -->
              <b-row>
                <div class="col-12"></div>
              </b-row>
              <b-row align-h="center">
                <b-overlay
                  :show="submitState"
                  opacity="0.6"
                  spinner-small
                  spinner-variant="primary"
                >
                  <b-button-group>
                    <b-button type="submit" variant="primary" class="btn-lg"
                      >Save Memo</b-button
                    >
                  </b-button-group>
                </b-overlay>
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
// import Handsontable from "handsontable";
import { HyperFormula } from "hyperformula";
import draggable from "vuedraggable";
import SelectTypeApprover from "@/components/SelectTypeApprover";
// Import the editor

import Editor2 from "@/components/Editor2";
import TableEditApprover from "@/components/TableEditApprover.vue";
export default {
  metaInfo: { title: "Form Draft Memo" },
  props: [
    "_token",
    "userinfo",
    "notif",
    "breadcrumbItems",
    "dataMemo",
    // "dataTypeMemo",
    "formType",
    "errors",
    "dataPosition",
    "dataTotalCost",
    "dataAttachments",
    "headerCost",
    "columnCost",
    "dataMemoType",
    "__store",
    "__updateApprover",
    //"__addDataTotal",
    "__updateAcknowledge",
    "__deleteAcknowledge",
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
    SelectTypeApprover,
    TableEditApprover,
  },
  data() {
    return {
      submitState: false,
      isAcknowledgebusy: false,
      selectedAcknowledge: null,
      //   checkPPNInclude: false,
      //   sub_total: 0,
      //   pph: 0,
      //   ppn: 0,
      //   grand_total: 0,
      form: {},
      dataApprovers: [],
      dataCost: null,
      colHeaders: this.headerCost,
      hotSettings: {
        data: [],
        colHeaders: (index) => {
          return this.colHeaders[index];
        },
        height: "auto",
        width: "100%",
        startCols: 5,
        startRows: 10,
        minSpareRows: 1,
        rowHeaders: true,
        columns: this.columnCost,
        manualColumnResize: true,
        contextMenu: true,
        formulas: {
          engine: HyperFormula.buildEmpty({
            // licenseKey: "gpl-v3",
          }),
        },
        licenseKey: "non-commercial-and-evaluation",

        afterChange: () => {
          //this.dataCost = this.$refs.formCost.hotInstance.getSourceData();
          this.dataFormula =
            this.hotSettings.formulas.engine.getAllSheetsValues();
          //this.dataWithFormulaValue = this.dataFormula.Sheet1;
        },
      },
      fileRecords: [],
      uploadUrl: "#",
      uploadHeaders: {
        "X-Test-Header": "vue-file-agent",
        "X-CSRF-TOKEN": this._token,
      },
      fileRecordsForUpload: [], // maintain an upload queue
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
    // sub_total: function (val) {
    //   if (!val) {
    //     val = 0;
    //   }
    //   this.ppn = this.checkPPNInclude ? 0 : 0.1 * parseFloat(val);
    //   this.pph = 0.02 * parseFloat(val);
    //   this.grand_total =
    //     parseFloat(val) + parseFloat(this.ppn) - parseFloat(this.pph);
    // },
    // pph: function (val) {
    //   if (!val || !this.sub_total) {
    //     val = 0;
    //     // this.sub_total = 0;
    //   }
    //   this.grand_total =
    //     parseFloat(this.sub_total) + parseFloat(this.ppn) - parseFloat(val);
    // },
    // checkPPNInclude: function (val) {
    //   if (val) {
    //     this.ppn = 0;
    //   } else {
    //     this.ppn = 0.1 * parseFloat(this.sub_total);
    //   }
    //   this.grand_total =
    //     parseFloat(this.sub_total) +
    //     parseFloat(this.ppn) -
    //     parseFloat(this.pph);
    // },
    dataMemo: function (val) {
      this.fillForm();
    },
    // dataTotalCost: function (val) {
    //   this.fillForm();
    // },
  },
  methods: {
    getOptionLabel: (option) => {
      let firstname = option.employee ? option.employee.firstname : "";
      let lastname = option.employee ? option.employee.lastname : "";

      return option.position.position_name + " - " + firstname + " " + lastname;
    },
    // reset: function () {
    //   this.sub_total = this.dataTotalCost.sub_total;
    //   this.pph = this.dataTotalCost.pph;
    //   this.ppn = this.dataTotalCost.ppn;
    //   this.grand_total = this.dataTotalCost.grand_total;
    //   this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;
    // },
    // pphValueChange: function (val) {
    //   this.pph = 0.02 * parseFloat(val);
    // },
    uploadFiles: function () {
      // Using the default uploader. You may use another uploader instead.
      var form_data = new FormData();

      // this.fileRecordsForUpload.forEach((item, index) => {
      //   form_data.append(`files[${index}]`, item.file);
      // });
      _.each(this.fileRecordsForUpload, (item, index) => {
        form_data.append(`files[${index}]`, item.file);
      });
      // this.$refs.vueFileAgent.upload(
      //   route(this.__attachment, this.dataMemo.id),
      //   this.uploadHeaders,
      //   this.fileRecordsForUpload
      // );
      this.$inertia.post(
        route(this.__attachment, this.dataMemo.id),
        form_data,
        {
          forceFormData: true,
        }
      );
    },
    deleteUploadedFile: function (fileRecord) {
      // Using the default uploader. You may use another uploader instead.
      this.$refs.vueFileAgent.deleteUpload(
        this.uploadUrl,
        this.uploadHeaders,
        fileRecord
      );
    },
    filesSelected: function (fileRecordsNewlySelected) {
      var validFileRecords = fileRecordsNewlySelected.filter(
        (fileRecord) => !fileRecord.error
      );
      this.fileRecordsForUpload =
        this.fileRecordsForUpload.concat(validFileRecords);
    },
    onBeforeDelete: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        // queued file, not yet uploaded. Just remove from the arrays
        this.fileRecordsForUpload.splice(i, 1);
        var k = this.fileRecords.indexOf(fileRecord);
        if (k !== -1) this.fileRecords.splice(k, 1);
      } else {
        if (confirm("Are you sure you want to delete?")) {
          this.$refs.vueFileAgent.deleteFileRecord(fileRecord); // will trigger 'delete' event
        }
      }
    },
    fileDeleted: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1);
      } else {
        this.deleteUploadedFile(fileRecord);
      }
    },
    fillForm() {
      this.form = { ...this.dataMemo };
      this.dataApprovers = [...this.form.approvers];
      //   this.sub_total = this.dataTotalCost.sub_total;
      //   this.pph = this.dataTotalCost.pph;
      //   this.ppn = this.dataTotalCost.ppn;
      //   this.grand_total = this.dataTotalCost.grand_total;
      //   this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;
      this.selectedAcknowledge = _.map(
        this.form.acknowledges,
        (acknowledge) => acknowledge.position_now
      );
    },
    submit() {
      //   if (
      //     this.dataMemoType.ref_table.with_po == 1 ||
      //     this.dataMemoType.ref_table.with_payment == 1
      //   ) {
      //     if (this.grand_total == 0 || this.sub_total == 0) {
      //       this.pageFlashes.danger = "Please fill data completely!";
      //       return;
      //     }
      //   }
      if (!this.submitState) {
        let newData = {};
        if (this.dataFormula.Sheet1.length != 0) {
          newData = _.map(this.dataFormula.Sheet1, (value) => {
            const res = {};
            for (let idx in value) {
              res[this.colHeaders[idx]] = value[idx];
            }
            return res;
          });
        } else {
          newData = _.map(this.dataFormula.Sheet2, (value) => {
            const res = {};
            for (let idx in value) {
              res[this.colHeaders[idx]] = value[idx];
            }
            return res;
          });
        }
        let arrayCost = _.map(newData, (valueCost) => {
          let objCost = {};
          valueCost = Object.assign({}, valueCost);
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
        // this.form.sub_total = this.sub_total;
        // this.form.pph = this.pph;
        // this.form.ppn = this.ppn;
        // this.form.grand_total = this.grand_total;
        this.$inertia
          .post(route(this.__update, this.dataMemo.id), this.form)
          .then(() => {
            this.submitState = false;
            this.$refs.upload.remove();
          });
      }
    },
    removeAttachment(id) {
      this.$inertia.delete(route(this.__removeAttachment, id)).then(() => {});
    },
    onHidden() {
      // Return focus to the button once hidden
      this.$refs.button.focus();
    },
    actionAcknowledgeRemoving(removeOption) {
      this.isAcknowledgebusy = true;
      this.$inertia
        .delete(
          route(this.__deleteAcknowledge, {
            memo: this.dataMemo.id,
            id_employee: removeOption.id_employee,
            type: this.formType,
          })
        )
        .then(() => {
          this.isAcknowledgebusy = false;
        });
    },
    actionAcknowledgeSelecting(selectedOption) {
      this.isAcknowledgebusy = true;
      this.$inertia
        .post(
          route(this.__updateAcknowledge, {
            memo: this.dataMemo.id,
            type: this.formType,
          }),
          {
            acknowledge: selectedOption,
          }
        )
        .then(() => {
          this.isAcknowledgebusy = false;
        });
    },
  },
};
</script>
