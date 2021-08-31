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
                                        <search
                                            v-model="form.search"
                                            @reset="reset"
                                        />
                                    </div>
                                    <!-- table news -->
                                    <div class="table-responsive">
                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">
                                                        Document No
                                                    </th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(item,
                                                    index) in dataMemo.data"
                                                    :key="item.id"
                                                >
                                                    <th scope="row">
                                                        {{
                                                            (filters.page !==
                                                            undefined
                                                                ? filters.page -
                                                                  1
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
                                                        <b-button-group
                                                            size="sm"
                                                        >
                                                            <b-button
                                                                v-b-tooltip.hover
                                                                title="Submit"
                                                                href="#"
                                                                variant="primary"
                                                                @click="
                                                                    showMsgBoxPropose(
                                                                        item.id
                                                                    )
                                                                "
                                                                ><i
                                                                    class="fa fa-check-square"
                                                                    aria-hidden="true"
                                                                ></i
                                                            ></b-button>
                                                            <inertia-link
                                                                v-b-tooltip.hover
                                                                title="Edit"
                                                                :href="
                                                                    route(
                                                                        __edit,
                                                                        item.id
                                                                    )
                                                                "
                                                                class="btn btn-secondary"
                                                                ><i
                                                                    class="fa fa-edit"
                                                                    aria-hidden="true"
                                                                ></i
                                                            ></inertia-link>
                                                            <b-button
                                                                v-b-tooltip.hover
                                                                title="Delete"
                                                                href="#"
                                                                variant="danger"
                                                                @click="
                                                                    showMsgBoxDelete(
                                                                        item.id
                                                                    )
                                                                "
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
        "__edit_draft",
        "__show",
        "__destroy",
        "__propose",
        "__index"
    ],
    metaInfo: { title: "Admin Reference Approve Page" },
    data() {
        return {
            tabIndex: 0,
            form: {
                search: this.filters.search
            },
            isCheched: false
        };
    },
    components: {
        Layout,
        FlashMsg,
        Breadcrumb,
        Pagination,
        Search
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
        showMsgBoxDelete: function(id) {
            this.$bvModal
                .msgBoxConfirm(
                    "Please confirm that you want to delete this memo?",
                    {
                        title: "Please Confirm",
                        size: "sm",
                        buttonSize: "sm",
                        okVariant: "danger",
                        okTitle: "YES",
                        cancelTitle: "NO",
                        footerClass: "p-2",
                        hideHeaderClose: false,
                        centered: true
                    }
                )
                .then(value => {
                    value && this.submitDelete(id);
                })
                .catch(err => {
                    console.log(err);
                    // An error occurred
                });
        },
        showMsgBoxPropose: function() {
            this.$bvModal
                .msgBoxConfirm(
                    "Please confirm that you want to submit this Memo.",
                    {
                        title: "Please Confirm",
                        size: "sm",
                        buttonSize: "sm",
                        okTitle: "YES",
                        cancelTitle: "NO",
                        footerClass: "p-2",
                        hideHeaderClose: false,
                        centered: true
                    }
                )
                .then(value => {
                    value && this.submitPropose(id);
                })
                .catch(err => {
                    // An error occurred
                });
        },
        showMsgBoxDeleteAll: function() {
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
                        centered: true
                    }
                )
                .then(value => {
                    // value && this.submitDeleteAll(this.selected);
                })
                .catch(err => {
                    // An error occurred
                });
        },
        uncheckAll: function() {
            // this.selected = []
        },
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = this.form.search;
                this.$inertia.replace(
                    this.route(
                        this.__index,
                        Object.keys(query).length
                            ? { search: query, tab: this.tab[this.tabIndex] }
                            : {
                                  remember: "forget",
                                  tab: this.tab[this.tabIndex]
                              }
                    )
                );
            }, 150),
            deep: true
        }
    }
};
</script>
