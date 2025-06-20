/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#006546",
                secondary: "#4a7c59",
                accent: "#6B9E4B",
                transparent: 'transparent',
                current: 'currentColor',
                'white': '#ffffff',
                'purple': '#3f3cbb',
                'midnight': '#121063',
                'metal': '#565584',
                'tahiti': '#3ab7bf',
                'silver': '#ecebff',
                'bubble-gum': '#ff77e9',
                'bermuda': '#78dcca',
                'ijobg': '#034833',
                'ijofont':'#E1EEBC',
                'ijologin':'#67AE6E',
                'bglogin' : '#90C67C',
                'ijologinfont' : '#034833',
                'ijolanding' : '#4E823B',
                'ijo1' : '#034833',
                'ijo2' : '#2A471F',
                'ijo3' : '#328E6E',
                'ijo4' : '#67AE6E',
                'ijo5' : '#90C67C',
                'ijo6' : '#E1EEBC',
                'ijo7' : '#83CD20',
                "light-accent": "#8ABD5F",
            },
            fontFamily: {
                'display': [ 'Oswald'],
            },
        },
    },
    plugins: [],
};
