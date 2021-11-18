<template>
  <b-modal
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
      modalTitle: "",
      dataPositions: [],
      dataApprovers: [],
      updateApprover: "user.api.po.updateapprover",
      url_positions: "user.api.employee.positions",
      url_approvers: "user.api.memo.approvers",
      url_approvers_po: "user.api.po.approvers",
      id_memo: null,
      isTableApproverbusy: false,
      isSubmitbusy: false,
    };
  },
  methods: {
    getData() {
      this.isTableApproverbusy = true;
      this.modalTitle = "Continue purpose Purchase Order";

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
    getDataApproversPo: async function () {
      return axios.get(route(this.url_approvers_po, this.indexMemo)); //TODO: add count
    },
  },
};
</script>
