const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            "verde-silconio": "#30b472",
            "verde-tecnologico": "#7fc57f",
            "negro-inicio": "#221f1f",
            "negro-azulino": "#262c38",
            "blanco-hueso": "#e6e6e5",
            "celeste-guia": "#7dcede",
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
