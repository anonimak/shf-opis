<template>
  <div class="editor">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <span>
        <b-button-group v-if="editMode" class="mb-4">
          <b-button
            :class="{ active: isActive.bold() }"
            @click="commands.bold"
            variant="light"
          >
            <i class="fa fa-bold" />
          </b-button>
          <b-button
            :class="{ active: isActive.italic() }"
            @click="commands.italic"
            variant="light"
          >
            <i class="fa fa-italic" />
          </b-button>
          <b-button
            :class="isActive.strike() && 'active'"
            @click="commands.strike"
            variant="light"
          >
            <i class="fa fa-strikethrough" />
          </b-button>

          <b-button
            :class="isActive.underline() && 'active'"
            @click="commands.underline"
            variant="light"
          >
            <i class="fa fa-underline" />
          </b-button>

          <b-button
            :class="isActive.code() && 'active'"
            @click="commands.code"
            variant="light"
          >
            <i class="fa fa-code" />
          </b-button>

          <b-button
            :class="isActive.paragraph() && 'active'"
            @click="commands.paragraph"
            variant="light"
          >
            <i class="fa fa-paragraph" />
          </b-button>

          <b-button
            :class="{ active: isActive.heading({ level: 1 }) }"
            @click="commands.heading({ level: 1 })"
            variant="light"
          >
            H1
          </b-button>

          <b-button
            :class="{ active: isActive.heading({ level: 2 }) }"
            @click="commands.heading({ level: 2 })"
            variant="light"
          >
            H2
          </b-button>

          <b-button
            :class="{ active: isActive.heading({ level: 3 }) }"
            @click="commands.heading({ level: 3 })"
            variant="light"
          >
            H3
          </b-button>

          <b-button
            :class="{ active: isActive.bullet_list() }"
            @click="commands.bullet_list"
            variant="light"
          >
            <i class="fa fa-list-ul" />
          </b-button>

          <b-button
            :class="{ active: isActive.ordered_list() }"
            @click="commands.ordered_list"
            variant="light"
          >
            <i class="fa fa-list-ol" />
          </b-button>

          <b-button v-b-modal.modal-prevent-closing variant="light">
            <i class="fa fa-image" />
          </b-button>

          <b-modal
            id="modal-prevent-closing"
            ref="modal"
            title="URL Image"
            centered
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk(commands.image)"
          >
            <form ref="form">
              <b-form-group
                label-for="name-input"
                invalid-feedback="URL Image is required"
                :state="urlState"
              >
                <b-form-input
                  id="name-input"
                  v-model="url"
                  placeholder="http://url_image"
                  :state="urlState"
                  required
                ></b-form-input>
              </b-form-group>
            </form>
          </b-modal>

          <b-button
            :class="{ active: isActive.blockquote() }"
            @click="commands.blockquote"
            variant="light"
          >
            <i class="fa fa-quote-right" />
          </b-button>

          <b-button
            :class="{ active: isActive.code_block() }"
            @click="commands.code_block"
            variant="light"
          >
            <code-braces-box />
          </b-button>

          <b-button @click="commands.horizontal_rule" variant="light">
            <i class="fa fa-ruler-horizontal" />
          </b-button>

          <b-button @click="commands.undo" variant="light">
            <i class="fa fa-undo" />
          </b-button>

          <b-button @click="commands.redo" variant="light">
            <i class="fa fa-redo" />
          </b-button>

          <b-button
            @click="
              commands.createTable({
                rowsCount: 3,
                colsCount: 3,
                withHeaderRow: false,
              })
            "
            variant="light"
          >
            <table-plus />
          </b-button>
        </b-button-group>
        <b-button-group v-if="isActive.table()" class="mb-4">
          <b-button variant="light" @click="commands.deleteTable">
            <table-remove />
          </b-button>
          <b-button variant="light" @click="commands.addColumnBefore">
            <table-column-plus-before />
          </b-button>
          <b-button variant="light" @click="commands.addColumnAfter">
            <table-column-plus-after />
          </b-button>
          <b-button variant="light" @click="commands.deleteColumn">
            <table-column-remove />
          </b-button>
          <b-button variant="light" @click="commands.addRowBefore">
            <table-row-plus-before />
          </b-button>
          <b-button variant="light" @click="commands.addRowAfter">
            <table-row-plus-after />
          </b-button>
          <b-button variant="light" @click="commands.deleteRow">
            <table-row-remove />
          </b-button>
          <b-button variant="light" @click="commands.toggleCellMerge">
            <table-merge-cells />
          </b-button>
        </b-button-group>
      </span>
    </editor-menu-bar>
    <editor-content v-if="editMode" class="editor__content" :editor="editor" />
    <div v-else v-html="value"></div>
  </div>
