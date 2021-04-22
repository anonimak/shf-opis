<template>
  <Layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Department</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
          <b-card>
            <keep-alive>
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-12">
                      <inertia-link
                        :href="route(__create)"
                        class="btn btn-primary my-2 float-right"
                      >
                        <i class="fas fa-plus"></i>
                        Add</inertia-link
                      >
                    </div>
                  </div>
                  <div class="col-lg-3 col-xs-12 mt-3">
                    <search v-model="form.search" @reset="reset" />
                  </div>
                  <!-- table news -->
                  <table class="table mt-4">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in dataDepartments.data"
                        :key="item.id"
                      >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>
                          {{ item.department_name }}
                        </td>
                        <td>
                          <b-button-group size="sm">
                            <!-- <inertia-link
                              :href="route(__show, item.id)"
                              class="btn btn-primary"
                              ><i
                                class="fa fa-search-plus"
                                aria-hidden="true"
                              ></i
                            ></inertia-link> -->
                            <inertia-link
                              :href="route(__edit, item.id)"
                              class="btn btn-secondary"
                              ><i class="fa fa-edit" aria-hidden="true"></i
                            ></inertia-link>
                            <b-button
                              href="#"
                              variant="danger"
                              @click="showMsgBoxDelete(item.id)"
                              ><i class="fa fa-trash-alt" aria-hidden="true"></i
                            ></b-button>
                          </b-button-group>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="dataDepartments.links" />
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
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
  props: [
    "dataDepartments",
    "flash",
    "breadcrumbItems",
    "userinfo",
    "filters",
    "__create",
    "__edit",
    "__show",
    "__destroy",
    "__index",
  ],
  metaInfo: { title: "Admin Department Page" },
  data() {
    return {
      tabIndexCfgHome: 0,
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
          "Please confirm that you want to delete this department.",
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
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form);
        this.$inertia.replace(
          this.route(
            this.__index,
            Object.keys(query).length ? query : { remember: "forget" }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
