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
            v-if="dataMemo.payment == false"
          >
            preview
          </a>
          <a
            role="button"
            class="btn btn-secondary"
            v-b-tooltip.hover
            title="Preview Payment"
            :href="route(__previewpayment, dataMemo.id)"
            target="_blank"
            v-if="dataMemo.payment == true"
          >
            preview payment
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
                      @change="autoSaveItem()"
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
                    <!-- <div class="table-responsive" v-if="formType == 'payment'"> -->
                    <table-edit-approver
                      :dataPosition="dataPosition"
                      :dataApprovers="dataApprovers"
                      :__updateApprover="
                        formType == 'payment'
                          ? updateApproverPayment
                          : __updateApprover
                      "
                      :id_memo="dataMemo.id"
                    />
                    <!-- </div> -->
                  </b-row>
                  <!-- <hr /> -->
                  <b-row class="mb-4">
                    <b-col>
                      <h5 v-if="formType == 'payment'">
                        Send email after memo payment approved to:
                      </h5>
                      <h5 v-else>Send email after memo approved to:</h5>
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
                      :accept="'.rar,.zip,.png,.jpeg,.jpg,.xls,.xlsx,.doc,.docx,.pdf'"
                      :maxSize="'25MB'"
                      :maxFiles="10"
                      :helpText="'Choose images, pdf, excel, pdf, rar or word files'"
                      :errorText="{
                        type: 'Invalid file type. Only images, excel, pdf, rar, zip and word files allowed',
                        size: 'Files should not exceed 25MB in size',
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
                <div class="col-12 mb-4">
                  <b-row>
                    <b-col>
                      <h5 class="mb-0">Background</h5>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                      <div>
                        <b-badge
                          v-if="fieldSaving == 'background' && isSaving"
                          variant="info"
                        >
                          <b-spinner small label="Floated Right"></b-spinner>
                          Saving
                        </b-badge>
                      </div>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-text"
                    label=""
                    label-for="input-text"
                    class="mt-2"
                  >
                    <!-- <Editor2 v-model="form.background" /> -->
                    <Editor2
                      @input="typing('background')"
                      v-model="form.background"
                    />
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12 mb-4">
                  <b-row>
                    <b-col>
                      <h5 class="mb-0">Information</h5>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                      <div>
                        <b-badge
                          v-if="fieldSaving == 'information' && isSaving"
                          variant="info"
                        >
                          <b-spinner small label="Floated Right"></b-spinner>
                          Saving
                        </b-badge>
                      </div>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-text"
                    label=""
                    label-for="input-text"
                    class="mt-2"
                  >
                    <!-- <Editor2 v-model="form.information" /> -->
                    <Editor2
                      @input="typing('information')"
                      v-model="form.information"
                    />
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12 mb-4">
                  <b-row>
                    <b-col>
                      <h5 class="mb-0">Conclusion</h5>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                      <div>
                        <b-badge
                          v-if="fieldSaving == 'conclusion' && isSaving"
                          variant="info"
                        >
                          <b-spinner small label="Floated Right"></b-spinner>
                          Saving
                        </b-badge>
                      </div>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-text"
                    label=""
                    label-for="input-text"
                    class="mt-2"
                  >
                    <!-- <Editor2 v-model="form.conclusion" /> -->
                    <Editor2
                      @input="typing('conclusion')"
                      v-model="form.conclusion"
                    />
                  </b-form-group>
                </div>
              </b-row>
              <b-row>
                <div class="col-12 mb-4">
                  <b-row>
                    <b-col>
                      <h5 class="mb-0">Cost/Expense</h5>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                      <div>
                        <b-badge
                          v-if="fieldSaving == 'cost' && isSaving"
                          variant="info"
                        >
                          <b-spinner small label="Floated Right"></b-spinner>
                          Saving
                        </b-badge>
                      </div>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-text"
                    label=""
                    label-for="input-text"
                    class="mt-2"
                  >
                    <b-form-checkbox
                      id="checkbox-1"
                      v-model="form.is_cost_invoice"
                      @change="autoSaveItem()"
                      name="checkbox-1"
                      :value="true"
                      :unchecked-value="false"
                      class="mb-2"
                    >
                      use Cost Invoice
                    </b-form-checkbox>
                    <form-invoice
                      v-if="form.is_cost_invoice"
                      :id_memo="dataMemo.id"
                    />
                    <hot-table
                      v-else
                      ref="formCost"
                      :settings="hotSettings"
                    ></hot-table>
                  </b-form-group>
                </div>
              </b-row>
              <b-row
                v-if="
                  formType == 'payment' ||
                  dataMemoType.ref_table.with_po == true
                "
              >
                <div class="col-5">
                  <b-overlay
                    :show="isSubmitBusy"
                    opacity="0.6"
                    spinner-small
                    spineer-variant="primary"
                  >
                    <b-form-group
                      id="input-group-text"
                      label=""
                      label-for="input-text"
                    >
                      <b-input-group prepend="Sub Total" class="mb-2 mt-5">
                        <b-form-input
                          aria-label="sub_total"
                          v-model="sub_total"
                          @change="debouncedSaveCost()"
                        ></b-form-input>
                      </b-input-group>
                      <b-input-group prepend="Pph 23" class="mb-2 mt-2">
                        <b-form-input
                          aria-label="pph"
                          v-model="pph"
                          v-on:change="pphValueChange"
                        ></b-form-input>
                        <b-form-checkbox
                          v-model="manualInputPph"
                          class="justify-content-center my-auto ml-2"
                          :value="true"
                          :unchecked-value="false"
                          @change="actionChangeChenckboxManualInput"
                        >
                          Manual input Pph
                        </b-form-checkbox>
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
                  </b-overlay>
                </div>
              </b-row>

              <b-row>
                <div class="col-12"></div>
              </b-row>

              <!-- form payment -->
              <b-row v-if="formType == 'payment'">
                <b-overlay
                  :show="isSubmitBusy"
                  opacity="0.6"
                  spinner-small
                  spinner-variant="primary"
                >
                  <b-button-group>
                    <b-button
                      v-b-modal.modal-add-payment
                      class="mt-2 ml-2"
                      variant="primary"
                    >
                      Add Data Vendor
                    </b-button>
                  </b-button-group>
                </b-overlay>
              </b-row>
              <b-overlay
                :show="isSubmitBusy"
                opacity="0.6"
                spinner-small
                spinner-variant="primary"
                v-if="formType == 'payment'"
              >
                <b-col
                  class="mt-4 p-0 table-responsive"
                  v-if="formType == 'payment'"
                >
                  <h5>Vendor</h5>
                  <table class="table table-stripped table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Vendor Name</th>
                        <th scope="col">Bank Name</th>
                        <th scope="col">Bank Account</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Remark</th>
                        <th scope="col">Address</th>
                        <th>action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in dataPayments" :key="item.id">
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <input
                            type="text"
                            name="name"
                            v-model="activeItemPayment.name"
                          />
                        </td>
                        <td v-else>{{ item.name }}</td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <input
                            type="text"
                            name="bank_name"
                            v-model="activeItemPayment.bank_name"
                          />
                        </td>
                        <td v-else>{{ item.bank_name }}</td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <input
                            type="text"
                            name="bank_account"
                            v-model="activeItemPayment.bank_account"
                          />
                        </td>
                        <td v-else>{{ item.bank_account }}</td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <CurrencyInput v-model="activeItemPayment.amount" />
                        </td>
                        <td v-else>
                          Rp.
                          {{
                            Number(item.amount).toLocaleString("id-ID", {
                              maximumFractionDigits: 2,
                            })
                          }}
                        </td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <input
                            type="text"
                            name="remark"
                            v-model="activeItemPayment.remark"
                          />
                        </td>
                        <td v-else>{{ item.remark }}</td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <textarea
                            type="text"
                            name="address"
                            v-model="activeItemPayment.address"
                            rows="3"
                          ></textarea>
                        </td>
                        <td v-else>{{ item.address }}</td>
                        <td v-if="isFormPaymentEdited && activeIndex == index">
                          <b-button
                            variant="primary"
                            @click="submitUpdate(item.id)"
                            >save</b-button
                          >
                          <b-button variant="secondary" @click="actionCancel"
                            >cancel</b-button
                          >
                        </td>
                        <td v-else>
                          <b-button-group size="sm">
                            <b-button
                              variant="primary"
                              @click="actionEdit(index, item.id)"
                              ><i class="fa fa-edit"></i
                            ></b-button>
                            <b-button
                              variant="secondary"
                              @click="actionDelete(item.id)"
                              ><i class="fa fa-trash"></i
                            ></b-button>
                          </b-button-group>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </b-col>
              </b-overlay>

              <!-- <b-row align-h="center">
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
              </b-row> -->
            </b-card-body>
          </b-form>
        </b-card>
      </div>
    </div>
    <b-modal
      id="modal-add-payment"
      title="Add Data Vendor"
      ok-title="Add"
      @ok="handleOkPayment"
      @hidden="resetModalPayment"
      no-close-on-backdrop
    >
      <b-overlay
        :show="isModalFormBusy"
        opacity="0.6"
        spinner-small
        spinner-variant="primary"
      >
        <b-form ref="form_modal" @submit.prevent="handleSubmitPayment">
          <b-card-body>
            <b-col col lg="6" md="auto">
              <b-form-group
                id="input-group-title"
                label="Vendor Name:"
                label-for="input-title"
                :invalid-feedback="errors.name ? errors.name[0] : ''"
                :state="errors.name ? false : null"
              >
                <b-form-input
                  id="input-title"
                  type="text"
                  name="name"
                  v-model="form_modal.name"
                  placeholder="Vendor Name"
                  :state="errors.name ? false : null"
                  trim
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-title"
                label="Bank Name:"
                label-for="input-title"
                :invalid-feedback="errors.bank_name ? errors.bank_name[0] : ''"
                :state="errors.bank_name ? false : null"
              >
                <b-form-input
                  id="input-title"
                  type="text"
                  name="bank_name"
                  v-model="form_modal.bank_name"
                  placeholder="Bank Name"
                  :state="errors.bank_name ? false : null"
                  trim
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-title"
                label="Bank Account"
                label-for="input-title"
                :invalid-feedback="
                  errors.bank_account ? errors.bank_account[0] : ''
                "
                :state="errors.bank_account ? false : null"
              >
                <b-form-input
                  id="input-title"
                  type="text"
                  name="bank_account"
                  v-model="form_modal.bank_account"
                  placeholder="Account Number"
                  :state="errors.bank_account ? false : null"
                  trim
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-title"
                label="Amount:"
                label-for="input-title"
                :invalid-feedback="errors.amount ? errors.amount[0] : ''"
                :state="errors.amount ? false : null"
              >
                <CurrencyInput v-model="form_modal.amount" />
              </b-form-group>
              <b-form-group
                id="input-group-title"
                label="Remark:"
                label-for="input-title"
                :invalid-feedback="errors.remark ? errors.remark[0] : ''"
                :state="errors.remark ? false : null"
              >
                <b-form-input
                  id="input-title"
                  type="text"
                  name="remark"
                  placeholder="Remark"
                  v-model="form_modal.remark"
                  :state="errors.remark ? false : null"
                  trim
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-title"
                label="Vendor Address"
                label-for="textarea"
                :invalid-feedback="errors.address ? errors.address[0] : ''"
                :state="errors.address ? false : null"
              >
                <b-form-textarea
                  id="textarea"
                  type="text"
                  name="address"
                  placeholder="Vendor Address"
                  v-model="form_modal.address"
                  :state="errors.address ? false : null"
                  rows="3"
                  max-rows="6"
                  trim
                  required
                ></b-form-textarea>
              </b-form-group>
            </b-col>
          </b-card-body>
        </b-form>
      </b-overlay>
    </b-modal>
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import FormInvoice from "@/components/FormInvoice";
// import Handsontable from "handsontable";
import { HyperFormula } from "hyperformula";
import draggable from "vuedraggable";
import SelectTypeApprover from "@/components/SelectTypeApprover";
import CurrencyInput from "@/components/CurrencyInput.vue";
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
    "__autoSaveItem",
    "__autoSaveItemCost",
    //"__addDataTotal",
    "__updateAcknowledge",
    "__deleteAcknowledge",
    "__preview",
    "__previewpayment",
    "__attachment",
    "__removeAttachment",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Editor2,
    draggable,
    CurrencyInput,
    SelectTypeApprover,
    TableEditApprover,
    FormInvoice,
  },
  data() {
    return {
      submitState: false,
      isAcknowledgebusy: false,
      selectedAcknowledge: null,
      fieldSaving: "",
      isSaving: false,
      form: {},
      //payment
      checkPPNInclude: false,
      sub_total: 0,
      pph: 0,
      ppn: 0,
      grand_total: 0,
      manualInputPph: false,
      form_modal: {
        name: "",
        bank_name: "",
        bank_account: null,
        amount: 0,
        remark: "",
        address: "",
      },
      dataPayments: [],
      isSubmitBusy: false,
      isModalFormBusy: false,
      isFormPaymentEdited: false,
      activeItemPayment: {},
      activeIndex: null,
      url_data_payment: "user.api.payment.datapayments",
      updateApproverPayment: "user.api.payment.updateapprover",
      url_approvers: "user.api.memo.approvers",
      url_approvers_payment: "user.api.payment.approvers",

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
          this.typing("cost");
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
    // this.fillForm();
    this.getData();

    if (!_.isNull(this.dataMemo.cost)) {
      let cost = this.dataMemo.cost;
      cost = _.toArray(JSON.parse(cost));
      this.$refs.formCost.hotInstance.loadData(cost);
    }
  },
  watch: {
    sub_total: function (val) {
      if (!val) {
        val = 0;
      }
      this.ppn = this.checkPPNInclude ? 0 : 0.1 * parseFloat(val);
      // this.pph = 0.02 * parseFloat(val);
      this.pphValueChange(val);
      this.grand_total =
        parseFloat(val) + parseFloat(this.ppn) - parseFloat(this.pph);
    },
    pph: function (val) {
      if (!val || !this.sub_total) {
        val = 0;
        // this.sub_total = 0;
      }
      this.grand_total =
        parseFloat(this.sub_total) + parseFloat(this.ppn) - parseFloat(val);
    },
    checkPPNInclude: function (val) {
      if (val) {
        this.ppn = 0;
      } else {
        this.ppn = 0.1 * parseFloat(this.sub_total);
      }
      this.grand_total =
        parseFloat(this.sub_total) +
        parseFloat(this.ppn) -
        parseFloat(this.pph);

      this.debouncedSaveCost();
    },
    dataTotalCost: function (val) {
      this.fillForm();
    },
    dataMemo: function (val) {
      this.fillForm();
    },
  },
  created() {
    this.debouncedSave = _.debounce(this.autoSaveItem, 3000);
    this.debouncedSaveCost = _.debounce(this.autoSaveItemCost, 3000);
  },
  methods: {
    typing: function (field) {
      this.fieldSaving = field;
      this.debouncedSave();
    },
    autoSaveItem: function () {
      this.isSaving = true;
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
      axios
        .post(route(this.__autoSaveItem, this.dataMemo.id), this.form)
        .then((response) => {
          this.form.background = response.data.background;
          this.form.information = response.data.information;
          this.form.conclusion = response.data.conclusion;
          this.form.orientation_paper = response.data.orientation_paper;
          this.form.is_cost_invoice = response.data.is_cost_invoice;
          this.fieldSaving = "";
          this.isSaving = false;
          if (response.data.status == 200) {
            // this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          this.pageFlashes.error = error.response.data.errors;
        });
    },
    autoSaveItemCost: function () {
      this.isSaving = true;
      this.form.sub_total = this.sub_total;
      this.form.pph = this.pph;
      this.form.ppn = this.ppn;
      this.form.grand_total = this.grand_total;
      axios
        .post(route(this.__autoSaveItemCost, this.dataMemo.id), this.form)
        .then((response) => {
          this.sub_total = response.data.sub_total;
          this.pph = response.data.pph;
          this.ppn = response.data.ppn;
          this.grand_total = response.data.grand_total;
          this.isSaving = false;
          if (response.data.status == 200) {
            // this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          this.pageFlashes.error = error.response.data.errors;
        });
    },
    getOptionLabel: (option) => {
      let firstname = option.employee ? option.employee.firstname : "";
      let lastname = option.employee ? option.employee.lastname : "";

      return option.position.position_name + " - " + firstname + " " + lastname;
    },
    // payment
    reset: function () {
      this.sub_total = this.dataTotalCost.sub_total;
      this.pph = this.dataTotalCost.pph;
      this.ppn = this.dataTotalCost.ppn;
      this.grand_total = this.dataTotalCost.grand_total;
      this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;
    },
    pphValueChange: function (val) {
      // this.pph = 0.02 * parseFloat(val);
      if (!this.manualInputPph) {
        this.pph = 0.02 * parseFloat(val);
      }
      this.debouncedSaveCost();
    },

    uploadFiles: function () {
      // Using the default uploader. You may use another uploader instead.
      var form_data = new FormData();

      // this.fileRecordsForUpload.forEach((item, index) => {
      //   form_data.append(`files[${index}]`, item.file);
      // });
      _.each(this.fileRecordsForUpload, (item, index) => {
        form_data.append(`files[${index}]`, item.file);
      });
      if (this.formType == "payment") {
        form_data.append("type", "payment");
      }
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
      if (this.formType != "payment") {
        this.dataApprovers = [...this.form.approvers];
      }
      //   payment
      this.sub_total = this.dataTotalCost.sub_total;
      this.pph = this.dataTotalCost.pph;
      this.ppn = this.dataTotalCost.ppn;
      this.grand_total = this.dataTotalCost.grand_total;
      this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;

      this.selectedAcknowledge = _.map(
        this.form.acknowledges,
        (acknowledge) => acknowledge.position_now
      );
    },
    // submit() {
    //   // payment
    //   if (this.formType == "payment") {
    //     if (this.grand_total == 0 || this.sub_total == 0) {
    //       this.pageFlashes.danger = "Please fill data completely!";
    //       return;
    //     }
    //     if (this.dataPayments.length <= 0) {
    //       this.pageFlashes.danger = "Please fill data completely!";
    //       return;
    //     }
    //   }

    //   if (!this.submitState) {
    //     // let newData = {};
    //     // if (this.dataFormula.Sheet1.length != 0) {
    //     //   newData = _.map(this.dataFormula.Sheet1, (value) => {
    //     //     const res = {};
    //     //     for (let idx in value) {
    //     //       res[this.colHeaders[idx]] = value[idx];
    //     //     }
    //     //     return res;
    //     //   });
    //     // } else {
    //     //   newData = _.map(this.dataFormula.Sheet2, (value) => {
    //     //     const res = {};
    //     //     for (let idx in value) {
    //     //       res[this.colHeaders[idx]] = value[idx];
    //     //     }
    //     //     return res;
    //     //   });
    //     // }
    //     // let arrayCost = _.map(newData, (valueCost) => {
    //     //   let objCost = {};
    //     //   valueCost = Object.assign({}, valueCost);
    //     //   _.map(this.colHeaders, (v) => {
    //     //     objCost[v] = valueCost[v];
    //     //   });
    //     //   objCost = _.pickBy(objCost, _.identity);
    //     //   if (!_.isEmpty(objCost)) {
    //     //     return objCost;
    //     //   }
    //     // });
    //     // arrayCost = _.pickBy(arrayCost, _.identity);
    //     // if (!_.isEmpty(arrayCost)) this.form.cost = JSON.stringify(arrayCost);
    //     this.submitState = true;
    //     // payment
    //     this.form.sub_total = this.sub_total;
    //     this.form.pph = this.pph;
    //     this.form.ppn = this.ppn;
    //     this.form.grand_total = this.grand_total;
    //     this.isSubmitBusy = true;
    //     this.isTableApproverbusy = true;

    //     this.$inertia
    //       .post(route(this.__update, this.dataMemo.id), this.form)
    //       .then(() => {
    //         this.submitState = false;
    //         this.isSubmitBusy = true;
    //         this.isTableApproverbusy = true;
    //         this.$refs.upload.remove();
    //       });
    //   }
    // },
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

    // payment
    actionEdit(index, id) {
      this.activeIndex = index;
      this.isFormPaymentEdited = true;
      this.activeItemPayment = { ...this.dataPayments[index] };
    },
    actionDelete(idData) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this data vendor.",
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
        .then((value) => value && this.submitDelete(idData))
        .catch((err) => {
          // An error occurred
        });
    },
    actionChangeChenckboxManualInput() {
      if (this.manualInputPph) {
        this.pph = 0;
      }
    },
    submitUpdate(id) {
      axios
        .put(
          route("user.memo.statusmemo.updatepayment", [this.dataMemo.id, id]),
          this.activeItemPayment
        )
        .then((response) => {
          this.dataPayments = _.map(this.dataPayments, (item) => {
            if (item.id === this.activeItemPayment.id) {
              item = { ...this.activeItemPayment };
            }
            return item;
          });
          if (response.data.success) {
            this.pageFlashes.success = "Successfull update data vendor";
          }
          this.sub_total = this.sub_total;
          this.ppn = this.ppn;
          this.pph = this.pph;
          this.grand_total = this.grand_total;
          this.activeItemPayment = {};
          this.form_modal.amount = 0;
          this.isFormPaymentEdited = false;
        });
    },
    submitDelete(id) {
      axios
        .delete(route("user.memo.statusmemo.deletepayment", id))
        .then((response) => {
          if (response.data.success) {
            this.pageFlashes.success = "Successfull delete data vendor";
            this.dataPayments = _.filter(
              this.dataPayments,
              (item) => item.id != id
            );
            this.form.amount = 0;
          }
        });
    },
    actionCancel() {
      this.activeItemPayment = {};
      this.isFormPaymentEdited = false;
    },
    handleSubmitPayment() {
      this.isModalFormBusy = true;
      axios
        .put(
          route("user.api.payment.storepayment", this.dataMemo.id),
          this.form_modal
        )
        .then((response) => {
          this.errors = {};
          if (Object.entries(this.errors).length === 0) {
            this.$nextTick(() => {
              this.$bvModal.hide("modal-add-payment");
            });
          }
          this.isModalFormBusy = false;
          let id = response.data.id;
          this.form_modal.id = id;
          this.dataPayments = [...this.dataPayments, this.form_modal];
          this.sub_total = this.sub_total;
          this.ppn = this.ppn;
          this.pph = this.pph;
          this.grand_total = this.grand_total;
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          } else {
            this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          if (error.response) {
            this.errors = { ...error.response.data.errors };
            this.isModalFormBusy = false;
          }
        });
    },
    getData() {
      this.isTableApproverbusy = true;
      Promise.all([
        // this.getDataPositions(),
        this.getDataApproversPayment(),
        this.getDataApprovers(),
        this.getDataPayments(),
      ]).then((results) => {
        // this.isTableApproverbusy = false;
        // this.dataPositions = results[0].data;
        this.dataApprovers =
          results[0].data.length > 0 ? results[0].data : results[1].data;
        this.dataPayments = results[2].data;
        this.fillForm();
      });
    },
    resetModalPayment() {
      this.form_modal = {
        name: "",
        bank_name: "",
        bank_account: null,
        amount: 0,
        remark: "",
        address: "",
      };
    },
    handleOkPayment(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmitPayment();
    },
    getDataApprovers: async function () {
      return axios.get(route(this.url_approvers, this.dataMemo.id));
    },
    getDataApproversPayment: async function () {
      return axios.get(route(this.url_approvers_payment, this.dataMemo.id));
    },
    getDataPayments: async function () {
      return axios.get(route(this.url_data_payment, this.dataMemo.id));
    },
  },
};
</script>
