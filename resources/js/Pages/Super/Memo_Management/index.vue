<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Memo Management</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
          <b-card>
            <keep-alive>
              <div class="row">
                <div class="col-12">
                  <div class="col-lg-3 col-xs-12 mt-3">
                    <search v-model="form.search" @reset="reset" />
                  </div>
                  <!-- table news -->
                  <table class="table mt-4">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Document No</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in dataMemos.data"
                        :key="item.id"
                      >
                        <th scope="row">
                          {{
                            (filters.page !== undefined
                              ? filters.page - 1
                              : 1 - 1) *
                              perPage +
                            index +
                            1
                          }}
                        </th>
                        <td>
                          {{ item.title }}
                        </td>
                        <td>
                          {{ item.doc_no }}
                        </td>
                        <td>
                          <b-button
                            @click="
                              actionEditMemo(
                                item.id,
                                item.id_employee2,
                                item.id_employee,
                                item.id_type,
                                item.confirmed_payment_by
                              )
                            "
                            variant="primary"
                            size="sm"
                            >Edit Memo</b-button
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="dataMemos.links" />
                </div>
              </div>
            </keep-alive>
          </b-card>
        </div>
      </div>
    </div>
    <modal-form-memo-management
      :title="modalTitle"
      :indexMemo="idItemClicked"
      :idTakeover="idTakeover"
      :idEmployee="idEmployee"
      :idTypeMemo="idTypeMemo"
      :idConfirmerPayment="idConfirmerPayment"
      :errors="errors"
      :__update="__update"
    />
  </layout>
</template>
<script>
import Layout from "@/Shared/SuperLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import ModalFormMemoManagement from "../../../components/ModalFormMemoManagement.vue";

export default {
  props: [
    "meta",
    "dataMemos",
    "flash",
    "breadcrumbItems",
    "userinfo",
    "notif",
    "errors",
    "filters",
    "perPage",
    "__index",
    "__update",
  ],
  metaInfo: { title: "Super User" },
  data() {
    return {
      idItemClicked: null,
      idTakeover: null,
      idEmployee: null,
      idTypeMemo: null,
      idConfirmerPayment: null,
      modalTitle: "",
      form: {
        search: this.filters.search,
      },
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
    Search,
    ModalFormMemoManagement,
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    actionEditMemo(id, id_takeover, id_propose_employee, id_type, id_confirmed_payment_by) {
      this.idItemClicked = id;
      this.idEmployee = id_propose_employee;
      this.idTypeMemo = id_type;
      this.idTakeover = id_takeover;
      this.idConfirmerPayment = id_confirmed_payment_by;
      this.modalTitle = "Edit Memo";

      this.$root.$emit("bv::show::modal", "modal-edit-memo", "#btnShow");
    },
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = this.form.search;
        this.$inertia.replace(
          this.route(
            this.__index,
            Object.keys(query).length
              ? { search: query }
              : { remember: "forget" }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
