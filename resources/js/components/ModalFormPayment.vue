<template>
  <b-modal
    id="modal-propose-payment"
    ref="modal-propose-payment"
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
      :show="isTableApproverbusy"
      opacity="0.6"
      spinner-small
      spinner-variant="primary"
      class="d-inline-block"
    >
      <table-edit-approver
        :dataPosition="dataPositions"
        :dataApprovers="dataApprovers"
        :__updateApprover="updateApprover"
        :id_memo="indexMemo"
        @beforeSave="beforeSaveEditApprover"
        @onSave="onSaveEditApprover"
      />
    </b-overlay>

    <b-button v-b-modal.modal-add-payment class="mt-2" variant="primary">
      Add Data Payment
    </b-button>

    <b-col class="mt-4">
      <h5>Payment</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Bank Name</th>
            <th scope="col">Bank Account</th>
            <th scope="col">Amount</th>
            <th scope="col">Remark</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in dataPayments" :key="item.id">
            <th scope="row">
              {{ index + 1 }}
            </th>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input type="text" v-model="activeItemPayment.name" />
            </td>
            <td v-else>{{ item.name }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input type="text" v-model="activeItemPayment.bank_name" />
            </td>
            <td v-else>{{ item.bank_name }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input type="text" v-model="activeItemPayment.bank_account" />
            </td>
            <td v-else>{{ item.bank_account }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input type="text" v-model="activeItemPayment.amount" />
            </td>
            <td v-else>{{ item.amount }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <input type="text" v-model="activeItemPayment.remark" />
            </td>
            <td v-else>{{ item.remark }}</td>
            <td v-if="isFormPaymentEdited && activeIndex == index">
              <b-button variant="primary">save</b-button>
              <b-button variant="secondary" @click="actionCancel"
                >cancel</b-button
              >
            </td>
            <td v-else>
              <b-button variant="primary" @click="actionEdit(index)"
                ><i class="fa fa-edit"></i
              ></b-button>
              <b-button variant="secondary" @click="actionDelete(index)"
                ><i class="fa fa-trash"></i
              ></b-button>
            </td>
          </tr>
        </tbody>
      </table>
    </b-col>
    <b-modal
      id="modal-add-payment"
      title="Add Data Payment"
      ok-title="Add"
      @ok="handleOkPayment"
      @hidden="resetModalPayment"
      no-close-on-backdrop
    >
      <form ref="form" @submit.stop.prevent="handleSubmitPayment">
        <b-card-body>
          <b-col col lg="6" md="auto">
            <b-form-group
              id="input-group-title"
              label="Name:"
              label-for="input-title"
              :invalid-feedback="errors.name ? errors.name[0] : ''"
              :state="errors.name ? false : null"
            >
              <b-form-input
                id="input-title"
                type="text"
                name="name"
                v-model="form.name"
                placeholder="Name"
                :state="errors.name ? false : null"
                trim
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
                placeholder="Bank Account"
                :state="errors.bank_account ? false : null"
                trim
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
                type="tel"
                name="remark"
                placeholder="Remark"
                v-model="form.remark"
                :state="errors.remark ? false : null"
                trim
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-card-body>
      </form>
    </b-modal>
  </b-modal>
</template>

<script>
import TableEditApprover from "@/components/TableEditApprover.vue";

export default {
  components: {
    TableEditApprover,
  },
  props: ["indexMemo", "proposeLink", "errors"],
  data() {
    return {
      form: {
        name: null,
        bank_name: null,
        bank_account: null,
        amount: null,
        remark: null,
      },
      modalTitle: "",
      dataPositions: [],
      dataPayments: [],
      dataApprovers: [],
      updateApprover: "user.api.payment.updateapprover",
      url_positions: "user.api.employee.positions",
      url_approvers: "user.api.memo.approvers",
      url_approvers_payment: "user.api.payment.approvers",
      id_memo: null,
      isTableApproverbusy: false,
      isSubmitbusy: false,
      isFormPaymentEdited: false,
      activeItemPayment: {},
      activeIndex: null,
    };
  },
  methods: {
    actionEdit(index) {
      console.log("edit");
      this.activeIndex = index;
      this.isFormPaymentEdited = true;
      this.activeItemPayment = this.dataPayments[index];
    },
    actionDelete(index) {
      console.log("edit");
    },
    actionCancel() {
      this.activeItemPayment = {};
      this.isFormPaymentEdited = false;
    },
    handleSubmitPayment() {
      this.dataPayments.push(this.form);
      this.form = {};
    },
    getData() {
      this.isTableApproverbusy = true;
      this.modalTitle = "Continue purpose Payment";

      Promise.all([
        this.getDataPositions(),
        this.getDataApproversPayment(),
        this.getDataApprovers(),
      ]).then((results) => {
        this.isTableApproverbusy = false;
        this.dataPositions = results[0].data;
        this.dataApprovers =
          results[1].data.length > 0 ? results[1].data : results[2].data;
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
      this.isSubmitbusy = true;
      this.$inertia.put(route(this.proposeLink, this.indexMemo));
    },

    beforeSaveEditApprover() {
      console.log("okee");
    },

    onSaveEditApprover(response) {},

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
  },
};
</script>
