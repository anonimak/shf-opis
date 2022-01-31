<template>
  <b-col>
    <b-col v-for="(invoice, idx) in dataInvoices" :key="idx" class="my-5">
      <b-row class="my-2">
        <b-col sm="4" md="2">
          <b-form-input
            v-model="invoice.no_invoice"
            @change="updateInvoice(idx, invoice.id)"
            placeholder="No Invoice"
          ></b-form-input>
        </b-col>
        <b-col>
          <b-button
            v-if="idx >= 0"
            class="mx-auto float-right"
            variant="outline-secondary"
            size="sm"
            @click="deleteInvoice(idx, invoice.id)"
          >
            <i class="fa fa-times" aria-hidden="true"></i> Remove Invoice
          </b-button>
        </b-col>
      </b-row>
      <b-row class="mb-4">
        <b-col>
          <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="">Description</th>
                <th scope="col">Description 2</th>
                <th scope="col" class="text-right">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Type</th>
                <th scope="col" class="text-right">Total</th>
                <th scope="col">#</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in invoice.item_invoices"
                :key="index"
                @click="editMode(index, idx)"
              >
                <td @click="editMode(index, idx)">
                  <b-form-textarea
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.description"
                    @change="submitItemInvoice(index, idx, 'description')"
                    placeholder="Description"
                    rows="1"
                    size="sm"
                  ></b-form-textarea>
                  <p v-else>
                    {{ item.description }}
                  </p>
                </td>
                <td @click="editMode(index, idx)">
                  <b-form-textarea
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.description2"
                    @change="submitItemInvoice(index, idx, 'description2')"
                    placeholder="Description 2"
                    rows="1"
                    size="sm"
                  ></b-form-textarea>
                  <p v-else>
                    {{ item.description2 }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" class="text-right">
                  <vue-numeric
                    v-if="editRow == index && editInvoice == idx"
                    @change="submitItemInvoice(index, idx, 'price')"
                    class="form-control form-control-sm"
                    currency="Rp"
                    thousand-separator="."
                    decimal-separator=","
                    v-bind:precision="2"
                    :empty-value="0"
                    v-model="item.price"
                  ></vue-numeric>
                  <!-- <b-form-input
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.price"
                    @change="submitItemInvoice(index, idx, invoice.id)"
                    placeholder="Price"
                    size="sm"
                  ></b-form-input> -->
                  <p v-else>
                    {{ item.price | currency }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" style="width: 7%">
                  <vue-numeric
                    v-if="editRow == index && editInvoice == idx"
                    @change="submitItemInvoice(index, idx, 'qty')"
                    class="form-control form-control-sm"
                    :empty-value="0"
                    thousand-separator="."
                    v-model="item.qty"
                  ></vue-numeric>
                  <p v-else>
                    {{ item.qty }}
                  </p>
                </td>
                <td @click="editMode(index, idx)">
                  <b-form-group v-if="editRow == index && editInvoice == idx">
                    <b-form-radio
                      v-model="item.type"
                      @change="submitItemInvoice(index, idx, 'type')"
                      value="barang"
                      >barang</b-form-radio
                    >
                    <b-form-radio
                      v-model="item.type"
                      @change="submitItemInvoice(index, idx, 'type')"
                      value="jasa"
                      >jasa</b-form-radio
                    >
                  </b-form-group>
                  <p v-else>
                    {{ item.type }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" class="text-right">
                  <vue-numeric
                    v-if="editRow == index && editInvoice == idx"
                    class="form-control form-control-sm"
                    currency="Rp"
                    separator="."
                    :empty-value="0"
                    :value="item.qty * item.price"
                    read-only
                    placeholder="Total"
                  ></vue-numeric>
                  <p v-else>
                    {{ (item.qty * item.price) | currency }}
                  </p>
                </td>
                <td @click="editMode(index, idx)">
                  <b-col
                    v-if="editRow == index && editInvoice == idx"
                    class="px-auto"
                  >
                    <b-button
                      variant="outline-secondary"
                      size="sm"
                      @click="deleteItemInvoice(idx, index, item.id)"
                    >
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </b-button>
                  </b-col>
                </td>
              </tr>
              <tr>
                <td colspan="7" class="p-0">
                  <div
                    class="col px-0 bg-secondary"
                    style="height: 5px"
                    :id="'btnAddInvoice' + invoice.id"
                    @mouseover="onMouseOverTableInvoice"
                    @mouseleave="onMouseLeaveTableInvoice"
                  >
                    <div
                      v-b-tooltip.hover
                      title="add item"
                      class="
                        round-box
                        d-none
                        align-items-center
                        justify-content-center
                      "
                      @click="addItemInvoice(idx)"
                    >
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-center mt-0"></div>
        </b-col>
      </b-row>
      <b-row align-h="end">
        <b-col md="6" lg="1">
          <b-form-checkbox
            v-model="invoice.npwp"
            @change="actionCheckNpwp(idx)"
            name="checkbox-npwp"
            :value="false"
            :unchecked-value="true"
          >
            non NPWP
          </b-form-checkbox>
          <b-form-checkbox
            v-model="invoice.grossup"
            @change="actionCheckGrossUp(idx)"
            name="checkbox-grossup"
            :value="true"
            :unchecked-value="false"
          >
            Gross Up
          </b-form-checkbox>
        </b-col>
        <b-col md="6" lg="3">
          <table class="table table-bordered mb-0">
            <tbody>
              <tr class="text-right">
                <td>Total Barang</td>
                <td>
                  {{
                    sumItemInvoiceBy(idx, "barang")
                      ? sumItemInvoiceBy(idx, "barang")
                      : "-" | currency
                  }}
                </td>
              </tr>
              <tr class="text-right">
                <td>Total Jasa</td>
                <td>
                  {{
                    sumItemInvoiceBy(idx, "jasa")
                      ? sumItemInvoiceBy(idx, "jasa")
                      : "-" | currency
                  }}
                </td>
              </tr>
              <tr class="text-right font-weight-bold bg-light">
                <td>Sub Total</td>
                <td>
                  {{
                    (sumItemInvoiceBy(idx, "barang") +
                      sumItemInvoiceBy(idx, "jasa"))
                      | currency
                  }}
                </td>
              </tr>
              <tr class="text-right" v-if="invoice.grossup">
                <td>Total Jasa Gross Up</td>
                <td>
                  <div class="d-flex align-items-center justify-content-center">
                    <vue-numeric
                      class="form-control form-control-sm"
                      @change="actionOnChange(idx)"
                      currency="Rp"
                      thousand-separator="."
                      decimal-separator=","
                      v-bind:precision="2"
                      :empty-value="0"
                      v-model="invoice.grossup_value"
                    ></vue-numeric>
                    <b-dropdown variant="none" size="sm" no-caret>
                      <template #button-content>
                        <span class="fas fa-ellipsis-v"> </span>
                      </template>
                      <b-dropdown-item @click="countTotal(idx, true, false)">
                        reset
                      </b-dropdown-item>
                    </b-dropdown>
                  </div>
                </td>
              </tr>
              <tr class="text-right" v-if="invoice.ppn">
                <td>PPN</td>
                <td>
                  <div class="d-flex align-items-center justify-content-center">
                    <vue-numeric
                      class="form-control form-control-sm"
                      @change="actionOnChange(idx)"
                      currency="Rp"
                      thousand-separator="."
                      decimal-separator=","
                      v-bind:precision="2"
                      :empty-value="0"
                      v-model="invoice.ppn_value"
                    ></vue-numeric>
                    <b-dropdown variant="none" size="sm" no-caret>
                      <template #button-content>
                        <span class="fas fa-ellipsis-v"> </span>
                      </template>
                      <b-dropdown-item @click="countTotal(idx, false, true)">
                        reset
                      </b-dropdown-item>
                    </b-dropdown>
                  </div>
                </td>
              </tr>
              <tr class="text-right" v-if="invoice.pph">
                <td v-if="invoice.pph == 'pph21'">Pph 21</td>
                <td v-if="invoice.pph == 'pph23'">Pph 23</td>
                <td v-if="invoice.pph == 'pph4_2_kon'">
                  Pph 4(2) Konstruksi(non klasifikasi)
                </td>
                <td v-if="invoice.pph == 'pph4_2_kon_klas'">
                  Pph 4(2) Konstruksi (klasifikasi)
                </td>
                <td v-if="invoice.pph == 'pph4_2_rent'">
                  Pph 4(2) Sewa & Utility
                </td>
                <td v-if="invoice.pph != 'none'">
                  <vue-numeric
                    v-if="invoice.pph == 'pph21'"
                    class="form-control form-control-sm"
                    @change="actionOnChange(idx)"
                    currency="Rp"
                    thousand-separator="."
                    decimal-separator=","
                    v-bind:precision="2"
                    :empty-value="0"
                    v-model="invoice.pph_value"
                  ></vue-numeric>
                  <span v-else>
                    {{ invoice.pph_value | currency }}
                  </span>
                </td>
                <!-- <td v-if="invoice.pph == 'pph23'">
                  {{ -Math.abs(countPph23(idx)) | currency }}
                </td>
                <td v-if="invoice.pph == 'pph21'">{{ countPph21(idx) }}</td>
                <td v-if="invoice.pph == 'pph4_2_kon'">
                  {{ countPph4_2_kon(idx) | currency }}
                </td>
                <td v-if="invoice.pph == 'pph4_2_kon_klas'">
                  {{ countPph4_2_kon_klas(idx) | currency }}
                </td>
                <td v-if="invoice.pph == 'pph4_2_rent'">
                  {{ countPph4_2_rent(idx) | currency }}
                </td> -->
              </tr>
            </tbody>
            <tbody v-if="invoice.others">
              <tr
                class="text-right"
                v-for="(item, index) in invoice.others"
                :key="index"
              >
                <td>
                  <b-input
                    type="text"
                    size="sm"
                    v-model="item.title"
                    @change="countTotal(idx)"
                    placeholder="item other"
                  />
                </td>
                <td>
                  <div class="d-flex align-items-center justify-content-center">
                    <vue-numeric
                      class="form-control form-control-sm"
                      currency="Rp"
                      thousand-separator="."
                      decimal-separator=","
                      v-bind:precision="2"
                      v-model="item.value"
                      @change="countTotal(idx)"
                    ></vue-numeric>
                    <b-dropdown variant="none" size="sm" no-caret>
                      <template #button-content>
                        <span class="fas fa-ellipsis-v"> </span>
                      </template>
                      <b-dropdown-item @click="removeOthers(idx, item.index)">
                        remove
                      </b-dropdown-item>
                    </b-dropdown>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td colspan="2" class="p-0">
                  <div
                    class="col px-0 bg-secondary"
                    style="height: 5px; cursor: pointer"
                    :id="'btnAddInvoice' + invoice.id"
                    @mouseover="onMouseOverTableInvoice"
                    @mouseleave="onMouseLeaveTableInvoice"
                  >
                    <div
                      v-b-tooltip.hover
                      title="add others"
                      class="
                        round-box
                        d-none
                        align-items-center
                        justify-content-center
                      "
                      @click="addOthers(idx)"
                    >
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="text-right font-weight-bold bg-dark text-white">
                <td>Total</td>
                <td>
                  {{ invoice.total | currency }}
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-center my-2">
            <b-dropdown variant="secondary" size="sm" no-caret>
              <template #button-content>
                new item
                <i class="fa fa-plus" aria-hidden="true"></i>
              </template>
              <b-dropdown-item
                :active="invoice.ppn"
                @click="actioncheckItem(idx, 'ppn')"
                >PPN</b-dropdown-item
              >
              <b-dropdown-item
                :active="invoice.pph == 'pph21'"
                @click="actioncheckItem(idx, 'pph21')"
                >Pph 21</b-dropdown-item
              >
              <b-dropdown-item
                :active="invoice.pph == 'pph23'"
                @click="actioncheckItem(idx, 'pph23')"
                >Pph 23</b-dropdown-item
              >
              <b-dropdown-item
                disabled
                class="bg-light text-white"
                :active="
                  invoice.pph == 'pph4_2_kon' ||
                  invoice.pph == 'pph4_2_kon_klas' ||
                  invoice.pph == 'pph4_2_rent'
                "
                >Pph 4(2)</b-dropdown-item
              >
              <b-dropdown-item
                class="ml-2"
                :active="invoice.pph == 'pph4_2_kon_klas'"
                @click="actioncheckItem(idx, 'pph4_2_kon_klas')"
                >Konstruksi (klasifikasi)</b-dropdown-item
              >
              <b-dropdown-item
                class="ml-2"
                :active="invoice.pph == 'pph4_2_kon'"
                @click="actioncheckItem(idx, 'pph4_2_kon')"
                >Konstruksi (nonklasifikasi)</b-dropdown-item
              >
              <b-dropdown-item
                class="ml-2"
                :active="invoice.pph == 'pph4_2_rent'"
                @click="actioncheckItem(idx, 'pph4_2_rent')"
                >Sewa & Utility</b-dropdown-item
              >
              <!-- <b-dropdown-divider></b-dropdown-divider> -->
              <!-- <b-dropdown-item>Other</b-dropdown-item> -->
            </b-dropdown>
            <!-- <b-button variant="secondary" size="sm">
              new item
              <i class="fa fa-plus" aria-hidden="true"></i>
            </b-button> -->
          </div>
        </b-col>
      </b-row>
    </b-col>
    <b-col>
      <b-button
        class="mx-auto"
        variant="outline-primary"
        size="sm"
        @click="addNewInvoice"
      >
        <i class="fa fa-plus" aria-hidden="true"></i> Add Invoice
      </b-button>
    </b-col>
  </b-col>
</template>
<script>
import CurrencyInput from "@/components/CurrencyInput";
export default {
  components: {
    CurrencyInput,
  },

  props: ["id_memo"],

  data() {
    return {
      editRow: null,
      editInvoice: null,
      dataInvoices: [],
      url_data_invoices: "user.api.invoice.datainvoices",
      url_add_data_invoices: "user.api.invoice.addinvoice",
      url_save_item_invoice: "user.api.invoice.additeminvoice",
      url_update_item_invoice: "user.api.invoice.updateiteminvoice",
      url_update_data_invoice: "user.api.invoice.updateinvoice",
      url_delete_item_invoice: "user.api.invoice.deleteiteminvoice",
      url_delete_data_invoice: "user.api.invoice.deletedatainvoice",
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    onMouseOverTableInvoice(event) {
      let button = $(event.target).find("div.round-box");
      button.removeClass("d-none").addClass("d-flex");
      $(event.target).removeClass("bg-secondary");
      $(event.target).addClass("bg-primary");
    },

    onMouseLeaveTableInvoice(event) {
      let button = $(event.target).find("div.round-box");
      button.addClass("d-none").removeClass("d-flex");
      $(event.target).removeClass("bg-primary");
      $(event.target).addClass("bg-secondary");
    },

    deleteInvoice(deleteindex, id_invoice) {
      this.dataInvoices = this.dataInvoices.filter(
        (item, index) => index != deleteindex
      );
      axios
        .delete(route(this.url_delete_data_invoice, id_invoice))
        .then((response) => {
          this.dataInvoices = _.filter(
            this.dataInvoices,
            (invoice) => invoice.id_invoice != id_invoice
          );
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          }
        });
    },

    addNewInvoice() {
      axios
        .post(route(this.url_add_data_invoices, this.id_memo))
        .then((response) => {
          //   this.dataInvoices = response.data.dataInvoices;
          let invoice = response.data.dataInvoice;
          invoice.item_invoices = [this.generateItemInvoice(invoice.id)];
          invoice.others = JSON.parse(invoice.others);
          this.dataInvoices = [...this.dataInvoices, invoice];
          this.editMode(0, this.dataInvoices.length - 1);
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          this.pageFlashes.error = error.response.data.errors;
        });
    },

    deleteItemInvoice(indexInvoice, deleteindex, id_item) {
      if (
        this.dataInvoices[indexInvoice].item_invoices.length <= 1 &&
        indexInvoice > 0
      ) {
        this.deleteInvoice(indexInvoice);
        return;
      }
      this.dataInvoices[indexInvoice].item_invoices = this.dataInvoices[
        indexInvoice
      ].item_invoices.filter((item, index) => index != deleteindex);

      if (id_item != undefined) {
        axios
          .delete(route(this.url_delete_item_invoice, id_item))
          .then((response) => {
            if (response.data.status == 200) {
              this.pageFlashes.success = response.data.message;
            }
          });
      }
    },

    addItemInvoice(indexInvoice) {
      let invoice = this.dataInvoices[indexInvoice];
      invoice.item_invoices = [
        ...invoice.item_invoices,
        this.generateItemInvoice(invoice.id),
      ];
      let lastitemIndex =
        this.dataInvoices[indexInvoice].item_invoices.length - 1;
      this.editMode(lastitemIndex, indexInvoice);
    },

    addOthers(indexInvoice) {
      // convert to json from str
      let index = this.dataInvoices[indexInvoice].others.length + 1;
      var Keyname = "Other" + index;
      let obj = {
        index: index,
        title: Keyname,
        value: 0,
      };

      this.dataInvoices[indexInvoice].others.push(obj);

      // this.updateInvoice(
      //   indexInvoice,
      //   this.dataInvoices[indexInvoice].id,
      //   "others"
      // );
    },

    removeOthers(indexInvoice, index) {
      this.dataInvoices[indexInvoice].others = _.filter(
        this.dataInvoices[indexInvoice].others,
        (item) => item.index != index
      );
      this.countTotal(indexInvoice);
    },

    editMode(indexItem, indexInvoice) {
      this.editRow = indexItem;
      this.editInvoice = indexInvoice;
    },

    submitItemInvoice(indexItem, indexInvoice, keyfield) {
      this.countTotal(indexInvoice);
      let row = this.dataInvoices[indexInvoice].item_invoices[indexItem];
      //   _.debounce(this.autoSaveItemInvoice(row), 2000);
      this.autoSaveItemInvoice(row, keyfield);
    },

    autoSaveItemInvoice: function (row, keyfield) {
      if (row.id == undefined) {
        axios
          .post(route(this.url_save_item_invoice), row)
          .then((response) => {
            // this.getData();
            if (response.data.status == 200) {
              this.pageFlashes.success = response.data.message;
            }
          })
          .catch((error) => {
            this.pageFlashes.error = error.response.data.errors;
          });
      } else {
        axios
          .put(
            route(this.url_update_item_invoice, row.id),
            _.pick(row, keyfield)
          )
          .then((response) => {
            // this.getData();
            if (response.data.status == 200) {
              this.pageFlashes.success = response.data.message;
            }
          })
          .catch((error) => {
            this.pageFlashes.error = error.response.data.errors;
          });
      }
    },

    updateInvoice: function (index, id_invoice) {
      axios
        .put(
          route(this.url_update_data_invoice, id_invoice),
          _.pick(this.dataInvoices[index], [
            "no_invoice",
            "ppn",
            "pph",
            "npwp",
            "grossup",
            "ppn_value",
            "grossup_value",
            "pph_value",
            "total",
            "others",
          ])
        )
        .then((response) => {
          // this.getData();
          if (response.data.status == 200) {
            this.pageFlashes.success = response.data.message;
          }
        })
        .catch((error) => {
          this.pageFlashes.error = error.response.data.errors;
        });
    },

    generateItemInvoice(id_invoice = null) {
      return {
        id_invoice: id_invoice,
        description: "",
        description2: "",
        qty: 1,
        price: 0,
        type: "barang",
      };
    },

    generateItemOther(indexInvoice) {
      let invoice = this.dataInvoices[indexInvoice];

      return {};
    },

    sumItemInvoiceBy(indexInvoice, type) {
      return _.sumBy(
        this.dataInvoices[indexInvoice].item_invoices,
        (item) => item.type == type && item.price * item.qty
      );
    },

    countPPN(idx) {
      let countPPN =
        ((this.sumItemInvoiceBy(idx, "barang") +
          this.sumItemInvoiceBy(idx, "jasa")) *
          10) /
        100;
      this.$set(this.dataInvoices[idx], "ppn_value", countPPN);
      return countPPN;
    },

    actionOnChange(idx) {
      this.countTotal(idx, true, true);
    },

    actionCheckNpwp(idx) {
      this.dataInvoices[idx].npwp = this.dataInvoices[idx].npwp;
      this.countTotal(idx);
    },

    actionCheckGrossUp(idx) {
      this.dataInvoices[idx].grossup = this.dataInvoices[idx].grossup;
      this.countTotal(idx);
      // kalau menggunakan pph 23
      // maka total jasa * 100 / (jika punya npwp 98 jika tidak 96)
    },

    countGrossUp(idx, pph) {
      let invoice = this.dataInvoices[idx];
      let percent = 0;
      let grossup = 0;
      if (pph == "pph23") {
        percent = invoice.npwp ? 98 : 96;
        return Math.floor((this.sumItemInvoiceBy(idx, "jasa") * 100) / percent);
      }
      if (pph == "pph4_2_kon") {
        percent = 96;
      }
      if (pph == "pph4_2_kon_klas") {
        percent = 97;
      }
      if (pph == "pph4_2_rent") {
        percent = 90;
      }
      grossup = Math.round(
        (this.sumItemInvoiceBy(idx, "jasa") * 100) / percent
      );
      console.log("grossup", grossup);
      return grossup;
    },

    countPph23(idx) {
      // total jasa (atau jika grossup menggunakan total grossup) * (jika punya npwp 2% jika tidak 4%)
      let invoice = this.dataInvoices[idx];
      let totalJasa = invoice.grossup
        ? invoice.grossup_value
        : this.sumItemInvoiceBy(idx, "jasa");
      let tarif = invoice.npwp ? 2 : 4;
      let pph = Math.floor((totalJasa * tarif) / 100);

      this.$set(this.dataInvoices[idx], "pph_value", pph);
      return pph;
    },

    countPph4_2_kon(idx) {
      // hitung kon
      let invoice = this.dataInvoices[idx];
      let totalJasa = invoice.grossup
        ? invoice.grossup_value
        : this.sumItemInvoiceBy(idx, "jasa");
      let tarif = 4;
      let pph = Math.round((totalJasa * tarif) / 100);

      this.$set(this.dataInvoices[idx], "pph_value", pph);
      return pph;
    },

    countPph4_2_kon_klas(idx) {
      // hitung kon_klas
      let invoice = this.dataInvoices[idx];
      let totalJasa = invoice.grossup
        ? invoice.grossup_value
        : this.sumItemInvoiceBy(idx, "jasa");
      let tarif = 3;
      let pph = Math.round((totalJasa * tarif) / 100);

      this.$set(this.dataInvoices[idx], "pph_value", pph);
      return pph;
    },

    countPph4_2_rent(idx) {
      // hitung rent
      let invoice = this.dataInvoices[idx];
      let totalJasa = invoice.grossup
        ? invoice.grossup_value
        : this.sumItemInvoiceBy(idx, "jasa");
      let tarif = 10;
      let pph = Math.round((totalJasa * tarif) / 100);

      this.$set(this.dataInvoices[idx], "pph_value", pph);
      return pph;
    },

    countTotal(idx, actionChangePPN = false, actionChangeGrossup = false) {
      console.log("hitung total...");
      let invoice = this.dataInvoices[idx];
      let ppn = 0;
      let sumBarang = this.sumItemInvoiceBy(idx, "barang");
      let sumJasa = this.sumItemInvoiceBy(idx, "jasa");
      let pph = 0;
      let other = 0;
      let totalJasa = 0;

      if (invoice.ppn) {
        ppn = actionChangePPN ? invoice.ppn_value : this.countPPN(idx);
      }

      // check grossup
      if (invoice.grossup && !_.includes(["none", "pph21"], invoice.pph)) {
        totalJasa = actionChangeGrossup
          ? invoice.grossup_value
          : this.$set(
              this.dataInvoices[idx],
              "grossup_value",
              this.countGrossUp(idx, invoice.pph)
            );
      } else {
        this.$set(this.dataInvoices[idx], "grossup_value", 0);
        totalJasa = sumJasa;
      }

      pph =
        invoice.pph == "pph21"
          ? invoice.pph_value
          : invoice.pph == "pph23"
          ? this.countPph23(idx)
          : invoice.pph == "pph4_2_kon"
          ? this.countPph4_2_kon(idx)
          : invoice.pph == "pph4_2_kon_klas"
          ? this.countPph4_2_kon_klas(idx)
          : invoice.pph == "pph4_2_rent"
          ? this.countPph4_2_rent(idx)
          : 0;

      // check others
      if (!_.isEmpty(invoice.others)) {
        other = _.sumBy(invoice.others, (item) => item.value);
      }

      let total = sumBarang + totalJasa + ppn - pph + other;
      this.$set(this.dataInvoices[idx], "total", total);

      this.updateInvoice(idx, invoice.id);
    },

    actioncheckItem(idx, key) {
      switch (key) {
        case "ppn":
          this.dataInvoices[idx].ppn = !this.dataInvoices[idx].ppn;
          break;
        case "pph23":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph23" ? "none" : "pph23";
          break;
        case "pph21":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph21" ? "none" : "pph21";
          this.dataInvoices[idx].pph_value = 0;
          break;
        case "pph4_2_kon":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon" ? "none" : "pph4_2_kon";
          break;
        case "pph4_2_kon_klas":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon_klas"
              ? "none"
              : "pph4_2_kon_klas";
          break;
        case "pph4_2_rent":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon_rent"
              ? "none"
              : "pph4_2_rent";
          break;
        default:
          break;
      }
      this.countTotal(idx);
    },

    getData() {
      Promise.all([this.getDataInvoices()]).then((results) => {
        this.dataInvoices = results[0].data;
        // set parse string to object (others)
        this.dataInvoices = _.map(this.dataInvoices, (item) => {
          item.others = JSON.parse(item.others);
          return item;
        });
      });
    },

    getDataInvoices: async function () {
      return axios.get(route(this.url_data_invoices, this.id_memo)); //TODO: add count
    },
  },
};
</script>

<style lang="scss" scoped>
.round-box {
  cursor: pointer;
  position: absolute;
  bottom: -12px;
  right: 0;
  left: 0;
  margin-left: auto;
  margin-right: auto;
  border-radius: 50% !important;
  width: 30px;
  height: 30px;
  background-color: #009688;
  color: white;
}
</style>