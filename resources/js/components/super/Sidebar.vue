<template>
  <!-- Sidebar -->
  <ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
  >
    <!-- Sidebar - Brand -->
    <inertia-link
      class="sidebar-brand d-flex align-items-center"
      :href="route('admin.dashboard')"
    >
      <div class="sidebar-brand-text mx-3">SuperMenu WebSHF</div>
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
  components: {
    SidebarItem,
  },
  data() {
    return {
      itemsNav: [
        {
          id: 0,
          title: "Dashboard",
          link: "super.dashboard",
          index: "super.dashboard",
          icon: "fas fa-fw fa-tachometer-alt",
        },
        {
          id: 1,
          title: "User Management",
          link: "super.user.*",
          index: "super.user.index",
          icon: "fas fa-fw fa-user",
        },
        {
          id: 2,
          title: "Reference",
          link: "#",
          icon: "fas fa-fw fa-folder",
          child: [
            {
              title: "Position",
              link: "super.ref_position.*",
              index: "super.ref_position.index",
            },
            {
              title: "Title",
              link: "super.ref_title.*",
              index: "super.ref_title.index",
            },
            {
              title: "Approver",
              link: "super.ref_approver.*",
              index: "super.ref_approver.index",
            },
            {
              title: "Type Memo",
              link: "super.ref_type_memo.*",
              index: "super.ref_type_memo.index",
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
  mounted() {
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
