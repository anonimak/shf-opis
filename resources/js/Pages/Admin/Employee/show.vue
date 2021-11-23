<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <b-button type="button" variant="dark" class="float-right">Delete</b-button>
    <b-button
      v-if="!employee.terminated_at"
      type="button"
      variant="outline-danger"
      class="float-right mr-2"
      >Terminate</b-button
    >
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Detail Employee {{ employee.nik }}</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <b-col>
        <b-card class="mb-2">
          <b-row>
            <b-col>
              <inertia-link
                :href="route(__edit, employee.id)"
                class="text-secondary float-right"
                v-b-tooltip.hover.bottom="'Edit Employee'"
                ><i class="fa fa-edit" aria-hidden="true"></i
              ></inertia-link>
              <h4>Personal Info</h4>
              <hr />
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="fit">Full Name</th>

                    <td>{{ employee.firstname + " " + employee.lastname }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Title</th>

                    <td>{{ employee.title && employee.title.title_name }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Gender</th>

                    <td>{{ employee.gender === "L" ? "Male" : "Female" }}</td>
                  </tr>
                  <tr>
                    <th class="fit">NIK</th>

                    <td>{{ employee.nik }}</td>
                  </tr>
                </tbody>
              </table>

              <h4 class="mt-5">Contact Info</h4>
              <hr />
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="fit">Email</th>

                    <td>{{ employee.email }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Mobile Phone</th>

                    <td>{{ employee.mobile }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Telephone</th>

                    <td>{{ employee.phone }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Telephone 2</th>

                    <td>{{ employee.phone_two }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Address</th>

                    <td>{{ employee.address }}</td>
                  </tr>
                  <tr>
                    <th class="fit">Address 2</th>

                    <td>{{ employee.address_two }}</td>
                  </tr>
                </tbody>
              </table>

              <h4 class="mt-5">Employee Info</h4>
              <hr />
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="fit">Hired Date</th>

                    <td>
                      {{ employee.hired_at | moment("DD/MM/YYYY") }}
                    </td>
                  </tr>
                  <tr>
                    <th class="fit">Start Branch</th>

                    <td>
                      {{ employee.branch.branch_name }}
                    </td>
                  </tr>
                  <tr v-if="employee.terminated_at" class="text-danger">
                    <th class="fit">Terminate Date</th>

                    <td>{{ employee.terminated_at | moment("DD/MM/YYYY") }}</td>
                  </tr>
                </tbody>
              </table>
            </b-col>
          </b-row>
        </b-card>

        <b-card class="mb-2">
          <b-row>
            <b-col>
              <b-button
                v-if="employee_detail.length > 0"
                size="sm"
                class="float-right"
                v-b-modal.modal-prevent-closing
                variant="primary"
                @click="itemClicked = null"
                ><i class="fa fa-plus"></i
              ></b-button>
              <h4>Employee History</h4>
              <hr />
              <b-row v-if="employee_detail.length > 0">
                <b-col>
                  <table class="table mt-4">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Position</th>
                        <th scope="col"></th>
                        <th scope="col">Period</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in employee_detail"
                        :key="item.id"
                      >
                        <td>
                          <em>{{ item.position.position_name }}</em> in
                          {{ item.branch.branch_name }}
                        </td>
                        <td></td>
                        <td>
                          <em>
                            <span>
                              {{
                                item.year_started | moment("DD MMMM YYYY")
                              }} </span
                            >-
                            <span
                              v-if="item.year_started && item.year_finished"
                              >{{
                                item.year_finished | moment("DD MMMM YYYY")
                              }}</span
                            >
                            <span v-else>now</span>
                          </em>
                        </td>
                        <td>
                          <b-button-group size="sm">
                            <b-button
                              v-b-modal.modal-prevent-closing
                              variant="primary"
                              @click="itemClicked = index"
                              ><i class="fa fa-edit" aria-hidden="true"></i
                            ></b-button>
                            <b-button
                              href="#"
                              variant="danger"
                              @click="showMsgBoxDeleteHistory(item.id)"
                              ><i class="fa fa-trash-alt" aria-hidden="true"></i
                            ></b-button>
                          </b-button-group>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </b-col>
              </b-row>
              <b-row v-else align-h="center">
                <b-button
                  v-b-modal.modal-prevent-closing
                  variant="primary"
                  @click="itemClicked = null"
                  >Add Employee History</b-button
                >
              </b-row>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </div>
    <modal-form-emp-history
      :dataBranch="dataBranch"
      :dataPosition="dataPosition"
      :errors="errors"
      :indexEmpHistory="itemClicked"
    />
  </layout>
</template>
<script>
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import ModalFormEmpHistory from "@/components/ModalFormEmpHistory";

export default {
  props: [
    "employee",
    "employee_detail",
    "dataBranch",
    "dataPosition",
    "errors",
    "flash",
    "breadcrumbItems",
    "userinfo",
    "notif",
    "perPage",
    "__edit",
    "__destroy_history",
  ],
  metaInfo: { title: "Admin Employee Page" },
  data() {
    return {
      itemClicked: null,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    ModalFormEmpHistory,
  },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(
        route(this.__destroy_history, [this.employee.id, id])
      );
    },
    showMsgBoxDeleteHistory: function (id) {
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to delete this history.", {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okVariant: "danger",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => value && this.submitDelete(id))
        .catch((err) => {
          // An error occurred
        });
    },
  },
};
</script>
<style scoped>
.table td.fit,
.table th.fit {
  white-space: nowrap;
  width: 1%;
}
</style>
