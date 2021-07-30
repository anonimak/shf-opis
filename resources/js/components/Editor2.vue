<template>
    <div class="editor" v-if="editor">
        <menu-bar class="editor__header" :editor="editor" />
        <editor-content class="editor__content" :editor="editor" />
    </div>
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-2";
import StarterKit from "@tiptap/starter-kit";
import TextAlign from "@tiptap/extension-text-align";
import Table from "@tiptap/extension-table";
import TableRow from "@tiptap/extension-table-row";
import TableCell from "@tiptap/extension-table-cell";
import TableHeader from "@tiptap/extension-table-header";
import MenuBar from "@/components/EditorMenuBar.vue";

export default {
    components: {
        EditorContent,
        MenuBar
    },

    props: {
        value: {
            type: String,
            default: ""
        }
    },

    data() {
        return {
            editor: null,
            focused: false
        };
    },

    watch: {
        value(value) {
            // HTML
            const isSame = this.editor.getHTML() === value;

            // JSON
            // const isSame = this.editor.getJSON().toString() === value.toString()

            if (isSame) {
                return;
            }

            this.editor.commands.setContent(this.value, false);
        }
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Table.configure({
                    resizable: true
                }),
                TableRow,
                TableHeader,
                TableCell,
                TextAlign.configure({
                    types: ["heading", "paragraph"]
                })
            ],
            content: this.value,
            onUpdate: () => {
                // HTML
                this.$emit("input", this.editor.getHTML());

                // JSON
                // this.$emit('input', this.editor.getJSON())
            }
        });
    },

    methods: {},

    beforeDestroy() {
        this.editor.destroy();
    }
};
</script>

<style lang="scss">
.editor {
    display: flex;
    flex-direction: column;
    max-height: 400px;
    color: #0d0d0d;
    background-color: white;
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
    border: 1px solid #dbdbdb;
    border-radius: 4px;

    &__content {
        display: block;
        max-width: 100%;
        min-width: 100%;
        padding: 0.625em;
        resize: vertical;
        background-color: white;
    }

    &__header {
        display: flex;
        align-items: center;
        flex: 0 0 auto;
        flex-wrap: wrap;
        padding: 0.25rem;
        border-bottom: 1px solid #dbdbdb;
    }
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

.ProseMirror {
    ul,
    ol {
        padding: 0 1rem;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
    }

    code {
        background-color: rgba(#616161, 0.1);
        color: #616161;
    }

    pre {
        background: #0d0d0d;
        color: #fff;
        font-family: "JetBrainsMono", monospace;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;

        code {
            color: inherit;
            padding: 0;
            background: none;
            font-size: 0.8rem;
        }
    }

    mark {
        background-color: #faf594;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    hr {
        margin: 1rem 0;
    }

    blockquote {
        padding-left: 1rem;
        border-left: 2px solid rgba(#0d0d0d, 0.1);
    }

    hr {
        border: none;
        border-top: 2px solid rgba(#0d0d0d, 0.1);
        margin: 2rem 0;
    }

    ul[data-type="taskList"] {
        list-style: none;
        padding: 0;

        li {
            display: flex;
            align-items: center;

            > label {
                flex: 0 0 auto;
                margin-right: 0.5rem;
            }
        }
    }

    table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
        margin: 0;
        overflow: hidden;

        td,
        th {
            min-width: 1em;
            border: 2px solid #ced4da;
            padding: 3px 5px;
            vertical-align: top;
            box-sizing: border-box;
            position: relative;

            > * {
                margin-bottom: 0;
            }
        }

        th {
            font-weight: bold;
            text-align: left;
            background-color: #f1f3f5;
        }

        .selectedCell:after {
            z-index: 2;
            position: absolute;
            content: "";
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(200, 200, 255, 0.4);
            pointer-events: none;
        }

        .column-resize-handle {
            position: absolute;
            right: -2px;
            top: 0;
            bottom: -2px;
            width: 4px;
            background-color: #adf;
            pointer-events: none;
        }
    }
}

.tableWrapper {
    overflow-x: auto;
}

.resize-cursor {
    cursor: ew-resize;
    cursor: col-resize;
}
</style>
