module.exports = {
    content: ['./resources/views/**/*.blade.php', './public/js/**/*.js'],
    theme: {
        fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
        },
        extend: {
            colors: {
                mw: {
                    50: '#fff4ee',
                    100: '#ffe6d3',
                    200: '#ffc9a6',
                    300: '#ffa36d',
                    400: '#ff7232',
                    500: '#f26322',
                    600: '#e04e0f',
                    700: '#b83a0e',
                    800: '#932f13',
                    900: '#772913',
                },
            },
        },
    },
};
