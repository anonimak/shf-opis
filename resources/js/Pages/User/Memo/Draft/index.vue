<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Draft Memo</h1>
    </div>
    <breadcrumb v-if="!isMobile()" :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div v-if="!isMobile()">
          <b-card>
            <keep-alive>
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <!-- <div class="col-12">
                      <inertia-link
                        :href="route(__create)"
                        class="btn btn-primary my-2 float-right"
                      >
                        <i class="fas fa-plus"></i>
                        Add</inertia-link
                      >
                    </div> -->
                  </div>
                  <div class="col-lg-3 col-xs-12 mt-3">
                    <search v-model="form.search" @reset="reset" />
                  </div>
                  <!-- table news -->
                  <div class="table-responsive">
                    <table class="table mt-4">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Title</th>
                          <th scope="col">Type Memo</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(item, index) in dataMemo.data"
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
                            <b-badge
                              v-if="item.latest_history"
                              variant="warning"
                            >
                              revised
                            </b-badge>
                          </td>
                          <td
                            v-if="
                              item.ref_table.type == 'approval' &&
                              item.ref_table.with_payment == true
                            "
                          >
                            approval and payment
                          </td>
                          <td v-else>{{ item.ref_table.type }}</td>
                          <td>
                            <small v-if="item.latest_history">
                              {{ item.latest_history.content }}
                            </small>
                            <p
                              v-else-if="
                                Object.keys(item.check_terminate_approver)
                                  .length !== 0
                              "
                              class="text-danger"
                            >
                              Submit disabled because some approver has been
                              terminated
                            </p>
                            <span v-else>-</span>
                          </td>
                          <td>
                            <b-button-group size="sm">
                              <b-button
                                :disabled="
                                  Object.keys(item.check_terminate_approver)
                                    .length !== 0
                                    ? true
                                    : false
                                "
                                v-b-tooltip.hover
                                title="Submit"
                                href="#"
                                variant="primary"
                                @click="showMsgBoxPropose(item.id)"
                                ><i
                                  class="fa fa-check-square"
                                  aria-hidden="true"
                                ></i
                              ></b-button>
                              <inertia-link
                                v-b-tooltip.hover
                                title="Edit"
                                :href="route(__edit, item.id)"
                                class="btn btn-secondary"
                                ><i class="fa fa-edit" aria-hidden="true"></i
                              ></inertia-link>
                              <b-button
                                v-b-tooltip.hover
                                title="Delete"
                                href="#"
                                variant="danger"
                                @click="showMsgBoxDelete(item.id)"
                                ><i
                                  class="fa fa-trash-alt"
                                  aria-hidden="true"
                                ></i
                              ></b-button>
                            </b-button-group>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <Pagination :links="dataMemo.links" />
                </div>
              </div>
            </keep-alive>
          </b-card>
        </div>
        <div v-else>
          <card-memo @clicked:Menu="onclickMenu" />
          <card-memo />
          <card-memo />
          <card-memo />
          <card-memo />
        </div>
      </div>
      <b-modal id="bv-modal-example" hide-footer>
        <template #modal-title> Using <code>$bvModal</code> Methods </template>
        <div class="d-block text-center">
          <h3>Hello From This Modal!</h3>
        </div>
        <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example')"
          >Close Me</b-button
        >
      </b-modal>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import CardMemo from "@/components/CardMemo";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "dataMemo",
    "userinfo",
    "notif",
    "filters",
    "perPage",
    "tab",
    "__create",
    "__edit",
    "__edit_draft",
    "__show",
    "__destroy",
    "__propose",
    "__index",
  ],
  metaInfo: { title: "Draft Memo" },
  data() {
    return {
      tabIndex: 0,
      isApproverTerminated: true,
      form: {
        search: this.filters.search,
      },
      isCheched: false,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
    Search,
    CardMemo,
  },
  mounted() {
    if (this.dataMemo.data.length > 0) {
      this.dataMemo.data = _.map(this.dataMemo.data, (memo) => {
        if (memo.check_terminate_approver.length > 0) {
          memo.check_terminate_approver = _.pick(
            _.find(memo.check_terminate_approver, (approver) => {
              return approver.employee_history.position_count > 0;
            }),
            "employee_history.position_count"
          );
        }
        return memo;
      });
    }
  },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    submitPropose(id) {
      this.$inertia.put(route(this.__propose, id));
    },
    submitDeleteAll(idx) {
      //   this.$inertia.delete(route("admin.post.news.delete-all", idx.join()));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to delete this memo?", {
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
        .then((value) => {
          value && this.submitDelete(id);
        })
        .catch((err) => {});
    },
    showMsgBoxPropose: function (id) {
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to submit this Memo.", {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => {
          value && this.submitPropose(id);
        })
        .catch((err) => {});
    },
    showMsgBoxDeleteAll: function () {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this checked post.",
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
        .then((value) => {
          // value && this.submitDeleteAll(this.selected);
        })
        .catch((err) => {
          // An error occurred
        });
    },
    uncheckAll: function () {
      // this.selected = []
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    onclickMenu: function () {
      this.$bvModal.show("bv-modal-example");
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
              ? { search: query, tab: this.tab[this.tabIndex] }
              : {
                  remember: "forget",
                  tab: this.tab[this.tabIndex],
                }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>