<template>
  <nav
    id="bottom-navbar"
    class="
      navbar
      border-top
      navbar-expand
      d-lg-none d-xl-none
      fixed-bottom
      bottom-navbar
    "
  >
    <ul class="navbar-nav nav-justified mx-auto w-100">
      <li class="nav-item">
        <inertia-link
          :href="route('user.dashboard')"
          class="nav-link"
          :class="{
            active: isRoute('user.dashboard') || isRoute('user.setting.*'),
          }"
        >
          <i class="bx bx-home-alt"></i>
          <span class="title small d-block">Home</span>
        </inertia-link>
      </li>
      <li class="nav-item">
        <inertia-link
          :href="route('user.memo.draft.index')"
          class="nav-link"
          :class="{ active: isRoute('user.memo.draft.*') }"
        >
          <i class="bx bx-box"></i>
          <span class="title small d-block">Draft</span>
        </inertia-link>
      </li>
      <li class="nav-item">
        <inertia-link
          :href="route('user.memo.create')"
          class="nav-link"
          :class="{ active: isRoute('user.memo.create') }"
        >
          <i class="bx bx-plus-circle"></i>
          <span class="title small d-block">Create</span>
        </inertia-link>
      </li>
      <li class="nav-item">
        <div class="dropdown dropup">
          <a
            href="#"
            id="dropdownMenuButtonStatus"
            data-toggle="dropdown"
            class="nav-link nav-icon"
            :class="{
              active:
                isRoute('user.memo.statusmemo.*') ||
                isRoute('user.memo.statuspayment.*') ||
                isRoute('user.memo.statuspo.*') ||
                isRoute('user.memo.statustakeovermemobranch.*') ||
                isRoute('user.memo.statustakeoverpaymentbranch.*') ||
                isRoute('user.memo.confirmpayment.*'),
            }"
          >
            <i class="bx bx-info-square"></i>
            <b-badge
              v-if="notif.memo_branch || notif.confirmed_paymentmemo"
              pill
              variant="primary"
              class="notif-badge"
              >!</b-badge
            >
            <span class="title small d-block">Status</span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="dropdownMenuButtonStatus"
          >
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.statusmemo.*') }"
              :href="route('user.memo.statusmemo.index')"
              >Memo
            </inertia-link>
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.statuspayment.*') }"
              :href="route('user.memo.statuspayment.index')"
              >Payment
            </inertia-link>
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.statuspo.*') }"
              :href="route('user.memo.statuspo.index')"
              >PO
            </inertia-link>

            <inertia-link
              v-if="isOvertakeMemo"
              class="dropdown-item"
              :class="{
                active: isRoute('user.memo.statustakeovermemobranch.*'),
              }"
              :href="route('user.memo.statustakeovermemobranch.index')"
              >Memo Branch
              <b-badge
                v-if="notif.memo_branch"
                pill
                variant="primary"
                class="notif-badge"
                >!</b-badge
              >
            </inertia-link>
            <inertia-link
              v-if="isOvertakeMemo"
              class="dropdown-item"
              :class="{
                active: isRoute('user.memo.statustakeoverpaymentbranch.*'),
              }"
              :href="route('user.memo.statustakeoverpaymentbranch.index')"
              >Payment Branch
            </inertia-link>

            <inertia-link
              v-if="isConfirmedPayment"
              class="dropdown-item"
              :class="{
                active: isRoute('user.memo.confirmpayment.*'),
              }"
              :href="route('user.memo.confirmpayment.index')"
              >Confirm Payment
              <b-badge
                v-if="notif.confirmed_paymentmemo"
                pill
                variant="primary"
                class="notif-badge"
                >!</b-badge
              >
            </inertia-link>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="dropdown dropup">
          <a
            href="#"
            id="dropdownMenuButtonApproval"
            data-toggle="dropdown"
            class="nav-link nav-icon"
            :class="{
              active:
                isRoute('user.memo.approval.memo.*') ||
                isRoute('user.memo.approval.payment.*') ||
                isRoute('user.memo.approval.po.*'),
            }"
          >
            <i class="bx bx-list-check"></i>
            <b-badge
              v-if="
                notif.approval_memo ||
                notif.approval_memo_payment ||
                notif.approval_memo_po
              "
              pill
              variant="primary"
              class="notif-badge"
              >!</b-badge
            >
            <span class="title small d-block">Approval</span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="dropdownMenuButtonApproval"
          >
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.approval.memo.*') }"
              :href="route('user.memo.approval.memo.index')"
              >Memo
              <b-badge
                v-if="notif.approval_memo"
                pill
                variant="primary"
                class="notif-badge"
                >!</b-badge
              ></inertia-link
            >
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.approval.payment.*') }"
              :href="route('user.memo.approval.payment.index')"
              >Payment
              <b-badge
                v-if="notif.approval_memo_payment"
                pill
                variant="primary"
                class="notif-badge"
                >!</b-badge
              >
            </inertia-link>
            <inertia-link
              class="dropdown-item"
              :class="{ active: isRoute('user.memo.approval.po.*') }"
              :href="route('user.memo.approval.po.index')"
              >PO
              <b-badge
                v-if="notif.approval_memo_po"
                pill
                variant="primary"
                class="notif-badge"
                >!</b-badge
              >
            </inertia-link>
          </div>
        </div>
      </li>
    </ul>
  </nav>
