<template>
  <b-modal
    id="modal-propose-payment"
    ref="modal-propose-payment"
    size="lg"
    :title="modalTitle"
    @shown="getData"
    @hidden="resetModal"
    ok-title="Purpose Payment"
    @ok="handleOk"
    :cancel-disabled="isSubmitbusy || isTableApproverbusy"
    :ok-disabled="isSubmitbusy || isTableApproverbusy"
    hide-header-close
    scrollable
  >
    <b-overlay
      :show="isTableApproverbusy || isModalformbusy"
      opacity="0.6"
      spinner-small
      spinner-variant="primary"
    >
      <table-edit-approver
        :dataPosition="dataPositions"
        :dataApprovers="dataApprovers"
        :__updateApprover="updateApprover"
        :id_memo="indexMemo"
        @beforeSave="beforeSaveEditApprover"
        @onSave="onSaveEditApprover"
      />

      <b-button v-b-modal.modal-add-payment class="mt-2 ml-2" variant="primary">
        Add Data Vendor
      </b-button>
    </b-overlay>
    <b-overlay
      :show="isModalformbusy"
      opacity="0.6"
      spinner-small
      spinner-variant="primary">
    <b-col class="mt-4">
      <h5>Vendor</h5>
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Name Vendor</th>
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
              <input type="text" name="name" v-model="activeItemPayment.name" />
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
              <input
                type="text"
                name="amount"
                v-model="activeItemPayment.amount"
              />
            </td>
            <td v-else>{{ Number(item.amount).toLocaleString() }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input
                type="text"
                name="remark"
                v-model="activeItemPayment.remark"
              />
            </td>
            <td v-else>{{ item.remark }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input
                type="text"
                name="address"
                v-model="activeItemPayment.address"
              />
            </td>
            <td v-else>{{ item.address }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <b-button variant="primary" @click="submitUpdate(item.id)"
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
                  <b-button variant="secondary" @click="actionDelete(item.id)"
                    ><i class="fa fa-trash"></i
                  ></b-button>
                </b-button-group>
              </td>
            </tr>
          </tbody>
        </table>
      </b-col>
    </b-overlay>
    <b-modal
      id="modal-add-payment"
      title="Add Data Vendor"
      ok-title="Add"
      @ok="handleOkPayment"
      @hidden="resetModalPayment"
      no-close-on-backdrop
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
                type="number"
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
              <b-form-input
                id="input-title"
                type="number"
                name="amount"
                v-model="form.amount"
                placeholder="amount"
                :state="errors.amount ? false : null"
                trim
                required
              ></b-form-input>
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
              label-for="input-title"
              :invalid-feedback="errors.address ? errors.address[0] : ''"
              :state="errors.address ? false : null"
            >
              <b-form-input
                id="input-title"
                type="text"
                name="address"
                placeholder="Vendor Address"
                v-model="form.address"
                :state="errors.address ? false : null"
                trim
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-card-body>
      </b-form>
    </b-modal>
  </b-modal>
</template>

<script>
import TableEditApprover from "@/components/TableEditApprover.vue";

export default {
  components: {
    TableEditApprover,
  },
  props: ["indexMemo", "proposeLink"],
  data() {
    return {
      form: {
        name: null,
        bank_name: null,
        bank_account: null,
        amount: null,
        remark: null,
        address: null
      },

      modalTitle: "",
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
    };
  },
  methods: {
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

    submitUpdate(id) {
      this.$inertia
        .put(
          route("user.memo.statusmemo.updatepayment", [this.indexMemo, id]),
          this.activeItemPayment
        )
        .then(() => {
          this.dataPayments = _.map(this.dataPayments, (item) => {
            if (item.id === this.activeItemPayment.id) {
              item = { ...this.activeItemPayment };
            }
            return item;
          });
          this.activeItemPayment = {};
          this.isFormPaymentEdited = false;
        });
    },

    submitDelete(id) {
      axios.delete(route("user.memo.statusmemo.deletepayment", id))
      .then((response) => {
          if(response.data.success) {
              this.pageFlashes.success = "Successfull delete data vendor"
              this.dataPayments = _.filter(this.dataPayments, item => item.id != id);
          }
        });
    },

    actionCancel() {
      this.activeItemPayment = {};
      this.isFormPaymentEdited = false;
    },
    handleSubmitPayment() {
      axios
        .put(route("user.api.payment.storepayment", this.indexMemo), this.form)
        .then((response) => {
          this.errors = {};
          if (Object.entries(this.errors).length === 0) {
            console.log("no error");
            this.$nextTick(() => {
              this.$bvModal.hide("modal-add-payment");
            });
          }
          let id = response.data.id;
          this.form.id = id;
          this.dataPayments = [...this.dataPayments, this.form];
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          } else {
            this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          if (error.response) {
            this.errors = { ...error.response.data.errors };
            //console.log(error.response.data);
          }
        });
    },
    getData() {
      this.isTableApproverbusy = true;
      this.modalTitle = "Continue Purpose Payment";
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
        //console.log(results);
        this.dataPayments = results[3].data;
      });

      // this.getDataPositions();
      // this.getDataApprovers();
    },
    resetModal() {
      this.dataPayments = [];
      this.dataPositions = [];
      this.dataApprovers = [];
      this.id_memo = null;
    },

    resetModalPayment() {
      this.form = {};
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleOkPayment(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmitPayment();
    },
    handleSubmit() {
      console.log("submit");
      if (this.dataPayments.length <= 0) {
        this.pageFlashes.danger = "Please fill payment data!";
        return;
      }
      this.isSubmitbusy = true;
      this.isModalformbusy = true;
      this.$inertia.put(route(this.proposeLink, this.indexMemo));
    },

    beforeSaveEditApprover() {
      console.log("okee");
    },

    onSaveEditApprover(response) {
      Promise.all([this.getDataApproversPayment()]).then((results) => {
        this.isTableApproverbusy = false;
        this.dataApprovers = results[0].data;
        //console.log(results);
      });
    },

    // axios
    getDataPositions: async function () {
      return axios.get(route(this.url_positions)); //TODO: add count
    },
    getDataApprovers: async function () {
      return axios.get(route(this.url_approvers, this.indexMemo)); //TODO: add count
    },
    getDataApproversPayment: async function () {
      return axios.get(route(this.url_approvers_payment, this.indexMemo)); //TODO: add count
    },
    getDataPayments: async function () {
      return axios.get(route(this.url_data_payment, this.indexMemo)); //TODO: add count
    },
  },
};
</script>