</template>

<script>
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import CodeBracesBox from "vue-material-design-icons/CodeBracesBox";
import TablePlus from "vue-material-design-icons/TablePlus";
import TableRemove from "vue-material-design-icons/TableRemove";
import TableColumnPlusBefore from "vue-material-design-icons/TableColumnPlusBefore";
import TableColumnPlusAfter from "vue-material-design-icons/TableColumnPlusAfter";
import TableColumnRemove from "vue-material-design-icons/TableColumnRemove";
import TableRowPlusAfter from "vue-material-design-icons/TableRowPlusAfter";
import TableRowPlusBefore from "vue-material-design-icons/TableRowPlusBefore";
import TableRowRemove from "vue-material-design-icons/TableRowRemove";
import TableMergeCells from "vue-material-design-icons/TableMergeCells";

import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Table,
  TableHeader,
  TableCell,
  TableRow,
  Strike,
  Underline,
  History,
  Image,
} from "tiptap-extensions";

export default {
  props: {
    editMode: {
      type: Boolean,
      default: true,
    },
    value: {
      type: String,
      default: "",
    },
  },
  components: {
    EditorContent,
    EditorMenuBar,
    TablePlus,
    TableRemove,
    TableColumnPlusBefore,
    TableColumnPlusAfter,
    TableColumnRemove,
    TableRowPlusAfter,
    TableRowPlusBefore,
    TableRowRemove,
    TableMergeCells,
    CodeBracesBox,
  },
  data() {
    return {
      url: "",
      urlState: null,
      valueChangedFromEditor: false,
      editor: new Editor({
        editable: true,
        content: "",
        extensions: [
          new Blockquote(),
          new BulletList(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new HorizontalRule(),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Code(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History(),
          new Image(),
          new Table(),
          new TableHeader(),
          new TableCell(),
          new TableRow(),
        ],
        onUpdate: ({ state, getHTML, getJSON, transaction }) => {
          this.valueChangedFromEditor = true;
          this.$emit("input", getHTML());
        },
      }),
    };
  },
  methods: {
    checkFormValidity: function () {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal: function () {
      this.url = "";
      this.urlState = null;
    },
    handleOk: function (command) {
      // Prevent modal from closing
      // bvModalEvt.preventDefault();
      if (this.url != "") {
        this.$bvModal.hide("modal-prevent-closing");
        this.loadImage(command);
      }
    },
    loadImage: function (command) {
      command({
        src: this.url,
      });
    },
  },
  watch: {
    value: {
      handler(newVal, oldVal) {
        if (!this.valueChangedFromEditor) {
          this.editor.setContent(newVal);
        }
        // console.log(`value changed: ${newVal}`);
      },
      immediate: true,
    },
  },
  beforeDestroy() {
    this.editor.destroy();
  },
};
</script>
<style>
.editor__content {
  box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  border: 1px solid #dbdbdb;
  display: block;
  max-width: 100%;
  min-width: 100%;
  padding: 0.625em;
  resize: vertical;
  background-color: white;
  border-radius: 4px;
}
.editor__content .ProseMirror {
  outline: none;
}

.editor__content .ProseMirror .ProseMirror-focused {
  outline: none !important;
}

.editor__content .ProseMirror table td,
.editor__content .ProseMirror table th {
  min-width: 1em;
  border: 2px solid #ddd;
  padding: 3px 5px;
  vertical-align: top;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
}
</style>