</template>
<script>
export default {
  props: ["notif"],
  data() {
    return {
      isOvertakeMemo: false,
      isConfirmedPayment: false,
    };
  },
  beforeMount() {
    let userinfo = this.$inertia.page.props.userinfo;
    // let position = userinfo.employee.position_now.position.position_name;
    let isovertakeMemo = userinfo.employee.overtake;
    let isConfirmedPayment = userinfo.employee.confirmed_payment;
    this.isOvertakeMemo = isovertakeMemo;
    this.isConfirmedPayment = isConfirmedPayment;
  },
  mounted() {
    this.actionHideShowNav();
  },
  methods: {
    actionHideShowNav() {
      var prevScrollpos = window.pageYOffset;
      window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
          $("#bottom-navbar").slideDown(100);
        } else {
          $("#bottom-navbar").slideUp(100);
        }
        prevScrollpos = currentScrollPos;
      };
    },
  },
};
</script>

<style lang="scss" scoped>
$milkwhite: #fafafa !default;
$white: #fff !default;
$darkteal: #006e63 !default;
$teal: #009688 !default;
$gray-800: #5a5c69 !default;
$gray-900: #3a3b45 !default;
$black: #000 !default;

nav {
  border-radius: 20px 20px 0 0;
  padding: 0.9rem 0.5rem 0 0.5rem;
  ul.navbar-nav {
    li.nav-item {
      a:hover,
      a:hover.nav-link {
        // color: $teal;
        span.title {
          display: block !important;
        }
      }
      a.nav-link {
        padding: 0 !important;
        font-size: 24px;
        display: inline-grid;
        color: #3a3b45;
        z-index: 1;
        span.title {
          display: none !important;
          font-size: 10px;
        }
      }
      a.nav-link.active {
        color: $teal;
        transform: translateY(-10%);
        transition: transform 0.5s cubic-bezier(0.075, 0.82, 0.165, 1);
        font-size: 26px;
        > span.title {
          display: block !important;
        }
        span.notif-badge {
          display: block !important;
        }
      }

      .dropdown {
        display: block;
        .dropdown-item > span.notif-badge {
          display: inline-block !important;
          font-size: 60%;
        }

        .dropdown-item.active > span.notif-badge {
          background-color: $white;
          color: #009688;
        }

        .nav-icon span.notif-badge {
          position: absolute;
          top: 2px;
          right: 18px;
          display: block;
          font-size: 40%;
        }
      }
    }
  }
  .navbar-nav .show > .nav-link,
  .navbar-nav .active > .nav-link,
  .navbar-nav .nav-link.show,
  .navbar-nav .nav-link.active {
    color: $teal;
  }
}

.bottom-navbar {
  background: $white;
}
</style>