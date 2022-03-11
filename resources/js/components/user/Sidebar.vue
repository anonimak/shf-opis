<template>
  <!-- Sidebar -->
  <ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
  >
    <!-- Sidebar - Brand -->
    <inertia-link
      class="sidebar-brand d-flex align-items-center"
      :href="route('user.dashboard')"
    >
      <div class="sidebar-brand-text mx-3">User E-Memo</div>
    </inertia-link>
    <!-- Divider -->
    <hr class="sidebar-divider my-0" />
    <!-- Heading -->
    <sidebar-item :items="itemsNav"></sidebar-item>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>
  <!-- End of Sidebar -->
</template>
<script>
import SidebarItem from "@/components/SidebarItem";
export default {
  props: ["notif"],
  components: {
    SidebarItem,
  },
  data() {
    return {
      itemsNav: [
        {
          id: 0,
          title: "Dashboard",
          link: "user.dashboard",
          index: "user.dashboard",
          icon: "fas fa-fw fa-tachometer-alt",
        },
        {
          id: 1,
          title: "Memo",
          link: "#",
          icon: "fas fa-fw fa-clipboard",
          badge: this.notif.confirmed_paymentmemo || this.notif.memo_branch,
          child: [
            {
              title: "New Memo",
              link: "user.memo.create",
              index: "user.memo.create",
            },
            {
              title: "Draft",
              link: "user.memo.draft.*",
              index: "user.memo.draft.index",
            },
            {
              title: "Status Memo",
              link: "user.memo.statusmemo.*",
              index: "user.memo.statusmemo.index",
            },
            {
              title: "Status Payment",
              link: "user.memo.statuspayment.*",
              index: "user.memo.statuspayment.index",
            },
            {
              title: "Status PO",
              link: "user.memo.statuspo.*",
              index: "user.memo.statuspo.index",
            },
          ],
        },
        {
          id: 2,
          title: "Approval",
          link: "#",
          icon: "fas fa-fw fa-clipboard-check",
          badge:
            this.notif.approval_memo ||
            this.notif.approval_memo_payment ||
            this.notif.approval_memo_po,
          child: [
            {
              title: "Approval Memo",
              link: "user.memo.approval.memo.*",
              index: "user.memo.approval.memo.index",
              badge: this.notif.approval_memo,
            },
            {
              title: "Approval Payment",
              link: "user.memo.approval.payment.*",
              index: "user.memo.approval.payment.index",
              badge: this.notif.approval_memo_payment,
            },
            {
              title: "Approval PO",
              link: "user.memo.approval.po.*",
              index: "user.memo.approval.po.index",
              badge: this.notif.approval_memo_po,
            },
          ],
        },
      ],
    };
  },
  methods: {
    sidebarMenuHandle() {
      if (window.innerWidth < 768) {
      }
      if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      }
    },
  },
  beforeMount() {
    let userinfo = this.$inertia.page.props.userinfo;
    // let position = userinfo.employee.position_now.position.position_name;
    let isovertakeMemo = userinfo.employee.overtake;
    let isConfirmedPayment = userinfo.employee.confirmed_payment;
    if (isovertakeMemo) {
      this.itemsNav[1].child.push(
        {
          title: "Status Memo Branch",
          link: "user.memo.statustakeovermemobranch.*",
          index: "user.memo.statustakeovermemobranch.index",
          badge: this.notif.memo_branch,
        },
        {
          title: "Status Payment Branch",
          link: "user.memo.statustakeoverpaymentbranch.*",
          index: "user.memo.statustakeoverpaymentbranch.index",
        }
      );
    }
    if (isConfirmedPayment) {
      this.itemsNav[1].child.push({
        title: "Confirm Payment",
        link: "user.memo.confirmpayment.*",
        index: "user.memo.confirmpayment.index",
        badge: this.notif.confirmed_paymentmemo,
      });
    }
  },
  mounted() {
    // hide sidebar if mobile view
    if (this.isMobile()) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $(".sidebar .collapse").collapse("hide");
    }

    $("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $(".sidebar .collapse").collapse("hide");
      }
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
      if ($(window).width() < 768) {
        $(".sidebar .collapse").collapse("hide");
      }

      // Toggle the side navigation when window is resized below 480px
      if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
        $(".sidebar .collapse").collapse("hide");
      }
    });
  },
  created() {
    window.addEventListener("resize", this.sidebarMenuHandle);
  },
  destroyed() {
    window.removeEventListener("resize", this.sidebarMenuHandle);
  },
};
</script>
