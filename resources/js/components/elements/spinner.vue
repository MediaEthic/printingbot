<template>
    <div class="circles-loader">

    </div>
</template>

<script>
    export default {
        name: 'spinner',
    }
</script>

<style lang="scss" scoped>
    @-moz-keyframes circles-loader {
        0% {
            -moz-transform: rotate(-720deg);
            transform: rotate(-720deg);
        }
        50% {
            -moz-transform: rotate(720deg);
            transform: rotate(720deg);
        }
    }
    @-webkit-keyframes circles-loader {
        0% {
            -webkit-transform: rotate(-720deg);
            transform: rotate(-720deg);
        }
        50% {
            -webkit-transform: rotate(720deg);
            transform: rotate(720deg);
        }
    }
    @keyframes circles-loader {
        0% {
            -moz-transform: rotate(-720deg);
            -ms-transform: rotate(-720deg);
            -webkit-transform: rotate(-720deg);
            transform: rotate(-720deg);
        }
        50% {
            -moz-transform: rotate(720deg);
            -ms-transform: rotate(720deg);
            -webkit-transform: rotate(720deg);
            transform: rotate(720deg);
        }
    }
    /* :not(:required) hides this rule from IE9 and below */
    .circles-loader:not(:required) {
        position: relative;
        text-indent: -9999px;
        display: inline-block;
        width: 25px;
        height: 25px;
        background-color: theme('colors.yellow1');
        opacity: 0.9;
        border-radius: 100%;
        -moz-animation: circles-loader 3s infinite ease-in-out;
        -webkit-animation: circles-loader 3s infinite ease-in-out;
        animation: circles-loader 3s infinite ease-in-out;
        -moz-transform-origin: 50% 100%;
        -ms-transform-origin: 50% 100%;
        -webkit-transform-origin: 50% 100%;
        transform-origin: 50% 100%;
    }
    .circles-loader:not(:required)::before {
        background-color: theme('colors.red1');
        opacity: 0.9;
        border-radius: 100%;
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        top: 18.75px;
        left: -10.82532px;
    }
    .circles-loader:not(:required)::after {
        background-color: theme('colors.purple1');
        opacity: 0.9;
        border-radius: 100%;
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        top: 18.75px;
        left: 10.82532px;
    }
</style>
