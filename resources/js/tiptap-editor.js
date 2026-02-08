import { Editor } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";

/** @type {Editor | null} */
let richTextEditorInstance = null;

/** @type {string | null} */
let currentEditorInputId = null;

const DEFAULT_EDITOR_ELEMENT_ID = "rich_body_editor";
const DEFAULT_INPUT_ID = "rich_body";

/**
 * Create a simple toolbar for the editor and prepend it to the wrapper.
 * @param {Editor} editor
 * @param {HTMLElement} wrapper
 */
function createToolbar(editor, wrapper) {
    const toolbar = document.createElement("div");
    toolbar.className =
        "flex flex-wrap gap-1 p-2 border-b border-gray-300 bg-gray-50 rounded-t-md";
    toolbar.setAttribute("aria-label", "Formatting");

    const buttons = [
        {
            title: "Bold",
            shortcut: "Ctrl+B",
            cmd: () => editor.chain().focus().toggleBold().run(),
            isActive: () => editor.isActive("bold"),
        },
        {
            title: "Italic",
            shortcut: "Ctrl+I",
            cmd: () => editor.chain().focus().toggleItalic().run(),
            isActive: () => editor.isActive("italic"),
        },
        {
            title: "Strike",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleStrike().run(),
            isActive: () => editor.isActive("strike"),
        },
        {
            title: "Code",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleCode().run(),
            isActive: () => editor.isActive("code"),
        },
        { type: "separator" },
        {
            title: "Heading 2",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleHeading({ level: 2 }).run(),
            isActive: () => editor.isActive("heading", { level: 2 }),
        },
        {
            title: "Heading 3",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleHeading({ level: 3 }).run(),
            isActive: () => editor.isActive("heading", { level: 3 }),
        },
        { type: "separator" },
        {
            title: "Bullet list",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleBulletList().run(),
            isActive: () => editor.isActive("bulletList"),
        },
        {
            title: "Ordered list",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleOrderedList().run(),
            isActive: () => editor.isActive("orderedList"),
        },
        { type: "separator" },
        {
            title: "Blockquote",
            shortcut: null,
            cmd: () => editor.chain().focus().toggleBlockquote().run(),
            isActive: () => editor.isActive("blockquote"),
        },
        {
            title: "Horizontal rule",
            shortcut: null,
            cmd: () => editor.chain().focus().setHorizontalRule().run(),
            isActive: () => false,
        },
    ];

    buttons.forEach((item) => {
        if (item.type === "separator") {
            const sep = document.createElement("span");
            sep.className = "w-px h-6 bg-gray-300 self-center";
            toolbar.appendChild(sep);
            return;
        }
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className =
            "px-2 py-1 text-sm rounded border border-gray-300 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500";
        btn.textContent = item.title;
        btn.title = item.shortcut
            ? `${item.title} (${item.shortcut})`
            : item.title;
        btn.addEventListener("click", () => item.cmd());
        const setActive = () => {
            const active = item.isActive();
            btn.classList.toggle("bg-indigo-100", active);
            btn.classList.toggle("border-indigo-400", active);
        };
        editor.on("selectionUpdate", setActive);
        editor.on("transaction", setActive);
        toolbar.appendChild(btn);
    });

    wrapper.insertBefore(toolbar, wrapper.firstChild);
}

/**
 * Initialize the Tiptap rich text editor.
 * Syncs HTML to the hidden input for form submission.
 * @param {string} [editorElementId] - ID of the editor container (default: rich_body_editor).
 * @param {string} [inputId] - ID of the hidden input (default: rich_body). Use image_text_body_editor / image_text_body for Image + Text section.
 */
export function initRichTextEditor(editorElementId, inputId) {
    const editorElId = editorElementId ?? DEFAULT_EDITOR_ELEMENT_ID;
    const inputElId = inputId ?? DEFAULT_INPUT_ID;
    const editorEl = document.getElementById(editorElId);
    const inputEl = document.getElementById(inputElId);
    if (!editorEl || !inputEl) {
        return;
    }
    if (richTextEditorInstance && currentEditorInputId === inputElId) {
        return;
    }
    if (richTextEditorInstance) {
        destroyRichTextEditor();
    }
    const initialContent = inputEl.value?.trim() || "";
    const wrapper = editorEl.parentElement;
    richTextEditorInstance = new Editor({
        element: editorEl,
        extensions: [
            StarterKit,
            // Image extension can be added here when upload is ready, e.g.:
            // Image.configure({ inline: false, allowBase64: false }),
        ],
        content: initialContent || "<p></p>",
        editorProps: {
            attributes: {
                class: "prose prose-sm max-w-none min-h-[200px] p-4 focus:outline-none",
            },
        },
        onUpdate: ({ editor }) => {
            inputEl.value = editor.getHTML();
        },
    });
    inputEl.value = richTextEditorInstance.getHTML();
    currentEditorInputId = inputElId;
    if (wrapper) {
        createToolbar(richTextEditorInstance, wrapper);
    }
    if (typeof window !== "undefined") {
        window.richTextEditorInstance = richTextEditorInstance;
    }
}

/**
 * Destroy the editor instance (e.g. when navigating away or switching section type).
 */
export function destroyRichTextEditor() {
    if (richTextEditorInstance) {
        richTextEditorInstance.destroy();
        richTextEditorInstance = null;
        currentEditorInputId = null;
        if (typeof window !== "undefined") {
            window.richTextEditorInstance = null;
        }
    }
}
