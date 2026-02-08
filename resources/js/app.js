import "./bootstrap";

import Alpine from "alpinejs";
import { initRichTextEditor } from "./tiptap-editor";

window.Alpine = Alpine;
window.initRichTextEditor = initRichTextEditor;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("image_text_body_editor")) {
        initRichTextEditor("image_text_body_editor", "image_text_body");
    } else if (document.getElementById("rich_body_editor")) {
        initRichTextEditor();
    }
});
