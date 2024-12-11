/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");
import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

function withOpacityValue(variable) {
    return ({ opacityValue }) => {
        if (opacityValue === undefined) {
            return `rgb(var(${variable}))`;
        }
        return `rgb(var(${variable}) / ${opacityValue})`;
    };
}

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./app/Filament/**/*.php",
        './vendor/kenepa/banner/resources/**/*.php',
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        './vendor/bezhansalleh/filament-language-switch/resources/views/language-switch.blade.php',
        './vendor/awcodes/filament-quick-create/resources/**/*.blade.php',
        "./vendor/awcodes/overlook/resources/**/*.blade.php",
        "./vendor/andrewdwallo/filament-selectify/resources/views/**/*.blade.php",
        "<./vendor/awcodes/filament-tiptap-editor/resources/**/*.blade.php",
    ],
    darkMode: "class",
    presets: [preset],
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
