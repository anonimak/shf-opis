<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Memo {{ dataMemo.doc_no }}</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <!-- <a
            role="button"
            class="btn btn-secondary"
            v-b-tooltip.hover
            title="Preview Memo"
            :href="route(__preview, dataMemo.id)"
            target="_blank"
          >
            preview
          </a> -->
          <b-form id="form_payment" @submit.prevent="submit">
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
                          <td>{{ dataMemo.title }}</td>
                        </tr>
                        <tr>
                          <td>Doc. No</td>
                          <td>{{ dataMemo.doc_no }}</td>
                        </tr>
                        <tr>
                          <td>Type</td>
                          <td>Payment</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </b-col>
                <b-col col lg="12" class="mb-4">
                  <b-row>
                    <div class="table-responsive">
                      <b-overlay
                        :show="isTableApproverbusy"
                        opacity="0.6"
                        spinner-small
                        spinner-variant="primary"
                      >
                        <table-edit-approver
                          :dataPosition="dataPosition"
                          :dataApprovers="dataApprovers"
                          :__updateApprover="updateApprover"
                          :id_memo="dataMemo.id"
                          @beforeSave="beforeSaveEditApprover"
                          @onSave="onSaveEditApprover"
                        />
                      </b-overlay>
                    </div>
                  </b-row>
                </b-col>
              </b-row>

              <b-row class="mb-4">
                <b-col>
                  <h5>Send email after memo payment approved to:</h5>
                  <b-form-group id="input-group-name" label-for="input-name">
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
              <b-row
                v-if="dataMemo.background && dataMemo.background != '<p></p>'"
                class="mb-2"
              >
                <b-col>
                  <h5>Background</h5>
                  <div class="data-memo" v-html="dataMemo.background"></div>
                </b-col>
              </b-row>
              <b-row
                v-if="dataMemo.information && dataMemo.information != '<p></p>'"
                class="mb-2"
              >
                <b-col>
                  <h5>Information</h5>
                  <div class="data-memo" v-html="dataMemo.information"></div>
                </b-col>
              </b-row>
              <b-row
                v-if="dataMemo.conclusion && dataMemo.conclusion != '<p></p>'"
                class="mb-2"
              >
                <b-col>
                  <h5>Conclusion</h5>
                  <div class="data-memo" v-html="dataMemo.conclusion"></div>
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
                      :helpText="'Choose images, pdf, excel, pdf, rar, or word files'"
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
                      @click.prevent="uploadFiles"
                    >
                      Upload {{ fileRecordsForUpload.length }} files
                    </button>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-row v-if="memocost.length > 0" class="mb-2">
                <b-col>
                  <h5>Cost/Expense</h5>
                  <div class="table-responsive">
                    <b-table bordered :items="memocost"></b-table>
                  </div>
                </b-col>
              </b-row>
              <b-row v-else>
                <b-col>
                  <h5>Cost/Expense</h5>
                  <b-form-checkbox
                      id="checkbox-2"
                      v-model="dataMemo.is_cost_invoice"
                      name="checkbox-2"
                      :value="true"
                      :unchecked-value="false"
                      class="mb-2"
                    >
                      use Cost Invoice
                    </b-form-checkbox>
                  <form-invoice v-if="dataMemo.is_cost_invoice" :id_memo="dataMemo.id" />
                </b-col>
              </b-row>
              <b-row
                v-if="
                  dataMemoType.ref_table.with_po == 1 ||
                  dataMemoType.ref_table.with_payment == 1
                "
              >
                <div class="col-5" v-if="memocost.length > 0">
                  <b-overlay
                    :show="isSubmitbusy"
                    opacity="0.6"
                    spinner-small
                    spinner-variant="primary"
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
            </b-card-body>
            <b-row class="ml-2">
              <b-overlay
                :show="isSubmitbusy"
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
              :show="isSubmitbusy"
              opacity="0.6"
              spinner-small
              spinner-variant="primary"
            >
              <b-col class="mt-4 table-responsive">
                <h5>Vendor</h5>
                <table class="table table-striped table-bordered">
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
                        <!-- <input
                          type="text"
                          name="amount"
                          v-model="activeItemPayment.amount"
                        /> -->
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
            <b-row align-h="center">
              <b-overlay
                :show="isSubmitbusy"
                opacity="0.6"
                spinner-small
                spinner-variant="primary"
              >
                <b-button-group>
                  <b-button
                    type="submit"
                    variant="primary"
                    class="btn-lg mt-3 mb-3"
                    :disabled="isTerminateApprover"
                    >Propose Payment</b-button
                  >
                </b-button-group>
              </b-overlay>
            </b-row>
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
        :show="isModalformbusy"
        opacity="0.6"
        spinner-small
        spinner-variant="primary"
      >
        <b-form ref="form" @submit.prevent="handleSubmitPayment">
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
                  v-model="form.name"
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
                  v-model="form.bank_name"
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
                  v-model="form.bank_account"
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
                <CurrencyInput v-model="form.amount" />

                <!-- <p>Price (in parent component): {{ form.amount }}</p> -->
                <!-- <b-form-input
                id="input-title"
                type="number"
                name="amount"
                v-model="form.amount"
                placeholder="amount"
                :state="errors.amount ? false : null"
                trim
                required
              ></b-form-input> -->
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
                  v-model="form.remark"
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
                  v-model="form.address"
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
import TableEditApprover from "@/components/TableEditApprover.vue";
import CurrencyInput from "@/components/CurrencyInput.vue";
import draggable from "vuedraggable";
import SelectTypeApprover from "@/components/SelectTypeApprover";

