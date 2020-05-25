
window.Vue = require('vue');

console.log("test!");

window.addEventListener('load', function () {

var bugReport = new Vue({
            el: '#vue-test',
            data: {
                debug: 'test',
                stage: 'start',
            }
        });
});