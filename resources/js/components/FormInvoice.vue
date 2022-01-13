<template>
  <b-col>
    <b-col v-for="(invoice, idx) in dataInvoices" :key="idx" class="my-5">
      <b-row class="my-2">
        <b-col sm="4" md="2">
          <b-form-input
            v-model="invoice.no_invoice"
            placeholder="No Invoice"
          ></b-form-input>
        </b-col>
        <b-col>
          <b-button
            v-if="idx > 0"
            class="mx-auto float-right"
            variant="outline-secondary"
            size="sm"
            @click="deleteInvoice(idx)"
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
                v-for="(item, index) in invoice.item_invoice"
                :key="index"
                @click="editMode(index, idx)"
              >
                <td @click="editMode(index, idx)">
                  <b-form-textarea
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.description"
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
                    placeholder="Description 2"
                    rows="1"
                    size="sm"
                  ></b-form-textarea>
                  <p v-else>
                    {{ item.description2 }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" class="text-right">
                  <b-form-input
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.price"
                    placeholder="Price"
                    size="sm"
                  ></b-form-input>
                  <p v-else>
                    {{ item.price }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" style="width: 7%">
                  <b-form-input
                    v-if="editRow == index && editInvoice == idx"
                    v-model="item.qty"
                    placeholder="Qty"
                    value="1"
                    size="sm"
                  ></b-form-input>
                  <p v-else>
                    {{ item.qty }}
                  </p>
                </td>
                <td @click="editMode(index, idx)">
                  <b-form-group v-if="editRow == index && editInvoice == idx">
                    <b-form-radio v-model="item.type" value="barang"
                      >barang</b-form-radio
                    >
                    <b-form-radio v-model="item.type" value="jasa"
                      >jasa</b-form-radio
                    >
                  </b-form-group>
                  <p v-else>
                    {{ item.type }}
                  </p>
                </td>
                <td @click="editMode(index, idx)" class="text-right">
                  <b-form-input
                    v-if="editRow == index && editInvoice == idx"
                    readonly
                    placeholder="Total"
                    :value="item.qty * item.price"
                    size="sm"
                  ></b-form-input>
                  <p v-else>
                    {{ item.qty * item.price }}
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
                      @click="deleteItemInvoice(idx, index)"
                    >
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </b-button>
                  </b-col>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-center mt-0">
            <b-button
              variant="secondary"
              size="sm"
              @click="addItemInvoice(idx)"
            >
              new item
              <i class="fa fa-plus" aria-hidden="true"></i>
            </b-button>
          </div>
        </b-col>
      </b-row>
      <b-row align-h="end">
        <b-col md="6" lg="1">
          <b-form-checkbox
            v-model="invoice.npwp"
            name="checkbox-npwp"
            :value="true"
            :unchecked-value="false"
          >
            NPWP
          </b-form-checkbox>
          <b-form-checkbox
            v-model="invoice.grossup"
            name="checkbox-grossup"
            :value="true"
            :unchecked-value="false"
          >
            Gross Up
          </b-form-checkbox>
        </b-col>
        <b-col md="6" lg="3">
          <table class="table table-bordered">
            <tbody>
              <tr class="text-right">
                <td>Total Barang</td>
                <td>
                  {{
                    sumItemInvoiceBy(idx, "barang")
                      ? sumItemInvoiceBy(idx, "barang")
                      : "-"
                  }}
                </td>
              </tr>
              <tr class="text-right">
                <td>Total Jasa</td>
                <td>
                  {{
                    sumItemInvoiceBy(idx, "jasa")
                      ? sumItemInvoiceBy(idx, "jasa")
                      : "-"
                  }}
                </td>
              </tr>
              <tr class="text-right font-weight-bold bg-light">
                <td>Sub Total</td>
                <td>
                  {{
                    sumItemInvoiceBy(idx, "barang") +
                    sumItemInvoiceBy(idx, "jasa")
                  }}
                </td>
              </tr>
              <tr class="text-right" v-if="invoice.grossup">
                <td>Total Jasa Gross Up</td>
                <td>
                  {{ countGrossUp(idx) }}
                </td>
              </tr>
              <tr class="text-right" v-if="invoice.ppn">
                <td>PPN</td>
                <td>
                  {{ countPPN(idx) }}
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
                <td v-if="invoice.pph == 'pph23'">{{ countPph23(idx) }}</td>
                <td v-if="invoice.pph == 'pph21'">{{ countPph21(idx) }}</td>
                <td v-if="invoice.pph == 'pph4_2_kon'">
                  {{ countPph4_2_kon(idx) }}
                </td>
                <td v-if="invoice.pph == 'pph4_2_kon_klas'">
                  {{ countPph4_2_kon_klas(idx) }}
                </td>
                <td v-if="invoice.pph == 'pph4_2_rent'">
                  {{ countPph4_2_rent(idx) }}
                </td>
              </tr>

              <tr class="text-right font-weight-bold bg-dark text-white">
                <td>Total</td>
                <td>
                  {{ countTotal(idx) }}
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-center mt-0">
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
                >Konstruksi (klasifikasi)</b-dropdown-item
              >
              <b-dropdown-item
                class="ml-2"
                :active="invoice.pph == 'pph4_2_kon'"
                >Konstruksi (nonklasifikasi)</b-dropdown-item
              >
              <b-dropdown-item
                class="ml-2"
                :active="invoice.pph == 'pph4_2_rent'"
                >Sewa & Utility</b-dropdown-item
              >
              <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item active>Other</b-dropdown-item>
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
      dataInvoices: [
        {
          id: 1,
          no_invoice: "",
          item_invoice: [
            {
              description: "test 1",
              description2: "",
              qty: 2,
              price: 1000000,
              type: "barang",
            },
            {
              description: "test 2",
              description2: "",
              qty: 1,
              price: 650000,
              type: "barang",
            },
            {
              description: "test 3",
              description2: "",
              qty: 1,
              price: 350000,
              type: "jasa",
            },
          ],
          ppn: true,
          npwp: true,
          grossup: true,
          pph: null,
          others: "",
        },
      ],
      selected: "a",
      optionPPhs: [
        { value: "a", text: "PPh 21" },
        { value: "b", text: "PPh 23" },
        { value: "d", text: "Pph 4(2)" },
      ],
      tax: [
        null,
        "pph21",
        "pph23",
        "pph4_2_kon",
        "pph4_2_kon_klas",
        "pph4_2_rent",
      ],
    };
  },

  mounted() {},

  methods: {
    onClickOutside(indexInvoice) {
      if (this.editInvoice == indexInvoice) {
        this.editRow = null;
        this.editInvoice = null;
      }
      console.log("clicked outside");
    },

    deleteInvoice(deleteindex) {
      this.dataInvoices = this.dataInvoices.filter(
        (item, index) => index != deleteindex
      );
    },

    addNewInvoice() {
      this.dataInvoices = [
        ...this.dataInvoices,
        {
          no_invoice: "",
          item_invoice: [this.generateItemInvoice()],
        },
      ];
      this.editMode(0, this.dataInvoices.length - 1);
    },

    deleteItemInvoice(indexInvoice, deleteindex) {
      if (
        this.dataInvoices[indexInvoice].item_invoice.length <= 1 &&
        indexInvoice > 0
      ) {
        this.deleteInvoice(indexInvoice);
        return;
      }
      this.dataInvoices[indexInvoice].item_invoice = this.dataInvoices[
        indexInvoice
      ].item_invoice.filter((item, index) => index != deleteindex);
    },
    addItemInvoice(indexInvoice) {
      this.dataInvoices[indexInvoice].item_invoice = [
        ...this.dataInvoices[indexInvoice].item_invoice,
        this.generateItemInvoice(),
      ];
      console.log(this.dataInvoices[indexInvoice].item_invoice.length);
      let lastitemIndex =
        this.dataInvoices[indexInvoice].item_invoice.length - 1;
      this.editMode(lastitemIndex, indexInvoice);
    },

    editMode(indexItem, indexInvoice) {
      this.editRow = indexItem;
      this.editInvoice = indexInvoice;
    },

    generateItemInvoice() {
      return {
        description: "",
        description2: "",
        qty: 1,
        price: 0,
        type: "barang",
      };
    },

    sumItemInvoiceBy(indexInvoice, type) {
      return _.sumBy(
        this.dataInvoices[indexInvoice].item_invoice,
        (item) => item.type == type && item.price * item.qty
      );
    },

    countPPN(idx) {
      return (
        ((this.sumItemInvoiceBy(idx, "barang") +
          this.sumItemInvoiceBy(idx, "jasa")) *
          10) /
        100
      );
    },

    actionCheckGrossUp(idx) {
      this.dataInvoices[idx].grossup = this.dataInvoices[idx].grossup;

      // kalau menggunakan pph 23
      // maka total jasa * 100 / (jika punya npwp 98 jika tidak 96)
    },

    countGrossUp(idx) {
      let invoice = this.dataInvoices[idx];
      let percent = invoice.npwp ? 96 : 98;
      return (this.sumItemInvoiceBy(idx, "jasa") * 100) / percent;
    },

    countPph21(idx) {
      // hitung pph21
      return;
    },

    countPph23(idx) {
      // total jasa (atau jika grossup menggunakan total grossup) * (jika punya npwp 2% jika tidak 4%)
      let invoice = this.dataInvoices[idx];
      let totalJasa = invoice.grossup
        ? this.countGrossUp(idx)
        : this.this.sumItemInvoiceBy(idx, "jasa");
      let tarif = invoice.npwp ? 2 : 4;

      return (totalJasa * tarif) / 100;
    },

    countPph4_2_kon(idx) {
      // hitung kon
      return;
    },

    countPph4_2_kon_klas(idx) {
      // hitung kon_klas
      return;
    },

    countPph4_2_rent(idx) {
      // hitung rent
      return;
    },

    countTotal(idx) {
      let invoice = this.dataInvoices[idx];
      let ppn = invoice.ppn ? this.countPPN(idx) : 0;
      let pph = 0;
      pph = invoice.pph == "pph21" ? this.countPph21(idx) : 0;
      pph = invoice.pph == "pph23" ? this.countPph23(idx) : 0;
      pph = invoice.pph == "pph4_2_kon" ? this.countPph4_2_kon(idx) : 0;
      pph =
        invoice.pph == "pph4_2_kon_klas" ? this.countPph4_2_kon_klas(idx) : 0;
      pph = invoice.pph == "pph4_2_rent" ? this.countPph4_2_rent(idx) : 0;

      return (
        this.sumItemInvoiceBy(idx, "barang") +
        this.sumItemInvoiceBy(idx, "jasa") +
        ppn +
        pph
      );
    },

    actioncheckItem(idx, key) {
      switch (key) {
        case "ppn":
          this.dataInvoices[idx].ppn = !this.dataInvoices[idx].ppn;
          return;
        case "pph23":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph23" ? null : "pph23";
          return;
        case "pph21":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph21" ? null : "pph21";
          return;
        case "pph4_2_kon":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon" ? null : "pph4_2_kon";
          return;
        case "pph4_2_kon_klas":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon_klas"
              ? null
              : "pph4_2_kon_klas";
          return;
        case "pph4_2_rent":
          this.dataInvoices[idx].pph =
            this.dataInvoices[idx].pph == "pph4_2_kon_rent"
              ? null
              : "pph4_2_rent";
          return;
        default:
          break;
      }
    },
  },
};
</script>