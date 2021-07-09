<template>
  <Layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Reference Approvers</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
          <b-card>
            <keep-alive>
              <div class="row">
                <div class="col-12">
                  <b-tabs
                    content-class="mt-3"
                    align="center"
                    v-model="tabIndex"
                    @activate-tab="activeTab"
                    small
                  >
                    <b-tab>
                      <template #title>
                        On Process <b-badge variant="primary">4</b-badge>
                      </template>
                    </b-tab>
                    <b-tab title="Approved" />
                    <b-tab title="Rejected" />
                  </b-tabs>
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
                  <div class="table-responsive">
                    <table class="table mt-4">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Title</th>
                          <th scope="col">Document No</th>
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
                          </td>
                          <td>
                            {{ item.doc_no }}
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
      </div>
    </div>
  </Layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
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
    "filters",
    "perPage",
    "tab",
    "__create",
    "__edit",
    "__show",
    "__destroy",
    "__index",
  ],
  metaInfo: { title: "Admin Reference Approve Page" },
  data() {
    return {
      tabIndex: 0,
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
  },
  mounted() {
    this.setLsTabMemo();
  },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    submitDeleteAll(idx) {
      //   this.$inertia.delete(route("admin.post.news.delete-all", idx.join()));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this reference approver.",
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
          value && this.submitDelete(id);
        })
        .catch((err) => {
          // An error occurred
        });
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
    setLsTabMemo() {
      if (this.$ls.get("tabIndexMemo")) {
        this.tabIndex = this.$ls.get("tabIndexMemo") - 1;
        this.$inertia.replace(
          route(this.__index, { tab: this.tab[this.tabIndex] })
        );
      }
    },
    activeTab(tabIndex) {
      this.tabIndex = tabIndex;
      this.$ls.set("tabIndexMemo", this.tabIndex + 1, 60 * 60 * 1000);
      this.$inertia.replace(route(this.__index, { tab: this.tab[tabIndex] }));
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
              : { remember: "forget", tab: this.tab[this.tabIndex] }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
