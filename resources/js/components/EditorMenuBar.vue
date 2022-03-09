<template>
  <div>
    <b-button-group size="sm">
      <template v-for="(item, index) in items">
        <div class="divider" v-if="item.type === 'divider'" :key="index" />
        <menu-item
          v-else
          :key="index"
          v-bind="item"
          @onMouseDown="onMouseDown"
        />
      </template>
      <div class="divider" />
      <b-button
        title="Remove Table"
        @click="editor.chain().focus().deleteTable().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().deleteTable()"
        variant="light"
      >
        <i class="ri-close-circle-line" />
      </b-button>
      <b-button
        title="Insert column before"
        @click="editor.chain().focus().addColumnBefore().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().addColumnBefore()"
        variant="light"
      >
        <i class="ri-insert-column-left" />
      </b-button>
      <b-button
        title="Insert column after"
        @click="editor.chain().focus().addColumnAfter().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().addColumnAfter()"
        variant="light"
      >
        <i class="ri-insert-column-right" />
      </b-button>
      <b-button
        title="Remove column"
        @click="editor.chain().focus().deleteColumn().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().deleteColumn()"
        variant="light"
      >
        <i class="ri-delete-column" />
      </b-button>
      <b-button
        title="Insert row top"
        @click="editor.chain().focus().addRowBefore().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().addRowBefore()"
        variant="light"
      >
        <i class="ri-insert-row-top" />
      </b-button>
      <b-button
        title="Insert row bottom"
        @click="editor.chain().focus().addRowAfter().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().addRowAfter()"
        variant="light"
      >
        <i class="ri-insert-row-bottom" />
      </b-button>
      <b-button
        title="Remove row"
        @click="editor.chain().focus().deleteRow().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().deleteRow()"
        variant="light"
      >
        <i class="ri-delete-row" />
      </b-button>
      <b-button
        title="Toggle header cell"
        @click="editor.chain().focus().toggleHeaderCell().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().toggleHeaderCell()"
        variant="light"
      >
        <i class="ri-heading" />
      </b-button>
      <b-button
        title="Merge cells"
        @click="editor.chain().focus().mergeCells().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().mergeCells()"
        variant="light"
      >
        <i class="ri-merge-cells-horizontal" />
      </b-button>
      <b-button
        title="Split cell"
        @click="editor.chain().focus().splitCell().run()"
        @mousedown="onMouseDown"
        :disabled="!editor.can().splitCell()"
        variant="light"
      >
        <i class="ri-split-cells-horizontal" />
      </b-button>
    </b-button-group>
  </div>
</template>

<script>
import MenuItem from "@/components/EditorMenuItem.vue";

export default {
  components: {
    MenuItem,
  },

  props: {
    editor: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      items: [
        {
          icon: "bold",
          title: "Bold",
          action: () => this.editor.chain().focus().toggleBold().run(),
          isActive: () => this.editor.isActive("bold"),
        },
        {
          icon: "italic",
          title: "Italic",
          action: () => this.editor.chain().focus().toggleItalic().run(),
          isActive: () => this.editor.isActive("italic"),
        },
        {
          icon: "strikethrough",
          title: "Strike",
          action: () => this.editor.chain().focus().toggleStrike().run(),
          isActive: () => this.editor.isActive("strike"),
        },
        {
          type: "divider",
        },
        {
          icon: "align-left",
          title: "Left",
          action: () => this.editor.chain().focus().setTextAlign("left").run(),
          isActive: () => this.editor.isActive({ textAlign: "left" }),
        },
        {
          icon: "align-center",
          title: "Center",
          action: () =>
            this.editor.chain().focus().setTextAlign("center").run(),
          isActive: () => this.editor.isActive({ textAlign: "center" }),
        },
        {
          icon: "align-right",
          title: "Right",
          action: () => this.editor.chain().focus().setTextAlign("right").run(),
          isActive: () => this.editor.isActive({ textAlign: "right" }),
        },
        {
          icon: "align-justify",
          title: "Justify",
          action: () =>
            this.editor.chain().focus().setTextAlign("justify").run(),
          isActive: () => this.editor.isActive({ textAlign: "justify" }),
        },
        {
          type: "divider",
        },
        {
          icon: "h-1",
          title: "Heading 1",
          action: () =>
            this.editor.chain().focus().toggleHeading({ level: 1 }).run(),
          isActive: () => this.editor.isActive("heading", { level: 1 }),
        },
        {
          icon: "h-2",
          title: "Heading 2",
          action: () =>
            this.editor.chain().focus().toggleHeading({ level: 2 }).run(),
          isActive: () => this.editor.isActive("heading", { level: 2 }),
        },
        {
          icon: "paragraph",
          title: "Paragraph",
          action: () => this.editor.chain().focus().setParagraph().run(),
          isActive: () => this.editor.isActive("paragraph"),
        },
        {
          icon: "list-unordered",
          title: "Bullet List",
          action: () => this.editor.chain().focus().toggleBulletList().run(),
          isActive: () => this.editor.isActive("bulletList"),
        },
        {
          icon: "list-ordered",
          title: "Ordered List",
          action: () => this.editor.chain().focus().toggleOrderedList().run(),
          isActive: () => this.editor.isActive("orderedList"),
        },
        {
          type: "divider",
        },
        {
          icon: "double-quotes-l",
          title: "Blockquote",
          action: () => this.editor.chain().focus().toggleBlockquote().run(),
          isActive: () => this.editor.isActive("blockquote"),
        },
        {
          icon: "separator",
          title: "Horizontal Rule",
          action: () => this.editor.chain().focus().setHorizontalRule().run(),
        },
        {
          type: "divider",
        },
        {
          icon: "text-wrap",
          title: "Hard Break",
          action: () => this.editor.chain().focus().setHardBreak().run(),
        },
        {
          icon: "format-clear",
          title: "Clear Format",
          action: () =>
            this.editor.chain().focus().clearNodes().unsetAllMarks().run(),
        },
        {
          type: "divider",
        },
        {
          icon: "arrow-go-back-line",
          title: "Undo",
          action: () => this.editor.chain().focus().undo().run(),
        },
        {
          icon: "arrow-go-forward-line",
          title: "Redo",
          action: () => this.editor.chain().focus().redo().run(),
        },
        {
          type: "divider",
        },
        {
          icon: "table-2",
          title: "Table",
          action: () =>
            this.editor
              .chain()
              .focus()
              .insertTable({ rows: 3, cols: 3, withHeaderRow: true })
              .run(),
        },
      ],
    };
  },

  methods: {
    onMouseDown: function (e) {
      e.preventDefault();
      console.log("mouse down");
      this.$emit("onButtonMouseDown", true);
    },
  },
};
</script>

<style lang="scss" scoped>
.divider {
  width: 2px;
  height: 1.25rem;
  margin-left: 2px;
  margin-right: 2px;
}
</style>