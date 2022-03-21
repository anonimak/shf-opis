<template>
  <b-overlay
    :show="isApproverbusy"
    opacity="0.6"
    spinner-small
    spinner-variant="primary"
    class="col"
  >
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
        :get-option-label="getOptionLabel"
        placeholder="-- Add Approver --"
        :options="dataPosition"
        v-model="selected"
        :reduce="(position) => position.id_employee"
        @option:selected="actionApproverSelecting"
      ></v-select>
    </b-form-group>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Approver Name</th>
            <th>Position</th>
            <th>Approver Type</th>
            <th>Level</th>
            <th v-if="isApproverEdited">#</th>
          </tr>
        </thead>
        <draggable
          tag="tbody"
          handle=".handle"
          :list="dataApprovers"
          @change="actionApproverSave()"
        >
          <tr v-for="(approver, index) in dataApprovers" :key="index">
            <td>
              <i
                v-if="isApproverEdited"
                class="fas fa-bars handle"
                style="cursor: pointer"
              ></i>
              {{
                approver.employee.firstname + " " + approver.employee.lastname
              }}
            </td>
            <td>
              <strong>
                {{ approver.employee.position_now.position.position_name }}
              </strong>
            </td>
            <td>
              <div v-if="isApproverEdited">
                <strong>
                  {{
                    approver.type_approver == "acknowledge"
                      ? "reviewer"
                      : approver.type_approver
                  }}
                </strong>
                <a
                  role="button"
                  v-b-tooltip.hover
                  @click="showSelectTypeApprover(index)"
                  title="Edit Approver Type"
                >
                  <i class="fas fa-edit"></i>
                </a>
              </div>
              <strong class="text-capitalize" v-else>
                {{
                  approver.type_approver == "acknowledge"
                    ? "reviewer"
                    : approver.type_approver
                }}
              </strong>
              <select-type-approver
                v-if="activeSelect == index"
                :approver="approver"
                @changeSelected="changeApproverSelected"
              />
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
    </div>
    <!-- <b-button
        v-if="isApproverEdited"
        :disabled="$_.isEqual(form.approvers, dataApprovers)"
        variant="primary"
        size="sm"
        @click="actionApproverSave"
        >save</b-button
      >
    <b-button
      v-if="isApproverEdited"
      :disabled="isApproverbusy"
      variant="secondary"
      size="sm"
      @click="actionApproverCanceled"
      >cancel</b-button
    > -->
  </b-overlay>
</template>
<script>
import draggable from "vuedraggable";
import SelectTypeApprover from "@/components/SelectTypeApprover";

export default {
  components: { draggable, SelectTypeApprover },

  props: ["dataPosition", "id_memo", "dataApprovers", "__updateApprover"],
  data() {
    return {
      selected: null,
      isApproverbusy: false,
      isApproverEdited: true,
      activeSelect: null,
      form: {},
    };
  },
  methods: {
    getOptionLabel(option) {
      let firstname = option.employee ? option.employee.firstname : "";
      let lastname = option.employee ? option.employee.lastname : "";

      return option.position.position_name + " - " + firstname + " " + lastname;
    },
    actionApproverSelecting(selectedOption) {
      this.actionApproverAddItem(selectedOption);
      this.selected = null;
    },

    actionApproverRemoveAt(index) {
      this.dataApprovers.splice(index, 1);
      this.actionApproverSave();
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
        id_memo: this.id_memo,
        id_employee: item.id_employee,
        type_approver: "approver",
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
      this.actionApproverSave();
    },

    actionApproverSave() {
      this.isApproverbusy = true;
      this.$emit("beforeSave");
      axios
        .post(route(this.__updateApprover, this.id_memo), {
          approver: this.dataApprovers,
        })
        .then((response) => {
          this.isApproverbusy = false;
          this.isApproverEdited = true;

          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          }
          this.$emit("onSave", response.data);
        });
    },

    actionApproverCanceled() {
      this.isApproverEdited = true;
      this.activeSelect = null;
      this.dataApprovers = [...this.form.approvers];
    },

    changeApproverSelected(approver) {
      this.dataApprovers = _.map(this.dataApprovers, (item) => {
        if (item.id_employee === approver.id_employee) {
          item = approver;
        }
        return item;
      });
      this.activeSelect = null;
      this.actionApproverSave();
    },
    showSelectTypeApprover(index) {
      this.activeSelect = index;
    },
  },
};
</script>
