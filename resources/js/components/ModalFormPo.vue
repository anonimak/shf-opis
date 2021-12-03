<template>
  <b-modal
    size="lg"
    id="modal-propose-po"
    ref="modal-propose-po"
    :title="modalTitle"
    @shown="getData"
    @hidden="resetModal"
    ok-title="Purpose PO"
    @ok="handleOk"
    :cancel-disabled="isSubmitbusy || isTableApproverbusy"
    :ok-disabled="isSubmitbusy || isTableApproverbusy"
    hide-header-close
  >
    <b-overlay
      :show="isTableApproverbusy"
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
    </b-overlay>
    <b-overlay
      :show="isModalformbusy"
      opacity="0.6"
      spinner-small
      spinner-variant="primary"
    >
      <h5 class="ml-3">Vendor</h5>
      <b-form ref="form">
        <b-card-body>
          <b-col col lg="7" md="auto">
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
                :disabled="isSubmitbusy"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              id="input-group-title"
              label="Vendor Address:"
              label-for="input-title"
              :invalid-feedback="errors.address ? errors.address[0] : ''"
              :state="errors.address ? false : null"
            >
              <b-form-textarea
                id="textarea"
                type="text"
                name="address"
                v-model="form.address"
                placeholder="Vendor Address"
                :state="errors.address ? false : null"
                rows="3"
                max-rows="6"
                trim
                required
                :disabled="isSubmitbusy"
              ></b-form-textarea>
            </b-form-group>
          </b-col>
        </b-card-body>
      </b-form>
    </b-overlay>
  </b-modal>
</template>

<script>
import TableEditApprover from "@/components/TableEditApprover.vue";

export default {
  components: {
    TableEditApprover,
  },
  props: {
    indexMemo: {
      type: Number,
    },
    proposeLink: {
      type: String,
    },
  },
  data() {
    return {
      form: {
        name: null,
        address: null,
      },
      modalTitle: "",
      dataPositions: [],
      dataApprovers: [],
      updateApprover: "user.api.po.updateapprover",
      url_positions: "user.api.employee.positions",
      url_approvers: "user.api.memo.approvers",
      url_approvers_po: "user.api.po.approvers",
      id_memo: null,
      isTableApproverbusy: false,
      isModalformbusy: false,
      isSubmitbusy: false,
      errors: {},
    };
  },
  methods: {
    getData() {
      this.isTableApproverbusy = true;
      this.modalTitle = "Continue Purpose Purchase Order";

      Promise.all([
        this.getDataPositions(),
        this.getDataApproversPo(),
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
      this.dataPositions = [];
      this.dataApprovers = [];
      this.id_memo = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      //   console.log("submit");
      //   this.isSubmitbusy = true;
      //   this.isTableApproverbusy = true;
      console.log("submit");
      if (this.form.name == null || this.form.address == null) {
        this.pageFlashes.danger = "Please fill vendor data!";
        return;
      }
        this.isSubmitbusy = true;
        this.isTableApproverbusy = true;
        this.$inertia.put(route(this.proposeLink, this.indexMemo), this.form);
      //   axios.put(route(this.proposeLink, this.indexMemo),this.form)
      //     .then((response)=> {
      //         this.errors = {};
      //         this.form = [];
      //         this.isTableApproverbusy = false;
      //         this.isSubmitbusy = false;
      //         if (Object.entries(this.errors).length === 0) {
      //         console.log("no error");
      //         this.$nextTick(() => {
      //           this.$bvModal.hide("modal-propose-po");
      //         });
      //       }
      //         if (response.data.status == 200) {
      //         this.pageFlashes.success = response.data.message;
      //       } else {
      //         this.pageFlashes.success = response.data.message;
      //       }
      //     })
      //     .catch((error) => {
      //         if (error.response) {
      //             this.isTableApproverbusy = false;
      //             this.isSubmitbusy = false;
      //             this.errors = {...error.response.data.errors};
      //         }
      //     });
    },

    beforeSaveEditApprover() {
      console.log("okee");
    },

    onSaveEditApprover(response) {
      Promise.all([this.getDataApproversPo()]).then((results) => {
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
    getDataApproversPo: async function () {
      return axios.get(route(this.url_approvers_po, this.indexMemo)); //TODO: add count
    },
  },
};
</script>