export default {
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    draggable,
    CurrencyInput,
    SelectTypeApprover,
    TableEditApprover,
    FormInvoice,
  },
  props: [
    "_token",
    "userinfo",
    "notif",
    "breadcrumbItems",
    "dataMemo",
    "formType",
    "memocost",
    "__proposepayment",
    "dataPosition",
    "dataTotalCost",
    "dataAttachments",
    "headerCost",
    "columnCost",
    "__attachment",
    "__removeAttachment",
    "__updateAcknowledge",
    "__deleteAcknowledge",
    "__autoSaveItemCost",
    "dataMemoType",
  ],
  data() {
    return {
      form: {
        name: "",
        bank_name: "",
        bank_account: null,
        amount: 0,
        remark: "",
        address: "",
      },
      form_payment: {},
      isAcknowledgebusy: false,
      isTerminateApprover: false,
      selectedAcknowledge: null,
      checkPPNInclude: false,
      sub_total: 0,
      pph: 0,
      ppn: 0,
      grand_total: 0,
      manualInputPph: false,
      colHeaders: this.headerCost,
      dataPositions: [],
      dataPayments: [],
      dataApprovers: [],
      updateApprover: "user.api.payment.updateapprover",
      url_positions: "user.api.employee.positions",
      url_approvers: "user.api.memo.approvers",
      url_approvers_payment: "user.api.payment.approvers",
      url_data_payment: "user.api.payment.datapayments",
      id_memo: null,
      isTableApproverbusy: false,
      isSubmitbusy: false,
      isModalformbusy: false,
      isFormPaymentEdited: false,
      activeItemPayment: {},
      activeIndex: null,
      errors: {},
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
    this.getData();
    // table
    $(".data-memo table").wrap('<div class="table-responsive"></div>');
    $(".data-memo table").addClass("table").addClass("table-bordered");
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
    // dataMemo: function (val) {
    //   this.fillForm();
    // },
    dataTotalCost: function (val) {
      this.fillForm();
    },
    // fillForm() {},
  },
  created: function () {
    this.debouncedSaveCost = _.debounce(this.autoSaveItemCost, 1000);
  },
  methods: {
      autoSaveItemCost: function () {
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
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          this.pageFlashes.error = error.response.data.errors;
        });
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
      form_data.append("type", "payment");
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
    removeAttachment(id) {
      this.$inertia.delete(route(this.__removeAttachment, id)).then(() => {});
    },
    getOptionLabel: (option) => {
      let firstname = option.employee ? option.employee.firstname : "";
      let lastname = option.employee ? option.employee.lastname : "";

      return option.position.position_name + " - " + firstname + " " + lastname;
    },
    reset: function () {
      this.sub_total = this.dataTotalCost.sub_total;
      this.pph = this.dataTotalCost.pph;
      this.ppn = this.dataTotalCost.ppn;
      this.grand_total = this.dataTotalCost.grand_total;
      this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;
    },
    pphValueChange: function (val) {
      if (!this.manualInputPph) {
        this.pph = 0.02 * parseFloat(val);
      }
      this.debouncedSaveCost();
    },
    fillForm() {
      //   this.form = { ...this.dataMemo };
      //   this.dataApprovers = [...this.form.approvers];
      this.sub_total = this.dataTotalCost.sub_total;
      this.pph = this.dataTotalCost.pph;
      this.ppn = this.dataTotalCost.ppn;
      this.grand_total = this.dataTotalCost.grand_total;
      this.checkPPNInclude = this.dataTotalCost.ppn == 0 && true;
      // this.selectedAcknowledge = [...this.form.acknowledges];
      this.selectedAcknowledge = _.map(
        this.dataMemo.acknowledges,
        (acknowledge) => acknowledge.position_now
      );
    },
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
          this.form.amount = 0;
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
      this.isModalformbusy = true;
      axios
        .put(
          route("user.api.payment.storepayment", this.dataMemo.id),
          this.form
        )
        .then((response) => {
          this.errors = {};
          if (Object.entries(this.errors).length === 0) {
            this.$nextTick(() => {
              this.$bvModal.hide("modal-add-payment");
            });
          }
          this.isModalformbusy = false;
          let id = response.data.id;
          this.form.id = id;
          this.dataPayments = [...this.dataPayments, this.form];
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
            this.isModalformbusy = false;
          }
        });
    },
    getData() {
      this.isTableApproverbusy = true;
      Promise.all([
        this.getDataPositions(),
        this.getDataApproversPayment(),
        this.getDataApprovers(),
        this.getDataPayments(),
      ]).then((results) => {
        this.isTableApproverbusy = false;
        this.dataPositions = results[0].data;
        this.dataApprovers =
          results[1].data.length > 0 ? results[1].data : results[2].data;
        this.isTerminateApprover = this.dataApprovers.some(
          (approver) =>
            approver.employee.position_now.position.position_name == "TERMINATE"
        )
          ? true
          : false;
        this.dataPayments = results[3].data;
        this.fillForm();
      });
    },
    resetModal() {
      this.dataPayments = [];
      this.dataPositions = [];
      this.dataApprovers = [];
      this.id_memo = null;
    },

    resetModalPayment() {
      this.form = {
        name: "",
        bank_name: "",
        bank_account: null,
        amount: 0,
        remark: "",
        address: "",
      };
    },
    // handleOk(bvModalEvt) {
    //   // Prevent modal from closing
    //   bvModalEvt.preventDefault();
    //   // Trigger submit handler
    //   this.handleSubmit();
    // },
    handleOkPayment(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmitPayment();
    },
    submit() {
      if (
        this.dataMemoType.ref_table.with_po == 1 ||
        this.dataMemoType.ref_table.with_payment == 1
      ) {
        if (
          (this.grand_total == 0 || this.sub_total == 0) &&
          this.memocost.length > 0
        ) {
          this.pageFlashes.danger = "Please fill data completely!";
          return;
        }
      }
      if (this.dataPayments.length <= 0) {
        this.pageFlashes.danger = "Please fill data completely!";
        return;
      }
      this.form_payment.is_cost_invoice = this.dataMemo.is_cost_invoice;
      this.form_payment.sub_total = this.sub_total;
      this.form_payment.pph = this.pph;
      this.form_payment.ppn = this.ppn;
      this.form_payment.grand_total = this.grand_total;
      this.isSubmitbusy = true;
      this.isTableApproverbusy = true;
      this.$inertia.put(
        route(this.__proposepayment, this.dataMemo.id),
        this.form_payment
      );
    },

    beforeSaveEditApprover() {},

    onSaveEditApprover(response) {
      Promise.all([this.getDataApproversPayment()]).then((results) => {
        this.isTableApproverbusy = false;
        this.dataApprovers = results[0].data;
        this.isTerminateApprover = this.dataApprovers.some(
          (approver) =>
            approver.employee.position_now.position.position_name == "TERMINATE"
        )
          ? true
          : false;
      });
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

    // axios
    getDataPositions: async function () {
      return axios.get(route(this.url_positions)); //TODO: add count
    },
    getDataApprovers: async function () {
      return axios.get(route(this.url_approvers, this.dataMemo.id)); //TODO: add count
    },
    getDataApproversPayment: async function () {
      return axios.get(route(this.url_approvers_payment, this.dataMemo.id)); //TODO: add count
    },
    getDataPayments: async function () {
      return axios.get(route(this.url_data_payment, this.dataMemo.id)); //TODO: add count
    },
  },
};
</script>
